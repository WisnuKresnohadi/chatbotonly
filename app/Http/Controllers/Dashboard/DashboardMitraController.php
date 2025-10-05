<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Seleksi;
use App\Helpers\Response;
use App\Models\SeleksiTahap;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\LowonganMagangStatusEnum;
use App\Enums\PendaftaranMagangStatusEnum;

class DashboardMitraController extends Controller
{
    public function index() {
        return view('dashboard.company.index');
    }

    public function getData(Request $request) {
        $user = auth()->user();
        $adminMitra = $user->pegawai_industri;

        $request->validate([
            'tahun' => 'required|exists:tahun_akademik,id_year_akademik',
            'section' => 'required|in:get_statistik_lowongan,get_statistik_proses_seleksi,get_detail_statistik_proses,get_calendar,get_detail_calendar',
            'data_id' => 'required_if:section,get_detail_statistik_proses',
            'data_id_calendar' => 'required_if:section,get_detail_calendar'
        ]);

        if ($request->section == 'get_statistik_lowongan') {
            $lowongan = LowonganMagang::where('id_industri', $adminMitra->id_industri)
                ->where(function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun)->orWhereExists(function ($q2) use ($request) {
                        $q2->select(DB::raw(1))->from('jenis_magang')->whereColumn('jenis_magang.id_jenismagang', 'lowongan_magang.id_jenismagang')->where('jenis_magang.id_year_akademik', $request->tahun);
                    });
                })->get();

            $data['total'] = $lowongan->count();
            $data['pending'] = $lowongan->where('statusaprove', LowonganMagangStatusEnum::PENDING)->count();
            $data['rejected'] = $lowongan->where('statusaprove', LowonganMagangStatusEnum::REJECTED)->count();
            $data['publish'] = $lowongan->where('statusaprove', LowonganMagangStatusEnum::APPROVED)
                ->where('startdate', '<=', date('Y-m-d'))
                ->where('enddate', '>=', date('Y-m-d'))
                ->count();

            $data = view('dashboard/company/components/statistik_lowongan', $data)->render();
        } else if ($request->section == 'get_statistik_proses_seleksi') {
            $lowongan = LowonganMagang::
                with(['total_pelamar' => function ($q) {
                    $q->select('id_lowongan')->whereNotIn('current_step', [
                        PendaftaranMagangStatusEnum::PENDING,
                        PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI,
                        PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
                        PendaftaranMagangStatusEnum::REJECTED_BY_LKM,
                    ]);
                }])
                ->select('lowongan_magang.id_lowongan', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position')
                ->where('lowongan_magang.id_industri', $adminMitra->id_industri)
                ->where('id_year_akademik', $request->tahun)
                ->where('statusaprove', LowonganMagangStatusEnum::APPROVED)
                ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
                ->get();

            $totalKandidat = 0;
            $listCategory = $lowongan->map(fn ($item) => ['label' => $item->intern_position]);

            $listData = array();
            foreach ($lowongan as $key => $item) {
                $totalKandidat += count($item->total_pelamar);
                $listData[] = [
                    'id' => $item->id_lowongan,
                    'value' => count($item->total_pelamar)
                ];
            }

            $data = [
                'total_kandidat' => $totalKandidat,
                'list_category' => $listCategory,
                'list_data' => $listData
            ];
        } else if ($request->section == 'get_detail_statistik_proses') {
            $lowongan = LowonganMagang::with(['total_pelamar' => function ($q) {
                    $q->select('id_lowongan', 'current_step')->whereNotIn('current_step', [
                        PendaftaranMagangStatusEnum::PENDING,
                        PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI,
                        PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
                        PendaftaranMagangStatusEnum::REJECTED_BY_LKM,
                    ]);
                }])
                ->select('id_lowongan', 'tahapan_seleksi')
                ->where('id_lowongan', $request->data_id)
                ->where('id_year_akademik', $request->tahun)
                ->first();

            if ($lowongan == null) return Response::error(null, 'Lowongan Tidak Ditemukan');

            $dataStep = [
                PendaftaranMagangStatusEnum::PENDING => 0,
                PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL => 0,
                PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI => 0,
                PendaftaranMagangStatusEnum::APPROVED_BY_LKM => 0,
                PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 0,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3
            ];

            $dataRejected = [
                PendaftaranMagangStatusEnum::REJECTED_SCREENING,
                PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
                PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
                PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
                PendaftaranMagangStatusEnum::DIBERHENTIKAN_MAGANG,
                PendaftaranMagangStatusEnum::MENGUNDURKAN_DIRI
            ];

            $total_pelamar = $lowongan->total_pelamar;
            $data['tahapan_seleksi'] = $lowongan->tahapan_seleksi + 1;
            $data['total'] = count($total_pelamar);
            $data['screening'] = 0;
            $data['seleksi_1'] = 0;
            $data['seleksi_2'] = 0;
            $data['seleksi_3'] = 0;
            $data['penawaran'] = 0;
            $data['diterima'] = 0;
            $data['ditolak'] = 0;
            foreach ($total_pelamar as $key => $value) {
                if (isset($dataStep[$value->current_step]) && $dataStep[$value->current_step] == $data['tahapan_seleksi']) {
                    $data['penawaran'] += 1;
                } else if (isset($dataStep[$value->current_step]) && $dataStep[$value->current_step] < $data['tahapan_seleksi']) {
                    $data['seleksi_' . $dataStep[$value->current_step] + 1] += 1;
                } else if ($value->current_step == PendaftaranMagangStatusEnum::APPROVED_BY_LKM) {
                    $data['screening'] += 1;
                } else if ($value->current_step == PendaftaranMagangStatusEnum::APPROVED_PENAWARAN) {
                    $data['diterima'] += 1;
                } else if (in_array($value->current_step, $dataRejected)) {
                    $data['ditolak'] += 1;
                }
            }

            $data = view('dashboard/company/components/detail_lowongan_proses', $data)->render();
        } else if ($request->section == 'get_calendar') {
            $pendaftar = PendaftaranMagang::select(
                'pendaftaran_magang.id_pendaftaran', 'pendaftaran_magang.id_lowongan', 'pendaftaran_magang.current_step',
                'mahasiswa.namamhs', 'lowongan_magang.intern_position', 'lowongan_magang.tahapan_seleksi'
            )
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->where('lowongan_magang.id_industri', $adminMitra->id_industri)
            ->where('lowongan_magang.id_year_akademik', $request->tahun)
            ->where('lowongan_magang.statusaprove', LowonganMagangStatusEnum::APPROVED)
            ->whereIn('pendaftaran_magang.current_step', [
                PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
            ])->get();

            $seleksiDefault = SeleksiTahap::select('id_seleksi', 'id_lowongan', 'tgl_mulai as start_date', 'tgl_akhir as end_date', 'tahap as tahapan_seleksi')->whereIn('id_lowongan', $pendaftar->pluck('id_lowongan')->unique()->toArray())->get();
            $seleksi = Seleksi::select('id_seleksi_lowongan as id_seleksi', 'id_pendaftaran', 'start_date', 'end_date', 'tahapan_seleksi')->whereIn('id_pendaftaran', $pendaftar->pluck('id_pendaftaran')->toArray())->get();

            $data['calendar'] = array();
            $data['table'] = array();

            $valid_step = [
                PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 0,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
            ];

            foreach ($pendaftar as $key => $value) {
                $seleksiCurrent = $seleksi->where('id_pendaftaran', $value->id_pendaftaran);
                if (count($seleksiCurrent) == 0) {
                    $seleksiCurrent = $seleksiDefault->where('id_lowongan', $value->id_lowongan);
                }

                foreach ($seleksiCurrent as $k => $v) {
                    $data['calendar'][] = [
                        'id' => $v->id_seleksi,
                        'title' => $value->namamhs . ' - Tahap ' . $v->tahapan_seleksi,
                        'start' => Carbon::parse($v->start_date)->format('Y-m-d'),
                        'end' => Carbon::parse($v->end_date)->format('Y-m-d'),
                    ];
                }

                if (isset($valid_step[$value->current_step]) && $valid_step[$value->current_step] == ($value->tahapan_seleksi + 1)) {
                    continue;
                }
                if ($value->current_step == PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1) {
                    $status = ['title' => 'Belum Seleksi Tahap 1', 'color' => 'warning'];
                } else if ($value->current_step == PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1) {
                    $status = ['title' => 'Belum Seleksi Tahap 2', 'color' => 'warning'];
                } else if ($value->current_step == PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2) {
                    $status = ['title' => 'Belum Seleksi Tahap 3', 'color' => 'warning'];
                }

                $seleksiCurrent = $seleksiCurrent->where('tahapan_seleksi', ($valid_step[$value->current_step] + 1))->first();

                $tanggal = '<div class="d-flex flex-column align-items-start">';
                $tanggal .= '<span class="fw-semibold text-nowrap mt-1">Mulai</span>';
                $tanggal .= '<span class="text-nowrap">' .Carbon::parse($seleksiCurrent->start_date)->format('d F Y') . '</span>';
                $tanggal .= '<span class="fw-semibold text-nowrap mt-1">Selesai</span>';
                $tanggal .= '<span class="text-nowrap">' .Carbon::parse($seleksiCurrent->end_date)->format('d F Y') . '</span>';
                $tanggal .= '</div>';

                $data['table'][] = [
                    'no' => $key + 1,
                    'nama' => $value->namamhs,
                    'posisi' => $value->intern_position,
                    'tanggal' => $tanggal,
                    'status' => '<div class="d-flex justify-content-center"><span class="badge bg-label-' . $status['color'] . '">'. $status['title'] .'</span></div>',
                    'aksi' => "<a class='btn-icon text-primary' href='".route('informasi_lowongan.detail', [
                        'id' => $value->id_lowongan,
                        'tab' => 'tahap',
                        'select' => $value->current_step,
                    ])."'><i class='tf-icons ti ti-file-invoice'></i></a>"
                ];
            }

        } else if ($request->section == 'get_detail_calendar') {
            $seleksi = Seleksi::select('start_date', 'end_date', 'tahapan_seleksi as tahap')
                ->where('id_seleksi_lowongan', $request->data_id_calendar)
                ->whereExists(function ($q) use ($adminMitra, $request) {
                    $q->select(DB::raw(1))->from('lowongan_magang')->whereColumn('lowongan_magang.id_lowongan', 'seleksi_lowongan.id_lowongan')
                        ->where('lowongan_magang.id_industri', $adminMitra->id_industri)
                        ->where('lowongan_magang.id_year_akademik', $request->tahun);
                })->first();

            if ($seleksi == null) {
                $seleksi = SeleksiTahap::select('tgl_mulai as start_date', 'tgl_akhir as end_date', 'tahap')
                    ->where('id_seleksi', $request->data_id_calendar)
                    ->whereExists(function ($q) use ($adminMitra, $request) {
                        $q->select(DB::raw(1))->from('lowongan_magang')->whereColumn('lowongan_magang.id_lowongan', 'seleksi.id_lowongan')
                            ->where('lowongan_magang.id_industri', $adminMitra->id_industri)
                            ->where('lowongan_magang.id_year_akademik', $request->tahun);
                    })->first();
            }

            if ($seleksi == null) return Response::error(null, 'Not Found');

            return Response::success(
                view('dashboard/company/components/detail_jadwal', compact('seleksi'))->render(),
                'Success'
            );

        } else {
            return Response::error(null, 'Not Found');
        }

        return Response::success($data, 'Success');
    }
}
