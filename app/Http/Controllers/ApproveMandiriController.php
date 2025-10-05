<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use App\Jobs\SendMailJob;
use App\Mail\MailMahasiswa;
use App\Models\JenisMagang;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\Industri;
use Illuminate\Support\Facades\Storage;

class ApproveMandiriController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            $data = $response->getOriginalContent();

            if ($response instanceof JsonResponse && isset($data['code']) && $data['code'] == 200) {

                $count = isset($request->data_id) ? count($request->data_id) : 1;

                $result = new WriteAndReadCounterBadgeJob('pengajuan_magang_count', 'decrement', function () {
                    return PendaftaranMagang::whereIn('current_step', [
                        PendaftaranMagangStatusEnum::PENDING,
                        PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI
                    ])->count();
                }, $count);
                $data['data'] = $result->get()->pengajuan_magang_count;
                $response->setData($data);
            }
            return $response;
        })->only(['approved', 'rejected']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodi = ProgramStudi::all();
        $jenis_magang = JenisMagang::all();
        $label_penawaran = PendaftaranMagangStatusEnum::getWithLabel();
        return view('mandiri.approve_mandiri.index',compact('prodi','jenis_magang','label_penawaran'));
    }

    public function show(Request $request)
    {
        $request->validate(['status' => 'required|in:tertunda,done']);

        $pengajuan = PendaftaranMagang::select(
                'pendaftaran_magang.*', 'mahasiswa.namamhs', 'mahasiswa.nim', 'industri.namaindustri',
                'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'mhs_magang.startdate_magang',  'mhs_magang.enddate_magang',
                'industri.email as email_industri', 'industri.alamatindustri', 'industri.notelpon as telepon_industri', 'program_studi.namaprodi',
                'jenis_magang.namajenis','jenis_magang.durasimagang'
            )
            ->leftJoin('mahasiswa', 'mahasiswa.nim', 'pendaftaran_magang.nim')
            ->leftJoin('program_studi', 'program_studi.id_prodi', 'mahasiswa.id_prodi')
            ->leftJoin('mhs_magang', 'mhs_magang.id_pendaftaran', 'pendaftaran_magang.id_pendaftaran')
            ->leftJoin('lowongan_magang', 'lowongan_magang.id_lowongan', 'pendaftaran_magang.id_lowongan')
            ->join('industri', 'industri.id_industri', 'lowongan_magang.id_industri')
            ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
            ->join('jenis_magang', 'jenis_magang.id_jenismagang', 'lowongan_magang.id_jenismagang');

        if ($request->status == 'tertunda') $pengajuan = $pengajuan->whereIn('current_step', [
            PendaftaranMagangStatusEnum::PENDING,
            PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI
        ]);
        else if ($request->status == 'done') $pengajuan = $pengajuan->whereNotIn('current_step', [
            PendaftaranMagangStatusEnum::PENDING,
            PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI
        ]);

        if ($request->tahun_akademik) {
            $pengajuan->where('lowongan_magang.id_year_akademik', $request->tahun_akademik);
        }

        if ($request->prodi) {
            $pengajuan->where('program_studi.id_prodi', $request->prodi);
        }
        if ($request->jenis_magang) {
           $pengajuan->where('jenis_magang.id_jenismagang',$request->jenis_magang);
        }
        if($request->label_penawaran){
            $pengajuan->where('pendaftaran_magang.current_step', $request->label_penawaran);
        }
        return datatables()->of($pengajuan->get())
            ->addIndexColumn()
            ->addColumn('nama', function ($x) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span class="fw-bolder">' .$x->namamhs. '</span>';
                $result .= '<small>' .$x->nim. '</small>';
                $result .= '</div>';

                return $result;
            })
            ->editColumn('namajenis',fn ($x)=> $x->namajenis .'&ensp;-&ensp;'. $x->durasimagang)
            ->addColumn('posisi_magang', fn ($x) => $x->namaindustri .'&ensp;-&ensp;'. $x->intern_position)
            ->addColumn('tgl_magang', function ($x) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span class="text-nowrap">Tanggal Mulai : </span>';
                $result .= '<span class="text-nowrap fw-bolder">' . (($x->startdate_magang) ? Carbon::parse($x->startdate_magang)->format('d F Y') : '-') . '</span>';
                $result .= '<span class="text-nowrap">Tanggal Berakhir : </span>';
                $result .= '<span class="text-nowrap fw-bolder">' . (($x->enddate_magang) ? Carbon::parse($x->enddate_magang)->format('d F Y') : '-') . '</span>';
                $result .= '</div>';

                return $result;
            })
            ->addColumn('contact_perusahaan', function ($x) {
                $result = '<div class="d-flex flex-column align-items-start">';
                $result .= '<span class="fw-bolder">' .$x->email_industri. '</span>';
                $result .= '<span>' .$x->telepon_industri. '</span>';
                $result .= '</div>';
                return $result;
            })
            ->addColumn('dokumen', function ($x) {
                $listDokumen = [
                    'dokumen_skm' => 'Surat Keterangan Magang',
                    'dokumen_spm' => 'Surat Pengantar Magang',
                    'dokumen_sr' => 'Surat Rekomendasi'
                ];

                $result = '<div class="d-flex flex-column align-items-center justify-content-center">';
                foreach ($listDokumen as $key => $value) {
                    if ($x->{$key}) {
                        $result .= '<a href="'.url('storage/'. $x->{$key}).'" target="_blank" class="text-nowrap text-primary">'.$value.'</a>';
                    }
                }

                $result .= '</div>';

                return $result;
            })
            ->editColumn('current_step', function ($x) {
                $step = PendaftaranMagangStatusEnum::getWithLabel($x->current_step);
                return '<span class="badge bg-label-' . $step['color'] . '">' . $step['title'] . '</span>';
            })
            ->addColumn('action', function ($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= '<a class="mx-1 cursor-pointer text-primary" onclick="approved($(this));" data-namamhs="' . $x->namamhs .'" data-nim="' . $x->nim . '" data-position="' . $x->intern_position . '" data-industri="' . $x->namaindustri . '" data-id="' .$x->id_pendaftaran. '"><i class="ti ti-file-check"></i></a>';
                $result .= '<a class="mx-1 cursor-pointer text-danger" onclick="rejected($(this));" data-namamhs="' . $x->namamhs .'" data-nim="' . $x->nim . '" data-position="' . $x->intern_position . '" data-industri="' . $x->namaindustri . '" data-id="' .$x->id_pendaftaran. '"><i class="ti ti-file-x"></i></a>';
                $result .= '</div>';

                return $result;
            })
            ->rawColumns(['nama', 'namajenis', 'posisi_magang', 'tgl_magang', 'contact_perusahaan', 'dokumen', 'current_step', 'action'])
            ->make(true);
    }

    public function approved(Request $request)
    {
        $request->validate([
            'data_id' => 'required|array||exists:pendaftaran_magang,id_pendaftaran',
            // 'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ], [
            'data_id.required' => 'Data harus dipilih',
            'data_id.array' => 'Data harus berupa array',
            'data_id.exists' => 'Data tidak valid',
            'file.required' => 'Surat Pengantar Magang harus diisi',
            'file.mimes' => 'Surat Pengantar Magang harus berupa PDF, JPG, JPEG, PNG',
            'file.max' => 'Surat Pengantar Magang maksimal 2 MB'
        ]);

        try {
            $data = PendaftaranMagang::select(
                'pendaftaran_magang.*', 'lowongan_magang.id_lowongan', 'lowongan_magang.id_industri',
                'mahasiswa.namamhs', 'mahasiswa.nim', 'mahasiswa.emailmhs', 'lowongan_magang.intern_position',
                'program_studi.namaprodi'
            )
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->whereIn('id_pendaftaran', $request->data_id)
            ->whereIn('current_step', [
                PendaftaranMagangStatusEnum::PENDING,
                PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI
            ])->get();

            $industri = Industri::select('industri.id_industri', 'industri.namaindustri', 'pegawai_industri.emailpeg')
            ->join('pegawai_industri', 'pegawai_industri.id_peg_industri', 'industri.penanggung_jawab')
            ->whereIn('industri.id_industri', $data->pluck('id_industri')->toArray())->get();

            if (count($data) <= 0) return Response::error(null, 'Invalid.');

            DB::beginTransaction();

            foreach ($data as $key => $value) {
                $value->current_step = PendaftaranMagangStatusEnum::APPROVED_BY_LKM;
                $value->saveHistoryApproval()->save();

                new WriteAndReadCounterBadgeJob('informasi_lowongan_count.' . $value->id_industri, 'increment', function () use ($value) {
                    return PendaftaranMagang::whereHas('lowongan_magang', function ($q) use ($value) {
                        $q->where('id_industri', $value->id_industri);
                    })->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM)->count();
                });

                $industri_ = $industri->where('id_industri', $value->id_industri)->first();

                dispatch(new SendMailJob($industri_->emailpeg, new MailMahasiswa(
                    [
                        'name' => $value->namamhs,
                        'prodi' => $value->namaprodi,
                        'nim' => $value->nim,
                        'lowongan' => $value->intern_position,
                        'industri' => $industri_->namaindustri,
                        'reason' => $value->reason_aplicant,
                        'url_redirect' => route('informasi_lowongan.detail', ['id' => $value->id_lowongan])
                    ]
                )));
            }

            DB::commit();

            return Response::success(null, 'Berhasil menyetujui Pengajuan Magang.');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function rejected($id, Request $request)
    {
        $request->validate([
            'alasan' => 'required|string',
        ], [
            'alasan.required' => 'Alasan ditolak harus diisi',
        ]);

        try {
            $data = PendaftaranMagang::select('pendaftaran_magang.*', 'lowongan_magang.id_lowongan', 'lowongan_magang.id_industri')
            ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
            ->whereIn('current_step', [
                PendaftaranMagangStatusEnum::PENDING,
                PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI
            ])->where('id_pendaftaran', $id)->first();

            if (!$data) return Response::error(null, 'Invalid.');
            $data->current_step = PendaftaranMagangStatusEnum::REJECTED_BY_LKM;
            $data->reason_reject = $request->alasan;
            $data->saveHistoryApproval()->save();

            // new WriteAndReadCounterBadgeJob('informasi_lowongan_count.' . $data->id_lowongan, 'decrement', function () use ($data) {
            //     return PendaftaranMagang::whereHas('lowongan_magang', function ($q) use ($data) {
            //         $q->where('id_industri', $data->id_industri);
            //     })->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM)->count();
            // });

            return Response::success(null, 'Berhasil menolak pengajuan.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function uploadSR(Request $request) {
        $request->validate([
            'id_pendaftaran' => 'required|array|exists:pendaftaran_magang,id_pendaftaran',
            'type' => 'required|in:upload,batal',
            'type_file' => 'required_if:type,upload|in:surat_rekomendasi,surat_pengantar_magang',
            'dokumen' => 'required_if:type,upload|file|max:2048|mimes:pdf',
        ], [
            'id_pendaftaran.required' => 'Pendaftaran harus dipilih',
            'type.required' => 'Type tidak valid',
            'type.in' => 'Type tidak valid',
            'type_file.required' => 'Tipe Surat harus dipilih',
            'type_file.in' => 'Type tidak valid',
            'dokumen.mimes' => 'File harus berformat PDF',
            'dokumen.required_if' => 'File harus diunggah',
            'dokumen.max' => 'File tidak boleh lebih dari 2MB.'
        ]);

        try {
            DB::beginTransaction();
            $pendaftar = PendaftaranMagang::whereIn('id_pendaftaran', $request->id_pendaftaran);

            $data = [];
            $message = "Berhasil membatalkan Surat";
            $file = null;
            $data['dokumen_sr'] = $file;
            $data['dokumen_spm'] = $file;

            $files = array_merge($pendaftar->pluck('dokumen_sr')->toArray(), $pendaftar->pluck('dokumen_spm')->toArray());
            $files = array_filter($files);
            Storage::delete($files);

            if ($request->hasFile('dokumen') && $request->type == 'upload') {
                $message = 'Berhasil mengunggah Surat';
                $file = Storage::put('dokumen_sr', $request->dokumen);
            }

            if ($request->type_file == 'surat_rekomendasi') {
                $data['dokumen_sr'] = $file;
            } else {
                $data['dokumen_spm'] = $file;
            }

            $pendaftar->update($data);

            DB::commit();

            return Response::success(null, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }
}
