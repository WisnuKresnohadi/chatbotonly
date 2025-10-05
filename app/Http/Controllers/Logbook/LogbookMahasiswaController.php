<?php

namespace App\Http\Controllers\Logbook;

use App\Enums\LogbookWeeklyStatus;
use App\Models\Logbook;
use Carbon\CarbonPeriod;
use App\Helpers\Response;
use App\Models\LogbookDay;
use App\Models\LogbookWeek;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LogbookMahasiswaController extends LogbookController
{
    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->getMyPendaftaranMagang(function ($query) {
            return $query->select('industri.image', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'industri.namaindustri',
            'mhs_magang.id_mhsmagang', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'jenis_magang.durasimagang',
            'pendaftaran_magang.id_pendaftaran','pendaftaran_magang.dokumen_skm','jenis_magang.namajenis', 'dosen.namadosen', 'pegawai_industri.namapeg')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
            ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
            ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang')
            ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
            ->leftJoin('dosen', 'dosen.nip', '=', 'mhs_magang.nip')
            ->leftJoin('pegawai_industri', 'pegawai_industri.id_peg_industri', '=', 'mhs_magang.id_peg_industri')
            ->where('mhs_magang.status_magang', 1);
        });

        $data['data'] = $this->pendaftaran->first();
        if ($data['data'] == null) return view('errors.error_custom', [
            'title' => '<span class="text-muted fw-light">Kegiatan Saya /</span> Logbook',
            'message_1' => 'Anda Tidak Dalam Masa Magang',
            'message_2' => 'Anda tidak dalam masa magang. Kami sarankan untuk menghubungi LKM untuk informasi lebih lanjut.',
        ]);
        if ($data['data']->dokumen_skm == null) return view('errors.error_custom', [
            'title' => '<span class="text-muted fw-light">Kegiatan Saya /</span> Logbook',
            'message_1' => 'Anda Belum Dapat Mengisi Logbook',
            'message_2' => 'Anda belum dapat mengisi Logbook karena LKM belum mengirimkan surat keterangan magang. Kami sarankan untuk menghubungi LKM guna tindak lanjut proses tersebut.',
        ]);

        $logbook = Logbook::where([
            'id_mhsmagang' => $data['data']->id_mhsmagang,
            'id_pendaftaran' => $data['data']->id_pendaftaran,
        ])->first();

        // $data['id_logbook'] = $logbook->id_logbook;

        $current_month = ($request->current_month != null)? ($request->current_month + 1) : Carbon::now()->month;
        $data['logbook_week'] = [];
        if ($logbook) {
            $data['id_logbook'] = $logbook->id_logbook;
            $data['logbook_week'] = LogbookWeek::with(['logbookDay' => function($query){
                $query->where('activity', '!=', 'Libur');
            }])->where('id_logbook', $logbook->id_logbook)
            ->where(function ($query) use ($current_month) {
                $query->whereMonth('start_date', $current_month)->orWhereMonth('end_date', $current_month);
            })
            ->orderBy('start_date', 'asc')
            ->get()->transform(function ( $logbookWeek) {
                $logbookWeek->status = $this->getStatusLogbookWeek($logbookWeek);
                return $logbookWeek;
            });
        }

        if ($request->ajax()) {
            $result = null;
            if ($request->section == 'get_logbook_week') {
                $result['view_card_weekly'] = view('logbook/components/card_weekly', $data)->render();
            } else {
                return Response::error(null, 'Invalid');
            }
            return Response::success($result, 'Success');
        }

        $data['list_month'] = $this->getListMonth()->list_month;

        $data['total_days'] = CarbonPeriod::create($data['data']->startdate_magang, $data['data']->enddate_magang)->count();
        $data['filled_days'] = self::filledDays($data['logbook_week']);
        $data['percentage']= self::percentage($data['filled_days'], $data['total_days']);

        $data['periode_magang'] = Carbon::parse($data['data']->startdate_magang)->translatedFormat('d F Y') . ' - ' . Carbon::parse($data['data']->enddate_magang)->translatedFormat('d F Y');
        return view('logbook.logbook',$data);
    }

    public function detail(Request $request, $id)
    {
        $data['data'] = LogbookWeek::where('id_logbook_week', $id)->first();
        if ($data['data'] == null) return abort(403);

        if ($request->ajax()) {
            if ($request->section == 'get_logbook_daily') {
                $request->validate(['data_id' => 'required']);

                $logbook = LogbookDay::select('emoticon', 'activity', 'date')->where('id_logbook_day', $request->data_id)->first();
                if (!$logbook) return Response::error(null, 'Logbook daily tidak ditemukan.');

                return Response::success($logbook, 'Success');
            } else {
                return Response::error(null, 'Invalid Request', 400);
            }
        }

        $this->getMyPendaftaranMagang(function ($query) {
            return $query->select('mahasiswa.namamhs', 'mahasiswa.nim', 'program_studi.namaprodi', 'universitas.namauniv', 'mahasiswa.profile_picture')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
            ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
            ->where('mhs_magang.status_magang', 1);
        });

        $data['mahasiswa'] = $this->pendaftaran->first();

        if (!$data['mahasiswa']) return abort(403);

        $logbook_daily = $this->getLogbookDaily($data['data']);
        $data['logbook_day'] = $logbook_daily['logbook_day'];
        $data['can_apply'] = $logbook_daily['can_apply'];
        $data['percentage'] = $logbook_daily['percentage'];

        $data['data']->label_status = $this->getStatusLogbookWeek($data['data']);
        $data['data']['emoticon'] = $data['data']->logbookDay->where('activity', '!=', 'Libur');

        return view('logbook.logbook_detail', $data);
    }

    public function storeCreateLogbook(Request $request)
    {
        $this->getMyPendaftaranMagang(function ($query) {
            return $query->select('mhs_magang.id_mhsmagang', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'pendaftaran_magang.id_pendaftaran')
            ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
            ->where('mhs_magang.status_magang', 1);
        });

        $pendaftaran = $this->pendaftaran->first();

        $request->validate([
            'range_date' => ['required', function ($attribute, $value, $fail) use ($pendaftaran) {
                $startdate_magang = Carbon::parse($pendaftaran->startdate_magang);
                $enddate_magang = Carbon::parse($pendaftaran->enddate_magang);

                $value = explode(' to ', $value);
                $startDate = Carbon::parse($value[0]);
                $endDate = Carbon::parse($value[0]);
                if (count($value) > 1) {
                    $endDate = Carbon::parse($value[1]);
                }

                if (
                    $startDate->gt($endDate) &&
                    $startDate->lt($startdate_magang) &&
                    $endDate->gt($enddate_magang)
                ) {
                    $fail('Range date tidak valid');
                }
            }],
            'current_month' => ['required', 'numeric', 'min:0', 'max:11']
        ]);

        try {
            DB::beginTransaction();

            $value = explode(' to ', $request->range_date);
            $startDate = Carbon::parse($value[0]);
            $endDate = Carbon::parse($value[0]);
            if (count($value) > 1) {
                $endDate = Carbon::parse($value[1]);
            }

            $logbook = Logbook::firstOrCreate([
                'id_mhsmagang' => $pendaftaran->id_mhsmagang,
                'id_pendaftaran' => $pendaftaran->id_pendaftaran,
            ]);

            $dateUsed = CarbonPeriod::create($startDate, $endDate)->toArray();
            $dateUsed = array_map(function($date) {
                return $date->toDateString();
            }, $dateUsed);

            $logbookWeek = LogbookWeek::where('id_logbook', $logbook->id_logbook)
            ->where(function($query) use ($dateUsed) {
                foreach ($dateUsed as $date) {
                    $query->orWhere(function($q) use ($date) {
                        $q->whereDate('start_date', '<=', $date)
                          ->whereDate('end_date', '>=', $date);
                    });
                }
            })->count();

            if ($logbookWeek > 0) return Response::error(null, 'Logbook sudah ada');

            $week = LogbookWeek::where('id_logbook', $logbook->id_logbook)
            ->orderBy('week', 'desc')
            ->first()?->week + 1 ?: 1;

            $logbookWeek = LogbookWeek::create([
                'id_logbook' => $logbook->id_logbook,
                'week' => $week,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d')
            ]);

            $logbookSunday = LogbookDay::create([
                'id_logbook_week' => $logbookWeek->id_logbook_week,
                'date' => $startDate->format('Y-m-d'),
                'emoticon' => '4',
                'activity' => 'Libur'
            ]);

            $logbookSaturday = LogbookDay::create([
                'id_logbook_week' => $logbookWeek->id_logbook_week,
                'date' => $endDate->format('Y-m-d'),
                'emoticon' => '4',
                'activity' => 'Libur'
            ]);

            DB::commit();

            $logbook_week = LogbookWeek::with(['logbookDay' => function($query){
                $query->where('activity', '!=', 'Libur');
            }])->where('id_logbook', $logbook->id_logbook)
            ->where(function ($query) use ($request) {
                $query->whereMonth('start_date', ($request->current_month + 1))->orWhereMonth('end_date', ($request->current_month + 1));
            })
            ->orderBy('start_date', 'asc')
            ->get()->transform(function ($item) {
                $item->status = $this->getStatusLogbookWeek($item);
                return $item;
            });
            return Response::success([
                'view' => view('logbook/components/card_weekly', compact('logbook_week'))->render()
            ], 'Berhasil membuat logbook');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function storeLogbookDaily(Request $request, $id_logbook_week)
    {
        $request->validate([
            'activity' => ['required', 'string']
        ], ['activity.required' => 'Aktivitas harus diisi']);

        try {
            $user = auth()->user();
            $nim = $user->mahasiswa?->nim;

            $logbookWeek = LogbookWeek::whereHas('logbook', function ($q) use ($nim) {
                $q->whereHas('pendaftaran', function ($q2) use ($nim) {
                    $q2->where('nim', $nim);
                });
            })->where('id_logbook_week', $id_logbook_week)->first();

            $date = Carbon::parse($request->date);
            if (!$logbookWeek) return Response::error(null, 'Logbook Week Not Found');
            if ($date->lt($logbookWeek->start_date) || $date->gt($logbookWeek->end_date)) return Response::error(null, 'Tidak valid');
            if (!in_array($request->emoticon, [1, 2, 3, 4, 5])) return Response::error(null, 'Pilih mood anda pada hari ini.');

            LogbookDay::create([
                'id_logbook_week' => $id_logbook_week,
                'date' => $date->format('Y-m-d'),
                'emoticon' => $request->emoticon,
                'activity' => $request->activity
            ]);

            $logbookWeek->label_status = $this->getStatusLogbookWeek($logbookWeek);
            $logbookWeek = $logbookWeek->load('logbookDay');
            $logbookWeek['emoticon'] = $logbookWeek->logbookDay->where('activity', '!=', 'Libur');

            $logbook_daily = $this->getLogbookDaily($logbookWeek);

            $logbook_day = $logbook_daily['logbook_day'];
            $can_apply = $logbook_daily['can_apply'];
            $percentage = $logbook_daily['percentage'];

            return Response::success([
                'view' => view('logbook/components/card_daily', ['data' => $logbookWeek, 'logbook_day' => $logbook_day, 'can_apply' => $can_apply])->render(),
                'view_left_card' => view('logbook/components/left_card_detail', ['data' => $logbookWeek])->render(),
                'view_percentage' => view('logbook/components/percentage', ['percentage' => $percentage])->render()
            ], 'Logbook daily ditambahkan');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function changeLogbookType(Request $request, $id_logbook_week)
    {
        try {
            $user = auth()->user();

            $logbookWeek = LogbookWeek::where('id_logbook_week', $id_logbook_week)->first();

            $date = Carbon::parse($request->date);
            if (!$logbookWeek) return Response::error(null, 'Logbook Week Not Found');
            if ($date->lt($logbookWeek->start_date) || $date->gt($logbookWeek->end_date)) return Response::error(null, 'Tidak valid');
            // if (!in_array($request->emoticon, [1, 2, 3, 4, 5])) return Response::error(null, 'Pilih mood anda pada hari ini.');

            if(LogbookDay::where('id_logbook_week', $id_logbook_week)->where('date', $date->format('Y-m-d'))->count() > 0) {
                if($request->type == 'libur') {
                    LogbookDay::where('id_logbook_week', $id_logbook_week)->where('date', $date->format('Y-m-d'))->update([
                        'emoticon' => '4',
                        'activity' => 'Libur'
                    ]);
                } else {
                    LogbookDay::where('id_logbook_week', $id_logbook_week)->where('date', $date->format('Y-m-d'))->delete();
                }
            }else{
                LogbookDay::create([
                    'id_logbook_week' => $id_logbook_week,
                    'date' => $date->format('Y-m-d'),
                    'emoticon' => '4',
                    'activity' => 'Libur'
                ]);
            }

            $logbookWeek->label_status = $this->getStatusLogbookWeek($logbookWeek);
            $logbookWeek = $logbookWeek->load('logbookDay');
            $logbookWeek['emoticon'] = $logbookWeek->logbookDay->where('activity', '!=', 'Libur');

            $logbook_daily = $this->getLogbookDaily($logbookWeek);

            $logbook_day = $logbook_daily['logbook_day'];
            $can_apply = $logbook_daily['can_apply'];
            $percentage = $logbook_daily['percentage'];

            return Response::success([
                'view' => view('logbook/components/card_daily', ['data' => $logbookWeek, 'logbook_day' => $logbook_day, 'can_apply' => $can_apply])->render(),
                'view_left_card' => view('logbook/components/left_card_detail', ['data' => $logbookWeek])->render(),
                'view_percentage' => view('logbook/components/percentage', ['percentage' => $percentage])->render()
            ], 'Logbook berhasil diubah');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateLogbookDaily(Request $request, $id)
    {
        $request->validate([
            'activity' => ['required', 'string'],
        ], ['activity.required' => 'Aktivitas harus diisi']);

        try {
            if (!in_array($request->emoticon, [1, 2, 3, 4, 5])) return Response::error(null, 'Pilih mood anda.');

            $logbookDaily = LogbookDay::with('logbookWeek')->where('id_logbook_day', $id)->first();
            if (!$logbookDaily) return Response::error(null, 'Logbook Daily Not Found');

            $logbookDaily->activity = $request->activity;
            $logbookDaily->emoticon = $request->emoticon;
            $logbookDaily->save();

            $logbookWeek = $logbookDaily->logbookWeek;
            $logbookWeek->label_status = $this->getStatusLogbookWeek($logbookWeek);
            $logbookWeek['emoticon'] = $logbookWeek->logbookDay->where('activity', '!=', 'Libur');

            $logbook_daily = $this->getLogbookDaily($logbookWeek->load('logbookDay'));

            $logbook_day = $logbook_daily['logbook_day'];
            $can_apply = $logbook_daily['can_apply'];
            $percentage = $logbook_daily['percentage'];

            return Response::success([
                'view' => view('logbook/components/card_daily', ['data' => $logbookWeek, 'logbook_day' => $logbook_day, 'can_apply' => $can_apply])->render(),
                'view_left_card' => view('logbook/components/left_card_detail', ['data' => $logbookWeek])->render(),
                'view_percentage' => view('logbook/components/percentage', ['percentage' => $percentage])->render()
            ], 'Logbook daily diupdate');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function applyLogbook($id_logbook_week)
    {
        try {
            $logbookWeekly = LogbookWeek::with('logbookDay')->where('id_logbook_week', $id_logbook_week)->first();
            if (!$logbookWeekly) return Response::error(null, 'Logbook Daily Not Found');

            $dateUsed = CarbonPeriod::create($logbookWeekly->start_date, $logbookWeekly->end_date)->toArray();
            $dateUsed = array_map(function($date) {
                return $date->toDateString();
            }, $dateUsed);

            $dateInLogbookDaily = $logbookWeekly->logbookDay->pluck('date')->toArray();

            if (
                !empty(array_diff($dateInLogbookDaily, $dateUsed)) ||
                !empty(array_diff($dateUsed, $dateInLogbookDaily))
            ) {
                return Response::error(null, 'Logbook belum diisi semuanya');
            }

            $logbookWeekly->status = 1;
            $logbookWeekly->save();

            $logbookWeekly->label_status = $this->getStatusLogbookWeek($logbookWeekly);
            $logbookWeekly['emoticon'] = $logbookWeekly->logbookDay->where('activity', '!=', 'Libur');
            return Response::success([
                'view_left_card' => view('logbook/components/left_card_detail', ['data' => $logbookWeekly])->render(),
                'view_detail' => view('logbook.components.card_daily', ['data' => $logbookWeekly, 'logbook_day' => $logbookWeekly->logbookDay, 'can_apply' => false])->render()
            ], 'Logbook successfully applied!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    private function getMyPendaftaranMagang($additional = null)
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $this->getPendaftaranMagang(function ($query) use ($additional, $mahasiswa) {
            $query = $query->where('mahasiswa.nim', $mahasiswa->nim);
            if ($additional != null) $query = $additional($query);
            return $query;
        });

        return $this;
    }

    private function getLogbookDaily($logbookWeek)
    {
        $dateArray = CarbonPeriod::create($logbookWeek->start_date, $logbookWeek->end_date)->toArray();

        $dateArray = array_map(function($date) {
            return $date->toDateString();
        }, $dateArray);


        $logbook_day = [];
        $canApply = true;
        foreach ($dateArray as $key => $value) {
            $logbookDay =  $logbookWeek->logbookDay->where('date', $value)->first();
            if ($logbookDay == null) {
                $canApply = false;
                $logbookDay = new LogbookDay();
                $logbookDay->date = $value;
            }

            $logbook_day[] = $logbookDay;
        }

        if (in_array($logbookWeek->status, [LogbookWeeklyStatus::PENDING, LogbookWeeklyStatus::APPROVED])) $canApply = false;

        $data = [
            'logbook_day' => collect($logbook_day)->sortBy('date'),
            'can_apply' => $canApply
        ];

        $totalDays = CarbonPeriod::create($logbookWeek->start_date, $logbookWeek->end_date)->count();
        $filledDays = $data['logbook_day']->whereNotNull('activity')->count();
        $data['percentage'] = self::percentage($filledDays, $totalDays);

        return $data;
    }

    private function getStatusLogbookWeek(LogbookWeek $logbook) {
        $status = LogbookWeeklyStatus::getWithLabel($logbook->status);
        return '<span class="badge bg-label-' .$status['color']. '">' .$status['title']. '</span>';
    }

    private static function percentage($filledDays = 1, $totalDays = 100) {
        return floor(($filledDays / $totalDays) * 100);
    }

    private static function filledDays($logbook_week) {
        $filledDays = 0;
        foreach ($logbook_week as $logbook) {
            $filledDays += $logbook->logbookDay->whereNotNull('activity')->count();
        }
        return $filledDays;
    }

    public function printLogbook($id)
    {
        $pendaftaran = $this->getMyPendaftaranMagang(function ($query) {
            return $query->select('industri.image', 'lowongan_magang.intern_position', 'industri.namaindustri','mahasiswa.namamhs', 'mahasiswa.nim',
            'mhs_magang.id_mhsmagang', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 'jenis_magang.durasimagang',
            'pendaftaran_magang.id_pendaftaran','jenis_magang.namajenis', 'dosen.namadosen', 'pegawai_industri.namapeg')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
            ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
            ->join('jenis_magang', 'lowongan_magang.id_jenismagang', '=', 'jenis_magang.id_jenismagang')
            ->leftJoin('dosen', 'dosen.nip', '=', 'mhs_magang.nip')
            ->leftJoin('pegawai_industri', 'pegawai_industri.id_peg_industri', '=', 'mhs_magang.id_peg_industri');
        });
        $data['data'] = $pendaftaran->pendaftaran->first();
        $data['weeklyActivities'] = LogbookWeek::select('id_logbook_week', 'week', 'start_date', 'end_date','id_logbook')
        ->with(['logbookDay' => function ($query) {
            $query->select('id_logbook_week', 'activity','date');
        }])->where('id_logbook',$id)
        ->get();


        $data['currentDate'] = Carbon::now()->isoFormat('dddd, D MMMM YYYY');

        return view('logbook.logbook_print',$data);
    }
}
