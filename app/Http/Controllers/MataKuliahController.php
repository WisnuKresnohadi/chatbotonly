<?php

namespace App\Http\Controllers;

use App\Exports\DataFailedExport;
use App\Helpers\Response;
use App\Imports\MkImport;
use App\Models\MataKuliah;
use Exception;
use Illuminate\Http\Request;
use App\Sync\MkSync;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class MataKuliahController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:igracias.view');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            MataKuliah::create([
                'kode_mk' => $request->kode_mk,
                'namamk' => $request->namamk,
                'id_univ' => $request->id_univ,
                'id_fakultas' => $request->id_fakultas,
                'id_prodi' => $request->id_prodi,
                'sks' => $request->sks,
                'status' => true,
            ]);

            return Response::success(null, 'Mata Kuliah successfully Created!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $mata_kuliah = MataKuliah::select('mata_kuliah.*', 'universitas.namauniv', 'fakultas.namafakultas', 'program_studi.namaprodi')
        ->leftJoin('universitas', 'universitas.id_univ', '=', 'mata_kuliah.id_univ')
        ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mata_kuliah.id_fakultas')
        ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mata_kuliah.id_prodi');

        if ($request->id_prodi != null) {
            $mata_kuliah->where("mata_kuliah.id_prodi", $request->id_prodi);
        } else if ($request->id_fakultas != null) {
            $mata_kuliah->where("mata_kuliah.id_fakultas", $request->id_fakultas);
        } else if ($request->id_univ != null) {
            $mata_kuliah->where("mata_kuliah.id_univ", $request->id_univ);
        }

        $mata_kuliah = $mata_kuliah->with('univ', 'prodi', 'fakultas')->orderBy('kode_mk', "asc")->get();

        return DataTables::of($mata_kuliah)
            ->addIndexColumn()
            ->editColumn('namamk', fn ($data) => '<div class="text-nowrap">' . $data->namamk . '</div>')
            ->editColumn('id_univ', function ($data) {
                $result = '<span class="fw-bolder text-nowrap">' .$data->namauniv. '</span><br>';
                $result .= '<span class="text-nowrap">' .$data->namafakultas. '</span><br>';
                $result .= '<small class="text-nowrap">(' .$data->namaprodi. ')</small>';

                return $result;
            })
            ->editColumn('sks', fn ($data) => '<div class="text-center">' . $data->sks . '</div>')
            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-primary'>" . "Active" . "</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>" . "Inactive" . "</div></div>";
                }
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "primary";

                $url = route('igracias.matakuliah.status', $row->kode_mk);
                $btn = "<div class='d-flex justfiy-content-center'>
                <a data-url='{$url}' data-function='afterUpdateStatus' class='cursor-pointer mx-1 update-status text-{$color}'><i class='tf-icons ti {$icon}'></i></a></div>";

                return $btn;
            })
            ->editColumn('kurikulum', fn($data) => "<div class='text-center'>$data->kurikulum</div>")
            ->rawColumns(['id_univ', 'namamk', 'sks', 'action', 'status', 'kurikulum'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mata_kuliah = MataKuliah::where('kode_mk', $id)->first();
        if (!$mata_kuliah) return Response::error(null, 'Not Found', 404);

        return Response::success($mata_kuliah, 'Success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $mata_kuliah = MataKuliah::where('kode_mk', $id)->first();

            $mata_kuliah->kode_mk = $request->kode_mk;
            $mata_kuliah->namamk = $request->namamk;
            $mata_kuliah->id_univ = $request->id_univ;
            $mata_kuliah->id_fakultas = $request->id_fakultas;
            $mata_kuliah->id_prodi = $request->id_prodi;
            $mata_kuliah->sks = $request->sks;
            $mata_kuliah->save();

            return Response::success(null, 'Mata Kuliah sudah diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function status($id)
    {
        try {
            $mata_kuliah = MataKuliah::where('kode_mk', $id)->first();
            $mata_kuliah->status = ($mata_kuliah->status) ? false : true;
            $mata_kuliah->save();

            return Response::success(null, 'Status Mata Kuliah successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function import(Request $request)
    {
        $validRequest = $request->validate([
            'import' => 'required',
            'id_univ' => 'required',
            'id_fakultas' => 'required',
            'id_prodi' => 'required',
        ], [
            'import.required' => 'File impor wajib diunggah.',
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
            'id_prodi.required' => 'Prodi wajib dipilih.',
        ]);

        $data = $request->file('import');
        $namafile = $data->getClientOriginalName();
        $data->move('MkData', $namafile);
        $import = new MkImport(...array_slice($validRequest, 1, count($validRequest) - 1));
        $filePath = public_path('/MkData/' . $namafile);

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

        if ($data['newData']->isEmpty() && $data['duplicatedData']->isEmpty() && $data['failedData']->isEmpty()) {

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            return response()->json([
                'message' => 'File yang diimpor kosong atau data telah terdaftar.',
                'error' => true
            ], 400);
        }

        session(['import_results' . auth()->user()->id => $data]);
        return Response::success([
            'error' => false,            
            'showConfirmButton' => false,
            'icon' => 'info',
            'title' => 'Informasi'
        ],'Sebelum disimpan, data di preview');
    }

    public function preview()
    {
        $data = session('import_results' . auth()->user()->id);
        if (!$data) return redirect()->route('igracias');

        return view('masters.igracias.mata-kuliah.preview', compact('data'));
    }

    public function storeImport(Request $request)
    {
        try {
            $records = json_decode($request->newData, true);

            if (isset($request->duplicatedData)) {
                $duplicates = [json_decode($request->duplicatedData, true)];
                $records = array_merge($records, $duplicates);
            }

            foreach ($records as $record) {
                MataKuliah::updateOrCreate(
                    ['kode_mk' => $record['kode_mk']],
                    [
                        ...$record,
                        'id_univ' => $request->input('univ'),
                        'id_fakultas' => $request->input('fakultas'),
                        'id_prodi' => $request->input('prodi'),
                    ]
                );
            }

            return Response::success([
                'error' => false,
                'showConfirmButton' => false,
            ],'Import data MataKuliah berhasil');
        } catch (Exception $e) {
            return Response::errorCatch($e, 'Terjadi kesalahan saat mengimport data');
        }
    }

    public function download_failed_data(Request $request)
    {
        $failedData = json_decode($request->failedData, true);
        $export = new DataFailedExport('Template_Import_Matakuliah', $failedData, 'data_failed_import_matakuliah');
        return $export->download();
    }

    public function syncronize(Request $request)
    {        
        // log request session
        // forget key session
        // $request->session()->forget('auth_token_igracias');
        // dd($request->session()->all());
        $request->validate([
            'id_univ' => 'required',
            'id_fakultas' => 'required',
            'id_prodi' => 'required',
        ], [
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
            'id_prodi.required' => 'Prodi wajib dipilih.',
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
            $mkSync = new MkSync($queryParams);
            $mkSync->synchronize();

            return Response::success(['icon' => 'info', 'title' => 'info'], 'Siknronisasi Data mata kuliah dalam proses');
        } catch (Exception $e) {
            return Response::errorCatch($e, $e->getMessage());
        }
    }
}
