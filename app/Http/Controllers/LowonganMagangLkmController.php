<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Enums\LowonganMagangStatusEnum;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Models\BidangPekerjaanMk;
use Exception;
use Illuminate\Support\Facades\Validator;

class LowonganMagangLkmController extends Controller
{
    public function __construct(){
        $this->middleware(function ( $request, $next) {
            $response = $next($request);

            if ($response instanceof JsonResponse && $response->getOriginalContent()['code'] == 200) {
                new WriteAndReadCounterBadgeJob('lowongan.kelola_count', 'decrement', function () {
                    return LowonganMagang::where('statusaprove', LowonganMagangStatusEnum::PENDING)->count();
                });
            }

            return $response;
        })->only(['approved', 'rejected']);
    }
     /**
     * Display a listing of the resource.
     */

     public function index()
     {
         return view('lowongan_magang.kelola_lowongan_magang_admin.halaman_lowongan_magang_admin');
     }

     /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate([
            'type' => 'string|in:' . implode(',', LowonganMagangStatusEnum::getConstants()),
            'durasimagang' => 'nullable|string|in:1 Semester,2 Semester',
            'posisi' => 'nullable|string',
            'page_length' => 'required|in:10,25,50,100',
        ]);

        $lowongan = LowonganMagang::select('lowongan_magang.*', 'industri.namaindustri', 'jenis_magang.namajenis', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position')
            ->leftJoin('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
            ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
            ->leftJoin('jenis_magang', 'jenis_magang.id_jenismagang', '=', 'lowongan_magang.id_jenismagang');

        // search datatable
        if ($request->search) {
            $searchValue = $request->search;
            $prodiGet = ProgramStudi::select('id_prodi')->where('namaprodi', 'like', "%$searchValue%")->get()->pluck('id_prodi')->toArray();

            $lowongan = $lowongan->where(function($query) use ($searchValue, $prodiGet) {
                $query
                    ->where(function ($q) use ($searchValue, $prodiGet) {
                        $q = $q
                        ->where('industri.namaindustri', 'like', "%$searchValue%")
                        ->orWhere('intern_position', 'like', "%$searchValue%")
                        ->orWhere('lowongan_magang.durasimagang', 'like', "%$searchValue%");

                        foreach ($prodiGet as $key => $value) {
                            $q = $q->orWhere('jenjang', 'like', "%$value%");
                        }
                    });
            });
        }
        // end search datatable

        if ($request->type) {
            $lowongan = $lowongan->where("statusaprove", $request->type);
        }

        if ($request->tahun_akademik) {
            $lowongan = $lowongan->where(function ($q) use ($request) {
                $q->where('lowongan_magang.id_year_akademik', $request->tahun_akademik)->orWhereNull('lowongan_magang.id_year_akademik');
            });
        }

        if ($request->durasimagang) {
            $lowongan->where('lowongan_magang.durasimagang', 'like', '%'.$request->durasimagang.'%');
        }

        if ($request->posisi) {
            $lowongan->where('bidang_pekerjaan_industri.namabidangpekerjaan', 'like', '%'.$request->posisi.'%');
        }

        $lowongan = $lowongan->with('bidangPekerjaanIndustri')->orderBy('enddate', 'asc')->paginate($request->page_length);

        $paginationInfo = [
            'current_page' => $lowongan->currentPage(),
            'last_page' => $lowongan->lastPage(),
            'per_page' => $lowongan->perPage(),
            'total' => $lowongan->total(),
        ];

        $lowongan = collect($lowongan->items())->map(function ($item) {
            $item->prodi = $item->dataTambahan('program_studi')->program_studi->pluck('namaprodi')->toArray();
            unset($item->program_studi);

            return $item;
        });

        $datatable = DataTables::of($lowongan)
            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-primary'>Active</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
                }
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "primary";
                $urlStatus = route('lowongan.kelola.status', $row->id_lowongan);
                $tooltipStatusText = ($row->status) ? "Non Active" : "Active";

                $btnItems = "<a href='" . route('lowongan.kelola.detail', ['id'=> $row->id_lowongan]) . "' onclick=detail($(this)) data-id='{$row->id_lowongan}' class='mx-1 cursor-pointer btn-detail text-success' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Detail'><i class='tf-icons ti ti-file-invoice'></i></a>";
                if($row->statusaprove == LowonganMagangStatusEnum::APPROVED) {
                    $btnItems .= "<a data-status='{$row->status}' data-function='afterUpdateStatus' data-id='{$row->id_lowongan}' data-url='$urlStatus' class='cursor-pointer mx-1 update-status text-{$color}' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='$tooltipStatusText'><i class='tf-icons ti {$icon}'></i></a>";
                }

                $btn = "<div class='d-flex justify-content-center'>$btnItems</div>";
                return $btn;
            })
            ->addColumn('tanggal', function ($row) {
                $result = '<div class="text-start text-nowrap">';

                $result .= '<span class="text-muted">Publish</span><br>';
                $result .= '<span>' . Carbon::parse($row->startdate)->format('d F Y') . '</span><br>';
                $result .= '<span class="text-muted">Takedown</span><br>';
                $result .= '<span>' . Carbon::parse($row->enddate)->format('d F Y') . '</span><br>';
                if ($row->statusaprove == LowonganMagangStatusEnum::APPROVED) {
                    $result .= '<br><span class="text-muted">Mulai Magang</span><br>';
                    $result .= '<span>' . Carbon::parse($row->mulai_magang)->format('d F Y') . '</span><br>';
                    $result .= '<span class="text-muted">Selesai Magang</span><br>';
                    $result .= '<span>' . Carbon::parse($row->selesai_magang)->format('d F Y') . '</span><br>';
                }

                $result .= '</div>';
                return  $result;
            })
            ->editColumn('id_jenismagang', function ($data) {
                // implode(' dan ', json_decode($data->durasimagang))
                $result = '<div class="d-flex justify-content-center flex-column align-items-start text-nowrap">';
                $result .= $data->namajenis;
                $result .= "<span>(" . implode(' dan ', json_decode($data->durasimagang)) . ")</span>";
                $result .= '</div>';

                return $result;
            })
            ->addColumn('prodi', function ($row) {
                $prodi = $row->prodi;
                $result = '<ul  class="mb-0 ps-2 ms-0">';
                foreach ($prodi as $key => $value) {
                    $result .= '<li class="text-nowrap">' .$value. '</li>';
                }
                $result .= '</ul>';

                return $result;
            })
            ->editColumn('intern_position', function ($data) {
                return $data->bidangPekerjaanIndustri?->namabidangpekerjaan ?? "";
            })
            ->rawColumns(['prodi', 'action', 'status', 'tanggal', 'id_jenismagang', 'intern_position'])
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

    public function detail(Request $request, $id)
    {
        $lowongan = LowonganMagang::where('id_lowongan', $id)
            ->with('industri', 'seleksi_tahap', 'bidangPekerjaanIndustri')
            ->first()->dataTambahan('jenjang_pendidikan', 'program_studi');

        $prodi = ProgramStudi::all();
        $tahunAjaran = TahunAkademik::all();
        if (!$lowongan) return redirect()->route('lowongan.kelola');

        $isMappedMk = BidangPekerjaanMk::where('id_bidang_pekerjaan_industri', $lowongan->intern_position)->exists();
        $kuotaPenuh = $lowongan->kuota_terisi / $lowongan->kuota == 1;
        $urlBack = route('lowongan.kelola') . '?page=' . $request->page . '&type=' . $request->type;
        return view('lowongan_magang.kelola_lowongan_magang_admin.detail', compact( 'lowongan', 'prodi', 'tahunAjaran', 'urlBack', 'kuotaPenuh', 'isMappedMk'));
    }

    public function approved(Request $request, $id)
    {
        try {
            $lowongan = LowonganMagang::find($id)->dataTambahan('jenjang_pendidikan');
            if (!$lowongan) return Response::error(null, 'Lowongan tidak ditemukan');

            $validate = [
                'tahun_ajaran' => 'required|exists:tahun_akademik,id_year_akademik',
                'mulai_magang' => 'required',
                'selesai_magang' => 'required|after:mulai_magang',
            ];
            $message = [
                'tahun_ajaran.required' => 'Pilih tahun ajaran terlebih dahulu',
                'tahun_ajaran.exists' => 'Tahun ajaran tidak valid',
                'mulai_magang.required' => 'Masukkan tanggal mulai magang terlebih dahulu',
                'selesai_magang.required' => 'Masukkan tanggal selesai magang terlebih dahulu',
                'selesai_magang.after' => 'Tanggal selesai magang harus lebih dari tanggal mulai magang',
            ];
            foreach ($lowongan->jenjang_pendidikan as $key => $value) {
                $validate["prodi_" . $value] = 'nullable|array|min:1|exists:program_studi,id_prodi';

                $message["prodi_" . $value . ".required"] = 'Pilih prodi terlebih dahulu';
                $message["prodi_" . $value . ".min"] = 'Pilih prodi terlebih dahulu';
                $message["prodi_" . $value . ".exists"] = 'Prodi tidak valid';
            }

            $validator = Validator::make($request->all(), $validate, $message);
            if ($validator->fails()) {
                return Response::errorValidate($validator->errors(), 'Data tidak valid');
            }

            DB::beginTransaction();

            $result = [];
            foreach ($lowongan->jenjang_pendidikan as $key => $value) {
                if ($request->input('prodi_' . $value) != null && count($request->input('prodi_' . $value)) > 0) {
                    foreach ($request->input('prodi_' . $value) as $k => $v) {
                        $result[$value][] = $v;
                    }
                }
            }

            $lowongan->id_year_akademik = $request->tahun_ajaran;
            if(count($result) > 0) $lowongan->jenjang = json_encode($result);
            $lowongan->mulai_magang = Carbon::parse($request->mulai_magang)->format('Y-m-d');
            $lowongan->selesai_magang = Carbon::parse($request->selesai_magang)->format('Y-m-d');
            $lowongan->statusaprove = LowonganMagangStatusEnum::APPROVED;
            $lowongan->status_user = json_encode([auth()->user()->id, auth()->user()->name]);
            $lowongan->status_time = date('H:i:s Y-m-d');
            $lowongan->save();

            DB::commit();

            return Response::success(null, 'Persetujuan berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function rejected($id, Request $request)
    {
        $request->validate([
            'alasan' => 'required|string',
        ], ['alasan.required' => 'Alasan ditolak harus diisi']);

        try{
            $data = LowonganMagang::find($id);
            if (!$data) return Response::error(null, 'Lowongan tidak ditemukan.');

            $data->alasantolak = $request->alasan;
            $data->statusaprove = LowonganMagangStatusEnum::REJECTED;
            $data->status_user = json_encode([auth()->user()->id, auth()->user()->name]);
            $data->status_time = date('H:i:s Y-m-d');
            $data->id_year_akademik = TahunAkademik::active()->first()->id_year_akademik ?? null;
            $data->save();
            DB::commit();

            return Response::success(null, 'Penolakan berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    public function detailMatakuliah(Request $request)
    {
        $matakuliahData = BidangPekerjaanMk::with('mkItems')
            ->where('id_bidang_pekerjaan_industri', $request->id)
            ->get();

        return datatables()
            ->of($matakuliahData)
            ->addIndexColumn()
            ->addColumn('matakuliah', function($row) {
                $result = '<ul class="mb-0 ps-2 ms-0">';
                foreach($row->mkItems as $mk) {
                    [$kode_mk, $namamk] = [$mk->mataKuliah->kode_mk, $mk->mataKuliah->namamk];
                    $result .= "
                    <li style='height: 100%;'>
                        <p class='mb-0' style='width: 100%;'>
                            <span style='color: #4EA971;'>{$kode_mk}</span>
                            &ensp; - &ensp;
                            <span>{$namamk}</span>
                        </p>
                    </li>";
                }
                $result .= '</ul>';

                return $result;
            })
            ->addColumn('prodi', function($row) {
                return $row->mkItems[0]->mataKuliah->prodi->namaprodi;
            })
            ->addColumn('bobot', function($row) {
                return $row->bobot;
            })
            ->rawColumns(['matakuliah', 'bobot'])
            ->make(true);
    }
    public function status($id)
    {
        try {
            $lowongan = LowonganMagang::where('id_lowongan', $id)->first();
            $lowongan->status = ($lowongan->status) ? false : true;
            $lowongan->save();

            return Response::success(null, 'Status Lowongan successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
