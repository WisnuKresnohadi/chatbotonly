<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use App\Enums\LowonganMagangStatusEnum;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\PendaftaranMagang;

class JadwalSeleksiAdminController extends Controller
{
    public function __construct()
    {
        $this->valid_step = [
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 3,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 4,
        ];
    }

    public function listMitra(){
        return view('company/jadwal_seleksi/mitra_seleksi');
    }

    public function getListMitra() {
        $listMitra = Industri::with([
            'lowongan_magang' => function ($query) {
                $query->where('statusaprove', LowonganMagangStatusEnum::APPROVED);
            },
            'lowongan_magang.total_pelamar',
        ])->where('statusapprove', 1)
        ->get();

        return datatables()->of($listMitra)
            ->addIndexColumn()
            ->addColumn('total_lowongan', function($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= $x->lowongan_magang->count();
                $result .= '</div>';

                return $result;
            })
            ->addColumn('total_pelamar', function($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= $x->lowongan_magang->sum(function ($x) {
                    return $x->total_pelamar->count();
                });
                $result .= '</div>';

                return $result;
            })
            ->addColumn('action', function ($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= '<a href="' .route('jadwal_seleksi_lkm.list_lowongan', $x->id_industri). '" class="text-primary"><i class="ti ti-file-invoice"></i></a>';
                $result .= '</div>';
                return $result;
            })
            ->editColumn('statuskerjasama', fn($x) => '<div class="text-center">' . $x->statuskerjasama . '</div>')
            ->rawColumns(['total_lowongan', 'total_pelamar', 'statuskerjasama', 'action'])
            ->make(true);
    }

    public function index($id)
    {
        $urlGetData = route('jadwal_seleksi_lkm.get_data', $id);
        $urlBack = route('jadwal_seleksi_lkm');
        return view('company.jadwal_seleksi.jadwal', compact('urlGetData', 'urlBack'));
    }

    public function getData($id) {
        $lowongan = LowonganMagang::with('total_pelamar', 'bidangPekerjaanIndustri')->where('id_industri', $id)->get()->map(function ($item) {
            $item->total_kandidat = $item->total_pelamar->whereIn('current_step', [
                PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2
            ])->count();

            for ($i=1; $i <= ($item->tahapan_seleksi + 1); $i++) {
                $item->{'seleksi_tahap_' . $i} = $item->total_pelamar->filter(function ($data) use ($i) {
                    return isset($this->valid_step[$data->current_step]) && $i == $this->valid_step[$data->current_step];
                })->count();
            }

            return $item;
        });

        return datatables()->of($lowongan)
        ->addColumn('card', function ($data) {
            $urlAction = route('jadwal_seleksi_lkm.detail', $data->id_lowongan);
            $result = view('company/jadwal_seleksi/components/card_list_lowongan', compact('data', 'urlAction'))->render();
            return $result;
        })
        ->rawColumns(['card'])
        ->make(true);
    }

    public function detail(Request $request, $id)
    {
        $lowongan = LowonganMagang::where('id_lowongan', $id)
        ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->first();
        $urlGetData = route('jadwal_seleksi_lkm.get_data_detail', $id);
        $urlBack = route('jadwal_seleksi_lkm.list_lowongan', $lowongan->id_industri);

        return view('company.jadwal_seleksi.detail', compact('lowongan', 'urlGetData', 'urlBack'));
    }

    public function getDetailData(Request $request, $id) {
        $request->validate([
            'tahap' => 'required|in:1,2,3'
        ]);

        $lowongan_ = LowonganMagang::with('seleksi_tahap')->where('id_lowongan', $id)->first();
        $pendaftaran_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->where('pendaftaran_magang.id_lowongan', $id)
            ->where('current_step', array_search($request->tahap, $this->valid_step))->get();

        $pendaftaran_magang->transform(function ($item) use ($lowongan_, $request) {
            $item->seleksi = $lowongan_->seleksi_tahap->where('tahap', $request->tahap)->first();
            return $item;
        });

        return datatables()->of($pendaftaran_magang)
        ->addIndexColumn()
        ->editColumn('namamhs', function ($x) {
            $result = '<div class="d-flex flex-column align-items-start">';
            $result .= '<span class="fw-bolder">' .$x->namamhs. '</span>';
            $result .= '<span>' .$x->nim. '</span>';
            $result .= '</div>';

            return $result;
        })
        ->addColumn('tanggalpelaksaan', function ($x) {
            $result = '<div class="d-flex flex-column justify-content-start">';
            $result .= '<span class="text-muted">Tanggal Mulai</span>';
            $result .= '<span>' .$x->seleksi->tgl_mulai. '</span>';
            $result .= '<span class="text-muted">Tanggal Akhir</span>';
            $result .= '<span>' .$x->seleksi->tgl_akhir. '</span>';
            $result .= '</div>';

            return $result;
        })
        ->addColumn('action', function ($x) {
            $result = '<div class="d-flex justify-content-center">';
            $result .= '<a class="mx-1 cursor-pointer text-info" href="' .route('jadwal_seleksi_lkm.detail_mahasiswa', ['id_lowongan' => $x->id_lowongan, 'id_pendaftaran' => $x->id_pendaftaran]). '"><i class="ti ti-file-invoice"></i></a>';
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['namamhs', 'tanggalpelaksaan', 'action'])
        ->make(true);
    }

    public function detailMahasiswa($id_lowongan, $id_pendaftaran) {
        $data['data'] = Mahasiswa::with('education', 'experience', 'sertifikat')->select(
            'mahasiswa.*', 'pendaftaran_magang.tanggaldaftar', 'industri.namaindustri',
            'lowongan_magang.intern_position', 'users.email', 'pendaftaran_magang.current_step',
            'pendaftaran_magang.id_pendaftaran', 'universitas.namauniv', 'fakultas.namafakultas'
        )
        ->join('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('users', 'mahasiswa.id_user', '=', 'users.id')
        ->join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
        ->where('pendaftaran_magang.id_pendaftaran', $id_pendaftaran)->first();

        $data['urlBack'] = route('jadwal_seleksi_lkm.detail', $id_lowongan);

        return view('company/jadwal_seleksi/detail_mahasiswa', $data);
    }
}
