<?php

namespace App\Http\Controllers\Logbook;

use App\Helpers\Response;
use App\Models\MhsMagang;
use App\Models\NilaiMutu;
use App\Models\LogbookDay;
use App\Models\LogbookWeek;
use App\Models\NilaiPemblap;
use Illuminate\Http\Request;
use App\Models\KomponenNilai;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use App\Enums\LogbookWeeklyStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\Logbook;

class LogbookPemLapController extends LogbookController
{
    public function viewList()
    {
        return view('kelola_mahasiswa.kelola_mahasiswa_lapangan.index');
    }

    public function getData(Request $request)
    {
        $this->getMyPendaftarMagang(function ($query) use ($request) {
            $query = $query->select(
                'mhs_magang.id_mhsmagang', 'mahasiswa.namamhs', 'program_studi.namaprodi', 'lowongan_magang.intern_position', 
                'lowongan_magang.durasimagang', 'jenis_magang.namajenis', 'mhs_magang.nilai_lap', 'mhs_magang.indeks_nilai_lap',
                'mhs_magang.status_magang'
            )
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->leftJoin('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang');

            if ($request->tahun_akademik) {
                $query = $query->where('lowongan_magang.id_year_akademik', $request->tahun_akademik);
            }
            
            if ($request->posisi) {
                $query = $query->where('lowongan_magang.intern_position', 'like', '%' . $request->posisi . '%');
            }

            return $query;
        });

        $logbook = Logbook::whereIn('id_mhsmagang', $this->pendaftaran->pluck('id_mhsmagang')->toArray())->get();

        return datatables()->of($this->pendaftaran)
        ->addIndexColumn()
        ->editColumn('durasimagang', fn ($x) => implode(' dan ', json_decode($x->durasimagang)))
        ->addColumn('nilai_akhir', fn ($x) => '<div class="text-center">' . $x->nilai_lap . '</div>')
        ->addColumn('indeks', fn ($x) => '<div class="text-center">' . $x->indeks_nilai_lap . '</div>')
        ->addColumn('status', function ($x) {
            $result = '<div class="d-flex justify-content-center">';
            if ($x->status_magang) {
                $result .= '<span class="badge bg-label-primary">Aktif</span>';
            } else {
                $result .= '<span class="badge bg-label-danger">Non Aktif</span>';
            }
            $result .= '</div>';

            return $result;
        })
        ->addColumn('aksi', function ($x) use ($logbook) {
            $result = '<div class="d-flex justify-content-center">';
            if ($logbook->where('id_mhsmagang', $x->id_mhsmagang)->count() > 0) {
                $result .= '<a class="cursor-pointer mx-1 text-warning" href="'.route('kelola_magang_pemb_lapangan.input_nilai', $x->id_mhsmagang).'" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Penilaian"><i class="ti ti-clipboard-list"></i></a>';
            } else {
                $result .= '<a class="cursor-pointer mx-1 text-secondary" onclick="return false;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Tidak dapat menilai sekarang"><i class="ti ti-clipboard-list"></i></a>';
            }
            $result .= '<a class="cursor-pointer mx-1 text-info" href="'.route('kelola_magang_pemb_lapangan.logbook', $x->id_mhsmagang).'" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Logbook Mahasiswa"><i class="ti ti-book"></i></a>';
            $result .= '<a class="cursor-pointer mx-1 text-danger" onclick="deleteMhsMagang($(this))" data-mahasiswa="'.$x->namamhs.'" data-id="'.$x->id_mhsmagang.'"><i class="ti ti-circle-x"></i></a>';
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['nilai_akhir', 'indeks', 'status', 'aksi'])
        ->make(true);
    }

    public function deleteMhs(Request $request, $id)
    {
        $request->validate([
            'reason_kick' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ], [
            'reason_kick.required' => 'Alasan harus diisi',
            'file.required' => 'File harus diisi',
            'file.mimes' => 'File harus berformat PDF',
            'file.max' => 'File maksimal 2 MB'
        ]);

        try {
            DB::beginTransaction();

            $mhsMagang = MhsMagang::with('pendaftaran')->where('id_mhsmagang', $id)->first();
            if (!$mhsMagang) return Response::error(null, 'Data Not Found.');

            $pendaftaran = PendaftaranMagang::where('id_pendaftaran', $mhsMagang->id_pendaftaran)->first();
            if ($pendaftaran->current_step != PendaftaranMagangStatusEnum::APPROVED_PENAWARAN) {
                return Response::error(null, 'Invalid.');
            }

            $mhsMagang->status_magang = 0;
            $mhsMagang->alasan_pemulangan = $request->reason_kick;

            $file = null;
            if ($request->hasFile('file')) {
                $file = Storage::put('dokumen_pemulangan', $request->file);
            }
            $mhsMagang->berkas_pemulangan = $file;
            $mhsMagang->save();

            $pendaftaran->current_step = PendaftaranMagangStatusEnum::DIBERHENTIKAN_MAGANG;
            $pendaftaran->saveHistoryApproval()->save();

            DB::commit();
            return Response::success(null, 'Berhasil Mengeluarkan Mahasiswa');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function viewLogbook(Request $request, $id)
    {
        $isPembLapangan = true;

        $data['list_week'] = LogbookWeek::select('id_logbook_week', 'week', 'status', 'start_date', 'end_date')
        ->whereHas('logbook', function ($q) use ($id) {
            $q->where('id_mhsmagang', $id);
        })
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
                        $result['container_detail_logbook_weekly'] = view('kelola_mahasiswa/logbook/components/detail_logbook_weekly', compact('data', 'logbook_week', 'isPembLapangan', 'week'))->render();
                    }
                }
            } elseif ($request->section == 'get_list_week') {
                $data['list_week'] = $data['list_week']->where(function ($query) use ($request) {
                    $query->whereMonth('start_date', ($request->selected_month + 1))->orWhereMonth('end_date', ($request->selected_month + 1));
                })->get();

                $data['showStatus'] = true;
                $result['container_left_card'] = view('kelola_mahasiswa/logbook/components/left_card_week', $data)->render();
            } else {
                return Response::error(null, 'Invalid Request', 400);
            }

            return Response::success($result, 'Success');
        }

        $this->getMyPendaftarMagang(function ($query) use ($id) {
            return $query->select(
                    'mahasiswa.namamhs', 'mahasiswa.profile_picture', 'lowongan_magang.intern_position', 'mhs_magang.id_mhsmagang',
                    'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'jenis_magang.durasimagang', 'jenis_magang.namajenis', 'industri.namaindustri'
                )
                ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
                ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang')
                ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
                ->leftJoin('pegawai_industri', 'pegawai_industri.id_peg_industri', '=', 'mhs_magang.id_peg_industri')
                ->where('mhs_magang.id_mhsmagang', $id);
        });

        $data['mahasiswa'] = $this->pendaftaran->first();
        if (!$data['mahasiswa']) abort(403);

        $data['periode_magang'] = Carbon::parse($data['mahasiswa']->startdate_magang)->translatedFormat('d F Y') . ' - ' . Carbon::parse($data['mahasiswa']->enddate_magang)->translatedFormat('d F Y');
        
        $data['list_week'] = $data['list_week']->where(function ($query) {
            $query->whereMonth('start_date', now()->format('m'))->orWhereMonth('end_date', now()->format('m'));
        })->get();
        $data['showStatus'] = true;

        $data['list_month'] = $this->getListMonth('M')->list_month;
        $data['isPembLapangan'] = $isPembLapangan;
        $data['url_get'] = route('kelola_magang_pemb_lapangan.logbook', $id);
        $data['urlBack'] = route('kelola_magang_pemb_lapangan');
        return view('kelola_mahasiswa.logbook.logbook', $data);
    }

    public function approval(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejected_reason' => 'required_if:status,rejected',
            'week' => 'required',
            'selected_month' => 'required|min:0|max:11',
        ]);

        try {
            $logbookWeek = LogbookWeek::where('status', LogbookWeeklyStatus::PENDING)->where('id_logbook_week', $id)->first();
            if (!$logbookWeek) return Response::error(null, 'Logbook not found', 404);

            if ($request->status == 'approved') {
                $logbookWeek->status = LogbookWeeklyStatus::APPROVED;
            } else {
                $logbookWeek->status = LogbookWeeklyStatus::REJECTED;
                $logbookWeek->alasan_tolak = $request->rejected_reason;
            }

            $logbookWeek->save();

            $logbookWeek = $logbookWeek->load('logbook');

            $listLogbookWeek = LogbookWeek::select('id_logbook_week', 'week', 'status', 'start_date', 'end_date')
            ->whereHas('logbook', function ($q) use ($logbookWeek) {
                $q->where('id_mhsmagang', $logbookWeek->logbook->id_mhsmagang);
            })
            ->where(function ($query) use ($request) {
                $query->whereMonth('start_date', ($request->selected_month + 1))
                ->orWhereMonth('end_date', ($request->selected_month + 1));
            })
            ->orderBy('start_date', 'asc')->get();

            $logbookDaily = LogbookDay::where('id_logbook_week', $id)->get();
            return Response::success([
                'view_left_card' => view('kelola_mahasiswa/logbook/components/left_card_week', [
                    'list_week' => $listLogbookWeek,
                    'checked' => $id,
                    'showStatus' => true
                ])->render(),
                'view_rejected_reason' => view('kelola_mahasiswa/logbook/components/rejected_reason', ['logbook_week' => $logbookWeek])->render(),
                'view_logbook' => view('kelola_mahasiswa/logbook/components/detail_logbook_weekly', [
                    'logbook_week' => $logbookWeek,
                    'data' => $logbookDaily,
                    'week' => $request->week
                ])->render()
            ], 'Berhasil menyetujui logbook');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function viewInputNilai($id)
    {
        $user = auth()->user();
        $pegawai = $user->pegawai_industri;

        $data['fillable'] = true;
        $data['mhs_magang'] = MhsMagang::select('id_mhsmagang', 'jenis_magang', 'nilai_akademik', 'nilai_lap', 'indeks_nilai_akademik')->where('id_peg_industri', $pegawai->id_peg_industri)->where('id_mhsmagang', $id)->first();

        if (!$data['mhs_magang']) return Response::error(null, 'Mahasiswa not found', 404);
        if ($data['mhs_magang']->nilai_akademik != null) $data['fillable'] = false;

        $data['data_nilai'] = NilaiPemblap::select('id_kompnilai', 'nilai', 'aspek_penilaian', 'deskripsi_penilaian', 'nilai_max')
        ->where('id_mhsmagang', $id)->get();

        if (count($data['data_nilai']) == 0) {
            $data['data_nilai'] = KomponenNilai::select('id_kompnilai', 'aspek_penilaian', 'deskripsi_penilaian', 'nilai_max')
            ->where('scored_by', 2)
            ->where('id_jenismagang', $data['mhs_magang']->jenis_magang)
            ->where('status', 1)->get();
        }

        $data['nilai_mutu'] = NilaiMutu::select('nilaimin', 'nilaimax', 'nilaimutu')->where('status', 1)->get();
        
        return view('kelola_mahasiswa/penilaian/index', $data);
    }

    public function storeNilai(Request $request, $id)
    {
        $request->validate([
            'id_kompnilai' => 'required|array',
            'id_kompnilai.*' => 'required|exists:komponen_nilai,id_kompnilai',
            'nilai' => 'required|array',
            'nilai.*' => 'required|integer'
        ], [
            'id_kompnilai.required' => 'Invalid.',
            'id_kompnilai.array' => 'Invalid.',
            'id_kompnilai.*.required' => 'Invalid.',
            'id_kompnilai.*.exists' => 'Invalid.',
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.array' => 'Nilai wajib diisi.',
            'nilai.*.required' => 'Nilai wajib diisi.',
            'nilai.*.integer' => 'Nilai harus berupa bilangan bulat.'
        ]);

        try {
            $user = auth()->user();
            $pegawai = $user->pegawai_industri;

            $mhs_magang = MhsMagang::where('id_peg_industri', $pegawai->id_peg_industri)->where('id_mhsmagang', $id)->first();
            if (!$mhs_magang) return Response::error(null, 'Mahasiswa not found', 404);
            if ($mhs_magang->nilai_akademik != null) return Response::error(null, 'Sudah tidak dapat memperbarui nilai.', 403);

            $logbook = Logbook::select(DB::raw(1))->where('id_mhsmagang', $mhs_magang->id_mhsmagang)->first();
            if (!$logbook) return Response::error(null, 'Tidak dapat menginput nilai sekarang', 403);

            $kompNilai = KomponenNilai::where('scored_by', 2)
            ->where('id_jenismagang', $mhs_magang->jenis_magang)
            ->where('status', 1)->get();

            DB::beginTransaction();

            $errors = [];
            $total = 0;
            foreach ($request->id_kompnilai as $key => $value) {
                $komp_nilai = $kompNilai->where('id_kompnilai', $value)->first();
                if (!$komp_nilai) return Response::error(null, 'Invalid.');
                
                if ($komp_nilai->nilai_max < $request->nilai[$key]) {
                    $errors['nilai.' . $key] = ['Nilai tidak boleh lebih dari ' . $komp_nilai->nilai_max];
                }

                NilaiPemblap::updateOrCreate([
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

            if (!empty($errors)) {
                DB::rollBack();
                return Response::errorValidate($errors, 'Gagal menyimpan nilai');
            };

            $nilaiMutu = NilaiMutu::where('nilaimin', '<=', $total)
            ->where('nilaimax', '>=', $total)->where('status', 1)
            ->first();

            $mhs_magang->indeks_nilai_lap = $nilaiMutu->nilaimutu;
            $mhs_magang->nilai_lap = $total;
            $mhs_magang->save();

            DB::commit();
            return Response::success(null, 'Berhasil menyimpan nilai.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    private function getMyPendaftarMagang($additional = null)
    {
        $user = auth()->user();
        $pegawai = $user->pegawai_industri;

        $this->getPendaftaranMagang(function ($query) use ($additional, $pegawai) {
            $query = $query->join('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->where('mhs_magang.id_peg_industri', $pegawai->id_peg_industri);

            if ($additional != null) $query = $additional($query);

            return $query;
        });

        return $this;
    }
}

