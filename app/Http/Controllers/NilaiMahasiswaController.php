<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranMagang;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Exports\NilaiMhsMagangFakultasExport;
use App\Helpers\Response;
use App\Models\KomponenNilai;
use App\Models\ProgramStudi;

class NilaiMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nilai_mahasiswa_magang_fakultas.view', ['only' => ['viewMagangFakultas', 'detailMagangFakultas']]);
        $this->middleware('permission:nilai_mahasiswa_magang_mandiri.view', ['only' => ['viewMagangMandiri', 'detailMagangMandiri']]);
    }

    public function viewMagangFakultas()
    {
        $data['prodi'] = ProgramStudi::where('status', 1)->get();
        return view('nilai_mahasiswa.magang_fakultas.index', $data);
    }

    public function getListMagangFakultas(Request $request)
    {
        $this->getPemagang(function ($query) use ($request) {
            $query = $query->select(
                    'pendaftaran_magang.id_pendaftaran', 'mahasiswa.namamhs', 'mahasiswa.nim', 'program_studi.namaprodi', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
                    'mhs_magang.nilai_lap', 'mhs_magang.nilai_akademik', 'mhs_magang.nilai_akhir_magang', 'mhs_magang.indeks_nilai_akhir', 'mhs_magang.nilai_adjust', 'mhs_magang.indeks_nilai_adjust'
                )
                ->leftJoin('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
                ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
                ->leftJoin('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
                ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
                ->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran');

            if ($request->tahun_ajaran) $query = $query->where('lowongan_magang.id_year_akademik', $request->tahun_ajaran);

            if ($request->prodi) $query = $query->where('mahasiswa.id_prodi', $request->prodi);

            if ($request->namaperusahaan) $query = $query->where('industri.namaindustri', 'like', '%' . $request->tahun_ajaran . '%');

            if ($request->posisi) $query = $query->where('lowongan_magang.intern_position', 'like', '%' . $request->posisi . '%');

            return $query;

        });

        return datatables()->of($this->pemagang)
        ->addIndexColumn()
        ->editColumn('namamhs', function ($x) {
            $result = '<div class="d-flex flex-column justify-content-center align-items-start">';
            $result .= '<span>'.$x->namamhs.'</span>';
            $result .= '<small>'.$x->nim.'</small>';
            $result .= '</div>';

            return $result;
        })
        ->editColumn('nilai_akhir_magang', function ($x) {
            $result = $x->nilai_akhir_magang;
            if ($x->nilai_adjust) $result -= $x->nilai_adjust;
            return $result;
        })
        ->editColumn('indeks_nilai_akhir', fn($x) => $x->indeks_nilai_adjust ?? $x->indeks_nilai_akhir)
        ->addColumn('action', function ($x) {
            $result = '<div class="d-flex justify-content-center">';
            $result .= '<a href="' .route('nilai_mahasiswa.fakultas.detail', $x->id_pendaftaran). '" class="text-primary"><i class="ti ti-file-invoice"></i></a>';
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['namamhs', 'action'])
        ->make(true);
    }

    public function viewMagangMandiri()
    {
        $data['prodi'] = ProgramStudi::where('status', 1)->get();
        return view('nilai_mahasiswa.magang_mandiri.index', $data);
    }

    public function detailMagangFakultas($id)
    {
        $this->getPemagang(function ($query) use ($id) {
            return $query->select(
                'mahasiswa.namamhs', 'lowongan_magang.id_jenismagang', 'mhs_magang.id_mhsmagang', 'mhs_magang.nilai_akademik',
                'mhs_magang.nilai_lap', 'mhs_magang.indeks_nilai_lap', 'mhs_magang.indeks_nilai_akademik'
            )
            ->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->leftJoin('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->where('pendaftaran_magang.id_pendaftaran', $id);
        });

        $data['pemagang'] = $this->pemagang->first();

        $komponenPenilaian = KomponenNilai::where('komponen_nilai.status', 1)->where('komponen_nilai.id_jenismagang', $data['pemagang']->id_jenismagang);

        $data['komponen_penilaian_akademik'] = $komponenPenilaian->clone()
            ->select(
                'komponen_nilai.aspek_penilaian', 'komponen_nilai.deskripsi_penilaian', 'komponen_nilai.nilai_max',
                'nilai_pemb_akademik.nilai as nilai_filled', 'nilai_pemb_akademik.aspek_penilaian as aspek_penilaian_filled', 'nilai_pemb_akademik.nilai_max as nilai_max_filled',
                'nilai_pemb_akademik.deskripsi_penilaian as deskripsi_penilaian_filled'
            )
            ->leftJoin('nilai_pemb_akademik', function ($join) use ($data) {
                $join->on('nilai_pemb_akademik.id_kompnilai', '=', 'komponen_nilai.id_kompnilai')
                ->where('nilai_pemb_akademik.id_mhsmagang', $data['pemagang']->id_mhsmagang);
            })
            ->where('komponen_nilai.scored_by', 1)->get();

        $data['komponen_penilaian_lapangan'] = $komponenPenilaian->clone()
            ->select(
                'komponen_nilai.aspek_penilaian', 'komponen_nilai.deskripsi_penilaian', 'komponen_nilai.nilai_max',
                'nilai_pemblap.nilai as nilai_filled', 'nilai_pemblap.aspek_penilaian as aspek_penilaian_filled', 'nilai_pemblap.nilai_max as nilai_max_filled',
                'nilai_pemblap.deskripsi_penilaian as deskripsi_penilaian_filled'
            )
            ->leftJoin('nilai_pemblap', function ($join) use ($data) {
                $join->on('nilai_pemblap.id_kompnilai', '=', 'komponen_nilai.id_kompnilai')
                ->where('nilai_pemblap.id_mhsmagang', $data['pemagang']->id_mhsmagang);
            })
            ->where('scored_by', 2)->get();

        return view('nilai_mahasiswa.magang_fakultas.nilai', $data);
    }

    public function detailMagangMandiri()
    {
        return view('nilai_mahasiswa.magang_mandiri.nilai');
    }

    protected function getPemagang($additional = null)
    {
        $this->pemagang = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
        if ($additional != null) $this->pemagang = $additional($this->pemagang);

        $this->pemagang = $this->pemagang->get();
        return $this;
    }

    public function exportNilaiMhsMagangFakultas(Request $request) {
        $this->getPemagang(function ($query) use ($request) {
            $query = $query->select(
                    'pendaftaran_magang.id_pendaftaran', 'mahasiswa.namamhs', 'mahasiswa.nim', 'program_studi.namaprodi', 'industri.namaindustri', 'lowongan_magang.intern_position',
                    'mhs_magang.nilai_lap', 'mhs_magang.nilai_akademik', 'mhs_magang.nilai_akhir_magang', 'mhs_magang.indeks_nilai_akhir', 'mhs_magang.nilai_adjust', 'mhs_magang.indeks_nilai_adjust'
                )
                ->leftJoin('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
                ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
                ->leftJoin('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
                ->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran');

            if ($request->tahun_ajaran) $query = $query->where('lowongan_magang.id_year_akademik', $request->tahun_ajaran);

            if ($request->prodi) $query = $query->where('mahasiswa.id_prodi', $request->prodi);

            if ($request->namaperusahaan) $query = $query->where('industri.namaindustri', 'like', '%' . $request->tahun_ajaran . '%');

            if ($request->posisi) $query = $query->where('lowongan_magang.intern_position', 'like', '%' . $request->posisi . '%');

            return $query;

        });

        if(count($this->pemagang) < 1) {
            return Response::error(null, 'Belum ada Nilai mahasiswa magang fakultas');
        }

        $nilaiExport = new NilaiMhsMagangFakultasExport($this->pemagang->toArray());
        return $nilaiExport->download();
    }
}
