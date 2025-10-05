<?php

namespace App\Http\Controllers;

use stdClass;
use Exception;
use App\Models\Sertif;
use App\Models\Seleksi;
use App\Helpers\Response;
use App\Models\Education;
use App\Models\Mahasiswa;
use App\Models\Experience;
use App\Models\JenisMagang;
use App\Models\ProgramStudi;
use App\Models\SeleksiTahap;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\TahunAkademik;
use App\Jobs\SendMailIndustri;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\BahasaMahasiswa;
use App\Models\BidangPekerjaanIndustri;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use App\Models\SendedEmailIndustri;
use Illuminate\Support\Facades\Crypt;
use App\Enums\LowonganMagangStatusEnum;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenPendaftaranMagang;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\RejectionPendaftaranTimeOut;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Enums\TemplateEmailListProsesEnum;
use App\FAHP\FuzzyAHP;
use App\Models\BidangPekerjaanMkItem;
use App\Jobs\RejectionPendaftaranKuotaFull;
use App\Http\Requests\LowonganMagangRequest;
use App\Models\ExperiencePendaftaran;
use App\Models\Hasil_Wawancara;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\PredikatNilai;
use App\Models\SertifikatPendaftaran;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;

class LowonganMagangController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameters()['id'] ?? null;

            $this->getLowonganMagang(function ($query) use ($id) {
                return $query->where('id_lowongan', $id);
            });

            return $next($request);
        }, ['only' => ['setDateConfirmClosing', 'detailInformasi', 'getDataDetailInformasi', 'edit', 'detail', 'update', 'status', 'getTakedown', 'updateTakedown']]);

        $this->valid_step = [
            PendaftaranMagangStatusEnum::APPROVED_BY_LKM => -1,
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 0,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
        ];

        $this->rejected = [
            PendaftaranMagangStatusEnum::REJECTED_SCREENING,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
            PendaftaranMagangStatusEnum::REJECTED_PENAWARAN
        ];
    }

    public function indexInformasi(Request $request)
    {

        if ($request->ajax()) {
            if ($request->section == 'get_data_date') {
                $data = $this->getLowonganMagang(function ($query) use ($request) {
                    return $query->select('date_confirm_closing')->where('id_lowongan', $request->data_id)->where('statusaprove', LowonganMagangStatusEnum::APPROVED);
                })->my_lowongan_magang->first()?->date_confirm_closing ?? null;
            } else {
                return Response::error(null, 'Invalid!');
            }

            return Response::success($data, 'Success!');
        }

        return view('company.lowongan_magang.informasi_lowongan.informasi_lowongan');
    }

    public function showInformasi(Request $request)
    {
        $request->validate([
            'section' => 'required|in:data,total_pelamar',
            'page_length' => 'required_if:section,data|in:10,25,50,100',
        ]);

        $this->getLowonganMagang(function ($query) use ($request) {
            if ($request->section == 'total_pelamar') {
                $query = $query->select(
                    'lowongan_magang.*'
                )->where('lowongan_magang.statusaprove', LowonganMagangStatusEnum::APPROVED);
            } else if ($request->section == 'data') {
                $query = $query->select('lowongan_magang.*', 'industri.image', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position')
                    ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
                    ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
                    ->where('statusaprove', LowonganMagangStatusEnum::APPROVED);
            }

            //search datatable
            if ($request->search) {
                $query = $query->where('intern_position', 'like', "%$request->search%");
            }
            //end search datatable

            if ($request->tahun_akademik) {
                $query = $query->where('id_year_akademik', $request->tahun_akademik);
            }

            if ($request->section == 'total_pelamar') return $query;
            return $query->paginate($request->page_length);
        });

        $lowonganMagang = $this->my_lowongan_magang;

        if ($request->section == 'total_pelamar') {
            $lowonganMagang = self::calculatePelamar($lowonganMagang);
            return $lowonganMagang->sum('total_pelamar');
        }

        $paginationInfo = [
            'current_page' => $lowonganMagang->currentPage(),
            'last_page' => $lowonganMagang->lastPage(),
            'per_page' => $lowonganMagang->perPage(),
            'total' => $lowonganMagang->total(),
        ];

        $lowonganMagang = collect($lowonganMagang->items());

        RejectionPendaftaranKuotaFull::dispatch($lowonganMagang->pluck('id_lowongan')->toArray());
        RejectionPendaftaranTimeOut::dispatch($lowonganMagang->pluck('id_lowongan')->toArray());

        $lowongan_magang = self::calculatePelamar($lowonganMagang);
        $total_pelamar = $lowongan_magang->sum('total_pelamar');

        $datatable = datatables()->of($lowongan_magang)
            ->addColumn('data', function ($data) {
                $view = view('company/lowongan_magang/components/card_informasi_lowongan', compact('data'))->render();
                return $view;
            })
            ->rawColumns(['data'])
            ->make(true);

        return response()->json([
            'datatable' => $datatable,
            'pagination' => $paginationInfo,
            'page_length' => $request->page_length,
            'total_pelamar' => $total_pelamar
        ]);
    }

    private function calculatePelamar($lowonganMagang)
    {
        return $lowonganMagang->map(function ($item, $key) {
            $total_pelamar = $item->total_pelamar;
            $item->screening = $total_pelamar->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM)->count();

            $countProsesSeleksi = 0;
            $countPenawaran = 0;
            $countRejected = 0;

            foreach ($total_pelamar as $key => $data) {
                if (isset($this->valid_step[$data->current_step]) && $this->valid_step[$data->current_step] >= 0 && ($item->tahapan_seleksi + 1) > $this->valid_step[$data->current_step]) {
                    $countProsesSeleksi++;
                } else if (isset($this->valid_step[$data->current_step]) && ($item->tahapan_seleksi + 1) == $this->valid_step[$data->current_step]) {
                    $countPenawaran++;
                } else if (in_array($data->current_step, $this->rejected)) {
                    $countRejected++;
                }
            }

            $item->proses_seleksi = $countProsesSeleksi;
            $item->penawaran = $countPenawaran;

            $item->approved = $total_pelamar->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)->count();
            $item->rejected = $countRejected;

            $item->total_pelamar = $item->screening + $item->proses_seleksi + $item->penawaran + $item->approved + $item->rejected;

            return $item;
        });
    }

    public function setDateConfirmClosing(Request $request, $id)
    {
        $request->validate([
            'date' => ['required', 'integer', 'min:7']
        ], [
            'date.required' => 'Tidak boleh kosong!',
            'date.integer' => 'Harus berisikan angka!',
            'date.min' => 'Tidak boleh kurang dari 7 hari!'
        ]);

        try {
            if (!$this->my_lowongan_magang) return Response::error(null, 'Lowongan Magang Not Found');

            $this->my_lowongan_magang->first()->update([
                'date_confirm_closing' => $request->date
            ]);

            return Response::success($request->date, 'Berhasil memperbarui Batas Konfirmasi!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function detailInformasi(Request $request, $id)
    {

        if ($request->ajax()) {

            if ($request->section == 'get_detail_mhs') {
                $this->getPendaftarMagang(function ($query) use ($id, $request) {
                    return $query->where('pendaftaran_magang.id_lowongan', $id)->where('pendaftaran_magang.id_pendaftaran', $request->data_id);
                });

                $data['pendaftar'] = $this->my_pendaftar_magang->first();
                $data['education'] = Education::where('nim', $data['pendaftar']->nim)->get();
                $data['experience'] = ExperiencePendaftaran::where('nim', $data['pendaftar']->nim)->get();
                $data['skills'] = json_decode(PendaftaranMagang::where('nim', $data['pendaftar']->nim)->first()->skills, true) ?? [];
                // $data['skills'] = json_decode($data['pendaftar']->skills, true) ?? [];
                $data['language'] = BahasaMahasiswa::where('nim', $data['pendaftar']->nim)->orderBy('bahasa', 'asc')->get();
                $data['dokumen_pendukung'] = SertifikatPendaftaran::where('nim', $data['pendaftar']->nim)->orderBy('startdate', 'desc')->get();
                $data['dokumen_syarat'] = DokumenPendaftaranMagang::join('document_syarat', 'dokumen_pendaftaran_magang.id_document', '=', 'document_syarat.id_document')
                    ->where('id_pendaftaran', $request->data_id)->get();
                $data['headline_pendaftaran'] = PendaftaranMagang::where('nim', $data['pendaftar']->nim)->first()->headliner;
                $data['deskripsiDiri_pendaftar'] = PendaftaranMagang::where('nim', $data['pendaftar']->nim)->first()->deskripsi_diri;

                $data['onScreening'] = PendaftaranMagangStatusEnum::APPROVED_BY_LKM;

                $view = view('company/lowongan_magang/components/card_detail_pelamar', $data)->render();
                return Response::success([
                    'view' => $view,
                    'nim' => $data['pendaftar']->nim,
                    'id_pendaftar' => $data['pendaftar']->id_pendaftaran,
                    'current_step' => $data['pendaftar']->current_step,
                ], 'Success');
            } else if ($request->section == 'get_email_sent') {
                $pendaftaran = PendaftaranMagang::select('mahasiswa.id_user')
                    ->join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
                    ->where('id_pendaftaran', $request->data_id)->first();
                if (!$pendaftaran) return Response::error(null, 'Pendaftaran Not Found');

                $user = auth()->user();
                $pegawai = $user->pegawai_industri;

                $sended = SendedEmailIndustri::select('subject')
                    ->where('id_industri', $pegawai->id_industri)
                    ->where('id_send_to', $pendaftaran->id_user)
                    ->get();

                return Response::success($sended, 'Success!');
            } else if ($request->section == 'get_data_date') {
                $data = $this->getLowonganMagang(function ($query) use ($id) {
                    return $query->select('date_confirm_closing')->where('id_lowongan', $id)->where('statusaprove', LowonganMagangStatusEnum::APPROVED);
                })->my_lowongan_magang->first()?->date_confirm_closing ?? null;

                return Response::success($data, 'Success!');
            } else {
                return Response::error(null, 'Invalid!');
            }
        }

        //for table
        $data['lowongan'] = $this->my_lowongan_magang->first();
        $data['total_pelamar'] = $data['lowongan']->total_pelamar->count();

        $data['listStatus'][] = ['value' => PendaftaranMagangStatusEnum::APPROVED_BY_LKM, 'label' => 'Screening'];
        for ($i = 0; $i < ($data['lowongan']->tahapan_seleksi + 1); $i++) {
            $tahap_valid[] = ['label' => 'Seleksi Tahap ' . ($i + 1), 'table' => array_search($i, $this->valid_step)];
            $data['listStatus'][] = ['value' => array_search($i, $this->valid_step), 'label' => 'Seleksi Tahap ' . ($i + 1)];
        }

        $data['last_seleksi'] = array_search(($data['lowongan']->tahapan_seleksi + 1), $this->valid_step);
        array_push(
            $data['listStatus'],
            ['value' => $data['last_seleksi'], 'label' => 'Penawaran'],
            ['value' => 'rejected', 'label' => 'Ditolak'],
        );

        $data['tab']['screening'] = ['label' => 'Kandidat Pelamar', 'icon' => 'ti ti-files', 'table' => 'kandidat_pelamar'];
        $data['tab']['seleksi'] = ['label' => 'Seleksi', 'icon' => 'ti ti-writing-sign', 'table' => 'seleksi', 'tahap_valid' => $tahap_valid];
        $data['tab']['penawaran'] = ['label' => 'Penawaran', 'icon' => 'ti ti-device-desktop-analytics', 'table' => 'penawaran'];

        // $data['tab']['screening'] = ['label' => 'Kandidat Pelamar', 'icon' => 'ti ti-files', 'table' => PendaftaranMagangStatusEnum::APPROVED_BY_LKM];
        // $data['tab']['FAHP'] = ['label' => 'Seleksi', 'icon' => 'ti ti-writing-sign', 'table' => 'fahp'];
        // $data['tab']['penawaran'] = [ 'label' => 'Penawaran', 'icon' => 'ti ti-device-desktop-analytics', 'table' => array_search(($data['lowongan']->tahapan_seleksi + 1), $this->valid_step)];


        // $data['tab']['screening'] = ['label' => 'Screening', 'icon' => 'ti ti-files', 'table' => PendaftaranMagangStatusEnum::APPROVED_BY_LKM];
        // $data['tab']['tahap'] = ['label' => 'Seleksi', 'icon' => 'ti ti-device-desktop-analytics', 'table' => 'all_seleksi', 'tahap_valid' => $tahap_valid];

        // $data['tab']['screening'] = ['label' => 'Screening', 'icon' => 'ti ti-files', 'table' => PendaftaranMagangStatusEnum::APPROVED_BY_LKM];
        // $data['tab']['tahap'] = ['label' => 'Seleksi', 'icon' => 'ti ti-device-desktop-analytics', 'table' => 'all_seleksi', 'tahap_valid' => $tahap_valid];
        // $data['tab']['penawaran'] = ['label' => 'Penawaran', 'icon' => 'ti ti-writing-sign', 'table' => array_search(($data['lowongan']->tahapan_seleksi + 1), $this->valid_step)];
        // $data['tab']['diterima'] = ['label' => 'Diterima', 'icon' => 'ti ti-user-check', 'table' => PendaftaranMagangStatusEnum::APPROVED_PENAWARAN];
        // $data['tab']['ditolak'] = ['label' => 'Ditolak', 'icon' => 'ti ti-user-x', 'table' => 'all_rejected'];
        // $data['tab']['FAHP'] = ['label' => 'FAHP', 'icon' => 'ti ti-user-x', 'table' => 'fahp'];

        $data['urlGetData'] = route('informasi_lowongan.get_data', $id);
        $data['urlDetailPelamar'] = route('informasi_lowongan.detail', $id);
        $data['date_confirm_closing'] = isset($data['lowongan']->date_confirm_closing) ? ('<span class="text-primary">' . $data['lowongan']->date_confirm_closing . ' Hari Setelah Penerimaan</span>') : '<span class="text-danger">Belum Diatur</span>';

        $data['tahapValid'] = $tahap_valid;
        $data['afterScreening'] = PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1;

        $countPendaftarDitawarkan = PendaftaranMagang::select('current_step')
            ->where('id_lowongan', $data['lowongan']->id_lowongan)
            ->whereIn('current_step', [
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3
            ])->get()->filter(function ($item) use ($data) {
                return isset($this->valid_step[$item->current_step]) && ($data['lowongan']->tahapan_seleksi + 1) == $this->valid_step[$item->current_step];
            })->count();

        $data['kuota_penawaran_full'] = false;
        if ($data['lowongan']->kuota == $countPendaftarDitawarkan) {
            $data['kuota_penawaran_full'] = true;
        }

        // menjalakan rejection lowongan
        RejectionPendaftaranKuotaFull::dispatch($data['lowongan']->id_lowongan);
        RejectionPendaftaranTimeOut::dispatchSync($data['lowongan']->id_lowongan);
        // -----------------------------

        $data['urlBack'] = url('lowongan-magang/informasi-lowongan') . '?page=' . $request->page;

        return view('company/lowongan_magang/informasi_lowongan/detail_kandidat', $data);
    }

    public static function showCV($nim)
    {
        $dataProfile = Mahasiswa::join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
            ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->leftJoin('reg_regencies', 'reg_regencies.id', '=', 'mahasiswa.kota_id')
            ->leftJoin('reg_provinces', 'reg_provinces.id', '=', 'reg_regencies.province_id')
            ->leftJoin('reg_countries', 'reg_countries.id', '=', 'reg_provinces.country_id')
            ->select('mahasiswa.*', 'universitas.namauniv', 'fakultas.namafakultas', 'program_studi.namaprodi', 'reg_regencies.id as cities', 'reg_provinces.id as provinces', 'reg_countries.id as countries')
            ->where('nim', $nim)->firstOrFail();

        $dataInfoTambahan = $dataProfile;
        $dataInfoTambahan->bahasa = json_encode($dataProfile->bahasamhs->pluck('bahasa')->toArray());
        $dataInfoTambahan->sosmedmhs_ = json_encode($dataProfile->sosmedmhs->select('namaSosmed', 'urlSosmed')->toArray());
        unset($dataInfoTambahan->bahasamhs);
        unset($dataInfoTambahan->sosmedmhs);

        $pendidikan = Education::where('nim', $nim)->orderBy('startdate', 'asc')->get();
        $experience = Experience::where('nim', $nim)->orderBy('startdate', 'asc')->get();
        $dokumenPendukung = Sertif::where('nim', $nim)->orderBy('startdate', 'asc')->get();

        $data = [
            'dataProfile' => $dataProfile,
            'dataInfoTambahan' => $dataInfoTambahan,
            'pendidikan' => $pendidikan,
            'experience' => $experience,
            'dokumenPendukung' => $dokumenPendukung,
            'nim' => $nim,
        ];

        return view('mahasiswa.cv', $data);
    }

    public function getKandidat(Request $request, $tahap)
    {
        $this->getPendaftarMagang(function ($query) use ($tahap) {
            return $query->where('current_step', $tahap);
        });
        $pendaftar = $this->my_pendaftar_magang;
        $data = [];
        foreach ($pendaftar as $key => $value) {
            $data[$value->id_pendaftaran] = $value->namamhs;
        }

        return Response::success($data, 'Success');
    }

    public function setJadwal(Request $request, $id)
    {
        $request->validate([
            'tahapan_seleksi' => 'required|numeric',
            'kandidat' => 'required|array',
            'kandidat.*' => 'required|uuid',
            'mulai_date' => 'required|date',
            'selesai_date' => 'required|date',
        ], [
            'kandidat.required' => 'Kandidat tidak boleh kosong',
            'kandidat.*.required' => 'Kandidat tidak boleh kosong',
            'kandidat.*.uuid' => 'Kandidat tidak valid',
            'mulai_date.required' => 'Tanggal mulai tidak boleh kosong',
            'selesai_date.required' => 'Tanggal selesai tidak boleh kosong',
            'tahapan_seleksi.required' => 'Tahapan seleksi tidak boleh kosong',
        ]);

        try {
            DB::beginTransaction();

            $pegawai_industri = auth()->user()->pegawai_industri;
            $pendaftar = PendaftaranMagang::select('id_pendaftaran', 'id_lowongan')
                ->whereHas('lowongan_magang', function ($q) use ($pegawai_industri, $id) {
                    $q->where('id_lowongan', $id)
                        ->where('id_industri', $pegawai_industri->id_industri);
                })
                ->whereIn('id_pendaftaran', $request->kandidat)
                ->get();

            $emailTemplate = EmailTemplate::select('id_email_template')
                ->where('id_industri', $pegawai_industri->id_industri)
                ->where('proses', TemplateEmailListProsesEnum::PENJADWALAN_SELEKSI)->first();

            if ($emailTemplate == null) return Response::error(null, 'Template Email Penjadwalan Seleksi belum diatur.');

            foreach ($pendaftar as $key => $value) {
                Seleksi::updateOrCreate(
                    [
                        'id_pendaftaran' => $value->id_pendaftaran,
                        'tahapan_seleksi' => $request->tahapan_seleksi,
                        'id_lowongan' => $value->id_lowongan,
                    ],
                    [
                        'start_date' => Carbon::parse($request->mulai_date)->format('Y-m-d H:i:s'),
                        'end_date' => Carbon::parse($request->selesai_date)->format('Y-m-d H:i:s'),
                        'id_email_template' => $emailTemplate->id_email_template
                    ]
                );
            }
            dispatch(new SendMailIndustri(auth()->user(), 'penjadwalan_seleksi', $request->kandidat));

            DB::commit();
            return Response::success(null, 'Berhasil menetapkan jadwal seleksi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function getDataDetailInformasi(Request $request, $id)
    {
        $lowongan = $this->my_lowongan_magang->first();

        $inArray = 'in:' . PendaftaranMagangStatusEnum::APPROVED_BY_LKM;
        for ($i = 0; $i < ($lowongan->tahapan_seleksi + 1); $i++) {
            $inArray .= ',' . array_search($i, $this->valid_step);
        }
        $inArray .= ',';
        $inArray .= implode(',', [
            array_search(($lowongan->tahapan_seleksi + 1), $this->valid_step),
            PendaftaranMagangStatusEnum::APPROVED_PENAWARAN,
            'all_rejected',
            'all_seleksi',
            'seleksi',
            'kandidat_pelamar',
            'penawaran'
        ]);

        $tahap = $lowongan->tahapan_seleksi;

        $reqRules = ['type' => 'required|' . $inArray];
        if ($request->type == 'penawaran') {
            $reqRules['filter_seleksi'] = 'nullable|in:all,' . implode(',', [PendaftaranMagangStatusEnum::APPROVED_PENAWARAN, PendaftaranMagangStatusEnum::REJECTED_PENAWARAN, PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1, PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1]);
        }

        $request->validate($reqRules);

        $this->getPendaftarMagang(function ($query) use ($id, $request, $tahap) {
            $query = $query->where('pendaftaran_magang.id_lowongan', $id);

            if ($request->type == 'all_rejected') {
                $query = $query->whereIn('current_step', [
                    PendaftaranMagangStatusEnum::REJECTED_SCREENING,
                    PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
                    PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
                    PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
                    PendaftaranMagangStatusEnum::REJECTED_PENAWARAN
                ]);
            } elseif ($request->type == 'all_seleksi' || $request->type == 'seleksi') {
                for ($i = 0; $i < ($tahap + 1); $i++) {
                    $tahap_valid[] = array_search($i, $this->valid_step);
                }
                $query = $query->whereIn('current_step', $tahap_valid);
            } elseif ($request->type == 'penawaran') {
                $query = $query->whereIn(
                    'current_step',
                    [
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
                        PendaftaranMagangStatusEnum::MENGUNDURKAN_DIRI
                    ]
                )->orderBy('current_step', 'asc');

                if ($request->filter_seleksi && $request->filter_seleksi != 'all') {
                    $query = $query->where('current_step', $request->filter_seleksi);
                }
            } else {
                if ($request->type == 'kandidat_pelamar') {
                    return $query->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM);
                }
                if($request->type == 'rejected_penawaran'){
                    return $query->whereIn('current_step', [
                        PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
                        PendaftaranMagangStatusEnum::MENGUNDURKAN_DIRI
                    ]);
                }
                $query = $query->where('current_step', $request->type);
            }

            return $query;
        });

        if ($request->type == 'seleksi' && count($this->my_pendaftar_magang) > 0) $this->my_pendaftar_magang = $this->generateScores($this->my_pendaftar_magang);

        $datatables = datatables()->of($this->my_pendaftar_magang)
            ->addIndexColumn()
            // ->editColumn('namamhs', function ($data) {
            //     $result = '<div class="d-flex flex-column align-items-start">';
            //     $result .= '<span class="fw-semibold text-nowrap">' .$data->namamhs. '</span>';
            //     $result .= '<span class="text-nowrap">' .$data->namaprodi. '</span>';
            //     $result .= '</div>';
            //     return $result;
            // })
            ->editColumn('current_step', function ($data) {
                if ($data->current_step == array_search(($data->tahapan_seleksi + 1), $this->valid_step)) {
                    $status = ['title' => 'Penawaran', 'color' => 'info'];
                } else {
                    $status = PendaftaranMagangStatusEnum::getWithLabel($data->current_step);
                }

                return '<div class="d-flex justify-content-center"><span class="badge bg-label-' . $status['color'] . '">' . $status['title'] . '</span></div>';
            })
            ->editColumn('nohpmhs', function ($data) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span class="text-nowrap">' . $data->nohpmhs . '</span>';
                $result .= '<span class="text-nowrap">' . $data->emailmhs . '</span>';
                $result .= '</div>';
                return $result;
            })
            ->editColumn('namaprodi', fn($data) => '<span class="text-nowrap">' . $data->namaprodi . '</span>')
            ->editColumn('namauniv', function ($data) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span class="text-nowrap">' . $data->namauniv . '</span>';
                $result .= '<span class="text-nowrap">' . $data->namafakultas . '</span>';
                $result .= '</div>';
                return $result;
            })
            ->editColumn('tanggaldaftar', function ($data) {
                return '<span class="text-nowrap">' . Carbon::parse($data->tanggaldaftar)->format('d F Y') . '</span>';
            })
            ->editColumn('tanggalseleksi', function ($data) use ($lowongan) {
                $seleksiDefault = SeleksiTahap::where('id_lowongan', $lowongan->id_lowongan)->get();
                $result = '<div class="d-flex flex-column align-items-start">';
                foreach ($seleksiDefault as $key => $value) {
                    $seleksiCustom = Seleksi::where('id_pendaftaran', $data->id_pendaftaran)->where('tahapan_seleksi', $key + 1);
                    if ($seleksiCustom->exists()) {
                        $seleksiCustom = $seleksiCustom->first();
                        $result .= '<span class="mt-1 fw-semibold text-nowrap">' . "Tahap " . ($key + 1) . '</span>';
                        $result .= '<span class="text-nowrap">' . Carbon::parse($seleksiCustom->start_date)->format('d F Y') . ' - ' . Carbon::parse($seleksiCustom->end_date)->format('d F Y') . '</span>';
                    } else {
                        $result .= '<span class="mt-1 fw-semibold text-nowrap">' . "Tahap " . ($key + 1) . '</span>';
                        $result .= '<span class="text-nowrap">' . Carbon::parse($value->tgl_mulai)->format('d F Y') . ' - ' . Carbon::parse($value->tgl_akhir)->format('d F Y') . '</span>';
                    }
                }
                return $result;
            })
            ->editColumn('score', function ($data) {
                //format hanya 2 angka di belakang ,
                return number_format(floatval($data->score), 2);
            })
            ->addColumn('action', function ($data) use ($lowongan) {
                for ($i = 0; $i < ($lowongan->tahapan_seleksi + 1); $i++) {
                    $tahap_valid[] = array_search($i, $this->valid_step);
                }
                $result = '<div class="d-flex justify-content-center">';
                if (in_array($data->current_step, $tahap_valid)) {
                    $isLast = ($this->valid_step[$data->current_step] == $data->tahapan_seleksi) ? '1' : '0';
                    $result .= '<a class="cursor-pointer text-primary me-2" onclick="swalConfirmStatus($(this))" data-id="' . $data->id_pendaftaran . '" data-status="approved" data-last="' . $isLast . '"><i class="ti ti-circle-check"></i></a>';
                    $result .= '<a class="cursor-pointer text-danger" onclick="swalConfirmStatus($(this))" data-id="' . $data->id_pendaftaran . '" data-status="rejected"><i class="ti ti-circle-x"></i></a>';
                    $result .= '</div>';
                    $result .= '<div class="d-flex justify-content-center">';
                }
                $result .= '<a class="cursor-pointer text-warning me-2" onclick="emailSent($(this))" data-id="' . $data->id_pendaftaran . '" data-bs-toggle="tooltip" title=""><i class="ti ti-mail"></i></a>';
                $result .= '<a class="cursor-pointer text-primary" onclick="detailInfo($(this))" data-id="' . $data->id_pendaftaran . '" data-bs-toggle="tooltip" title="detail"><i class="ti ti-file-invoice"></i></a>';
                $result .= '</div>';

                return $result;
            })
            ->editColumn('dokumen_spm', fn($data) => ('<div class="text-center">' . ($data->dokumen_spm ? '<a href="' . url('storage/' . $data->dokumen_spm) . '" target="_blank" class="text-nowrap text-primary">Dokumen SPM.pdf</a>' : '-') . '</div>'))
            ->editColumn('dokumen_skm', fn($data) => ('<div class="text-center">' . ($data->dokumen_skm ? '<a href="' . url('storage/' . $data->dokumen_skm) . '" target="_blank" class="text-nowrap text-primary">Dokumen SKM.pdf</a>' : '-') . '</div>'));

        return $datatables->rawColumns([
            'nohpmhs',
            'tanggaldaftar',
            'namaprodi',
            'namafakultas',
            'namauniv',
            'current_step',
            'action',
            'tanggalseleksi',
            'dokumen_skm',
            'dokumen_spm'
        ])
            ->make(true);
    }

    public function updateStatusPelamar(Request $request)
    {
        try {
            DB::beginTransaction();

            $idPendaftaranList = $request->id_pendaftaran;
            foreach ($idPendaftaranList as $idPendaftaran) {
                $this->getPendaftarMagang(function ($query) use ($idPendaftaran) {
                    return $query->leftJoin('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
                        ->where('pendaftaran_magang.id_pendaftaran', $idPendaftaran);
                });

                $pendaftar = $this->my_pendaftar_magang->first();
                if (!$pendaftar) return Response::error(null, 'Pendaftaran Not Found');

                $email = EmailTemplate::where('id_industri', $pendaftar->id_industri)->get();

                if (count($email) != 4) return Response::error(null, 'Template email belum dibuat.');

                $countPendaftarDitawarkan = PendaftaranMagang::select('current_step')
                    ->where('id_lowongan', $pendaftar->id_lowongan)
                    ->whereIn('current_step', [
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
                        PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3
                    ])->get()->filter(function ($item) use ($pendaftar) {
                        return isset($this->valid_step[$item->current_step]) && ($pendaftar->tahapan_seleksi + 1) == $this->valid_step[$item->current_step];
                    })->count();

                if ($countPendaftarDitawarkan == $pendaftar->kuota) {
                    return Response::error([
                        'view_alert' => view('company/lowongan_magang/components/card_alert', [
                            'kuota_penawaran_full' => true,
                            'kuota' => $pendaftar->kuota,
                        ])->render()
                    ], 'Kuota sudah penuh. Anda dapat menawarkan kembali jika ada tawaran anda yang ditolak oleh mahasiswa');
                }

                $last_seleksi = array_search(($pendaftar->tahapan_seleksi + 1), $this->valid_step);
                $statusIfApproved = $this->valid_step[$pendaftar->current_step] + 1;

                $validate = ['status' => 'required|in:approved,rejected'];
                if ($this->valid_step[$last_seleksi] == $statusIfApproved || $request->status == 'rejected') {
                    $validate['file'] = 'required|mimes:pdf|max:2048';
                }

                $validateMsg = [
                    'status.required' => "Status tidak valid",
                    'status.in' => "Status tidak valid",
                    'file.mimes' => 'File harus berformat PDF',
                    'file.required' => 'File harus diunggah',
                    'file.max' => 'File tidak boleh lebih dari 2MB.'
                ];

                $request->validate($validate, $validateMsg);
                // $validator = Validator::make($request->all(), $validate, $validateMsg);

                // if ($validator->fails()) {
                //     return Response::error($validator->errors()->all(), 'Invalid');
                // }

                $file = null;
                $statusPicked = ($request->status == 'approved') ? array_search($statusIfApproved, $this->valid_step) : 'rejected';
                if ($pendaftar->date_confirm_closing == null && $statusPicked == $last_seleksi) {
                    return Response::error(null, 'Batas Konfirmasi belum diatur');
                }

                if (($statusPicked == $last_seleksi || $statusPicked == 'rejected') && $request->hasFile('file')) {
                    $file = Storage::put('berkas_mitra', $request->file('file'));
                }

                if ($request->status == 'rejected') {
                    if ($pendaftar->current_step == PendaftaranMagangStatusEnum::APPROVED_BY_LKM) {
                        $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SCREENING;
                    } else if ($pendaftar->current_step == PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1) {
                        $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1;
                    } else if ($pendaftar->current_step == PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1) {
                        $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2;
                    } else if ($pendaftar->current_step == PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2) {
                        $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3;
                    }
                }

                $pendaftar->current_step = $statusPicked;
                $pendaftar->file_document_mitra = $file;

                $pendaftar->saveHistoryApproval()->save();

                // masuk seleksi
                if ($statusIfApproved == 0) {
                    $idIndustri = auth()->user()->pegawai_industri->id_industri;
                    $counter = new WriteAndReadCounterBadgeJob('informasi_lowongan_count.' . $idIndustri, 'decrement', function () use ($idIndustri) {
                        return PendaftaranMagang::whereHas('lowongan_magang', function ($q) use ($idIndustri) {
                            $q->where('id_industri', $idIndustri);
                        })->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM)->count();
                    });

                    $counter = $counter->get()->{'informasi_lowongan_count.' . $idIndustri};
                }

                $pendaftar->label_step = PendaftaranMagangStatusEnum::getWithLabel($pendaftar->current_step)['title'];
                $proses = TemplateEmailListProsesEnum::LOLOS_SELEKSI;
                if ($statusPicked == $last_seleksi) {
                    $proses = TemplateEmailListProsesEnum::DITERIMA_MAGANG;
                    $countPendaftarDitawarkan++;
                } else if ($request->status == 'rejected') {
                    $proses = TemplateEmailListProsesEnum::TIDAK_LOLOS_SELEKSI;
                }

                // dispatch_sync(new SendMailIndustri(auth()->user(), $proses, $id));
                SendMailIndustri::dispatchSync(auth()->user(), $proses, $idPendaftaran);
            }

            DB::commit();

            $response = [];

            $response['counter'] = $counter ?? 0;

            if ($countPendaftarDitawarkan == $pendaftar->kuota) {
                $response['view_alert'] = view('company/lowongan_magang/components/card_alert', [
                    'kuota_penawaran_full' => true,
                    'kuota' => $pendaftar->kuota,
                ])->render();
            }

            return Response::success($response, 'Success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->element == 'id_prodi') {
            $data = ProgramStudi::select('id_prodi as id', 'namaprodi as text')->where('id_fakultas', $request->selected)->get();
            return Response::success($data, 'Success!');
        }
        $tahunAjaran = TahunAkademik::where('status', 1)->get();

        return view('company.lowongan_magang.kelola_lowongan.halaman_lowongan_magang_mitra', compact('tahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jenismagang = JenisMagang::whereExists(function ($q) {
            $q->select(DB::raw(1))->from('tahun_akademik')->where('status', 1)->whereColumn('jenis_magang.id_year_akademik', 'id_year_akademik');
        })->get();

        $id_industri = auth()->user()->pegawai_industri->id_industri;

        $dataBidangPekerjaan = DB::table('bidang_pekerjaan_industri as bpi_default')
            ->where('bpi_default.status', 1)
            ->where('bpi_default.default', 1)
            ->whereNotExists(function ($query) use ($id_industri) {
                $query->select(DB::raw(1))
                    ->from('bidang_pekerjaan_industri as bpi_industri')
                    ->whereRaw('LOWER(bpi_industri.namabidangpekerjaan) = LOWER(bpi_default.namabidangpekerjaan)')
                    ->where('bpi_industri.id_industri', $id_industri);
            })
            ->union(
                DB::table('bidang_pekerjaan_industri')
                    ->where('id_industri', $id_industri)
                    ->where('status', 1)
            )
            ->orderBy('namabidangpekerjaan')
            ->get();

        $kota = DB::table('reg_regencies')->select('id', 'name')->get();
        return view('company.lowongan_magang.kelola_lowongan.tambah_lowongan_magang', compact('jenismagang', 'kota', 'dataBidangPekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LowonganMagangRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataStep = Crypt::decryptString($request->data_step);

            if ($dataStep == 1) {
                return Response::success([
                    'ignore_alert' => true,
                    'data_step' => (int) ($dataStep + 1),
                ], 'Valid data!');
            }

            // if ($dataStep == 2) {
            //     $tahap = $request->tahapan_seleksi;
            //     return Response::success([
            //         'ignore_alert' => true,
            //         'data_step' => (int) ($dataStep + 1),
            //         'view' => view('company/lowongan_magang/kelola_lowongan/step/proses_seleksi', compact('tahap'))->render(),
            //     ], 'Valid data!');
            // }

            $request->jenjang = array_map(function () {
                return [];
            }, array_flip($request->jenjang));

            $id_industri = auth()->user()->pegawai_industri->id_industri;
            $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_industri', $id_industri)->where('id_bidang_pekerjaan_industri', $request->intern_position ?? "")->first();

            if ($bidangPekerjaanIndustri) {
                $bidangPekerjaanIndustri->update([
                    'deskripsi' => $request->deskripsi
                ]);
                $request->intern_position = $bidangPekerjaanIndustri->id_bidang_pekerjaan_industri;
            } else {
                // $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_industri', $id_industri)->where('nama', $request->intern_position ?? "")->first();

                $bidangPekerjaanIndustri = BidangPekerjaanIndustri::create([
                    'id_industri' => $id_industri,
                    'namabidangpekerjaan' => $request->intern_position,
                    'deskripsi' =>  $request->deskripsi
                ]);

                $request->intern_position = $bidangPekerjaanIndustri->id_bidang_pekerjaan_industri;

                $this->copyDefaultMappingMk($bidangPekerjaanIndustri->id_bidang_pekerjaan_industri);
            }

            $nominal_salary = null;
            if ($request->gaji == 1) {
                $nominal_salary = str_replace('.', '', $request->nominal_salary);
                $nominal_salary = (float) str_replace(',', '.', $nominal_salary);
            }

            $lowongan = LowonganMagang::create([
                'id_jenismagang' => $request->id_jenismagang,
                'intern_position' => $request->intern_position,
                'kuota' => $request->kuota,
                'deskripsi' => $request->deskripsi,
                'requirements' => collect($request->persyaratan_tambahan)->filter(fn($item) => !empty($item['persyaratan_tambah']))->pluck('persyaratan_tambah')->values() ?? [],
                'gender' => count($request->input('gender')) > 1 ? 'Laki-Laki & Perempuan' : $request->input('gender')[0],
                'jenjang' => json_encode($request->jenjang),
                'keterampilan' => json_encode($request->keterampilan),
                'pencapaian' => json_encode($request->pencapaian),
                'pengalaman' => json_encode($request->pengalaman),
                'softskill' => json_encode($request->softskill),
                'pelaksanaan' => $request->pelaksanaan,
                'nominal_salary' => (float) $nominal_salary ?? null,
                'benefitmagang' => $request->benefitmagang,
                'lokasi' => json_encode($request->lokasi),
                'startdate' => Carbon::parse($request->startdate)->format('Y-m-d'),
                'enddate' => Carbon::parse($request->enddate)->format('Y-m-d'),
                'durasimagang' => json_encode($request->durasimagang),
                'tahapan_seleksi' => 0,
                'id_industri' => $id_industri,
                'statusaprove' => LowonganMagangStatusEnum::PENDING,
                'pembobotan' => '{"Nilai Akademik":"5.00","Sertifikasi":"5.00","Prestasi Kompetisi":"5.00","Pengalaman Proyek":"5.00","Softskills":"5.00"}',
                'date_confirm_closing' => 7
            ]);

            SeleksiTahap::create([
                'id_lowongan' => $lowongan->id_lowongan,
                'tahap' => 1,
                'deskripsi' => "FAHP",
                'tgl_mulai' => $request['tgl_mulai'],
                'tgl_akhir' => $request['tgl_akhir'],
            ]);

            // foreach ($request->proses_seleksi as $key => $value) {
            //     SeleksiTahap::create([
            // 'id_lowongan' => $lowongan->id_lowongan,
            // 'tahap' => Crypt::decryptString($value['tahap']),
            // 'deskripsi' => $value['deskripsi'],
            // 'tgl_mulai' => $value['tgl_mulai'],
            // 'tgl_akhir' => $value['tgl_akhir'],
            //     ]);
            // }

            DB::commit();

            new WriteAndReadCounterBadgeJob('lowongan.kelola_count', 'increment', function () {
                return LowonganMagang::where('statusaprove', LowonganMagangStatusEnum::PENDING)->count();
            });

            return Response::success(null, 'Lowongan magang ditambahkan!');
        } catch (Exception $e) {
            DB::rollback();
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request)
    {
        $request->validate([
            'type' => 'required|in:total,tertunda,diterima,ditolak',
            'page_length' => 'required|in:10,25,50,100',
        ]);

        $this->getLowonganMagang(function ($query) use ($request) {
            //search datatable
            if ($request->search) {
                $query = $query
                    ->where(function ($q) use ($request) {
                        $q
                            ->where('intern_position', 'like', "%$request->search%")
                            ->orWhere('durasimagang', 'like', "%$request->search%");
                    });
            }
            //end search datatable

            $query = $query
                ->where(function ($q) use ($request) {
                    $q->where('id_year_akademik', $request->tahun_akademik)->orWhereNull('id_year_akademik');
                })->with("bidangPekerjaanIndustri")->orderBy('intern_position', 'asc');

            if ($request->type == 'total') return $query->paginate($request->page_length);
            return $query->where('statusaprove', $request->type)->paginate($request->page_length);
        });

        $lowongan = $this->my_lowongan_magang;

        $paginationInfo = [
            'current_page' => $lowongan->currentPage(),
            'last_page' => $lowongan->lastPage(),
            'per_page' => $lowongan->perPage(),
            'total' => $lowongan->total(),
        ];

        $datatable = DataTables::of($lowongan->items())
            ->editColumn('status', function ($row) {
                switch ($row->statusaprove) {
                    case LowonganMagangStatusEnum::APPROVED:
                        $color = 'success';
                        $text = 'Diterima';
                        break;
                    case LowonganMagangStatusEnum::PENDING:
                        $color = 'warning';
                        $text = 'Pending';
                        break;
                    case LowonganMagangStatusEnum::REJECTED:
                        $color = 'danger';
                        $text = 'Ditolak';
                        break;
                }

                return "<div class='text-center'><div class='badge rounded-pill bg-label-$color'>" . $text . "</div>";
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "primary";

                if ($row->statusaprove != 'diterima') {
                    $edit = "<a href='" . route('kelola_lowongan.edit', ['id' => $row->id_lowongan]) . "' class='mx-1 cursor-pointer text-warning btn-detail' data-bs-toggle='tooltip' title='Edit'><i class='tf-icons ti ti-edit' ></i></a>";
                } else {
                    $edit = '';
                }

                if ($row->statusaprove == 'ditolak' || $row->statusaprove == 'tertunda') {
                    $delete = '';
                    $editSchedule = '';
                } else {
                    $delete = "<a data-function='afterUpdateStatus' data-url='" . route('kelola_lowongan.change_status', ['id' => $row->id_lowongan]) . "' class='cursor-pointer mx-1 update-status text-{$color}' data-bs-toggle='tooltip' title='" . ($icon == 'ti-circle-x' ? 'Non Active' : 'Active') . "'><i class='tf-icons ti {$icon}'></i></a>";
                    $editSchedule = "<a data-id='" . $row->id_lowongan . "' class='mx-1 cursor-pointer text-info' onclick='updateTakedown($(this))' data-bs-toggle='tooltip' title='Edit Takedown'><i class='tf-icons ti ti-calendar'></i></a>";
                }

                $btn = "<div class='d-flex justify-content-center'>$edit
                        <a href='" . route('kelola_lowongan.detail', $row->id_lowongan) . "' class='mx-1 cursor-pointer text-primary btn-detail' data-bs-toggle='tooltip' title='Detail'><i class='tf-icons ti ti-file-invoice' ></i></a>
                        $editSchedule
                        $delete
                        </div>";
                return $btn;
            })
            ->addColumn('tanggal', function ($row) {
                $result = '<div class="text-start">';

                $result .= '<span class="text-muted">Publish</span><br>';
                $result .= '<span>' . Carbon::parse($row->startdate)->format('d F Y') . '</span><br>';
                $result .= '<span class="text-muted">Takedown</span><br>';
                $result .= '<span>' . Carbon::parse($row->enddate)->format('d F Y') . '</span>';

                $result .= '</div>';
                return  $result;
            })
            ->editColumn('durasimagang', function ($data) {
                $result = implode(' dan ', json_decode($data->durasimagang));
                return $result;
            })
            ->editColumn('intern_position', function ($data) {
                return $data->bidangPekerjaanIndustri?->namabidangpekerjaan ?? "";
            })
            ->rawColumns(['action', 'status', 'tanggal', 'durasimagang', 'intern_position'])
            ->make(true);

        return response()->json([
            'datatable' => $datatable,
            'pagination' => $paginationInfo,
            'page_length' => $request->page_length
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $lowongan = $this->my_lowongan_magang->load('jenisMagang')->first();

        $lowongan->nominal_salary = ($lowongan->nominal_salary) ? number_format($lowongan->nominal_salary, 2, ',', '.') : 0;

        $lowongan->requirements = json_decode($lowongan->requirements);

        if ($lowongan->statusaprove == 'diterima') {
            return redirect()->route('kelola_lowongan');
        }

        $jenismagang = JenisMagang::whereExists(function ($q) {
            $q->select(DB::raw(1))->from('tahun_akademik')->where('status', 1)->whereColumn('jenis_magang.id_year_akademik', 'id_year_akademik');
        })->get();

        $tahap = $lowongan->tahapan_seleksi;
        $kota = DB::table('reg_regencies')->select('id', 'name')->get();

        foreach ($lowongan->seleksi_tahap as $key => $value) {
            // $lowongan->{'proses_seleksi[' . $key . '][deskripsi]'} = $value->deskripsi;
            // $lowongan->{'proses_seleksi[' . $key . '][tgl_mulai]'} = $value->tgl_mulai;
            // $lowongan->{'proses_seleksi[' . $key . '][tgl_akhir]'} = $value->tgl_akhir;
            $lowongan->tgl_mulai = $value->tgl_mulai;
            $lowongan->tgl_akhir = $value->tgl_akhir;
        }

        $id_industri = auth()->user()->pegawai_industri->id_industri;

        $dataBidangPekerjaan = DB::table('bidang_pekerjaan_industri as bpi_default')
            ->where('bpi_default.status', 1)
            ->where('bpi_default.default', 1)
            ->whereNotExists(function ($query) use ($id_industri) {
                $query->select(DB::raw(1))
                    ->from('bidang_pekerjaan_industri as bpi_industri')
                    ->whereRaw('LOWER(bpi_industri.namabidangpekerjaan) = LOWER(bpi_default.namabidangpekerjaan)')
                    ->where('bpi_industri.id_industri', $id_industri);
            })
            ->union(
                DB::table('bidang_pekerjaan_industri')
                    ->where('id_industri', $id_industri)
                    ->where('status', 1)
            )
            ->orderBy('namabidangpekerjaan')
            ->get();

        return view('company.lowongan_magang.kelola_lowongan.tambah_lowongan_magang', compact('jenismagang', 'lowongan', 'tahap', 'kota',  'dataBidangPekerjaan'));
    }

    public function detail(Request $request, $id)
    {
        $lowongan = $this->my_lowongan_magang->load('seleksi_tahap', 'industri', 'bidangPekerjaanIndustri')->first()->dataTambahan('jenjang_pendidikan', 'program_studi');
        if (!$lowongan) return redirect()->route('kelola_lowongan');
        $kuotaPenuh = $lowongan->kuota_terisi / $lowongan->kuota == 1;

        $urlBack = route('kelola_lowongan') . '?page=' . $request->page . '&type=' . $request->type;
        return view('lowongan_magang.kelola_lowongan_magang_admin.detail', compact('lowongan', 'urlBack', 'kuotaPenuh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LowonganMagangRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $lowongan = $this->my_lowongan_magang->first();

            $prevStatus = $lowongan->statusaprove;

            $dataStep = Crypt::decryptString($request->data_step);
            if ($dataStep == 1) {
                return Response::success([
                    'ignore_alert' => true,
                    'data_step' => (int) ($dataStep + 1),
                ], 'Valid data!');
            }

            // if ($dataStep == 2) {
            //     $tahap = $request->tahapan_seleksi;
            //     $return = [
            //         'ignore_alert' => true,
            //         'data_step' => (int) ($dataStep + 1),
            //     ];

            //     if ($tahap != $lowongan->tahapan_seleksi) {
            //         $return['view'] = view('company/lowongan_magang/kelola_lowongan/step/proses_seleksi', compact('tahap'))->render();
            //     }

            //     return Response::success($return, 'Valid data!');
            // }

            $request->jenjang = array_map(function () {
                return [];
            }, array_flip($request->jenjang));

            $id_industri = auth()->user()->pegawai_industri->id_industri;
            $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_industri', $id_industri)->where('id_bidang_pekerjaan_industri', $request->intern_position ?? "")->first();

            if ($bidangPekerjaanIndustri) {
                $bidangPekerjaanIndustri->update([
                    'deskripsi' => $request->deskripsi
                ]);
                $request->intern_position = $bidangPekerjaanIndustri->id_bidang_pekerjaan_industri;
            } else {
                $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_industri', $id_industri)->where('nama', $request->intern_position ?? "")->first();

                $bidangPekerjaanIndustri = BidangPekerjaanIndustri::create([
                    'id_industri' => $id_industri,
                    'nama' => $request->intern_position,
                    'deskripsi' =>  $request->deskripsi
                ]);

                $request->intern_position = $bidangPekerjaanIndustri->id_bidang_pekerjaan_industri;

                $this->copyDefaultMappingMk($bidangPekerjaanIndustri->id_bidang_pekerjaan_industri);
            }

            if ($request->gaji == 1) {
                $nominal_salary = str_replace('.', '', $request->nominal_salary);
                $nominal_salary = (float) str_replace(',', '.', $nominal_salary);
            }

            $lowongan->id_jenismagang = $request->id_jenismagang;
            $lowongan->intern_position = $request->intern_position;
            $lowongan->kuota = $request->kuota;
            $lowongan->deskripsi = $request->deskripsi;
            $lowongan->requirements = collect($request->persyaratan_tambahan)->pluck('persyaratan_tambah');
            $lowongan->jenjang = $request->jenjang;
            $lowongan->keterampilan = $request->keterampilan;
            $lowongan->pencapaian = $request->pencapaian;
            $lowongan->pengalaman = $request->pengalaman;
            $lowongan->gender = count($request->input('gender')) > 1 ? 'Laki-Laki & Perempuan' : $request->input('gender')[0];
            $lowongan->nominal_salary = (float) $nominal_salary ?? null;
            $lowongan->benefitmagang = $request->benefitmagang;
            $lowongan->lokasi = $request->lokasi;
            $lowongan->pelaksanaan = $request->pelaksanaan;
            $lowongan->startdate = $request->startdate;
            $lowongan->enddate = $request->enddate;
            $lowongan->durasimagang = $request->durasimagang;
            $lowongan->tahapan_seleksi = 0;
            $lowongan->statusaprove = LowonganMagangStatusEnum::PENDING;

            $lowongan->save();

            SeleksiTahap::where('id_lowongan', $id)->first()
                ->update([
                    'tgl_mulai' => $request['tgl_mulai'],
                    'tgl_akhir' => $request['tgl_akhir'],
                ]);

            // foreach ($request->proses_seleksi as $key => $value) {
            //     SeleksiTahap::create([
            //         'id_lowongan' => $lowongan->id_lowongan,
            //         'tahap' => Crypt::decryptString($value['tahap']),
            //         'deskripsi' => $value['deskripsi'],
            //         'tgl_mulai' => $value['tgl_mulai'],
            //         'tgl_akhir' => $value['tgl_akhir'],
            //     ]);
            // }

            DB::commit();

            if ($prevStatus == LowonganMagangStatusEnum::REJECTED) {
                new WriteAndReadCounterBadgeJob('lowongan.kelola_count', 'increment', function () {
                    return LowonganMagang::where('statusaprove', LowonganMagangStatusEnum::PENDING)->count();
                });
            }

            return Response::success(null, 'lowongan magang successfully Updated!');
        } catch (Exception $e) {
            DB::rollback();
            return Response::errorCatch($e);
        }
    }

    private function copyDefaultMappingMk(string $id_bidang_pekerjaan_industri)
    {
        try {
            // Ambil bidang pekerjaan industri & relasinya langsung dengan `with()`
            $bidangPekerjaanIndustri = BidangPekerjaanIndustri::with('bidangPekerjaanMk')
                ->find($id_bidang_pekerjaan_industri);

            if (!$bidangPekerjaanIndustri) {
                throw new Exception("Bidang pekerjaan tidak ditemukan.");
            }

            // Cek apakah bidang pekerjaan industri sudah memiliki mapping
            if ($bidangPekerjaanIndustri->bidangPekerjaanMk->isNotEmpty()) {
                return true; // Jika sudah ada mapping, langsung return
            }

            // Cari bidang pekerjaan default dengan nama yang sama (case insensitive)
            $defaultBidangPekerjaan = BidangPekerjaanIndustri::with('bidangPekerjaanMk.mkItems')
                ->where('default', 1)
                ->whereRaw('LOWER(namabidangpekerjaan) = LOWER(?)', [$bidangPekerjaanIndustri->namabidangpekerjaan])
                ->first();

            if (!$defaultBidangPekerjaan) {
                return;
            }

            // Loop untuk copy semua bidang pekerjaan MK & MK Items
            $mkItemsToInsert = [];
            foreach ($defaultBidangPekerjaan->bidangPekerjaanMk as $defaultMk) {
                // Buat mapping MK baru
                $newBidangPekerjaanMk = $bidangPekerjaanIndustri->bidangPekerjaanMk()->create([
                    'bobot' => $defaultMk->bobot,
                    'id_prodi' => $defaultMk->id_prodi
                ]);

                // Siapkan data untuk bulk insert MK Items
                foreach ($defaultMk->mkItems as $mkItem) {
                    $mkItemsToInsert[] = [
                        'id_bidang_pekerjaan_mk' => $newBidangPekerjaanMk->id_bidang_pekerjaan_mk,
                        'id_mk' => $mkItem->id_mk,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert bulk untuk optimasi
            if (!empty($mkItemsToInsert)) {
                BidangPekerjaanMkItem::insert($mkItemsToInsert);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Terjadi kesalahan: " . $e->getMessage());
        }
    }
    public function getTakedown($id)
    {
        try {
            $lowongan = $this->my_lowongan_magang->first();
            if (!$lowongan) return Response::error(null, 'Lowongan Magang Not Found');
            return Response::success($lowongan->enddate, 'Success.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateTakedown(Request $request, $id)
    {
        $lowongan = $this->my_lowongan_magang->first();
        if (!$lowongan) return Response::error(null, 'Lowongan Magang Not Found');

        $request->validate([
            'enddate' => ['required', function ($attribute, $value, $fail) use ($lowongan) {
                if (isset($value) && isset($lowongan->startdate)) {
                    $startdate = Carbon::parse($lowongan->startdate);
                    $enddate = Carbon::parse($value);
                    $now = Carbon::parse(now()->format('Y-m-d'));

                    if ($startdate->gt($enddate)) {
                        $fail('Tanggal ini tidak boleh lebih kecil dari Tanggal Lowongan Ditayangkan');
                    }
                    if ($now->gt($enddate)) {
                        $fail('Tanggal ini tidak boleh kurang dari Tanggal Sekarang.');
                    }
                }
            }]
        ]);

        try {
            $lowongan->enddate = $request->enddate;
            $lowongan->save();

            return Response::success(null, 'lowongan magang successfully Updated!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function getDetailKriteriaKandidat(Request $request, $id)
    {
        // Mengambil data pendaftaran magang berdasarkan ID
        $my_pendaftar_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            // ->join('experience_pendaftaran', 'experience_pendaftaran.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            // ->join('sertifikat_pendaftaran', 'sertifikat_pendaftaran.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->where('id_pendaftaran', $id)
            ->first();

        // Dekode JSON dari lowongan untuk keterampilan, pencapaian, pengalaman, dan persyaratan
        $keterampilan = json_decode($my_pendaftar_magang->lowongan_magang->keterampilan, true) ?? [];
        $pencapaian = json_decode($my_pendaftar_magang->lowongan_magang->pencapaian, true) ?? [];
        $pengalaman = json_decode($my_pendaftar_magang->lowongan_magang->pengalaman, true) ?? [];
        $requirements = json_decode($my_pendaftar_magang->lowongan_magang->requirements, true) ?? [];

        // Dekode JSON dari pendaftaran magang untuk skill mahasiswa
        $skills_mhs = SertifikatPendaftaran::where('nim', $my_pendaftar_magang->nim)
            ->pluck('nama_sertif')
            ->toArray() ?? [];
        // $skills_mhs = json_decode($my_pendaftar_magang->skills, true) ?? [];

        // Mengambil data pengalaman kompetisi dan proyek mahasiswa berdasarkan NIM
        $prestasi_kompetisi = ExperiencePendaftaran::where('nim', $my_pendaftar_magang->nim)
            ->where('kategori', 'competition')
            ->pluck('nama')
            ->toArray() ?? [];

        $pengalaman_proyek = ExperiencePendaftaran::where('nim', $my_pendaftar_magang->nim)
            ->where('kategori', 'project')
            ->pluck('nama')
            ->toArray() ?? [];

        // $reason_aplicant = $my_pendaftar_magang->reason_aplicant;
        $reason_aplicant = Hasil_Wawancara::where('id_pendaftaran', $id)->where('nim', $my_pendaftar_magang->nim)->first();

        // dd($reason_aplicant);
        $relatedMk = $my_pendaftar_magang->lowongan_magang->bidangPekerjaanIndustri->bidangPekerjaanMk;

        $mkItems = [];

        foreach ($relatedMk as $bidangPekerjaanMk) {
            foreach ($bidangPekerjaanMk->mkItems as $mkItem) {
                if ($mkItem->mataKuliah->prodi->id_prodi == $my_pendaftar_magang->id_prodi) {
                    $mkItems[] = $mkItem;
                }
            }
        }

        $nilaiAkhirMhs = $my_pendaftar_magang->mahasiswa->nilaiAkhirMhs;

        $listNilaiAkhirMk = [];
        $mkItemIds = collect($mkItems)->pluck('id_mk')->toArray();
        if ($nilaiAkhirMhs) {
            foreach ($nilaiAkhirMhs as $key => $value) {
                $nilai = $value->nilai_mk;
                $namamk = $value->mataKuliah->namamk;

                if (in_array($value->id_mk, $mkItemIds)) {
                    $listNilaiAkhirMk[] = $namamk . ' : ' . $nilai .  "<br>";
                }
            }
        }

        $nilai_predikat = FuzzyAHP::generateNilaiAkademik($my_pendaftar_magang)->nilai_akademik;
        $desk_persyaratan = '';
        // foreach ($requirements as $r) {
        //     $desk_persyaratan = $r . ":<ul>";
        //     foreach ($r['questions'] as $question) {
        //         $desk_persyaratan .= "<li>" . $question['question'] . "</li>";
        //     }
        //     $desk_persyaratan .= "</ul>";
        // };

        $grades = json_decode($reason_aplicant?->skoring_wawancara, true) ?? [];
        $sumGrade = 0;
        foreach ($grades as $grade) {
            $sumGrade += $grade['score'];
        }
        $avgGrade = Round($sumGrade / count(json_decode($my_pendaftar_magang->softskill)));

        $url = route('wawancara-flow.result', $my_pendaftar_magang->id_pendaftaran);

        $link = '<a href="' . $url . '">Detail Hasil</a>';
        // dd($avgGrade);
        $data = [
            [
                'kriteria' => 'Nilai Akademik',
                'desk_persyaratan' => 'Informasi Nilai Akademik',
                'desk_kriteria_mhs' => $listNilaiAkhirMk,
                'predikat_nilai' => $nilai_predikat
            ],
            [
                'kriteria' => 'Sertifikasi',
                'desk_persyaratan' => $keterampilan,
                'desk_kriteria_mhs' => $skills_mhs,
            ],
            [
                'kriteria' => 'Prestasi Kompetisi',
                'desk_persyaratan' => $pencapaian,
                'desk_kriteria_mhs' => $prestasi_kompetisi,
            ],
            [
                'kriteria' => 'Pengalaman Proyek',
                'desk_persyaratan' => $pengalaman,
                'desk_kriteria_mhs' => $pengalaman_proyek,
            ],
            [
                'kriteria' => 'Softskills',
                'desk_persyaratan' => json_decode($my_pendaftar_magang->softskill) ?? "-",
                'desk_kriteria_mhs' => $link ?? "-",
                'predikat_nilai' => $avgGrade ?? '-'
            ]
        ];

        // dd($data);

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('kriteria', function ($data) {
                return '<span class="text-nowrap">' . $data['kriteria'] . '</span>';
            })
            ->addColumn('desk_persyaratan', function ($data) {
                if (is_array($data['desk_persyaratan'])) {
                    $result = '<ul>';
                    foreach ($data['desk_persyaratan'] as $key => $value) {
                        $result .= '<li>' . $value . '</li>';
                    }
                    $result .= '</ul>';
                } else {
                    $result = $data['desk_persyaratan'];
                }

                return $result;
            })
            ->addColumn('desk_kriteria_mhs', function ($data) {
                $except_kriteria = ["Nilai Akademik", "Softskills"];
                $result = (in_array($data['kriteria'], $except_kriteria)) ? '' : '<ul>';
                if (is_array($data['desk_kriteria_mhs'])) {
                    foreach ($data['desk_kriteria_mhs'] as $key => $value) {
                        $result .=  ($data['kriteria'] == 'Nilai Akademik') ? $value : '<li>' . $value . '</li>';
                    }
                } else {
                    $result .= $data['desk_kriteria_mhs'];
                }
                $result .= (in_array($data['kriteria'], $except_kriteria)) ? '' : '<ul>';
                return $result;
            })
            ->addColumn('predikat_nilai', function ($data) use ($my_pendaftar_magang, $requirements, $nilai_predikat) {

                $except_kriteria = ["Nilai Akademik", "Softskills"];
                if (in_array($data['kriteria'], $except_kriteria)) {
                    return $data['predikat_nilai'];
                }

                // $defaultScores = ['Sertifikasi' => '', 'Prestasi Kompetisi' => '', 'Pengalaman Proyek' => '', 'Passion' => '', 'Kriteria Tambahan' => ''];
                $defaultScores = ['Sertifikasi' => '', 'Prestasi Kompetisi' => '', 'Pengalaman Proyek' => '', 'Softskills' => ''];
                // foreach ($requirements as $r) {
                //     $defaultScores[$r['nama_kriteria']] = '';
                // }
                $scores = json_decode($my_pendaftar_magang->scores, true) ?? $defaultScores;

                $predikat_nilai = PredikatNilai::where('status', true)->get();

                $result = '<select name="scores[]" class="form-control select2" id="dropdown-' . $data['kriteria'] . '" onchange="changeColor(this)">';
                // $result .= '<option value="" disabled selected>Pilih Predikat Nilai</option>';
                foreach ($predikat_nilai as $key => $value) {
                    $selected = ($scores[$data['kriteria']] == $value->id_predikat_nilai) ? 'selected' : '';
                    $result .= '<option value="' . $value->id_predikat_nilai . '" ' . $selected . '> ' . $value->nama . '  (' . $value->nilai . ') </option>';
                }
                $result .= '</select>';
                return $result;
            })
            ->rawColumns([
                'kriteria',
                'desk_persyaratan',
                'desk_kriteria_mhs',
                'predikat_nilai'
            ])
            ->make(true);
    }

    public function detailKandidat(Request $request, $id)
    {
        if ($request->ajax()) {
            $my_pendaftar_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
                ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
                ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
                ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
                ->leftJoin('reg_regencies', 'reg_regencies.id', '=', 'mahasiswa.kota_id')
                ->leftJoin('reg_provinces', 'reg_provinces.id', '=', 'reg_regencies.province_id')
                ->leftJoin('reg_countries', 'reg_countries.id', '=', 'reg_provinces.country_id')
                // ->where('id_lowongan', $request->data_id)
                ->where('id_pendaftaran', $id)
                ->select('pendaftaran_magang.*', 'mahasiswa.*', 'universitas.*', 'fakultas.*', 'program_studi.*', 'reg_regencies.name as kota', 'reg_provinces.name as provinsi', 'reg_countries.name as negara');

            $data['pendaftar'] = $my_pendaftar_magang->first();
            $data['education'] = Education::where('nim', $data['pendaftar']->nim)->get();
            $data['experience'] = ExperiencePendaftaran::where('nim', $data['pendaftar']->nim)->get();
            // $data['experience'] = Experience::where('nim', $data['pendaftar']->nim)->get();
            // $data['skills'] = json_decode($data['pendaftar']->skills, true) ?? [];
            $data['skills'] = json_decode(PendaftaranMagang::where('id_pendaftaran', $id)->first()->skills, true) ?? [];
            // dd($data['skills']);
            $data['language'] = BahasaMahasiswa::where('nim', $data['pendaftar']->nim)->orderBy('bahasa', 'asc')->get();
            $data['dokumen_pendukung'] = SertifikatPendaftaran::where('nim', $data['pendaftar']->nim)->orderBy('startdate', 'desc')->get();
            // $data['dokumen_pendukung'] = Sertif::where('nim', $data['pendaftar']->nim)->orderBy('startdate', 'desc')->get();
            $data['dokumen_syarat'] = DokumenPendaftaranMagang::join('document_syarat', 'dokumen_pendaftaran_magang.id_document', '=', 'document_syarat.id_document')
                ->where('id_pendaftaran', $request->data_id)->get();
            $data['headline_pendaftaran'] = PendaftaranMagang::where('id_pendaftaran', $id)->first()->headliner;
            // dd($data['headline_pendaftaran']);
            $data['deskripsiDiri_pendaftar'] = PendaftaranMagang::where('id_pendaftaran', $id)->first()->deskripsi_diri;

            $view = view('company/lowongan_magang/components/card_detail_pelamar', $data)->render();
            return Response::success([
                'view' => $view,
                'id_pendaftar' => $data['pendaftar']->id_pendaftaran,
                'current_step' => $data['pendaftar']->current_step
            ], 'Success');
        }
        $data['kandidat'] = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->leftJoin('seleksi', 'seleksi.id_lowongan', '=', 'lowongan_magang.id_lowongan')
            ->leftJoin('hasil_wawancara', 'hasil_wawancara.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->where('pendaftaran_magang.id_pendaftaran', $id)
            ->select(
                'pendaftaran_magang.*',
                'mahasiswa.*',
                'seleksi.tgl_mulai',
                'seleksi.tgl_akhir',
                DB::raw('COALESCE(hasil_wawancara.kuota_wawancara, 1) as kuota_wawancara')
            )
        ->first();

        $data['urlDetailKandidat'] = route('informasi_lowongan.detail_kandidat', $id);
        return view('lowongan_magang/informasi_lowongan/detail_kandidat_lowongan/detail', $data);
    }

    public function updateNilaiKriteria(Request $request, $id)
    {
        // $request->validate([
        //     'scores' => 'required|array',
        //     'scores.*' => 'nullable|exists:predikat_nilai,id_predikat_nilai',
        // ]);
        DB::beginTransaction();
        try {

            $pendaftaran = PendaftaranMagang::where('id_pendaftaran', $id)->first();
            if (!$pendaftaran) {
                return Response::error(null, 'Pendaftaran Magang Not Found');
            }

            $requirements = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
                ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
                ->where('id_pendaftaran', $id)
                ->first()->requirements;

            $requirements = json_decode($requirements, true) ?? [];

            $criteriaScores = [];

            $criteriaKeys = [
                'Sertifikasi',
                'Prestasi Kompetisi',
                'Pengalaman Proyek',
                'Softskills',
            ];

            // foreach ($requirements as $r) {
            //     $criteriaKeys[] = $r['nama_kriteria'];
            // }

            foreach ($criteriaKeys as $index => $key) {
                $selectedValue = $request->input('scores.' . $index);

                $criteriaScores[$key] = $selectedValue ?? 0;
            }

            $criteriaScoresJson = $criteriaScores;

            if ($pendaftaran->scores || $pendaftaran->current_step == PendaftaranMagangStatusEnum::APPROVED_BY_LKM) {
                $pendaftaran->update([
                    'scores' => $criteriaScoresJson,
                    'current_step' => PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
                ]);
            }
            DB::commit();
            return Response::success(null, 'Nilai kriteria berhasil disimpan');
        } catch (Exception $e) {
            DB::rollback();
            return Response::errorCatch($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status($id)
    {
        try {
            $lowongan = $this->my_lowongan_magang->first();
            $lowongan->status = ($lowongan->status) ? false : true;
            $lowongan->save();

            return response()->json([
                'error' => false,
                'message' => 'Status Lowongan Magang successfully Updated!',
                'modal' => '#modalTambahLowongan',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getLowonganMagang($additional = null)
    {
        $user = auth()->user();
        $pegawaiIndustri = $user->pegawai_industri;

        $this->my_lowongan_magang = LowonganMagang::with('total_pelamar')->where('lowongan_magang.id_industri', $pegawaiIndustri->id_industri);
        if ($additional) $this->my_lowongan_magang = $additional($this->my_lowongan_magang);

        if (!$this->my_lowongan_magang instanceof LengthAwarePaginator) {
            $this->my_lowongan_magang = $this->my_lowongan_magang->get();
        }

        return $this;
    }

    private function getPendaftarMagang($additional = null)
    {
        $user = auth()->user();
        $pegawaiIndustri = $user->pegawai_industri;

        $this->my_pendaftar_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
            ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->leftJoin('reg_regencies', 'reg_regencies.id', '=', 'mahasiswa.kota_id')
            ->leftJoin('reg_provinces', 'reg_provinces.id', '=', 'reg_regencies.province_id')
            ->leftJoin('reg_countries', 'reg_countries.id', '=', 'reg_provinces.country_id')
            ->leftJoin('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->where('lowongan_magang.id_industri', $pegawaiIndustri->id_industri)
            ->select('lowongan_magang.*', 'pendaftaran_magang.*', 'mahasiswa.*', 'universitas.*', 'fakultas.*', 'program_studi.*', 'reg_regencies.name as kota', 'reg_provinces.name as provinsi', 'reg_countries.name as negara');
        if ($additional) $this->my_pendaftar_magang = $additional($this->my_pendaftar_magang);
        $this->my_pendaftar_magang = $this->my_pendaftar_magang->get();

        return $this;
    }

    public function pembobotanLowongan($id)
    {
        $getCriteria = LowonganMagang::where('id_lowongan', $id)->select('pembobotan', 'pembobotan_user', 'intern_position', 'requirements')->first();
        $kriteria = $getCriteria->pembobotan ? json_decode($getCriteria->pembobotan, true) : [];
        $getInternPosition = BidangPekerjaanIndustri::where('id_bidang_pekerjaan_industri', $getCriteria->intern_position)->select('namabidangpekerjaan')->first();

        return view('company.lowongan_magang.kelola_lowongan.pebobotan_lowongan', compact('id', 'kriteria', 'getInternPosition'));
    }

    public function updatePembobotan(Request $request, $id)
    {

        // check value_cr
        $valueCR = $request['value_cr'];

        // jika cr > 0.1 maka return error, jika tidak maka lanjutkan
        if ($valueCR > 0.1) {
            return Response::error(null, 'Nilai CR tidak boleh lebih dari 0.1. Silahkan sesuaikan kembali pembobotan kriteria');
        }

        $data = $request->except('_token', 'value_cr');

        $formattedData = [];
        foreach ($data as $key => $value) {
            // Ubah underscore menjadi spasi
            $formattedKey = str_replace('_', ' ', $key);

            // Simpan hasilnya ke array baru
            $formattedData[$formattedKey] = $value;
        }

        // Simpan data dalam format JSON
        $jsonPembobotan = json_encode($formattedData);

        // Lanjutkan dengan penyimpanan ke database
        try {
            $lowongan = LowonganMagang::where('id_lowongan', $id)->first();
            $lowongan->pembobotan = $jsonPembobotan;
            $lowongan->pembobotan_user = json_encode([auth()->user()->id, auth()->user()->name]);
            $lowongan->save();

            return Response::success(null, 'Pembobotan Lowongan Magang successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function generateScores($pendaftar)
    {
        $fuzzyAHP = new FuzzyAHP();
        $result = $fuzzyAHP->calculateFuzzyAHP($pendaftar);
        return $result;
    }
}
