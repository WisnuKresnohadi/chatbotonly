<?php

namespace App\Http\Controllers\Logbook;

use App\Helpers\Response;
use App\Models\NilaiMutu;
use App\Models\LogbookDay;
use App\Models\LogbookWeek;
use App\Models\NilaiPemblap;
use Illuminate\Http\Request;
use App\Models\KomponenNilai;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use App\Models\BerkasAkhirMagang;
use App\Models\NilaiPembAkademik;
use App\Enums\LogbookWeeklyStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Enums\BerkasAkhirMagangStatus;
use App\Http\Requests\NilaiPembAkademikReq;
use App\Models\ConfigNilaiAkhir;
use App\Models\JenisMagang;
use App\Models\MhsMagang;
use App\Models\ProgramStudi;

class KelolaMahasiswaPemAkademikController extends LogbookController
{
    public function __construct() {
        $this->middleware('permission:kelola_mhs_pemb_akademik.view')->only(['index', 'getData', 'inputNilai', 'viewInputNilai', 'storeNilaiPembAkademik', 'viewLogbook']);
    }

    public function index()
    {
        $data['programStudi'] = ProgramStudi::where('status', 1)->get();
        $data['jenisMagang'] = JenisMagang::where('status', 1)->get();

        return view('kelola_mahasiswa.index', $data);
    }

    public function getData(Request $request)
    {
        try {
            $this->getMyMhsMagang(function ($query) use ($request) {
                $query =  $query->select(
                        'mhs_magang.id_mhsmagang', 'mahasiswa.namamhs', 'program_studi.namaprodi',
                        'jenis_magang.namajenis', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'industri.namaindustri',
                        'lowongan_magang.durasimagang', 'mhs_magang.nilai_akademik', 'mhs_magang.indeks_nilai_akademik'
                    )
                    ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                    ->join('lowongan_magang', 'pendaftaran_magang.id_lowongan', '=', 'lowongan_magang.id_lowongan')
                    ->join('industri', 'lowongan_magang.id_industri', '=', 'industri.id_industri')
                    ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
                    ->join('jenis_magang', 'jenis_magang.id_jenismagang', '=', 'mhs_magang.jenis_magang');

                if ($request->tahun_ajaran) $query = $query->where('lowongan_magang.id_year_akademik', $request->tahun_ajaran);
                if ($request->prodi) $query = $query->where('mahasiswa.id_prodi', $request->prodi);
                if ($request->magang) $query = $query->where('mhs_magang.jenis_magang', $request->magang);

                return $query;
            });

            $berkas = BerkasAkhirMagang::where('status_berkas', BerkasAkhirMagangStatus::APPROVED)
            ->whereIn('id_mhsmagang', $this->pendaftaran->pluck('id_mhsmagang')->toArray())->get();

            $response = DataTables::of($this->pendaftaran)
                ->addIndexColumn()
                ->editColumn('namamhs', function ($row) {
                    return $row->namamhs ?: '-';
                })
                ->editColumn('namaprodi', function ($row) {
                    return $row->namaprodi ?: '-';
                })
                ->editColumn('jenis_magang', function ($row) {
                    return $row->namajenis ?: '-';
                })
                ->editColumn('intern_position', function ($row) {
                    return $row->intern_position ?: '-';
                })
                ->editColumn('namaindustri', function ($row) {
                    return $row->namaindustri ?: '-';
                })
                ->editColumn('durasimagang', function ($row) {
                    $durasimagang = json_decode($row->durasimagang, true);
                    $durasimagangText = is_array($durasimagang) ? implode(' & ', $durasimagang) : $durasimagang;
                    return $durasimagangText ?: '-';
                })
                ->editColumn('nilai_akademik', function ($row) {
                    return $row->nilai_akademik ?: '-';
                })
                ->editColumn('indeks_nilai_akademik', function ($row) {
                    return $row->indeks_nilai_akademik ?: '-';
                })
                ->addColumn('berkas_akhir', function ($row) use ($berkas) {
                    $berkasPicked = $berkas->where('id_mhsmagang', $row->id_mhsmagang);

                    $result = '<div class="d-flex flex-column text-nowrap justify-content-start">';
                    if (count($berkasPicked) == 0) {
                        $result .= '<span>-</span>';
                    } else {
                        foreach ($berkasPicked as $key => $value) {
                            $result .= '<a href="' . url('storage/' . $value->berkas_file) . '" class="cursor-pointer text-primary my-1" target="_blank">' .$value->berkas_magang. '.pdf</a>';
                        }
                    }
                    $result .= '</div>';

                    return $result;
                })
                ->addColumn('aksi', function ($row) {
                    $x = "<div class='d-flex justify-content-center'>";
                    $x .= "<a href='".route('kelola_mhs_pemb_akademik.view_nilai', $row->id_mhsmagang)."' class='btn-icon text-warning' data-bs-toggle='tooltip' title='View Nilai'><i class='tf-icons ti ti-clipboard-list'></i></a>";
                    $x .= "<a href='" .route('kelola_mhs_pemb_akademik.logbook', $row->id_mhsmagang). "' class='btn-icon text-info' data-bs-toggle='tooltip' title='Logbook'><i class='tf-icons ti ti-book'></i></a>";
                    $x .= "</div>";

                    return $x;
                })
                ->rawColumns(['berkas_akhir', 'aksi'])
                ->make(true);

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function inputNilai($id, Request $request)
    {
        $nilaiLapangan = NilaiPemblap::where('id_mhsmagang', $id)->get();
        if ($request->ajax()) {
            if ($request->section == 'get_nilai_pemb_lap') {
                $nilaiAkhir = $nilaiLapangan->sum('nilai');
                $indexAkhir = NilaiMutu::select('nilaimutu')
                ->where('nilaimin', '<=', $nilaiAkhir)
                ->where('nilaimax', '>=', $nilaiAkhir)
                ->where('status', 1)->first()->nilaimutu;

                $result = view('kelola_mahasiswa/penilaian/components/modal_nilai_pemb_lapangan', compact('nilaiLapangan', 'nilaiAkhir', 'indexAkhir'))->render();
            } else {
                return Response::error(null, 'Invalid!');
            }

            return Response::success($result, 'Success.');
        }

        $this->getMyMhsMagang(function ($query) use ($id) {
            return $query->select(
                    'mhs_magang.id_mhsmagang', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'mahasiswa.namamhs',
                    'mahasiswa.nim', 'program_studi.namaprodi', 'mhs_magang.jenis_magang', 'mahasiswa.profile_picture',
                    'jenis_magang.namajenis', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'industri.namaindustri',
                    'lowongan_magang.durasimagang', 'mhs_magang.nilai_akhir_magang', 'mhs_magang.indeks_nilai_akhir',
                    'mahasiswa.id_prodi', 'mhs_magang.status_magang'
                )
                ->join('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                ->join('lowongan_magang', 'pendaftaran_magang.id_lowongan', '=', 'lowongan_magang.id_lowongan')
                ->join('industri', 'lowongan_magang.id_industri', '=', 'industri.id_industri')
                ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
                ->join('jenis_magang', 'jenis_magang.id_jenismagang', '=', 'mhs_magang.jenis_magang')
                ->where('mhs_magang.id_mhsmagang', $id);
        });

        $data['mahasiswa'] = $this->pendaftaran->first();
        if (!$data['mahasiswa']) return abort(404);
        $config = ConfigNilaiAkhir::where('id_prodi', $data['mahasiswa']->id_prodi)->where('status', 1)->first();
        if (!$config) return abort(403);

        $data['mahasiswa']->durasimagang = json_decode($data['mahasiswa']->durasimagang, true);

        $data['penilaian'] = NilaiPembAkademik::where('id_mhsmagang', $data['mahasiswa']->id_mhsmagang)->get();

        $data['nilai_mutu'] = NilaiMutu::select('nilaimin', 'nilaimax', 'nilaimutu')->where('status', 1)->get();
        $data['url_get_nilai_pemb_lapangan'] = route('kelola_mhs_pemb_akademik.view_nilai', ['id' => $id, 'section' => 'get_nilai_pemb_lap']);


        $data['urlInputNilai'] = null;
        if (count($nilaiLapangan) > 0 && $data['mahasiswa']->status_magang == 1) {
            $data['urlInputNilai'] = route('kelola_mhs_pemb_akademik.view_input_nilai', ['id' => $id]);
        }

        $nilaiMutu = $data['nilai_mutu'];

        $nilaiLapangan = $nilaiLapangan->sum('nilai');
        $nilaiAkademik = $data['penilaian']->sum('nilai');
        $hasilNilaiLapangan = isset($config) ? ($nilaiLapangan * ($config->nilai_pemb_lap / 100)) : '-';
        $hasilNilaiAkademik = isset($config) ? ($data['penilaian']->sum('nilai') * ($config->nilai_pemb_akademik / 100)) : '-';
        $nilaiAkhir = 0;

        $nilaiMutuAkhir = '-';
        if (isset($config)) {
            $nilaiAkhir = ($hasilNilaiLapangan + $hasilNilaiAkademik);
            $nilaiMutuAkhir = $nilaiMutu->where('nilaimin', '<=', $nilaiAkhir)->where('nilaimax', '>=', $nilaiAkhir)->first();
        }

        if (count($data['penilaian']) == 0) {
            $data['penilaian'] =  KomponenNilai::select('id_kompnilai', 'aspek_penilaian', 'deskripsi_penilaian', 'nilai_max')
            ->where('scored_by', 1)
            ->where('id_jenismagang', $data['mahasiswa']->jenis_magang)
            ->where('status', 1)->get();
        }

        $data['container_result_nilai_lap'] = view('kelola_mahasiswa/penilaian/components/result_nilai', [
            'nilai' => $nilaiLapangan,
            'presentaseNilai' => $config->nilai_pemb_lap ?? 0,
            'hasil' => $hasilNilaiLapangan
        ])->render();

        $data['container_result_nilai_akademik'] = view('kelola_mahasiswa/penilaian/components/result_nilai', [
            'nilai' => $nilaiAkademik,
            'presentaseNilai' => $config->nilai_pemb_akademik ?? 0,
            'hasil' => $hasilNilaiAkademik
        ])->render();

        $data['container_result_nilai_akhir'] = view('kelola_mahasiswa/penilaian/components/result_nilai', [
            'hasil' => $nilaiAkhir . '<span class="ms-1">(' .$nilaiMutuAkhir->nilaimutu. ')</span>'
        ])->render();

        $data['total_nilai_pa'] = $nilaiAkademik;

        return view('kelola_mahasiswa/penilaian/view_nilai_dosen', $data);
    }

    public function viewInputNilai($id)
    {
        $this->getMyMhsMagang(function ($query) use ($id) {
            return $query->select('mhs_magang.id_mhsmagang', 'mhs_magang.jenis_magang', 'mhs_magang.status_magang')
            ->where('mhs_magang.id_mhsmagang', $id);
        });

        $data['mahasiswa'] = $this->pendaftaran->first();
        if (!$data['mahasiswa']) return abort(404);
        if ($data['mahasiswa']->status_magang == 0) return abort(403);

        $data['nilaiLapangan'] = NilaiPemblap::where('id_mhsmagang', $data['mahasiswa']->id_mhsmagang)->get();
        $data['nilaiAkhir'] = $data['nilaiLapangan']->sum('nilai');
        $data['indexAkhir'] = NilaiMutu::select('nilaimutu')
        ->where('nilaimin', '<=', $data['nilaiAkhir'])
        ->where('nilaimax', '>=', $data['nilaiAkhir'])
        ->where('status', 1)->first()->nilaimutu;

        $data['penilaian'] = NilaiPembAkademik::where('id_mhsmagang', $data['mahasiswa']->id_mhsmagang)->get();
        if (count($data['penilaian']) == 0) {
            $data['penilaian'] =  KomponenNilai::select('id_kompnilai', 'aspek_penilaian', 'deskripsi_penilaian', 'nilai_max')
            ->where('scored_by', 1)
            ->where('id_jenismagang', $data['mahasiswa']->jenis_magang)
            ->where('status', 1)->get();
        }

        $data['nilai_mutu'] = NilaiMutu::select('nilaimin', 'nilaimax', 'nilaimutu')->where('status', 1)->get();
        $data['urlBack'] = route('kelola_mhs_pemb_akademik.view_nilai', ['id' => $id]);
        $data['urlStore'] = route('kelola_mhs_pemb_akademik.store_nilai', ['id' => $id]);

        return view('kelola_mahasiswa/penilaian/view_input_nilai_dosen', $data);
    }

    public function storeNilaiPembAkademik(NilaiPembAkademikReq $request, $id)
    {
        try {
            $user = auth()->user();

            $this->getMyMhsMagang(function ($query) use ($id) {
                return $query->select(
                    'mhs_magang.id_mhsmagang', 'mhs_magang.jenis_magang', 'mahasiswa.id_prodi'
                )
                ->where('mhs_magang.id_mhsmagang', $id);
            });

            $data['mahasiswa'] = $this->pendaftaran->first();
            if (!$data['mahasiswa']) return abort(404);

            $kompNilai = KomponenNilai::where('scored_by', 1)
            ->where('id_jenismagang', $data['mahasiswa']->jenis_magang)
            ->where('status', 1)->get();

            $errors = [];
            $total = 0;
            foreach ($request->id_kompnilai as $key => $value) {
                $komp_nilai = $kompNilai->where('id_kompnilai', $value)->first();
                if (!$komp_nilai) return Response::error(null, 'Invalid.');

                if ($komp_nilai->nilai_max < $request->nilai[$key]) {
                    $errors['nilai.' . $key] = ['Nilai tidak boleh lebih dari ' . $komp_nilai->nilai_max];
                }

                $total += $request->nilai[$key];
            }

            if (!empty($errors)) {
                return Response::errorValidate($errors, 'Gagal menyimpan nilai');
            };

            $dataStep = Crypt::decryptString($request->data_step);
            $config = ConfigNilaiAkhir::where('id_prodi', $data['mahasiswa']->id_prodi)->where('status', 1)->first();
            if (!$config) return Response::error(null, 'Config Nilai Not Found!');
            $nilaiLapangan = NilaiPemblap::where('id_mhsmagang', $data['mahasiswa']->id_mhsmagang)->sum('nilai');
            $nilaiMutu = NilaiMutu::where('status', 1)->get();

            $hasilNilaiLapangan = ($nilaiLapangan * ($config->nilai_pemb_lap / 100));
            $hasilNilaiAkademik = ($total * ($config->nilai_pemb_akademik / 100));
            $nilaiAkhir = ($hasilNilaiLapangan + $hasilNilaiAkademik);
            $nilaiMutuAkhir = $nilaiMutu->where('nilaimin', '<=', $nilaiAkhir)->where('nilaimax', '>=', $nilaiAkhir)->first();

            if ($dataStep == '1') {

                return Response::success([
                    'ignore_alert' => true,
                    'data_step' => (int) ($dataStep + 1),
                    'container_result_nilai_lap' => view('kelola_mahasiswa/penilaian/components/result_nilai', [
                        'nilai' => $nilaiLapangan,
                        'presentaseNilai' => $config->nilai_pemb_lap,
                        'hasil' => $hasilNilaiLapangan
                    ])->render(),
                    'container_result_nilai_akademik' => view('kelola_mahasiswa/penilaian/components/result_nilai', [
                        'nilai' => $total,
                        'presentaseNilai' => $config->nilai_pemb_akademik,
                        'hasil' => $hasilNilaiAkademik
                    ])->render(),
                    'container_result_nilai_akhir' => view('kelola_mahasiswa/penilaian/components/result_nilai', [
                        'hasil' => $nilaiAkhir . '<span class="ms-1 fw-bolder">(' .$nilaiMutuAkhir->nilaimutu. ')</span>'
                    ])->render(),
                ], 'Valid data!');
            }

            DB::beginTransaction();
            $total = 0;
            foreach ($request->id_kompnilai as $key => $value) {
                $komp_nilai = $kompNilai->where('id_kompnilai', $value)->first();

                NilaiPembAkademik::updateOrCreate([
                    'id_mhsmagang' => $id,
                    'id_kompnilai' => $value
                ], [
                    'nilai' => $request->nilai[$key],
                    'oleh' => $user->name,
                    'id_user' => $user->id,
                    'dateinputnilai' => now(),
                    'aspek_penilaian' => $komp_nilai->aspek_penilaian,
                    'nilai_max' => $komp_nilai->nilai_max,
                    'deskripsi_penilaian' => $komp_nilai->deskripsi_penilaian
                ]);

                $total += $request->nilai[$key];
            }

            $nilaiMutu = $nilaiMutu->where('nilaimin', '<=', $total)->where('nilaimax', '>=', $total)->first();

            $mhsMagang = MhsMagang::where('id_mhsmagang', $id)->first();
            $mhsMagang->indeks_nilai_akademik = $nilaiMutu->nilaimutu;
            $mhsMagang->nilai_akademik = $total;
            $mhsMagang->indeks_nilai_akhir = $nilaiMutuAkhir->nilaimutu;
            $mhsMagang->nilai_akhir_magang = $nilaiAkhir;
            $mhsMagang->save();

            DB::commit();
            return Response::success(null, 'Berhasil menyimpan data nilai pembimbing akademik.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function viewLogbook(Request $request, $id)
    {
        $data['list_week'] = LogbookWeek::select('id_logbook_week', 'week', 'status', 'start_date', 'end_date')
        ->whereHas('logbook', function ($q) use ($id) {
            $q->where('id_mhsmagang', $id);
        })
        ->where('status', LogbookWeeklyStatus::APPROVED)
        ->orderBy('start_date', 'asc');

        if ($request->ajax()) {
            if ($request->section == 'get_logbook_week') {
                if ($request->data_id == null) {
                    $result['container_detail_logbook_weekly'] = '<h4 class="text-center">Belum di pilih</h4>';
                } else {
                    $logbook_week = LogbookWeek::select('week', 'id_logbook_week', 'status', 'alasan_tolak')->where('id_logbook_week', $request->data_id)->first();
                    if ($logbook_week->status == LogbookWeeklyStatus::NOT_YET_APPLIED) {
                        $result['container_detail_logbook_weekly'] = '<h4 class="text-center">Belum diajukan</h4>';
                    } else {
                        $data = LogbookDay::where('id_logbook_week', $request->data_id)->orderBy('date', 'asc')->get();
                        $week = $request->week;
                        $result['container_detail_logbook_weekly'] = view('kelola_mahasiswa/logbook/components/detail_logbook_weekly', compact('data', 'logbook_week', 'week'))->render();
                    }
                }
            } elseif ($request->section == 'get_list_week') {
                $data['list_week'] = $data['list_week']->where(function ($query) use ($request) {
                    $query->whereMonth('start_date', ($request->selected_month + 1))->orWhereMonth('end_date', ($request->selected_month + 1));
                })->get();

                $result['container_left_card'] = view('kelola_mahasiswa/logbook/components/left_card_week', $data)->render();
            } else {
                return Response::error(null, 'Invalid Request', 400);
            }

            return Response::success($result, 'Success');
        }

        $this->getMyMhsMagang(function ($query) use ($id) {
            return $query->select('mahasiswa.namamhs', 'mahasiswa.profile_picture', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'mhs_magang.id_mhsmagang',
                'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'jenis_magang.durasimagang', 'jenis_magang.namajenis', 'industri.namaindustri')
                ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
                ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang')
                ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
                ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
                ->leftJoin('pegawai_industri', 'pegawai_industri.id_peg_industri', '=', 'mhs_magang.id_peg_industri')
                ->where('mhs_magang.id_mhsmagang', $id);
        });

        $data['mahasiswa'] = $this->pendaftaran->first();

        $data['list_week'] = $data['list_week']->where(function ($query) {
            $query->whereMonth('start_date', now()->format('m'))->orWhereMonth('end_date', now()->format('m'));
        })->get();

        $data['list_month'] = $this->getListMonth('M')->list_month;

        $data['url_get'] = route('kelola_mhs_pemb_akademik.logbook', $id);
        $data['urlBack'] = route('kelola_mhs_pemb_akademik');

        $data['periode_magang'] = Carbon::parse($data['mahasiswa']->startdate_magang)->translatedFormat('d F Y') . ' - ' . Carbon::parse($data['mahasiswa']->enddate_magang)->translatedFormat('d F Y');

        return view('kelola_mahasiswa.logbook.logbook', $data);
    }

    private function getMyMhsMagang($additional = null)
    {
        $user = auth()->user();
        $dosen = $user->dosen;

        $this->getPendaftaranMagang(function ($query) use ($additional, $dosen) {
            $query = $query->join('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->where('mhs_magang.nip', $dosen->nip);

            if ($additional != null) $query = $additional($query);

            return $query;
        });

        return $this;
    }
}
