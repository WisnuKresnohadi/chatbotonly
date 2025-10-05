<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use App\Models\Mahasiswa;
use App\Exports\MhsExport;
use App\Imports\MhsImport;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Exports\DataFailedExport;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MahasiswaRequest;
use App\Models\NilaiAkhirMhs;
use App\Sync\MhsSync;
use App\Sync\NilaiAkhirMhsSync;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class mahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:igracias.view');
    }

    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     if ($request->type) {
    //         switch ($request->type) {
    //             case 'id_fakultas':
    //                 $data = Fakultas::select('namafakultas as text', 'id_fakultas as id')->where('id_univ', $request->selected)->get();
    //                 break;
    //             case 'id_prodi':
    //                 $data = ProgramStudi::select('namaprodi as text', 'id_prodi as id')->where('id_fakultas', $request->selected)->get();
    //                 break;
    //             case 'kode_dosen':
    //                 $data = Dosen::where('id_prodi', $request->selected)->get()->transform(function ($item) {
    //                     $result = new \stdClass();
    //                     $result->text = $item->kode_dosen . ' | ' . $item->namadosen;
    //                     $result->id = $item->kode_dosen;
    //                     return $result;
    //                 });
    //                 break;
    //             default:
    //                 # code...
    //                 break;
    //         }
    //         return Response::success($data, 'Success');
    //     }

    //     $universitas = Universitas::all();
    //     return view('masters.mahasiswa.index', compact('universitas'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->validated();

            $data['kode_dosen'] = $request->kode_dosen_wali;
            unset($data['kode_dosen_wali']);

            Mahasiswa::create($data);
            DB::commit();
            return Response::success(null, 'Data Created!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $mahasiswa = Mahasiswa::selectRaw(
            'mahasiswa.*, universitas.namauniv, fakultas.namafakultas, program_studi.namaprodi, @rownum := @rownum + 1 as nomor_urut'
        )
        ->crossJoin(DB::raw('(SELECT @rownum := 0) as r'))
        ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
        ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas');
        if ($request->id_prodi != null) {
            $mahasiswa->where("mahasiswa.id_prodi", $request->id_prodi);
        } else if ($request->id_fakultas != null) {
            $mahasiswa->where("mahasiswa.id_fakultas", $request->id_fakultas);
        } else if ($request->id_univ != null) {
            $mahasiswa->where("mahasiswa.id_univ", $request->id_univ);
        }
        $mahasiswa = $mahasiswa->with("univ", "prodi","fakultas")->orderBy('nim', "asc");

        $result = DataTables::eloquent($mahasiswa);
        $result = self::filterList($result);
        $result = $result
        ->addColumn('name', function ($data) {
            $result = "<span class='mb-2 text-nowrap fw-bolder'>$data->namamhs</span><br>";
            $result .= "<small class='text-muted'>$data->nim</small>";
            return $result;
        })
        ->addColumn('univ_fakultas', function ($data) {
            $result = "<span class='mb-2 text-nowrap fw-bolder'>$data->namauniv</span><br>";
            $result .= "<span class='mb-2 text-nowrap'>$data->namafakultas</span><br>";
            $result .= "<small class='text-nowrap text-muted'>$data->namaprodi</small>";

            return $result;
        })
        ->editColumn('tunggakan_bpp', fn ($data) => "<div class='text-center'>$data->tunggakan_bpp</div>")
        ->editColumn('ipk', fn ($data) => "<div class='text-center'>$data->ipk</div>")
        // ->editColumn('eprt', fn ($data) => "<div class='text-center'>$data->eprt</div>")
        ->editColumn(
            'tesbahasa',
            function ($data) {
                return "<div class='text-center'>" .
                    ($data->tesbahasa == 0
                        ? $data->tesbahasa
                        : "{$data->tipetesbahasa} - {$data->tesbahasa}"
                    ) .
                    "</div>";
            }
        )
        ->editColumn('tak', fn ($data) => "<div class='text-center'>$data->tak</div>")
        ->editColumn('angkatan', fn ($data) => "<div class='text-center'>$data->angkatan</div>")
        ->addColumn('contact', function ($data) {
            $result = "<span class='mb-2 fw-bolder'>$data->nohpmhs</span><br>";
            $result .= "<small>$data->emailmhs</small>";
            return $result;
        })
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

            $url = route('igracias.mahasiswa.status', $row->nim);
            $btn = "<div class='d-flex justify-content-center'>
            <a href='" . route('igracias.mahasiswa.detail', $row->nim) . "' class='text-primary'>
                <i class='ti ti-file-invoice' data-bs-toggle='tooltip' title='Detail'></i>
            </a>
            <a data-url='{$url}' class='cursor-pointer mx-1 update-status text-{$color}' data-function='afterUpdateStatus'><i class='tf-icons ti {$icon}'></i></a></div>";

            return $btn;
        })
        ->rawColumns([
            'action', 'status', 'name', 'univ_fakultas', 'tunggakan_bpp',
            'ipk', 'tak', 'angkatan', 'contact', 'tesbahasa'
        ])
        ->make(true);

        return $result;
    }

    private function filterList(EloquentDataTable $list)
    {
        $whereFilter = function ($query, $column, $keyword) {
            return $query->orWhere($column, 'like', "%{$keyword}%");
        };

        $listColumn = [
            'name' => ['mahasiswa.namamhs', 'mahasiswa.nim'],
            'univ_fakultas' => ['universitas.namauniv', 'fakultas.namafakultas', 'program_studi.namaprodi'],
            'tunggakan_bpp' => ['mahasiswa.tunggakan_bpp'],
            'ipk' => ['mahasiswa.ipk'],
            'eprt' => ['mahasiswa.eprt'],
            'tak' => ['mahasiswa.tak'],
            'angkatan' => ['mahasiswa.angkatan'],
            'contact' => ['mahasiswa.nohpmhs', 'mahasiswa.emailmhs'],
            'alamatmhs' => ['mahasiswa.alamatmhs'],
            'status' => ['mahasiswa.status'],
        ];

        foreach ($listColumn as $key => $value) {
            $list = $list->filterColumn($key, function($query, $keyword) use ($value, $whereFilter) {
                foreach ($value as $k => $v) {
                    $whereFilter($query, $v, $keyword);
                }
            });
        }

        return $list;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::where('nim', $id)->first();
        $mahasiswa->kode_dosen_wali = $mahasiswa->kode_dosen;
        unset($mahasiswa->kode_dosen);
        return $mahasiswa;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $mahasiswa = Mahasiswa::where('nim', $id)->first();
            if (!$mahasiswa) return Response::error(null, 'Mahasiswa not found!');

            $data = $request->all();
            $data['kode_dosen'] = $request->kode_dosen_wali;
            unset($data['kode_dosen_wali']);

            $mahasiswa->update($data);
            $mahasiswa->user()->update([
                'name' => $request->namamhs,
                'email' => $request->emailmhs
            ]);

            DB::commit();
            return Response::success(null, 'Mahasiswa successfully Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function status($id)
    {
        try {
            $mahasiswa = Mahasiswa::where('nim', $id)->first();
            $mahasiswa->status = ($mahasiswa->status) ? false : true;
            $mahasiswa->save();

            return Response::success(null, 'Status Mahasiswa successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function import(Request $request)
    {
        $validRequest = $request->validate([
            'import' => 'required|file|mimes:xlsx,xls',
            'id_univ' => 'required',
            'id_fakultas' => 'required',
            'id_prodi' => 'required',
            'kode_dosen_wali' => 'required',
        ], [
            'import.required' => 'File impor wajib diunggah.',
            'import.mimes' => 'File import harus berupa file Excel.',
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
            'id_prodi.required' => 'Prodi wajib dipilih.',
            'kode_dosen_wali.required' => 'Dosen Wali wajib dipilih.',
        ]);

        $validRequest['kode_dosen'] = $validRequest['kode_dosen_wali'];
        unset($validRequest['kode_dosen_wali']);

        $data = $request->file('import');
        $namafile = $data->getClientOriginalName();
        $data->move('ImportData/MhsData', $namafile);
        $import = new MhsImport(...array_slice($validRequest, 1, count($validRequest) - 1));
        $filePath = public_path('/ImportData/MhsData/' . $namafile);

        if (!$import->checkHeaders($filePath)) {

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            return response()->json([
                'message' => 'Header tidak sesuai. Mohon untuk menggunakan template yang telah disediakan.',
                'error' => true
            ], 400);
        }

        ($import)->import($filePath);

        $data = $import->getResults();

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($data['newData']->isEmpty() && $data['duplicatedData']->isEmpty() && $data['failedData']->isEmpty()) {

            return response()->json([
                'message' => 'File yang diimpor kosong atau data telah terdaftar.',
                'error' => true
            ], 400);
        }

        session()->flash('import_results_' . auth()->user()->id, $data);
        return Response::success([
            'error' => false,
            'showConfirmButton' => false,
            'icon' => 'info',
            'title' => 'Informasi'
        ],'Sebelum disimpan, data di preview');
    }

    public function preview()
    {
        $data = session('import_results_' . auth()->user()->id);
        if (!$data) return redirect()->route('igracias');

        return view('masters.igracias.mahasiswa.preview', compact('data'));
    }

    public function storeImport(Request $request)
    {
        try {
            DB::beginTransaction();
            $records = json_decode($request->newData, true);

            if (isset($request->duplicatedData)) {
                $duplicates = array_map(function($data) {
                    return json_decode($data, true);
                }, $request->duplicatedData);
                $records = array_merge($records, $duplicates);
            }

            foreach ($records as $record) {
                $record['tipetesbahasa'] = 'EPRT';
                unset($record['eprt']);
                Mahasiswa::updateOrCreate(
                    ['nim' => $record['nim']],
                    [
                        ...$record,
                        'id_univ' => $request->input('univ'),
                        'id_fakultas' => $request->input('fakultas'),
                        'id_prodi' => $request->input('prodi'),
                        'kode_dosen' => $request->input('dosen_wali')
                    ]
                );
            }

            DB::commit();
            return Response::success([
                'error' => false,
                'showConfirmButton' => false,
            ],'Import data mahasiswa berhasil');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Terjadi kesalahan saat mengimport data');
        }
    }

    public function download_failed_data(Request $request)
    {
        $failedData = json_decode($request->failedData, true);
        $export = new DataFailedExport('Template_Import_Mahasiswa', $failedData, 'data_failed_import_mahasiswa');
        return $export->download();
    }

    public function export(Request $request)
    {
        $request->validate([
            'id_univ' => 'required',
            'id_fakultas' => 'required',
            'id_prodi' => 'required',
        ], [
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
            'id_prodi.required' => 'Prodi wajib dipilih.',
        ]);

        $mahasiswa = Mahasiswa::select(
            'mahasiswa.*', 'universitas.namauniv', 'fakultas.namafakultas', 'program_studi.namaprodi'
        )
        ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
        ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas');
        if ($request->id_prodi != null) {
            $mahasiswa->where("mahasiswa.id_prodi", $request->id_prodi);
        } else if ($request->id_fakultas != null) {
            $mahasiswa->where("mahasiswa.id_fakultas", $request->id_fakultas);
        } else if ($request->id_univ !=null) {
            $mahasiswa->where("mahasiswa.id_univ", $request->id_univ);
        }
        $mahasiswa = $mahasiswa->with("univ", "prodi","fakultas")->orderBy('nim', "asc")->get();

        if(count($mahasiswa) < 1) {
            return Response::error(null, 'Data mahasiswa tidak tersedia');
        }

        $namaProdi = ProgramStudi::where('id_prodi', $request->id_prodi)->pluck('namaprodi')->first();
        $fileName = 'Export_Mahasiswa_' . str_replace(" ", "_", $namaProdi) . '_' . now()->format('d_M_Y');

        $export = new MhsExport($mahasiswa, $fileName);
        return $export->download();
    }

    public function detail(Request $request, $id)
    {

        if ($request->ajax()) {
            $nilaiAkhirMhs = NilaiAkhirMhs::select('nilai_akhir_mhs.semester', 'nilai_akhir_mhs.nilai_mk', 'nilai_akhir_mhs.predikat', 'mata_kuliah.kode_mk', 'mata_kuliah.namamk', 'mata_kuliah.sks')
                ->join('mata_kuliah', 'mata_kuliah.id_mk', '=', 'nilai_akhir_mhs.id_mk')
                ->where('nilai_akhir_mhs.nim', $id)
                ->with('mataKuliah')
                ->orderBy('nilai_akhir_mhs.semester', "asc")
                ->orderBy('nilai_akhir_mhs.id_mk', 'asc')
                ->get();

            return DataTables::of($nilaiAkhirMhs)
                ->addIndexColumn()
                ->editColumn('kode_mk', fn($data) => '<div class="text-center">' . $data->kode_mk . '</div>')
                ->editColumn('namamk', fn($data) => '<div class="text-center">' . $data->namamk . '</div>')
                ->editColumn('predikat', content: fn($data) => '<div class="text-center">' . $data->predikat . '</div>')
                ->editColumn('semester', content: fn($data) => 'Semester ' . $data->semester)
                ->rawColumns(['kode_mk', 'namamk', 'predikat', 'semester'])
                ->make(true);
        };

        $mahasiswa = Mahasiswa::select(
            'mahasiswa.namamhs',
            'mahasiswa.nim',
            'mahasiswa.kelas',
            'mahasiswa.angkatan',
            'mahasiswa.ipk',
            'program_studi.namaprodi',
            'program_studi.jenjang',
        )
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->where('mahasiswa.nim', $id)
            ->first();

        return view('masters.igracias.mahasiswa.detail', compact('id', 'mahasiswa'));
    }

    public function syncronize(Request $request)
    {
        $request->validate([
            'id_univ' => 'required',
            'id_fakultas' => 'required',
            'id_prodi' => 'required',
        ], [
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
            'id_prodi.required' => 'Program Studi wajib dipilih.',
        ]);

        try {

            $configKey = 'igracias.prodi';
            $listProdi= config($configKey, []);
            $listProdi = array_flip($listProdi);
            $userId = auth()->user()->id;
            $batchId = Cache::get("sync_batch_active_id_$userId");
            $batchInfo = Cache::get("batch_{$batchId}_info");
            $isRead = Cache::get('batch_{$batchId}_isRead');

            if($batchInfo && $batchInfo['progress'] != 100 && $batchInfo['finishedAt'] == null && !$isRead) {
                return Response::error(null, 'Sinkronisasi sedang berlangsung, mohon untuk menunggu sinknronisasi selesai untuk melakukan sinkronisasi baru.');
            }

            if(empty($listProdi) || !isset($listProdi[$request->id_prodi])) {
                return Response::error(null, 'Program studi terkait belum tersedia. Silakan melakukan sinkronisasi data pada program studi.');
            }

            $queryParams = [
                'id_prodi' => $listProdi[$request->id_prodi],
                'limit' => 500,
            ];

            $mhsSync = new MhsSync($queryParams);
            $mhsSync->synchronize();

            return Response::success(['icon' => 'info', 'title' => 'info'], 'Siknronisasi Data mahasiswa dalam proses');
        } catch (Exception $e) {
            return Response::errorCatch($e, $e->getMessage());
        }
    }

    public function syncronizeNilaiMhs(Request $request)
    {
        $request->validate([
            'id_univ' => 'required',
            'id_fakultas' => 'required',
            'id_prodi' => 'required',
        ], [
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
            'id_prodi.required' => 'Program Studi wajib dipilih.',
        ]);

        try {

            $configKey = 'igracias.prodi';
            $listProdi= config($configKey, []);
            $listProdi = array_flip($listProdi);
            $userId = auth()->user()->id;
            $batchId = Cache::get("sync_batch_active_id_$userId");
            $batchInfo = Cache::get("batch_{$batchId}_info");
            $isRead = Cache::get('batch_{$batchId}_isRead');

            if($batchInfo && $batchInfo['progress'] != 100 && $batchInfo['finishedAt'] == null && !$isRead) {
                return Response::error(null, 'Sinkronisasi sedang berlangsung, mohon untuk menunggu sinknronisasi selesai untuk melakukan sinkronisasi baru.');
            }

            if(empty($listProdi) || !isset($listProdi[$request->id_prodi])) {
                return Response::error(null, 'Program studi terkait belum tersedia. Silakan melakukan sinkronisasi data pada program studi.');
            }

            $queryParams = [
                'id_prodi' => $listProdi[$request->id_prodi],
                'limit' => 500,
            ];
            $nilaiSync = new NilaiAkhirMhsSync($queryParams);
            $nilaiSync->synchronize();

            return Response::success(['icon' => 'info', 'title' => 'info'], 'Siknronisasi Data nilai akhir mahasiswa dalam proses');
        } catch (Exception $e) {
            return Response::errorCatch($e, $e->getMessage());
        }
    }
}
