<?php

namespace App\Http\Controllers\DataMahasiswaMagang;

use App\Models\Industri;
use App\Helpers\Response;
use App\Models\JenisMagang;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Enums\PendaftaranMagangStatusEnum;

class DataMahasiswaMagangDosenController extends DataMahasiswaMagangController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('permission:data_mahasiswa_magang_dosen.view')->only(['index', 'getData']);
    }

    public function indexDosen(Request $request) {
        $data['view'] = $this->getViewDesign();

        if ($request->ajax()) {
            if ($request->section == 'jenjang') {
                $data = LowonganMagang::select('jenjang')
                    ->where('statusaprove', 'diterima')
                    ->get()
                    ->map(function ($item) {
                        $jenjang = json_decode($item->jenjang, true);
                        $result = [];
                        foreach ($jenjang as $key => $prodis) {
                            $result[] = [
                                'name' => $key,
                                'id' => json_encode([$key => $prodis])
                            ];
                        }
                        return $result;
                    })->collapse()->unique('name');
            }

            if ($request->section == 'program_studi') {
                $data = ProgramStudi::select('namaprodi as name', 'id_prodi as id')
                    ->whereIn('id_prodi', collect(json_decode($request->selected, true))->flatten())
                    ->get();
            }

            if ($request->section == 'nama_perusahaan') {
                // Filter nama perusahaan berdasarkan jenjang dan program studi yang dipilih sebelumnya
                $data = Industri::select('industri.namaindustri as name', 'industri.id_industri as id')
                    ->join('lowongan_magang', 'lowongan_magang.id_industri', '=', 'industri.id_industri')
                    ->where('lowongan_magang.statusaprove', 'diterima')
                    ->where('lowongan_magang.jenjang', 'LIKE', '%' . $request->selected . '%')
                    ->distinct()
                    ->get();
            }

            if ($request->section == 'posisi_magang') {
                $data = LowonganMagang::select('intern_position as name', 'intern_position as id')
                    ->where('id_industri', $request->selected)
                    ->where('statusaprove', 'diterima')
                    ->distinct()
                    ->get();
            }

            return Response::success($data, 'Success');
        }

        $data['jenis_magang'] = JenisMagang::all();
        $data['urlGetSelect'] = route('mahasiswa_magang_dosen');
        return view('data_mahasiswa_magang.index', $data);
    }

    public function getData(Request $request) {
        $this->getMyMhsMagang(function ($query) use ($request) {
            $query = $query->select(
                'pendaftaran_magang.id_pendaftaran', 'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'mahasiswa.namamhs', 'mahasiswa.nim', 'industri.namaindustri',
                'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'pendaftaran_magang.file_document_mitra',
                'pendaftaran_magang.dokumen_skm', 'pegawai_industri.namapeg', 'pegawai_industri.emailpeg', 'dosen.namadosen', 'dosen.nip'
            )
            ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
            ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang');

            //===== [Filter] =====
            // if ($request->filled('jenis_magang') && $request->jenis_magang != 'all') {
            //     $query->where('jenis_magang.id_jenismagang', $request->jenis_magang);
            // }

            // if ($request->filled('jenjang') && $request->jenjang != 'all') {
            //     $query->where('program_studi.jenjang', array_key_first(json_decode($request->jenjang, true)));
            //     // $query->where('lowongan_magang.jenjang', 'LIKE', '%' . array_key_first(json_decode($request->jenjang, true)) . '%');
            // }

            // if ($request->filled('program_studi') && $request->program_studi != 'all') {
            //     $query->where('mahasiswa.id_prodi', $request->program_studi);
            //     // $query->where('lowongan_magang.jenjang', 'LIKE', '%' . $request->program_studi . '%');
            // }

            // if ($request->filled('nama_perusahaan') && $request->nama_perusahaan != 'all') {
            //     $query->where('lowongan_magang.id_industri', $request->nama_perusahaan);
            // }

            // if ($request->filled('posisi_magang') && $request->posisi_magang != 'all') {
            //     $query->where('lowongan_magang.intern_position', $request->posisi_magang);
            // }

            if ($request->filled('tahun_ajaran')) {
                $query->where('lowongan_magang.id_year_akademik', $request->tahun_ajaran);
            }
            //===== [End Filter] =====

            if ($request->type == 'diterima') {
                $query = $query->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
            } else if ($request->type == 'belum_magang') {
                $query = $query->where(function ($q) {
                    $q->whereNull('pendaftaran_magang.id_pendaftaran')->orWhere('pendaftaran_magang.current_step', '!=', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
                });
            }
            return $query;
        });

        $datatables = datatables()->of($this->pendaftaran_magang)
        ->addIndexColumn()
        ->editColumn('namamhs', function ($data) {
            $result = '<div class="d-flex flex-column align-items-start">';
            $result .= '<span class="fw-bolder text-nowrap">' .$data->namamhs. '</span>';
            $result .= '<span>' .$data->nim. '</span>';
            $result .= '</div>';
            return $result;
        })
        ->editColumn('namaindustri', fn ($data) => '<span class="text-nowrap">'.$data->namaindustri.'</span>')
        ->editColumn('intern_position', fn ($data) => '<span class="text-nowrap">'.$data->intern_position.'</span>')
        ->editColumn('file_document_mitra', function ($data) {
            $result = '<div class="d-flex flex-column align-items-center">';

            if ($data->file_document_mitra == null) {
                $result .= '<span>-</span>';
            } elseif (isset($this->valid_steps[$data->current_step]) && ($data->tahapan_seleksi + 1) <= $this->valid_steps[$data->current_step]) {
                $result .= '<a href="' .asset('storage/' . $data->file_document_mitra). '" target="_blank" class="text-nowrap text-primary">Bukti Penerimaan.pdf</a>';
            } elseif (in_array($data->current_step, $this->reject_steps)) {
                $result .= '<a href="' .asset('storage/' . $data->file_document_mitra). '" target="_blank" class="text-nowrap text-primary">Bukti Penolakan.pdf</a>';
            }

            if ($data->dokumen_skm) {
                $result .= '<a href="' .url('storage/' . $data->dokumen_skm). '" target="_blank" class="text-nowrap text-primary">Dokumen SPM.pdf</a>';
            }

            $result .= '</div>';
            return $result;
        });

        if ($request->type == 'diterima') {
            $datatables = $datatables
            ->addColumn('tanggalmagang', function ($data) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span>Tanggal Mulai:</span>';
                $result .= '<span class="fw-semibold">' . ($data->startdate_magang == null ? '-' : Carbon::parse($data->startdate_magang)->format('d M Y')) . '</span>';
                $result .= '<span>Tanggal Berakhir:</span>';
                $result .= '<span class="fw-semibold">' . ($data->enddate_magang == null ? '-' : Carbon::parse($data->enddate_magang)->format('d M Y')) . '</span>';
                $result .= '</div>';

                return $result;
            })
            ->addColumn('pembimbing_lapangan', function ($data) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= (isset($data->namapeg) && isset($data->emailpeg)) ? '<span>' .$data->namapeg. '</span><span class="fw-semibold">' .$data->emailpeg. '</span>' : '<span>-</span>';
                $result .= '</div>';

                return $result;
            })
            ->addColumn('pembimbing_akademik', function ($data) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= (isset($data->namadosen) && isset($data->nip)) ? '<span>' .$data->namadosen. '</span><span class="fw-semibold">' .$data->nip. '</span>' : '<span>-</span>';
                $result .= '</div>';

                return $result;
            });
        }


        return $datatables->rawColumns([
            'namamhs', 'namaindustri', 'intern_position', 'file_document_mitra', 'tanggalmagang',
            'pembimbing_lapangan', 'pembimbing_akademik'
        ])->make(true);
    }

    private function getMyMhsMagang($additional = null)
    {
        $user = auth()->user();
        $dosen = $user->dosen;

        $this->getPendaftaranMagang(function ($query) use ($additional, $dosen) {
            $query = $query->where('mahasiswa.kode_dosen', $dosen->kode_dosen);
            if ($additional != null) $query = $additional($query);
            return $query;
        });

        return $this;
    }

    private function getViewDesign() {
        $title = 'Data Mahasiswa Magang';

        $urlGetData = route('mahasiswa_magang_dosen.get_data');

        $listTable = ['diterima', 'belum_magang'];
        $listTab = [
            '<li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-diterima" aria-controls="navs-pills-diterima" aria-selected="true">
                    <i class="ti ti-user-check"></i>
                    Diterima
                </button>
            </li>',
            '<li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-belum_magang" aria-controls="navs-pills-belum_magang" aria-selected="false" tabindex="-1">
                    <i class="ti ti-user-x"></i>
                    Belum Magang
                </button>
            </li>'
        ];

        $diterima = [
            '<th class="text-nowrap">No</th>',
            '<th class="text-nowrap">Nama/Nim</th>',
            '<th class="text-nowrap">Nama Perusahaan</th>',
            '<th class="text-nowrap">Posisi Magang</th>',
            '<th class="text-nowrap">Tanggal Magang</th>',
            '<th class="text-nowrap text-center">Dokumen</th>',
            '<th class="text-nowrap">Pembimbing Lapangan</th>',
            '<th class="text-nowrap">Pembimbing Akademik</th>'
        ];

        $belum_magang = [
            '<th class="text-nowrap">No</th>',
            '<th class="text-nowrap">Nama/Nim</th>',
            '<th class="text-nowrap">Nama Perusahaan</th>',
            '<th class="text-nowrap">Posisi Magang</th>',
            '<th class="text-nowrap text-center">Dokumen</th>'
        ];

        $columnsDiterima = "[
            {data: 'DT_RowIndex'},
            {data: 'namamhs'},
            {data: 'namaindustri'},
            {data: 'intern_position'},
            {data: 'tanggalmagang'},
            {data: 'file_document_mitra'},
            {data: 'pembimbing_lapangan'},
            {data: 'pembimbing_akademik'}
        ]";

        $columnsBelumMagang = "[
            {data: 'DT_RowIndex'},
            {data: 'namamhs'},
            {data: 'namaindustri'},
            {data: 'intern_position'},
            {data: 'file_document_mitra'}
        ]";

        return compact(
            'title',
            'urlGetData',
            'listTable',
            'listTab',
            'diterima',
            'belum_magang',
            'columnsDiterima',
            'columnsBelumMagang'
        );
    }
}
