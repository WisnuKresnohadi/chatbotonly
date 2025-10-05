<?php

namespace App\Http\Controllers\DataMahasiswaMagang;

use App\Exports\DataMahasiswaMagangExport;
use App\Helpers\Response;
use App\Models\MhsMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use App\Models\JenisMagang;
use App\Models\Industri;
use App\Models\ProgramStudi;
use App\Models\LowonganMagang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Facades\Excel;

class DataMahasiswaMagangController extends Controller
{

    public function __construct()
    {
        $this->valid_steps = [
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
            PendaftaranMagangStatusEnum::APPROVED_PENAWARAN => 4,
        ];

        $this->reject_steps = [
            PendaftaranMagangStatusEnum::REJECTED_SCREENING,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3
        ];
    }

    public function index(Request $request) {
        $view = $this->getViewDesign();

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

        $jenis_magang = JenisMagang::all();
        $urlGetSelect = route('data_mahasiswa');
        return view('data_mahasiswa_magang.index', compact('view', 'jenis_magang', 'urlGetSelect'));
    }

    public function getDataTable(Request $request) {
        $request->validate(['type' => ['required', 'in:diterima,belum_magang,belum_spm']]);

        $this->getPendaftaranMagang(function ($query) use ($request) {
            $query = $query->select(
                'pendaftaran_magang.id_pendaftaran', 'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'mahasiswa.namamhs', 'mahasiswa.nim', 'program_studi.namaprodi', 'jenis_magang.namajenis', 'industri.namaindustri',
                'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'pendaftaran_magang.file_document_mitra',
                'pendaftaran_magang.dokumen_skm', 'pegawai_industri.namapeg', 'pegawai_industri.emailpeg', 'dosen.namadosen', 'dosen.nip', 'mhs_magang.nilai_akhir_magang', 'mhs_magang.indeks_nilai_akhir'
            )
            ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang')
            ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
            ->orderBy('industri.namaindustri')
            ->orderBy('mhs_magang.startdate_magang');

            //===== [Filter] =====
            if ($request->filled('jenis_magang') && $request->jenis_magang != 'all') {
                $query->where('jenis_magang.id_jenismagang', $request->jenis_magang);
            }

            if ($request->filled('jenjang') && $request->jenjang != 'all') {
                $query->where('program_studi.jenjang', array_key_first(json_decode($request->jenjang, true)));
                // $query->where('lowongan_magang.jenjang', 'LIKE', '%' . array_key_first(json_decode($request->jenjang, true)) . '%');
            }

            if ($request->filled('program_studi') && $request->program_studi != 'all') {
                $query->where('mahasiswa.id_prodi', $request->program_studi);
                // $query->where('lowongan_magang.jenjang', 'LIKE', '%' . $request->program_studi . '%');
            }

            if ($request->filled('nama_perusahaan') && $request->nama_perusahaan != 'all') {
                $query->where('lowongan_magang.id_industri', $request->nama_perusahaan);
            }

            if ($request->filled('posisi_magang') && $request->posisi_magang != 'all') {
                $query->where('bidang_pekerjaan_industri.namabidangpekerjaan', $request->posisi_magang);
            }
            if ($request->filled('tahun_ajaran')) {
                $query->where('lowongan_magang.id_year_akademik', $request->tahun_ajaran);
            }
            //===== [End Filter] =====

            if ($request->type == 'diterima') {
                $query = $query->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)->whereNotNull('pendaftaran_magang.dokumen_skm');
            } else if ($request->type == 'belum_magang') {
                $query = $query->where(function ($q) {
                    $q->whereNull('pendaftaran_magang.id_pendaftaran')->orWhere('pendaftaran_magang.current_step', '!=', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
                });
            } else if ($request->type == 'belum_spm') {
                $query = $query->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                ->whereNull('pendaftaran_magang.dokumen_skm');
            }
            return $query;
        });

        $datatables = datatables()->of($this->pendaftaran_magang)
        ->addIndexColumn()
        ->addColumn('mhs_name', function ($data) {
            $result = '<div class="d-flex flex-column align-items-start">';
            $result .= '<span class="fw-bolder text-nowrap">' .$data->namamhs. '</span>';
            $result .= '<span>' .$data->nim. '</span>';
            $result .= '</div>';
            return $result;
        })
        ->addColumn('industri_name', fn ($data) => '<span class="text-nowrap">'.$data->namaindustri.'</span>')
        ->addColumn('posisi', fn ($data) => '<span class="text-nowrap">'.$data->intern_position.'</span>')
        ->addColumn('file_document', function ($data) {
            $result = '<div class="d-flex flex-column align-items-center">';

            if (isset($this->valid_steps[$data->current_step]) && ($data->tahapan_seleksi + 1) <= $this->valid_steps[$data->current_step]) {
                $result .= '<a href="' .asset('storage/' . $data->file_document_mitra). '" target="_blank" class="text-nowrap text-primary">Bukti Penerimaan.pdf</a>';
            } elseif (in_array($data->current_step, $this->reject_steps)) {
                $result .= '<a href="' .asset('storage/' . $data->file_document_mitra). '" target="_blank" class="text-nowrap text-primary">Bukti Penolakan.pdf</a>';
            } elseif ($data->file_document_mitra == null) {
                $result .= '<span>-</span>';
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
            'mhs_name', 'industri_name', 'posisi', 'file_document', 'tanggalmagang',
            'pembimbing_lapangan', 'pembimbing_akademik'
        ])->make(true);
    }

    public function uploadSPM(Request $request) {
        $request->validate([
            'id_pendaftaran' => 'required|array|exists:pendaftaran_magang,id_pendaftaran',
            'dokumen' => 'required|file|max:2048|mimes:pdf',
            'mulai_magang' => ['required', 'date'],
            'selesai_magang' => ['required', function ($attribute, $value, $fail) use ($request) {
                if (isset($request->mulai_magang) && isset($value)) {
                    $startDate = Carbon::parse($request->mulai_magang);
                    $endDate = Carbon::parse($value);
                    if ($startDate->gte($endDate)) {
                        $fail('Tanggal Selesai Magang harus setelah tanggal Mulai Magang');
                    }

                    $now = Carbon::now();
                    if ($now->gte($endDate)) {
                        $fail('Tanggal Selesai Magang harus setelah tanggal hari ini');
                    }
                }
            }]
        ], [
            'id_pendaftaran.required' => 'Pendaftaran harus dipilih',
            'dokumen.mimes' => 'File harus berformat PDF',
            'dokumen.required' => 'File harus diunggah',
            'dokumen.max' => 'File tidak boleh lebih dari 2MB.',
            'mulai_magang.required' => 'Mulai Magang harus diisi',
            'mulai_magang.date' => 'Mulai Magang harus format tanggal',
            'selesai_magang.required' => 'Selesai Magang harus diisi'
        ]);

        try {
            DB::beginTransaction();

            $file = null;
            if ($request->hasFile('dokumen')) {
                $file = Storage::put('dokumen_skm', $request->dokumen);
            }

            PendaftaranMagang::whereIn('id_pendaftaran', $request->id_pendaftaran)->update([
                'dokumen_skm' => $file,
            ]);

            MhsMagang::whereIn('id_pendaftaran', $request->id_pendaftaran)->update([
                'startdate_magang' => Carbon::parse($request->mulai_magang)->format('Y-m-d'),
                'enddate_magang' => Carbon::parse($request->selesai_magang)->format('Y-m-d'),
            ]);

            DB::commit();

            $result = new WriteAndReadCounterBadgeJob('data_mahasiswa_count', 'decrement', function () {
                return PendaftaranMagang::where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                ->whereNull('dokumen_skm')->count();
            });
            return Response::success($result, 'Berhasil mengunggah dokumen SKM');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    protected function getPendaftaranMagang($additional = null) {
        // $this->pendaftaran_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        $this->pendaftaran_magang = Mahasiswa::leftJoin('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->leftJoin('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->leftJoin('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->leftJoin('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
        ->leftJoin('pegawai_industri', 'mhs_magang.id_peg_industri', '=', 'pegawai_industri.id_peg_industri')
        ->leftJoin('dosen', 'mhs_magang.nip', '=', 'dosen.nip');

        if($additional != null) $this->pendaftaran_magang = $additional($this->pendaftaran_magang);

        $this->pendaftaran_magang = $this->pendaftaran_magang->get();

        return $this;
    }

    private function getViewDesign() {
        $title = 'Data Mahasiswa Magang';
        $urlGetData = route('data_mahasiswa.get_data');
        $isLKM = true;

        $listTable = ['belum_spm', 'diterima', 'belum_magang'];
        $listTab = [
            '<li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-belum_spm" aria-controls="navs-pills-belum_spm" aria-selected="false" tabindex="-1">
                    <i class="me-1 ti ti-upload"></i>
                    Upload SKM
                </button>
            </li>',
            '<li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-diterima" aria-controls="navs-pills-diterima" aria-selected="true">
                    <i class="me-1 ti ti-user-check"></i>
                    Magang
                </button>
            </li>',
            '<li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-belum_magang" aria-controls="navs-pills-belum_magang" aria-selected="false" tabindex="-1">
                    <i class="me-1 ti ti-user-x"></i>
                    Belum Magang
                </button>
            </li>'
        ];

        $diterima = [
            '<th class="text-nowrap">No</th>',
            '<th class="text-nowrap">Nama/Nim</th>',
            '<th class="text-nowrap">Program Studi</th>',
            '<th class="text-nowrap">Jenis Magang</th>',
            '<th class="text-nowrap">Posisi Magang</th>',
            '<th class="text-nowrap">Tanggal Magang</th>',
            '<th class="text-center text-nowrap">Dokumen</th>',
            '<th class="text-nowrap">Pembimbing Lapangan</th>',
            '<th class="text-nowrap">Pembimbing Akademik</th>',
            '<th class="text-nowrap">Nilai Akhir</th>',
            '<th class="text-nowrap">Indeks Nilai</th>'
        ];

        $belum_magang = [
            '<th class="text-nowrap">No</th>',
            '<th class="text-nowrap">Nama/Nim</th>',
            '<th class="text-nowrap">Program Studi</th>',
            '<th class="text-nowrap">Jenis Magang</th>',
            '<th class="text-nowrap">Nama Perusahaan</th>',
            '<th class="text-nowrap">Posisi Magang</th>',
            '<th class="text-center text-nowrap">Dokumen</th>'
        ];

        $belum_spm = [
            '<th class="text-nowrap">No</th>',
            '<th class="text-nowrap">Nama/Nim</th>',
            '<th class="text-nowrap">Program Studi</th>',
            '<th class="text-nowrap">Jenis Magang</th>',
            '<th class="text-nowrap">Posisi Magang</th>',
            '<th class="text-center text-nowrap">Dokumen</th>'
        ];

        $columnsDiterima = "[
            {data: 'DT_RowIndex'},
            {data: 'mhs_name'},
            {data: 'namaprodi'},
            {data: 'namajenis'},
            {data: 'posisi'},
            {data: 'tanggalmagang'},
            {data: 'file_document'},
            {data: 'pembimbing_lapangan'},
            {data: 'pembimbing_akademik'},
            {data: 'nilai_akhir_magang'},
            {data: 'indeks_nilai_akhir'}
        ]";

        $columnsBelumMagang = "[
            {data: 'DT_RowIndex'},
            {data: 'mhs_name'},
            {data: 'namaprodi'},
            {data: 'namajenis'},
            {data: 'industri_name'},
            {data: 'posisi'},
            {data: 'file_document'}
        ]";

        $columnsBelumSPM = "[
            {data: 'DT_RowIndex'},
            {data: 'mhs_name'},
            {data: 'namaprodi'},
            {data: 'namajenis'},
            {data: 'posisi'},
            {data: 'file_document'}
        ]";

        $columnDefs = "
        {
            targets: 0,
            searchable: false,
            orderable: false,
            render: function (data, type, row, meta) {
                return `<input type='checkbox' class='dt-checkboxes form-check-input'  data-namamhs='` + row.namamhs + `' data-nim='` + row.nim + `' data-position='` + row.intern_position + `' data-industri='` + row.namaindustri + `' value='` + row.id_pendaftaran + `'>`;
            },
            checkboxes: {
                selectRow: false,
                selectAllRender: `<input type='checkbox' class='form-check-input'>`
            }
        }";

        return compact(
            'title',
            'urlGetData',
            'isLKM',
            'listTable',
            'listTab',
            'diterima',
            'belum_magang',
            'belum_spm',
            'columnsDiterima',
            'columnsBelumMagang',
            'columnsBelumSPM',
            'columnDefs'
        );
    }

    // private function generateDocumentLink($filename)
    // {
    //     $this->pendaftaran_magang->map(function ($data){
    //         if (isset($this->valid_steps[$data->current_step]) && ($data->tahapan_seleksi + 1) <= $this->valid_steps[$data->current_step]) {
    //             return '<a href="' .asset('storage/' . $data->file_document_mitra). '" target="_blank" class="text-nowrap text-primary">Bukti Penerimaan.pdf</a>';
    //         } elseif (in_array($data->current_step, $this->reject_steps)) {
    //             return '<a href="' .asset('storage/' . $data->file_document_mitra). '" target="_blank" class="text-nowrap text-primary">Bukti Penolakan.pdf</a>';
    //         } elseif ($data->file_document_mitra == null) {
    //             return '<span>-</span>';
    //         }
    //     });
    // }

    public function getDataTerimaToExcel(Request $request){
        $request->validate(['type' => ['required', 'in:diterima,belum_magang']]);

        $headings = [];
        if ($request->type=='diterima') {
            $filename = 'diterima_magang_' . date('Y-m-d') . '.xlsx';
            $headings = ['NO','NIM','NAMA','PROGRAM STUDI','JENIS MAGANG','NAMA PERUSAHAAN', 'POSISI MAGANG', 'MULAI MAGANG', 'SELESAI MAGANG', 'DOKUMEN','NAMA PEMBIMBING LAPANGAN', 'EMAIL PEMBIMBING LAPANGAN', 'NAMA DOSEN', 'NIP DOSEN', 'NILAI AKHIR', 'INDEKS NILAI AKHIR'];
        } elseif($request->type == 'belum_magang'){
            $filename = 'belum_magang_' . date('Y-m-d') . '.xlsx';
            $headings = ['NO','NIM','NAMA','PROGRAM STUDI','JENIS MAGANG','NAMA PERUSAHAAN', 'POSISI MAGANG', 'DOKUMEN'];
        }

        $this->getPendaftaranMagang(function ($query) use ($request) {
                if ($request->type == 'diterima') {
                    $query = $query->select(
                        'pendaftaran_magang.id_pendaftaran', 'mahasiswa.nim','mahasiswa.namamhs', 'program_studi.namaprodi', 'jenis_magang.namajenis', 'industri.namaindustri',
                        'lowongan_magang.intern_position','mhs_magang.startdate_magang', 'mhs_magang.enddate_magang','pendaftaran_magang.file_document_mitra',
                        'pegawai_industri.namapeg', 'pegawai_industri.emailpeg', 'dosen.namadosen', 'dosen.nip', 'mhs_magang.nilai_akhir_magang', 'mhs_magang.indeks_nilai_akhir'
                    )
                        ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                        ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang');
                    $query = $query->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
                } else if ($request->type == 'belum_magang') {
                    $query = $query->select(
                        'pendaftaran_magang.id_pendaftaran', 'mahasiswa.nim','mahasiswa.namamhs', 'program_studi.namaprodi', 'jenis_magang.namajenis', 'industri.namaindustri',
                        'lowongan_magang.intern_position','pendaftaran_magang.file_document_mitra'
                    )
                        ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                        ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang');
                    $query = $query->where(function ($q) {
                        $q->whereNull('pendaftaran_magang.id_pendaftaran')->orWhere('pendaftaran_magang.current_step', '!=', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
                    });
                }
                return $query;
        });
        return Excel::download(new DataMahasiswaMagangExport($this->pendaftaran_magang,$headings), $filename,\Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

}
