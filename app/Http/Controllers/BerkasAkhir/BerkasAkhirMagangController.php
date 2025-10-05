<?php

namespace App\Http\Controllers\BerkasAkhir;

use App\Helpers\Response;
use App\Models\Mahasiswa;
use App\Models\MhsMagang;
use App\Models\NilaiMutu;
use App\Models\BerkasMagang;
use Illuminate\Http\Request;
use App\Jobs\SelesaikanMhsJob;
use Illuminate\Support\Carbon;
use App\Models\BerkasAkhirMagang;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\BerkasAkhirMagangStatus;
use Illuminate\Support\Facades\Storage;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Enums\PendaftaranMagangStatusEnum;

class BerkasAkhirMagangController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:berkas_magang_fakultas.view', ['only' => ['viewMagangFakultas']]);
        // $this->middleware('permission:berkas_magang_mandiri.view', ['only' => ['viewMagangMandiri']]);
    }

    public function viewMagangFakultas(Request $request)
    {
        if ($request->ajax()) { 
            if ($request->section == 'get_data_nilai') {
                $data = MhsMagang::select('nilai_akhir_magang', 'nilai_adjust', 'alasan_adjust')->where('id_mhsmagang', $request->data_id)->first();
                if (!$data) return Response::error(null, 'Not Found', 404);
            } else {
                return Response::error(null, 'Invalid');
            }

            return Response::success($data, 'Success');
        }

        $data['default_detail_mhs'] = view('berkas_akhir_magang/magang_fakultas/components/card_detail_mhs')->render();
        return view('berkas_akhir_magang.magang_fakultas.index', $data);
    }

    public function getDataFakultas(Request $request)
    {
        $request->validate([
            'type' => 'required|in:pending,incomplete,complete'
        ]);

        $pendaftaranMagang = $this->getPemagang(function ($q) use ($request) {
            $q = $q->select(
                'm.namamhs', 'm.nim', 'mhs.id_mhsmagang', 'dsn.namadosen',
                'mhs.nilai_akhir_magang', 'mhs.nilai_adjust', 'mhs.alasan_adjust',
                'mhs.indeks_nilai_akhir', 'mhs.indeks_nilai_adjust', 'lowongan_magang.id_jenismagang',
                DB::raw(
                    'JSON_ARRAYAGG(
                        JSON_OBJECT(
                            "id_berkas_akhir_magang", bam.id_berkas_akhir_magang,
                            "berkas_magang", bam.berkas_magang,
                            "nama_berkas", bm.nama_berkas,
                            "berkas_file", bam.berkas_file,
                            "status_berkas", bam.status_berkas,
                            "tgl_upload", bam.tgl_upload,
                            "due_date", bm.due_date
                        )
                    ) AS berkas_akhir_magang_list'
                )
            )
            ->join('mahasiswa as m', 'm.nim', '=', 'pendaftaran_magang.nim')
            ->join('mhs_magang as mhs', 'mhs.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->leftJoin('dosen as dsn', 'mhs.nip', '=', 'dsn.nip')
            ->leftJoin('berkas_magang as bm', 'mhs.jenis_magang', '=', 'bm.id_jenismagang')
            ->leftJoin('berkas_akhir_magang as bam', function ($q2) {
                return $q2->on('bam.id_berkas_magang', '=', 'bm.id_berkas_magang')->whereRaw('bam.id_mhsmagang = mhs.id_mhsmagang');
            })
            ->groupBy(
                'm.namamhs', 'm.nim', 'mhs.id_mhsmagang', 'dsn.namadosen',
                'mhs.nilai_akhir_magang', 'mhs.nilai_adjust', 'mhs.alasan_adjust',
                'mhs.indeks_nilai_akhir', 'mhs.indeks_nilai_adjust', 'lowongan_magang.id_jenismagang'
            )
            ->whereExists(function ($q2) {
                $q2 = $q2->select(DB::raw(1))->from('berkas_akhir_magang as bam_exists')->whereColumn('bam_exists.id_mhsmagang', 'mhs.id_mhsmagang');
            });

            if ($request->tahun_akademik) $q = $q->where('lowongan_magang.id_year_akademik', $request->tahun_akademik);

            $querySelect = function ($q2, $status_berkas) {
                if ($status_berkas == BerkasAkhirMagangStatus::PENDING) {
                    $q2 = $q2->havingRaw("SUM(bam.status_berkas = '$status_berkas') > 0");
                } else if ($status_berkas == BerkasAkhirMagangStatus::APPROVED) {
                    $q2 = $q2->havingRaw("SUM(bm.status_upload = 1) = SUM(bam.status_berkas = '$status_berkas')");
                } else if ($status_berkas == BerkasAkhirMagangStatus::REJECTED) {
                    $q2 = $q2->havingRaw("SUM(bam.status_berkas = '$status_berkas') > 0 OR (SUM(bm.status_upload = 1) > COUNT(bam.id_berkas_akhir_magang) AND SUM(bam.status_berkas = 'pending') = 0)");
                }

                return $q2;
            };
            
            if ($request->type == 'pending') {
                $q = $querySelect($q, BerkasAkhirMagangStatus::PENDING);
            } else if ($request->type == 'incomplete') {
                $q = $querySelect($q, BerkasAkhirMagangStatus::REJECTED);
            } else if ($request->type == 'complete') {
                $q = $querySelect($q, BerkasAkhirMagangStatus::APPROVED);
            }

            return $q;
        })->pemagang;

        $listStatus = BerkasAkhirMagangStatus::getWithLabel();

        return datatables()->of($pendaftaranMagang)
        ->addIndexColumn()
        ->editColumn('namamhs', function ($x) {
            $result = '<div class="d-flex flex-column align-items-start text-nowrap">';
            $result .= '<span class="fw-semibold">' .$x->namamhs. '</span>';
            $result .= '<small>' .$x->nim. '</small>';
            $result .= '<span class="fw-semibold mt-3">Pembimbing Akademik</span>';
            $result .= '<span>' . $x->namadosen . '</span>';
            $result .= '</div>';
            return $result;
        })
        ->addColumn('action', function ($x) {
            $result = '<div class="d-flex flex-column align-items-start">';
            $result .= '<a class="cursor-pointer" onclick="viewMhs($(this))" data-id="'.$x->nim.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail Mahasiswa"><i class="ti ti-file-text text-primary"></i></a>';
            if ($x->nilai_akhir_magang) {
                $result .= '<a class="cursor-pointer" onclick="adjustmentNilai($(this))" data-id="'.$x->id_mhsmagang.'" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Pengurangan Nilai"><i class="ti ti-clipboard-list text-warning"></i></a>';
            } else {
                $result .= '<a class="cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Nilai Akhir belum ada"><i class="ti ti-clipboard-list text-secondary"></i></a>';
            }
            $result .= '</div>';
            return $result;
        })
        ->addColumn('berkas_akhir_magang', function ($x) use ($listStatus) {
            $result = '<div class="d-flex flex-column align-items-start text-nowrap">';
            foreach (json_decode($x->berkas_akhir_magang_list, true) as $key => $value) {
                if (isset($value['id_berkas_akhir_magang'])) {
                    $status = $listStatus[$value['status_berkas']];
                    $result .= '<a data-bs-toggle="tooltip" data-bs-placement="top" title="'.$status['title'].'" class="text-decoration-none cursor-pointer my-2 w-100" href="'.route('berkas_akhir_magang.fakultas.detail_file', ['id' => $value['id_berkas_akhir_magang']]).'"><div class="card border border-' .$status['color']. ' p-2 d-flex flex-row justify-content-start">';
                    $result .= '<i class="ti ti-'.$status['icon'].' text-' .$status['color']. ' my-auto"></i>';
                    $result .= '<div class="my-auto mx-2 bg-' .$status['color']. '" style="width:0.1rem;height:25px;"></div>';
                    $result .= '<span class="text-' .$status['color']. ' fw-semibold my-auto">' .$value['nama_berkas']. '</span>';
                } else {
                    $result .= '<div data-bs-toggle="tooltip" data-bs-placement="top" title="Belum Diunggah" class="card border border-secondary p-2 my-2 d-flex flex-row justify-content-start w-100">';
                    $result .= '<i class="ti ti-circle-minus text-secondary my-auto"></i>';
                    $result .= '<div class="my-auto mx-2 bg-secondary" style="width:0.1rem;height:25px;"></div>';
                    $result .= '<span class="text-secondary fw-semibold my-auto">' .$value['nama_berkas']. '</span>';
                }
                $result .= '</div></a>';
            }
            $result .= '</div>';
            return $result;
        })
        ->addColumn('waktu_pengumpulan', function ($x) {
            $result = '<div class="d-flex flex-column align-items-center">';
            foreach (json_decode($x->berkas_akhir_magang_list, true) as $key => $value) {
                $result .= '<div class="d-flex my-2 flex-column justify-content-center align-items-center w-100" style="margin-top:0.3rem !important">';
                if (isset($value['id_berkas_akhir_magang'])) {
                    $result .= '<small class="fw-semibold">'.Carbon::parse($value['tgl_upload'])->format('d/m/Y H:i').'</small>';
                    if ($value['tgl_upload'] > $value['due_date']) $result .= '<span class="badge badge-pill bg-label-danger">Terlambat Diserahkan</span>';
                    else $result .= '<span class="badge badge-pill bg-label-primary">Tepat Waktu Diserahkan</span>';
                } else {
                    $result .= '<span class="badge badge-pill bg-label-secondary mt-3" style="margin-bottom: 0.6rem !important;">Belum Diunggah</span>';
                }
                $result .= '</div>';
            }
            $result .= '</div>';

            return $result;
        })
        ->addColumn('nilai_akhir', function ($x) {
            $result = '<div class="d-flex flex-column align-items-center">';
            if (isset($x->nilai_akhir_magang)) {
                $result .= '<span class="fw-semibold">' .($x->nilai_akhir_magang - $x->nilai_adjust ?? 0). '</span>';
                $result .= '<span class="badge badge-pill bg-label-info">'.($x->indeks_nilai_adjust ?? $x->indeks_nilai_akhir).'</span>';
            } else {
                $result .= '<span class="fw-bolder">-</span>';
            }
            $result .= '</div>';
            return $result;
        })
        ->addColumn('adjustment_nilai', function ($x) {
            $result = '<div class="d-flex flex-column align-items-start text-nowrap">';
            $result .= '<span class="fw-semibold">Nilai Akhir</span>';
            $result .= '<span>'.($x->nilai_akhir_magang ?? '-').'</span>';
            $result .= '<span class="fw-semibold mt-2">Pengurangan Nilai</span>';
            $result .= '<span>'.($x->nilai_adjust ?? '-').'</span>';
            $result .= '<span class="fw-semibold mt-2">Alasan Pengurangan Nilai</span>';
            $result .= '<span>'.($x->alasan_adjust ?? '-').'</span>';
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['namamhs', 'action', 'berkas_akhir_magang', 'waktu_pengumpulan', 'nilai_akhir', 'adjustment_nilai'])
        ->make(true);
    }

    public function getDataMhs($id, $view = true) {
        $data = $this->getPemagang(function ($q) use ($id) {
            return $q
            ->select(
                'mahasiswa.nim', 'mahasiswa.namamhs', 'program_studi.namaprodi', 'industri.namaindustri', 
                'lowongan_magang.intern_position', 'mhs_magang.startdate_magang', 'mhs_magang.enddate_magang', 
                'pemb_lapangan.namapeg', 'pemb_akademik.namadosen', 'pendaftaran_magang.file_document_mitra'
            )
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->join('mhs_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
            ->join('industri', 'industri.id_industri', 'lowongan_magang.id_industri')
            ->leftJoin('pegawai_industri as pemb_lapangan', 'pemb_lapangan.id_peg_industri', 'mhs_magang.id_peg_industri')
            ->leftJoin('dosen as pemb_akademik', 'pemb_akademik.nip', 'mhs_magang.nip')
            ->where('mahasiswa.nim', $id);
        })->pemagang->first();

        if($view){
            return view('berkas_akhir_magang/magang_fakultas/components/card_detail_mhs', compact('data'))->render();
        }else{
            return $data;
        }
    }

    public function detailFile($id) {
        $berkas = BerkasAkhirMagang::where('id_berkas_akhir_magang', $id)->first();
        if (!$berkas) return abort(403);

        $data['berkas'] = $berkas;
        $data['mahasiswa'] = self::getDataMhs($berkas->mhs_magang->pendaftaran->nim, false);
        $data['data'] = url('storage/' . $berkas->berkas_file);
        $data['url'] = route('berkas_akhir_magang.fakultas.approval_file', $id);
        return view('berkas_akhir_magang/magang_fakultas/detail_file', $data);
    }

    public function approvalBerkas(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:approve,reject',
            'reason' => 'required_if:status,reject',
        ], [
            'reason.required_if' => 'Alasan penolakan harus diisi.',
        ]);

        try {
            $berkas = BerkasAkhirMagang::join('mhs_magang', 'mhs_magang.id_mhsmagang', '=', 'berkas_akhir_magang.id_mhsmagang')
            ->where('berkas_akhir_magang.id_berkas_akhir_magang', $id)->first();
            if (!$berkas) return Response::error(null, 'Berkas tidak ditemukan.');

            $berkas->status_berkas = BerkasAkhirMagangStatus::APPROVED;
            if ($request->status == 'reject') {
                $berkas->status_berkas = BerkasAkhirMagangStatus::REJECTED;
                $berkas->rejected_reason = $request->reason;
            }

            $berkas->save();

            $berkasMagang = BerkasMagang::leftJoin('berkas_akhir_magang', function ($join) use ($berkas) {
                return $join->on('berkas_akhir_magang.id_berkas_magang', '=', 'berkas_magang.id_berkas_magang')->where('berkas_akhir_magang.id_mhsmagang', $berkas->id_mhsmagang);
            })
            ->where('berkas_magang.id_jenismagang', $berkas->jenis_magang)
            ->where('berkas_magang.status_upload', 1)
            ->get();

            if (count($berkasMagang->where('status_berkas', BerkasAkhirMagangStatus::PENDING)) == 0) {
                $result_decrement = new WriteAndReadCounterBadgeJob('berkas_akhir_magang.fakultas_count', 'decrement', function () {
                    return PendaftaranMagang::select('pendaftaran_magang.id_pendaftaran')
                    ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
                    ->join('berkas_magang', 'berkas_magang.id_jenismagang', 'mhs_magang.jenis_magang')
                    ->leftJoin('berkas_akhir_magang', function ($q) {
                        return $q->on('berkas_akhir_magang.id_berkas_magang', '=', 'berkas_magang.id_berkas_magang')
                        ->where('berkas_akhir_magang.status_berkas', '=', BerkasAkhirMagangStatus::PENDING);
                    })
                    ->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                    ->groupBy('pendaftaran_magang.id_pendaftaran')
                    ->havingRaw('count(berkas_akhir_magang.status_berkas) > 0')
                    ->count();
                });

                $result_decrement = $result_decrement->get()->{'berkas_akhir_magang.fakultas_count'};
            }

            $totalBerkas = $berkasMagang->count();
            $totalBerkasLengkap = $berkasMagang->where('status_berkas', BerkasAkhirMagangStatus::APPROVED)->count();
            if ($totalBerkas == $totalBerkasLengkap) {
                MhsMagang::where('id_mhsmagang', $berkas->id_mhsmagang)->update(['status_magang' => 0]);
            }

            return Response::success([
                'view' => view('berkas_akhir_magang/magang_fakultas/components/right_card_detail', compact('berkas'))->render(),
                'count' => $result_decrement ?? false
            ], 'Berhasil menyimpan data!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function adjustmentNilai(Request $request, $id) 
    {
        $mhsMagang = MhsMagang::where('id_mhsmagang', $id)->first();
        if (!$mhsMagang) return Response::error(null, 'Mahasiswa Not Found.');

        $request->validate([
            'nilai_adjust' => ['required', 'numeric', 'min:0', function ( $attribute, $value, $fail ) use ($mhsMagang) {
                if ($value > $mhsMagang->nilai_akhir_magang) {
                    $fail('Pengurangan nilai harus <= Nilai Akhir Magang.');
                }
            }],
            'alasan_adjust' => 'required',
        ], [
            'nilai_adjust.required' => 'Pengurangan Nilai harus diisi.',
            'nilai_adjust.numeric' => 'Pengurangan Nilai harus berupa angka.',
            'nilai_adjust.min' => 'Pengurangan Nilai harus >= 0.',
            'alasan_adjust.required' => 'Alasan harus diisi.',
        ]);

        try {
            $mhsMagang->nilai_adjust = $request->nilai_adjust;
            $mhsMagang->alasan_adjust = $request->alasan_adjust;

            $result = $mhsMagang->nilai_akhir_magang - $mhsMagang->nilai_adjust;

            $nilaiMutu = NilaiMutu::where('nilaimin', '<=', $result)
            ->where('nilaimax', '>=', $result)
            ->first();

            $mhsMagang->indeks_nilai_adjust = $nilaiMutu->nilaimutu;
            $mhsMagang->save();

            return Response::success(null, 'Berhasil menyimpan data!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function viewMagangMandiri()
    {
        return view('berkas_akhir_magang.magang_mandiri.index');
    }

    protected function getPemagang($additional = null)
    {
        $this->pemagang = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);
        if ($additional != null) $this->pemagang = $additional($this->pemagang);

        // dd($this->pemagang->toSql());
        $this->pemagang = $this->pemagang->get();
        return $this;
    }
}
