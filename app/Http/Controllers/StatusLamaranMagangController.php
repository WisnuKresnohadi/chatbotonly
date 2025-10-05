<?php

namespace App\Http\Controllers;

use App\FAHP\FuzzyAHP;
use App\Helpers\Response;
use App\Models\MhsMagang;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use App\Models\PekerjaanTersimpan;
use Illuminate\Support\Facades\DB;
use App\Jobs\RejectionPenawaranLowongan;
use App\Models\DokumenPendaftaranMagang;
use App\Jobs\RejectionPendaftaranTimeOut;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Jobs\RejectionPendaftaranKuotaFull;
use App\Models\BidangPekerjaanMk;
use Yajra\DataTables\Facades\DataTables;

class StatusLamaranMagangController extends Controller
{
    public function __construct(){
        $this->valid_step = [
            PendaftaranMagangStatusEnum::PENDING => 0,
            PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL => 0,
            PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI => 0,
            PendaftaranMagangStatusEnum::APPROVED_BY_LKM => 0,
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 0,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
            PendaftaranMagangStatusEnum::APPROVED_PENAWARAN => 4
        ];

        $this->rejected_step = [
            PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
            PendaftaranMagangStatusEnum::REJECTED_BY_LKM,
            PendaftaranMagangStatusEnum::REJECTED_SCREENING,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
            PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
            PendaftaranMagangStatusEnum::MENGUNDURKAN_DIRI,
            PendaftaranMagangStatusEnum::DIBERHENTIKAN_MAGANG
        ];
    }

    public function index(Request $request) {

        if ($request->ajax()) {
            if ($request->section == 'get_data_tgl_default') {
                $this->getDataLamaran(function ($query) use ($request) {
                    return $query->where('pendaftaran_magang.id_pendaftaran', $request->data_id);
                });

                $lamaran_magang = $this->lamaran_magang->first();

                return (object) [
                    'mulai_magang' => $lamaran_magang->mulai_magang,
                    'selesai_magang' => $lamaran_magang->selesai_magang
                ];
            }
            return self::getDataCard($request);
        }

        $this->getDataLamaran(function ($query) {
            return $query->select('pendaftaran_magang.id_lowongan', 'pendaftaran_magang.current_step');
        });

        // menjalakan rejection lowongan
        RejectionPendaftaranTimeOut::dispatchSync($this->lamaran_magang->pluck('id_lowongan')->toArray());
        RejectionPendaftaranKuotaFull::dispatchSync($this->lamaran_magang->pluck('id_lowongan')->toArray());
        // -----------------------------

        $this->getDataLamaran(function ($q) {
            return $q->select(
                'pendaftaran_magang.id_pendaftaran', 'industri.image', 'lowongan_magang.deskripsi', 'lowongan_magang.lokasi',
                'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'lowongan_magang.kuota', 'pendaftaran_magang.tanggaldaftar',
                'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'lowongan_magang.intern_position', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan',
                'mhs_magang.status_magang'
            )
            ->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', 'pendaftaran_magang.id_pendaftaran');
        })->setUpBadgeDataLamaran();
        $data['magangFakultas'] = $this->lamaran_magang->transform(function ($item) {
            $item->penawaran = (isset($this->valid_step[$item->current_step]) && $this->valid_step[$item->current_step] == ($item->tahapan_seleksi + 1)) ? true : false;
            return $item;
        });

        return view('kegiatan_saya/lamaran_saya/index', $data);
    }

    public function approvalPenawaran(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'onehundredagree' => 'required_if:status,approved|in:ayayaycaptain'
        ]);

        try {
            $this->getDataLamaran(function ($query) use ($id) {
                return $query->where('pendaftaran_magang.id_pendaftaran', $id);
            });

            $pendaftaran = $this->lamaran_magang->first();

            if (!$pendaftaran) {
                return Response::error(null, 'Pendaftaran Not Found.');
            }

            if ($this->valid_step[$pendaftaran->current_step] != ($pendaftaran->tahapan_seleksi + 1)) {
                return Response::error(null, 'Tidak dalam tahap penawaran.');
            }

            $history_approval = collect(json_decode($pendaftaran->history_approval))->last();
            if ($request->status == 'approved' && now()->gt(Carbon::parse($history_approval->time)->addDays($pendaftaran->date_confirm_closing))) {
                RejectionPendaftaranTimeOut::dispatch($pendaftaran->id_lowongan);
                return Response::error(null, 'Waktu konfirmasi penawaran telah habis.');
            }

            $kuota_terisi = PendaftaranMagang::select('id_pendaftaran')
            ->where('id_lowongan', $pendaftaran->id_lowongan)
            ->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)->count();

            if ($request->status == 'approved' && $pendaftaran->kuota == $kuota_terisi) {
                RejectionPendaftaranKuotaFull::dispatch($pendaftaran->id_lowongan);
                return Response::error(null, 'Kuota pendaftaran sudah penuh.');
            }

            DB::beginTransaction();
            $pendaftaran->current_step = ($request->status == 'approved') ? PendaftaranMagangStatusEnum::APPROVED_PENAWARAN : PendaftaranMagangStatusEnum::REJECTED_PENAWARAN;
            $pendaftaran->saveHistoryApproval()->save();

            if ($request->status == 'approved') {
                MhsMagang::create([
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                    'jenis_magang' => $pendaftaran->id_jenismagang,
                    'startdate_magang' => $request->startdate,
                    'enddate_magang' => $request->enddate,
                ]);

                RejectionPenawaranLowongan::dispatchSync($pendaftaran->id_pendaftaran);
            }

            DB::commit();

            if ($request->status == 'approved') {
                new WriteAndReadCounterBadgeJob('data_mahasiswa_count', 'increment', function () {
                    return PendaftaranMagang::where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                    ->whereNull('dokumen_skm')->count();
                });
            }

            return Response::success(null, 'Success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function detail($id) {
        $data['pelamar'] = $this->getDataLamaran(function ($query) use ($id) {
            return $query->leftJoin('hasil_wawancara', 'hasil_wawancara.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->select('pendaftaran_magang.*', 'lowongan_magang.*', 'mhs_magang.status_magang','bidang_pekerjaan_industri.id_bidang_pekerjaan_industri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'hasil_wawancara.kuota_wawancara')->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')->where('pendaftaran_magang.id_pendaftaran', $id);
        })->setUpStepStatusLamaran()->setUpBadgeDataLamaran()->lamaran_magang->first();

        if (!$data['pelamar']) return redirect()->route('lamaran_saya');

        $data['pelamar']->lowongan_tersedia = ($data['pelamar']->enddate > Carbon::now()) ? true : false;

        $data['pelamar'] = FuzzyAHP::generateNilaiAkademik($data['pelamar']);

        $data['dokumen_pendaftaran'] = DokumenPendaftaranMagang::select('document_syarat.namadocument', 'dokumen_pendaftaran_magang.file')
        ->join('document_syarat', 'document_syarat.id_document', 'dokumen_pendaftaran_magang.id_document')
        ->where('dokumen_pendaftaran_magang.id_pendaftaran', $data['pelamar']->id_pendaftaran)->get();

        $data['persuratan'] = '';

        $listDokumen = [
            'dokumen_skm' => 'Surat Keterangan Magang',
            'dokumen_spm' => 'Surat Pengantar Magang',
            'dokumen_sr' => 'Surat Rekomendasi'
        ];

        foreach ($listDokumen as $key => $value) {
            if ($data['pelamar']->{$key}) {
                $data['persuratan'] .= '<a class="me-4" href="'.asset('storage/'.$data['pelamar']->{$key}).'" download="'.$value.'">
                    <button class="btn btn-sm badge bg-label-info text-end">
                        <i class="ti ti-file-symlink me-2"></i>
                        '.$value.'
                    </button>
                </a>';
            }
        }

        if ($data['persuratan'] == '') $data['persuratan'] = '-';

        return view('kegiatan_saya.lamaran_saya.detail', $data);
    }


    // Controller
public function getDetailNilai($id_bidang_pekerjaan_industri) {
    $nim = auth()->user()->mahasiswa->nim;

    $bidang_pekerjaan_mk = BidangPekerjaanMk::leftJoin(
            'bidang_pekerjaan_mk_item',
            'bidang_pekerjaan_mk.id_bidang_pekerjaan_mk',
            '=',
            'bidang_pekerjaan_mk_item.id_bidang_pekerjaan_mk'
        )
        ->join('nilai_akhir_mhs', 'bidang_pekerjaan_mk_item.id_mk', '=', 'nilai_akhir_mhs.id_mk')
        ->join('mata_kuliah', 'mata_kuliah.id_mk', '=', 'nilai_akhir_mhs.id_mk')
        ->where('nilai_akhir_mhs.nim', $nim)
        ->where('id_bidang_pekerjaan_industri', $id_bidang_pekerjaan_industri)
        ->select(
            'bidang_pekerjaan_mk.id_bidang_pekerjaan_mk',
            'mata_kuliah.namamk',
            'bidang_pekerjaan_mk.bobot',
            'nilai_akhir_mhs.nilai_mk'
        )
        ->orderBy('bobot', 'desc')
        ->orderBy('nilai_mk', 'desc')
        ->orderBy('bidang_pekerjaan_mk.id_bidang_pekerjaan_mk', 'asc')
        ;
return DataTables::of($bidang_pekerjaan_mk)
    ->addColumn('index_key', fn($row) => $row->id_bidang_pekerjaan_mk) // real key
    ->addIndexColumn()
    ->editColumn('mata_kuliah', fn($row) => $row->namamk ?? '-')
    ->editColumn('bobot', fn($row) => $row->bobot ?? 0)
    ->editColumn('nilai_akhir', fn($row) => $row->nilai_mk ?? 0)
    ->make(true);

}



    public function detailLowongan($id) {
        $pendaftar = PendaftaranMagang::where('id_pendaftaran', $id)->first();
        $lowongan = LowonganMagang::select(
            'id_lowongan', 'intern_position', 'industri.namaindustri', 'industri.image', 'industri.description as deskripsi_industri',
            'pelaksanaan', 'durasimagang', 'lokasi', 'nominal_salary', 'created_at', 'jenjang', 'kuota',
            'gender', 'statusaprove', 'keterampilan', 'deskripsi', 'requirements', 'benefitmagang',
            'tahapan_seleksi'
        )
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->where('id_lowongan', $pendaftar->id_lowongan)->first()->dataTambahan('program_studi');
        if (!$lowongan) abort(404);

        $urlBack = route('lamaran_saya.detail', $id);
        $eligible = false;
        $tersimpan = PekerjaanTersimpan::select(DB::raw(1))->where('nim', auth()->user()->mahasiswa->nim)->where('id_lowongan', $pendaftar->id_lowongan)->first() ? true : false;

        return view('program_magang/detail_lowongan', compact('lowongan', 'urlBack', 'eligible', 'tersimpan'));
    }

    private function getDataLamaran($additionalBeforeGet = null)
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $this->lamaran_magang = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->where('pendaftaran_magang.nim', $mahasiswa->nim);

        if ($additionalBeforeGet != null) $this->lamaran_magang = $additionalBeforeGet($this->lamaran_magang);

        $this->lamaran_magang = $this->lamaran_magang->get();
        return $this;
    }

    private function getDataCard(Request $request) {
        switch ($request->component) {
            case 'proses_seleksi':
                $data = $this->getDataLamaran(function ($query) {
                    return $query->select(
                        'pendaftaran_magang.id_pendaftaran', 'industri.image', 'lowongan_magang.deskripsi', 'lowongan_magang.lokasi',
                        'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'lowongan_magang.kuota', 'pendaftaran_magang.tanggaldaftar',
                        'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',                    )->whereIn('current_step', [
                        PendaftaranMagangStatusEnum::PENDING,
                        PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI,
                        PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3,
                    ]);
                })->setUpBadgeDataLamaran()->lamaran_magang->filter(function ($value) use ($request) {
                    if (!in_array($request->filter, ['Pending', 'Screening'])) {
                        return isset($this->valid_step[$value->current_step]) && ($value->tahapan_seleksi + 1) > $this->valid_step[$value->current_step];
                    }
                    return true;
                });
                break;
            case 'penawaran':
                $data = $this->getDataLamaran(function ($query) {
                    return $query->select(
                        'pendaftaran_magang.id_pendaftaran', 'industri.image', 'lowongan_magang.deskripsi', 'lowongan_magang.lokasi',
                        'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'lowongan_magang.kuota', 'pendaftaran_magang.tanggaldaftar',
                        'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
                    )->whereIn('current_step', [
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3,
                    ]);
                })->setUpBadgeDataLamaran()->lamaran_magang->filter(function ($value) {
                    return isset($this->valid_step[$value->current_step]) && ($value->tahapan_seleksi + 1) == $this->valid_step[$value->current_step];
                })->transform(function ($item) {
                    $item->penawaran = true;
                    return $item;
                });
                break;
            case 'diterima':
                $data = $this->getDataLamaran(function ($query) {
                    return $query->select(
                        'pendaftaran_magang.id_pendaftaran', 'industri.image', 'lowongan_magang.deskripsi', 'lowongan_magang.lokasi',
                        'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'lowongan_magang.kuota', 'pendaftaran_magang.tanggaldaftar',
                        'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
                        'mhs_magang.status_magang'
                    )->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
                })->setUpBadgeDataLamaran()->lamaran_magang;
                break;
            case 'ditolak':
                $data = $this->getDataLamaran(function ($query) {
                    return $query->select(
                        'pendaftaran_magang.id_pendaftaran', 'industri.image', 'lowongan_magang.deskripsi', 'lowongan_magang.lokasi',
                        'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'lowongan_magang.kuota', 'pendaftaran_magang.tanggaldaftar',
                        'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
                    )->whereIn('current_step', $this->rejected_step);
                })->setUpBadgeDataLamaran()->lamaran_magang;
                break;
            default:
                $this->getDataLamaran(function ($q) {
                    return $q->select(
                        'pendaftaran_magang.id_pendaftaran', 'industri.image', 'lowongan_magang.deskripsi', 'lowongan_magang.lokasi',
                        'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'lowongan_magang.kuota', 'pendaftaran_magang.tanggaldaftar',
                        'pendaftaran_magang.current_step', 'lowongan_magang.tahapan_seleksi', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
                        'mhs_magang.status_magang'
                    )
                    ->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', 'pendaftaran_magang.id_pendaftaran');
                })->setUpBadgeDataLamaran();
                $data = $this->lamaran_magang->transform(function ($item) {
                    $item->penawaran = (isset($this->valid_step[$item->current_step]) && $this->valid_step[$item->current_step] == ($item->tahapan_seleksi + 1)) ? true : false;
                    return $item;
                });
                break;
        }

        return Response::success([
            'view' => view('kegiatan_saya.lamaran_saya.components.magang_fakultas', ['magangFakultas' => $data])->render()
        ], 'Successed');
    }

    private function setUpStepStatusLamaran()
    {
        if (count($this->lamaran_magang) == 0) return $this;

        $data = [
            ['title' => '1', 'desc' => 'Pra-seleksi oleh internal', 'active' => false, 'isReject' => false],
            ['title' => '2', 'desc' => 'Screening', 'active' => false, 'isReject' => false],
            ['title' => '3', 'desc' => 'Seleksi', 'active' => false, 'isReject' => false],
            ['title' => '4', 'desc' => 'Penawaran', 'active' => false, 'isReject' => false],
            ['title' => '5', 'desc' => 'Diterima', 'active' => false, 'isReject' => false],
        ];

        // dd($this->lamaran_magang[0]->current_step);
        switch ($this->lamaran_magang[0]->current_step) {
            case PendaftaranMagangStatusEnum::PENDING:
            case PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL:
                case PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI:
                $data[0]['active'] = true;
                break;
            case PendaftaranMagangStatusEnum::APPROVED_BY_LKM:
                $data[1]['active'] = true;
                break;
            case PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1:
            case PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1:
            case PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2:
            case PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3:
                if ($this->lamaran_magang[0]->current_step == array_search(($this->lamaran_magang[0]->tahapan_seleksi + 1), $this->valid_step)) {
                    $data[3]['active'] = true;
                } else {
                    $data[2]['active'] = true;
                }
                break;
            case PendaftaranMagangStatusEnum::APPROVED_PENAWARAN:
                $data[4]['active'] = true;
                break;
                case PendaftaranMagangStatusEnum::DIBERHENTIKAN_MAGANG:
                $data[4]['active'] = true;
                $data[4]['isReject'] = true;
                break;
            case PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL:
            case PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI:
            case PendaftaranMagangStatusEnum::REJECTED_BY_LKM:
                $data[0]['active'] = true;
                $data[0]['isReject'] = true;
                break;
            case PendaftaranMagangStatusEnum::REJECTED_SCREENING:
                $data[1]['active'] = true;
                $data[1]['isReject'] = true;
                break;
            case PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1:
            case PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2:
            case PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3:
                $data[2]['active'] = true;
                $data[2]['isReject'] = true;
                break;
            case PendaftaranMagangStatusEnum::REJECTED_PENAWARAN:
                $data[3]['active'] = true;
                $data[3]['isReject'] = true;
            break;
            default:
                # code...
                break;
        }

        // dd($data);

        $this->lamaran_magang[0]->step_status = view('kegiatan_saya/lamaran_saya/components/step_status', ['data' => $data])->render();
        return $this;
    }

    private function setUpBadgeDataLamaran() {

        if (count($this->lamaran_magang) == 0) return $this;

        $this->lamaran_magang->transform(function ($item) {
            if ($item->current_step == array_search(($item->tahapan_seleksi + 1), $this->valid_step)) {
                $getLabel = ['title' => 'Penawaran', 'color' => 'info'];
            } else {
                if (isset($item->status_magang) && $item->current_step == PendaftaranMagangStatusEnum::APPROVED_PENAWARAN && $item->status_magang == 0) $getLabel = ['title' => 'Magang Selesai', 'color' => 'secondary'];
                else $getLabel = PendaftaranMagangStatusEnum::getWithLabel($item->current_step);
            }

            $item->status_badge = '<span class="badge bg-label-' . $getLabel['color'] . ' text-end">' . $getLabel['title'] . '</span>';
            return $item;
        });

        return $this;
    }
}
