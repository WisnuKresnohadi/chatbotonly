<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Industri;
use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\BerkasAkhirMagangStatus;
use App\Enums\LowonganMagangStatusEnum;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\JenisMagang;
use App\Models\MhsMagang;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.admin.index');
    }

    public function getData(Request $request) {
        $request->validate([
            'tahun' => 'required|exists:tahun_akademik,id_year_akademik',
            'section' => 'required|in:get_waiting_approval,lowongan_published,get_dropdown_list_proses,get_proses_seleksi,get_rekapitulasi_mhs,get_detail_mitra_lowongan',
            'data_id' => 'required_if:section,get_proses_seleksi,get_detail_mitra_lowongan|exists:industri,id_industri'
        ]);

        if ($request->section == 'get_waiting_approval') {
            $data['mitra'] = Industri::select(DB::raw(1))->where('statusapprove', 0)->count();
            $data['lowongan'] = LowonganMagang::select('id_jenis_magang')
                ->whereHas('jenisMagang', function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun);
                })
                ->where('statusaprove', LowonganMagangStatusEnum::PENDING)
                ->count();
            $data['spm'] = PendaftaranMagang::select('id_lowongan')->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                ->whereHas('lowongan_magang', function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun);
                })->whereNull('pendaftaran_magang.dokumen_skm')->count();
            $data['berkas'] = PendaftaranMagang::select('pendaftaran_magang.id_lowongan')
                ->whereHas('lowongan_magang', function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun);
                })
                ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
                ->join('berkas_magang', 'berkas_magang.id_jenismagang', 'mhs_magang.jenis_magang')
                ->leftJoin('berkas_akhir_magang', function ($q) {
                    return $q->on('berkas_akhir_magang.id_berkas_magang', '=', 'berkas_magang.id_berkas_magang')
                    ->whereRaw('berkas_akhir_magang.id_mhsmagang = mhs_magang.id_mhsmagang')
                    ->where('berkas_akhir_magang.status_berkas', '=', BerkasAkhirMagangStatus::PENDING);
                })
                ->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                ->groupBy('pendaftaran_magang.id_pendaftaran', 'pendaftaran_magang.id_lowongan')
                ->havingRaw('count(berkas_akhir_magang.status_berkas) > 0')
                ->count();

            $data = view('dashboard/admin/components/waiting_approval', $data)->render();
        } else if ($request->section == 'lowongan_published') {
            $lowongan = Industri::select('namaindustri', 'id_industri')
                ->with(['lowongan_magang' => function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun)->where('statusaprove', LowonganMagangStatusEnum::APPROVED)->where('startdate', '<=', Carbon::now()->format('Y-m-d'))->where('enddate', '>=', Carbon::now()->format('Y-m-d'));
                }])
                ->whereHas('lowongan_magang', function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun)->where('statusaprove', LowonganMagangStatusEnum::APPROVED)->where('startdate', '<=', Carbon::now()->format('Y-m-d'))->where('enddate', '>=', Carbon::now()->format('Y-m-d'));
                })->get();

            $category = $lowongan->map(function ($item) {
                    $newItem = array();
                    $newItem['label'] = $item->namaindustri;
                    return $newItem;
                });
            $dataSet = $lowongan->map(function ($item) {
                    $newItem = array();
                    $newItem['value'] = count($item->lowongan_magang);
                    $newItem['id'] = $item->id_industri;
                    return $newItem;
                });

            $data = ['category' => $category, 'dataSet' => $dataSet];
        } else if ($request->section == 'get_dropdown_list_proses') {
            $data = Industri::select('namaindustri', 'id_industri')
                ->whereHas('lowongan_magang', function ($q) {
                    $q->whereHas('total_pelamar');
                })
                ->get()->transform(function ($item) {
                    $newItem = array();
                    $newItem['name'] = $item->namaindustri;
                    $newItem['id'] = $item->id_industri;

                    return $newItem;
                });
        } else if ($request->section == 'get_proses_seleksi') {
            $result = PendaftaranMagang::select('pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi')
                ->join('lowongan_magang', 'lowongan_magang.id_lowongan', 'pendaftaran_magang.id_lowongan')
                ->where('id_industri', $request->data_id)
                ->where('statusaprove', LowonganMagangStatusEnum::APPROVED)
                ->where('id_year_akademik', $request->tahun)
                ->get();

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

            $dataCount['Seleksi'] = 0;
            $dataCount['Penawaran'] = 0;
            $dataCount['Diterima'] = 0;
            $dataCount['Ditolak'] = 0;

            $dataTotal = 0;

            foreach ($result as $key => $value) {
                if (isset($dataStep[$value->current_step]) && $dataStep[$value->current_step] == ($value->tahapan_seleksi + 1)) {
                    $dataCount['Penawaran'] += 1;
                } else if (isset($dataStep[$value->current_step]) && $dataStep[$value->current_step] < ($value->tahapan_seleksi + 1)) {
                    $dataCount['Seleksi'] += 1;
                } else if ($value->current_step == PendaftaranMagangStatusEnum::APPROVED_PENAWARAN) {
                    $dataCount['Diterima'] += 1;
                } else if (in_array($value->current_step, [
                    PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
                    PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
                    PendaftaranMagangStatusEnum::REJECTED_BY_LKM,
                    PendaftaranMagangStatusEnum::REJECTED_SCREENING,
                    PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
                    PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
                    PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
                    PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
                    PendaftaranMagangStatusEnum::DIBERHENTIKAN_MAGANG,
                    PendaftaranMagangStatusEnum::MENGUNDURKAN_DIRI
                ])) {
                    $dataCount['Ditolak'] += 1;
                }

                $dataTotal += 1;
            }

            $dataResult = [];
            foreach ($dataCount as $key => $value) {
                $dataResult[] = ['label' => $key, 'value' => $value];
            }

            $data = ['data_chart' => $dataResult, 'data_total' => $dataTotal];
        } else if ($request->section == 'get_rekapitulasi_mhs') {
            $jenisMagang = JenisMagang::select('namajenis', 'durasimagang', 'id_jenismagang')
                ->where('id_year_akademik', $request->tahun)
                ->get();
            $mahasiswa = MhsMagang::select('jenis_magang')
                ->whereIn('jenis_magang', $jenisMagang->pluck('id_jenismagang')->toArray())
                ->whereHas('pendaftaran', function ($q) {
                    $q->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
                })->where('status_magang', 1)
                ->get();

            $dataResult = [];
            $dataJenisMagang = [];
            foreach ($jenisMagang as $key => $value) {
                $dataResult[] = [
                    'label' => $value->namajenis . ' (' . $value->durasimagang . ')',
                    'value' => $mahasiswa->where('jenis_magang', $value->id_jenismagang)->count() ?? 0
                ];
                $dataJenisMagang[] = $value->namajenis . ' (' . str_replace('Semester', 'Smstr', $value->durasimagang) . ')';
            }

            $data = [
                'data_chart' => $dataResult,
                'list_jenis_magang' => $dataJenisMagang
            ];
        } else if ($request->section == 'get_detail_mitra_lowongan') {
            $lowongan = LowonganMagang::select('intern_position', 'kuota')
                ->where('statusaprove', LowonganMagangStatusEnum::APPROVED)
                ->where('startdate', '<=', date('Y-m-d'))
                ->where('enddate', '>=', date('Y-m-d'))
                ->where('id_year_akademik', $request->tahun)
                ->where('id_industri', $request->data_id)->get();

            $data = view('dashboard/admin/components/list_lowongan', compact('lowongan'))->render();
        } else {
            return Response::error(null, 'Not Found');
        }

        return Response::success($data, 'Success');
    }
}
