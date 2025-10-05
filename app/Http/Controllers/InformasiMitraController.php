<?php

namespace App\Http\Controllers;

use App\Models\Sertif;
use App\Models\Industri;
use App\Helpers\Response;
use App\Models\Education;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\BahasaMahasiswa;
use App\Models\PendaftaranMagang;
use App\Enums\LowonganMagangStatusEnum;
use App\Models\DokumenPendaftaranMagang;
use App\Enums\PendaftaranMagangStatusEnum;

class InformasiMitraController extends Controller
{

    public function __construct()
    {
        $this->valid_step = [
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 0,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
        ];
    }

    public function listMitra()
    {
        return view('lowongan_magang.informasi_lowongan.index');
    }

    public function getListMitra()
    {
        $listMitra = Industri::with([
            'lowongan_magang' => function ($query) {
                $query->where('statusaprove', LowonganMagangStatusEnum::APPROVED);
            },
            'lowongan_magang.total_pelamar',
        ])->where('statusapprove', 1)
            ->get();

        return datatables()->of($listMitra)
            ->addIndexColumn()
            ->addColumn('total_lowongan', function ($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= $x->lowongan_magang->count();
                $result .= '</div>';

                return $result;
            })
            ->addColumn('total_pelamar', function ($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= $x->lowongan_magang->sum(function ($x) {
                    return $x->total_pelamar->count();
                });
                $result .= '</div>';

                return $result;
            })
            ->addColumn('action', function ($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= '<a href="' .route('lowongan.informasi.list_lowongan', $x->id_industri). '" class="text-primary"><i class="ti ti-file-invoice" data-bs-toggle="tooltip" title="Detail"></i></a>';
                $result .= '</div>';
                return $result;
            })
            ->editColumn('statuskerjasama', fn($x) => '<div class="text-center">' . $x->statuskerjasama . '</div>')
            ->rawColumns(['total_lowongan', 'total_pelamar', 'statuskerjasama', 'action'])
            ->make(true);
    }

    public function index($id)
    {
        $data['urlGetData'] = route('lowongan.informasi.show', $id);
        $data['urlBack'] = route('lowongan.informasi');
        return view('lowongan_magang.informasi_lowongan.informasi_mitra', $data);
    }

    public function show($id,Request $request)
    {
        $lowongan_magang = LowonganMagang::with('total_pelamar')
        ->select(
            'lowongan_magang.*', 'industri.image', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position'
        )
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->where('lowongan_magang.id_industri', $id)
        ->where('lowongan_magang.statusaprove', LowonganMagangStatusEnum::APPROVED);

        if (isset($request->tahun_akademik)) {
            $lowongan_magang->where('id_year_akademik', $request->tahun_akademik);
        }

        $rejected = [
            PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
            PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
        ];

        $lowongan_magang = $lowongan_magang->get()->map(function ($item) use ($rejected) {
            $total_pelamar = $item->total_pelamar;

            $item->total_pelamar = $total_pelamar->count();
            $item->screening = $total_pelamar->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM)->count();

            $countProsesSeleksi = 0;
            $countPenawaran = 0;
            $countRejected = 0;

            foreach ($total_pelamar as $key => $data) {
                if (isset($this->valid_step[$data->current_step]) && ($item->tahapan_seleksi + 1) > $this->valid_step[$data->current_step]) {
                    $countProsesSeleksi++;
                } else if (isset($this->valid_step[$data->current_step]) && ($item->tahapan_seleksi + 1) == $this->valid_step[$data->current_step]) {
                    $countPenawaran++;
                } else if (in_array($data->current_step, $rejected)) {
                    $countRejected++;
                }
            }

            $item->proses_seleksi = $countProsesSeleksi;
            $item->penawaran = $countPenawaran;

            $item->approved = $total_pelamar->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)->count();
            $item->rejected = $countRejected;

            $statusapprove = $item->statusaprove;
            $item->statusapprove = ($statusapprove == LowonganMagangStatusEnum::APPROVED) ? "Aktif" : "Menunggu Verifikasi";
            // dd($statusapprove);
            return $item;
        });

        return datatables()->of($lowongan_magang)
            ->addColumn('data', function ($data) {
                $view = view('lowongan_magang/informasi_lowongan/components/card_informasi_lowongan', compact('data'))->render();
                return $view;
            })
            ->rawColumns(['data'])
            ->make(true);
    }

    public function detail(Request $request, $id)
    {
        if ($request->ajax()) {
            $my_pendaftar_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
                ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
                ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
                ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
                ->leftJoin('reg_regencies', 'reg_regencies.id', '=', 'mahasiswa.kota_id')
                ->leftJoin('reg_provinces', 'reg_provinces.id', '=', 'reg_regencies.province_id')
                ->leftJoin('reg_countries', 'reg_countries.id', '=', 'reg_provinces.country_id')
                ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
                ->where('id_lowongan', $id)
                ->where('id_pendaftaran', $request->data_id)
                ->select('pendaftaran_magang.*', 'lowongan_magang.*', 'mahasiswa.*', 'universitas.*', 'fakultas.*', 'program_studi.*', 'reg_regencies.name as kota', 'reg_provinces.name as provinsi', 'reg_countries.name as negara');

            $data['pendaftar'] = $my_pendaftar_magang->first();
            $data['education'] = Education::where('nim', $data['pendaftar']->nim)->get();
            $data['experience'] = Experience::where('nim', $data['pendaftar']->nim)->get();
            $data['skills'] = json_decode($data['pendaftar']->skills, true) ?? [];
            $data['language'] = BahasaMahasiswa::where('nim', $data['pendaftar']->nim)->orderBy('bahasa', 'asc')->get();
            $data['dokumen_pendukung'] = Sertif::where('nim', $data['pendaftar']->nim)->orderBy('startdate', 'desc')->get();
            $data['dokumen_syarat'] = DokumenPendaftaranMagang::join('document_syarat', 'dokumen_pendaftaran_magang.id_document', '=', 'document_syarat.id_document')
                ->where('id_pendaftaran', $request->data_id)->get();

            $view = view('company/lowongan_magang/components/card_detail_pelamar', $data)->render();
            return Response::success([
                'view' => $view,
                'id_pendaftar' => $data['pendaftar']->id_pendaftaran,
                'current_step' => $data['pendaftar']->current_step
            ], 'Success');
        }

        $data['lowongan'] = LowonganMagang::with('total_pelamar')->where('id_lowongan', $id)->first();

        $data['tab'] = [
            'screening' => ['label' => 'Screening', 'icon' => 'ti ti-files', 'table' => PendaftaranMagangStatusEnum::APPROVED_BY_LKM],
        ];

        $data['listStatus'] = [];
        for ($i = 0; $i < ($data['lowongan']->tahapan_seleksi + 1); $i++) {
            $data['tab']['tahap_' . $i] = ['label' => 'Seleksi Tahap ' . ($i + 1), 'icon' => 'ti ti-device-desktop-analytics', 'table' => array_search($i, $this->valid_step)];
            $data['listStatus'][] = ['value' => array_search($i, $this->valid_step), 'label' => 'Seleksi Tahap ' . ($i + 1)];
        }

        $data['last_seleksi'] = array_search(($data['lowongan']->tahapan_seleksi + 1), $this->valid_step);
        array_push(
            $data['listStatus'],
            ['value' => $data['last_seleksi'], 'label' => 'Penawaran'],
            ['value' => 'rejected', 'label' => 'Ditolak'],
        );

        $data['tab']['penawaran'] = ['label' => 'Penawaran', 'icon' => 'ti ti-writing-sign', 'table' => array_search(($data['lowongan']->tahapan_seleksi + 1), $this->valid_step)];
        $data['tab']['diterima'] = ['label' => 'Diterima', 'icon' => 'ti ti-user-check', 'table' => PendaftaranMagangStatusEnum::APPROVED_PENAWARAN];
        $data['tab']['ditolak'] = ['label' => 'Ditolak', 'icon' => 'ti ti-user-x', 'table' => 'all_rejected'];

        $data['kandidat'] = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_pendaftaran')->join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')->where('id_lowongan', $id)->where('current_step', LowonganMagangStatusEnum::APPROVED);
        $data['urlGetData'] = route('lowongan.informasi.get_data', $id);
        $data['urlBack'] = route('lowongan.informasi.list_lowongan', $data['lowongan']->id_industri);
        $data['urlDetailPelamar'] = route('lowongan.informasi.detail', $id);
        // $data['urlToDetailKandidat'] = route('lowongan.informasi.detail_kandidat');
        // dd($data['urlToDetailKandidat']);

        return view('lowongan_magang/informasi_lowongan/detail', $data);
    }

    public function getDataDetail(Request $request, $id)
    {
        $lowongan =  LowonganMagang::where('id_lowongan', $id)->first();

        $inArray = 'in:' . PendaftaranMagangStatusEnum::APPROVED_BY_LKM;
        for ($i = 0; $i < ($lowongan->tahapan_seleksi + 1); $i++) {
            $inArray .= ',' . array_search($i, $this->valid_step);
        }
        $inArray .= ',';
        $inArray .= implode(',', [
            array_search(($lowongan->tahapan_seleksi + 1), $this->valid_step),
            PendaftaranMagangStatusEnum::APPROVED_PENAWARAN,
            'all_rejected'
        ]);

        $request->validate(['type' => 'required|' . $inArray]);

        $pendaftarMagang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
            ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->where('id_lowongan', $id);
        if ($request->type == 'all_rejected') {
            $pendaftarMagang = $pendaftarMagang->whereIn('current_step', [
                PendaftaranMagangStatusEnum::REJECTED_SCREENING,
                PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
                PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
                PendaftaranMagangStatusEnum::REJECTED_PENAWARAN
            ]);
        } else {
            $pendaftarMagang = $pendaftarMagang->where('current_step', $request->type);
        };

        return datatables()->of($pendaftarMagang)
            ->addIndexColumn()
            ->editColumn('namamhs', function ($data) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span class="fw-semibold text-nowrap">' . $data->namamhs . '</span>';
                $result .= '<span class="text-nowrap">' . $data->nim . '</span>';
                $result .= '</div>';
                return $result;
            })
            ->editColumn('nohpmhs', fn($data) => '<span class="text-nowrap">' . $data->nohpmhs . '</span>')
            ->editColumn('emailmhs', fn($data) => '<span class="text-nowrap">' . $data->emailmhs . '</span>')
            ->editColumn('tanggaldaftar', function ($data) {
                return '<span class="text-nowrap">' . Carbon::parse($data->tanggaldaftar)->format('d F Y') . '</span>';
            })
            ->editColumn('namaprodi', fn($data) => '<span class="text-nowrap">' . $data->namaprodi . '</span>')
            ->editColumn('namafakultas', fn($data) => '<span class="text-nowrap">' . $data->namafakultas . '</span>')
            ->editColumn('namauniv', fn($data) => '<span class="text-nowrap">' . $data->namauniv . '</span>')
            ->editColumn('current_step', function ($data) {
                if ($data->current_step == array_search(($data->tahapan_seleksi + 1), $this->valid_step)) {
                    $status = ['title' => 'Penawaran', 'color' => 'info'];
                } else {
                    $status = PendaftaranMagangStatusEnum::getWithLabel($data->current_step);
                }

                return '<div class="d-flex justify-content-center"><span class="badge bg-label-' . $status['color'] . '">' . $status['title'] . '</span></div>';
            })
            ->addColumn('action', function ($data) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= '<a class="cursor-pointer text-primary" onclick="detailInfo($(this))" data-id="' . $data->id_pendaftaran . '"><i class="ti ti-file-invoice"></i></a>';
                $result .= '</div>';

                return $result;
            })
            ->rawColumns([
                'namamhs',
                'nohpmhs',
                'emailmhs',
                'tanggaldaftar',
                'namaprodi',
                'namafakultas',
                'namauniv',
                'current_step',
                'action'
            ])
            ->make(true);
    }
}
