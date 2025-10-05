<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Seleksi;
use App\Helpers\Response;
use App\Jobs\SendMailJob;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Mail\EmailJadwalSeleksi;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\DokumenPendaftaranMagang;

class JadwalSeleksiController extends Controller
{
    public function __construct()
    {
        $this->valid_step = [
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 3,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 4,
        ];

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameters()['id'] ?? null;

            $this->getLowonganMagang(function ($query) use ($id) {
                return $query->where('id_lowongan', $id);
            });

            return $next($request);
        })->only(['detail', 'getDetailData', 'setJadwal']);
    }

    public function index(Request $request)
    {
        $urlGetData = route('jadwal_seleksi.get_data');
        return view('company.jadwal_seleksi.jadwal', compact('urlGetData'));
    }

    public function getData(Request $request) {

        $lowongan = $this->getLowonganMagang(function ($query) {
            return $query->with('total_pelamar');
        })->lowongan_magang->map(function ($item) {
            $item->total_kandidat = $item->total_pelamar->whereIn('current_step', [
                PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2
            ])->count();

            for ($i=1; $i <= ($item->tahapan_seleksi + 1); $i++) { 
                $item->{'seleksi_tahap_' . $i} = $item->total_pelamar->filter(function ($data) use ($i) {
                    return isset($this->valid_step[$data->current_step]) && $i == $this->valid_step[$data->current_step];
                })->count();
            }

            return $item;
        });

        return datatables()->of($lowongan)
        ->addColumn('card', function ($data) {
            $urlAction = route('jadwal_seleksi.detail', $data->id_lowongan);
            $result = view('company/jadwal_seleksi/components/card_list_lowongan', compact('data', 'urlAction'))->render();
            return $result;
        })
        ->rawColumns(['card'])
        ->make(true);
    }

    public function detail(Request $request, $id)
    {
        $lowongan = $this->lowongan_magang->first();
        $urlGetData = route('jadwal_seleksi.get_data_detail', $id);
        $urlSetJadwal = route('jadwal_seleksi.set_jadwal', ['id' => $id]);
        $urlBack = route('jadwal_seleksi');
        $isMitra = true;

        $lastSelection = $lowongan->tahapan_seleksi + 1;

        return view('company.jadwal_seleksi.detail', compact('lowongan', 'urlGetData', 'urlSetJadwal', 'urlBack', 'lastSelection', 'isMitra'));
    }

    public function getDetailData(Request $request, $id) {
        $request->validate([
            'tahap' => 'required|in:1,2,3'
        ]);

        $lowongan_ = $this->lowongan_magang->first()->load('seleksi_tahap');

        $this->getPendaftaranMagang(function ($query) use ($id, $request) {
            $query = $query->join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->where('pendaftaran_magang.id_lowongan', $id);

            if ($request->tahap) $query = $query->where('current_step', array_search($request->tahap, $this->valid_step));

            return $query;
        });
        $pendaftaran_magang = $this->pendaftaran_magang->transform(function ($item) use ($lowongan_, $request) {
            $item->seleksi = $lowongan_->seleksi_tahap->where('tahap', $request->tahap)->first();
            return $item;
        });

        return datatables()->of($pendaftaran_magang)
        ->addIndexColumn()
        ->editColumn('namamhs', function ($x) {
            $result = '<div class="d-flex flex-column align-items-start">';
            $result .= '<span class="fw-bolder">' .$x->namamhs. '</span>';
            $result .= '<span>' .$x->nim. '</span>';
            $result .= '</div>';

            return $result;
        })
        ->addColumn('tanggalpelaksaan', function ($x) {
            $result = '<div class="d-flex flex-column justify-content-start">';
            $result .= '<span class="text-muted">Tanggal Mulai</span>';
            $result .= '<span>' .$x->seleksi->tgl_mulai. '</span>';
            $result .= '<span class="text-muted">Tanggal Akhir</span>';
            $result .= '<span>' .$x->seleksi->tgl_akhir. '</span>';
            $result .= '</div>';

            return $result;
        })
        ->addColumn('action', function ($x) {
            $result = '<div class="d-flex justify-content-center">';
            $result .= '<a class="mx-1 cursor-pointer text-primary" onclick="approved($(this))" data-id="' .$x->id_pendaftaran. '" data-step="' .$this->valid_step[$x->current_step]. '"><i class="ti ti-file-check"></i></a>';
            $result .= '<a class="mx-1 cursor-pointer text-danger" onclick="rejected($(this))" data-id="' .$x->id_pendaftaran. '"><i class="ti ti-file-x"></i></a>';
            $result .= '<a class="mx-1 cursor-pointer text-info" href="' .route('jadwal_seleksi.detail_mahasiswa', ['id_lowongan' => $x->id_lowongan, 'id_pendaftaran' => $x->id_pendaftaran]). '"><i class="ti ti-file-invoice"></i></a>';
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['namamhs', 'tanggalpelaksaan', 'action'])
        ->make(true);
    }

    public function detailMahasiswa($id_lowongan, $id_pendaftaran) {
        $data['data'] = Mahasiswa::with('education', 'experience', 'sertifikat', 'sosmedmhs', 'bahasamhs')->select(
            'mahasiswa.*', 'pendaftaran_magang.tanggaldaftar', 'industri.namaindustri', 
            'lowongan_magang.intern_position', 'lowongan_magang.lokasi', 'lowongan_magang.durasimagang', 'lowongan_magang.id_jenismagang', 'users.email', 'pendaftaran_magang.current_step',
            'pendaftaran_magang.id_pendaftaran', 'universitas.namauniv', 'fakultas.namafakultas', 'pendaftaran_magang.reason_aplicant', 'jenis_magang.namajenis'
        )
        ->leftJoin('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->leftJoin('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('jenis_magang', 'jenis_magang.id_jenismagang', '=', 'lowongan_magang.id_jenismagang')        
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('users', 'mahasiswa.id_user', '=', 'users.id')
        ->join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
        ->where('pendaftaran_magang.id_pendaftaran', $id_pendaftaran)->first();

        $data['dokumen_persyaratan'] = DokumenPendaftaranMagang::join('document_syarat', 'document_syarat.id_document', '=', 'dokumen_pendaftaran_magang.id_document')
            ->where('id_pendaftaran', $id_pendaftaran)->get();

        $data['urlBack'] = route('jadwal_seleksi.detail', $id_lowongan);

        return view('company/jadwal_seleksi/detail_mahasiswa', $data);
    }

    public function setJadwal(Request $request, $id) {
        try {
            $this->getPendaftaranMagang(function ($query) use ($id, $request) {
                return $query->where('pendaftaran_magang.id_lowongan', $id)
                    ->where('current_step', array_search($request->tahapan_seleksi, $this->valid_step));
            });

            $pendaftar = $this->pendaftaran_magang;

            DB::beginTransaction();
            foreach ($pendaftar as $key => $value) {
                Seleksi::updateOrCreate(
                    [
                        'id_pendaftaran' => $value->id_pendaftaran,
                        'tahapan_seleksi' => $request->tahapan_seleksi
                    ],
                    [
                        'start_date' => Carbon::parse($request->mulai_date)->format('Y-m-d H:i:s'),
                        'end_date' => Carbon::parse($request->selesai_date)->format('Y-m-d H:i:s')
                    ]
                );
            }

            DB::commit();
            return Response::success(null, 'Berhasil menetapkan jadwal seleksi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function approval(Request $request, $id) {
        try {
            //code...
            $this->getPendaftaranMagang(function ($query) use ($id) {
                return $query->join('mahasiswa', 'pendaftaran_magang.nim', '=', 'mahasiswa.nim')
                    ->join('industri', 'lowongan_magang.id_industri', '=', 'industri.id_industri')
                    ->where('id_pendaftaran', $id);
            });

            $pendaftar = $this->pendaftaran_magang->first();
            if (!$pendaftar) {
                return Response::error(null, 'Pendaftar not found');
            }

            $validateArray = ['status' => 'required|in:approved,rejected'];

            $currentStep = $this->valid_step[$pendaftar->current_step];
            if ($request->status == 'approved') {
                if ($currentStep == ($pendaftar->tahapan_seleksi + 1)) {
                    $validateArray['file'] = 'required|mimes:pdf|max:2048';
                }
            } else if ($request->status == 'rejected') {
                $validateArray['file'] = 'required|mimes:pdf|max:2048';
            }

            $validator = Validator::make($request->all(), $validateArray, [
                'status.required' => 'Status harus dipilih',
                'status.in' => 'Status tidak valid',
                'file.required' => 'File harus diisi',
            ]);
            if ($validator->fails()) return Response::errorValidate($validator->errors(), 'Validation error');

            $statusPicked = $request->status;
            if ($request->status == 'approved') {
                $pendaftar->current_step;
                $data = ['current_step' => array_search(($this->valid_step[$pendaftar->current_step] + 1), $this->valid_step)];
                if ($currentStep == ($pendaftar->tahapan_seleksi + 1) && $request->hasFile('file')) {
                    $file = null;
                    if ($pendaftar->file_document_mitra) Storage::delete($pendaftar->file_document_mitra);

                    $file = Storage::put('berkas_mitra', $request->file('file'));
                    $data['file_document_mitra'] = $file;
                }
            } else if ($request->status == 'rejected') {
                if ($pendaftar->current_step == PendaftaranMagangStatusEnum::APPROVED_BY_LKM) {
                    $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SCREENING;
                } else if ($pendaftar->current_step == PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1) {
                    $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1;
                } else if ($pendaftar->current_step == PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1) {
                    $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2;
                } else if ($pendaftar->current_step == PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2) {
                    $statusPicked = PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3;
                }

                $file = null;
                if ($pendaftar->file_document_mitra) Storage::delete($pendaftar->file_document_mitra);

                $file = Storage::put('berkas_mitra', $request->file('file'));
                $data['file_document_mitra'] = $file;
                $data['current_step'] = $statusPicked;
                $data['reason_reject'] = $request->reason;
            }

            $pendaftar->update($data);

            $pendaftar->label_step = PendaftaranMagangStatusEnum::getWithLabel($pendaftar->current_step)['title'];
            dispatch(new SendMailJob($pendaftar->emailmhs, new EmailJadwalSeleksi($pendaftar)));

            return Response::success(null, 'Success');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    private function getLowonganMagang($additional = null) {
        $user = auth()->user();
        $pegawaiIndustri = $user->pegawai_industri;

        $this->lowongan_magang = LowonganMagang::where('id_industri', $pegawaiIndustri->id_industri);
        if ($additional != null) $this->lowongan_magang = $additional($this->lowongan_magang);
        $this->lowongan_magang = $this->lowongan_magang->get();
        return $this;
    }

    private function getPendaftaranMagang($addition = null) {
        $user = auth()->user();
        $pegawaiIndustri = $user->pegawai_industri;

        $this->pendaftaran_magang = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->where('lowongan_magang.id_industri', $pegawaiIndustri->id_industri);

        if ($addition != null) $this->pendaftaran_magang = $addition($this->pendaftaran_magang);

        $this->pendaftaran_magang = $this->pendaftaran_magang->get();
        return $this;
    }
}
