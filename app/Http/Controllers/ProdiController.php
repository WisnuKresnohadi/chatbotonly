<?php

namespace App\Http\Controllers;

use App\Exports\DataFailedExport;
use App\Sync\ProdiSync;
use Exception;
use App\Models\Fakultas;
use App\Helpers\Response;
use App\Models\Universitas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Requests\ProdiRequest;
use App\Imports\ProdiImport;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:program_studi.view', 'permission:igracias.view']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->section == 'id_fakultas') {
                $data = Fakultas::active()->select('namafakultas as text', 'id_fakultas as id')->where('id_univ', $request->selected)->get();
            } else if ($request->section == 'id_prodi') {
                $data = ProgramStudi::active()->select('namaprodi as text', 'id_prodi as id')->where('id_fakultas', $request->selected)->get();
            }
            return Response::success($data, 'Success');
        }

        $universitas = Universitas::active()->get();
        return view('masters.prodi.index', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdiRequest $request)
    {
        try {
            $prodi = ProgramStudi::create([
                'id_fakultas' => $request->id_fakultas,
                'id_univ' => $request->id_univ,
                'namaprodi' => $request->namaprodi,
                'jenjang' => $request->jenjang
            ]);

            return Response::success(null, 'Data Created!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $prodi = ProgramStudi::query();
        if ($request->id_fakultas != null) {
            $prodi->where("program_studi.id_fakultas", $request->id_fakultas);
        } else if ($request->id_univ != null) {
            $prodi->where("program_studi.id_univ", $request->id_univ);
        }

        $prodi = $prodi->with("univ", "fakultas")->orderBy('id_prodi', "asc")->get();

        return DataTables::of($prodi)
            ->addIndexColumn()
            ->editColumn('namaprodi', function ($x) {
                return '<span>' . $x->namaprodi . '<span class="ms-2 fw-bolder">(' . $x->jenjang . ')</span>' . '</span>';
            })
            ->editColumn('status', function ($prodi) {
                if ($prodi->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-success'>Active</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
                }
            })
            ->addColumn('action', function ($prodi) {
                $icon = ($prodi->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($prodi->status) ? "danger" : "success";

                $url = route('prodi.status', $prodi->id_prodi);

                $btn = "
                <div class='p-4 d-flex justify-content-center'>
                  <a data-url='{$url}' data-function='afterUpdateStatus' class='update-status cursor-pointer text-{$color}'><i class='tf-icons ti {$icon}'></i></a>
                </div>";
                return $btn;
            })
            ->rawColumns(['namaprodi', 'status', 'action'])

            // ->json();
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prodi = ProgramStudi::where('id_prodi', $id)->first();
        return $prodi;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdiRequest $request, $id)
    {
        try {
            $prodi = ProgramStudi::where('id_prodi', $id)->first();

            $prodi->id_univ = $request->id_univ;
            $prodi->id_fakultas = $request->id_fakultas;
            $prodi->namaprodi = $request->namaprodi;
            $prodi->jenjang = $request->jenjang;
            $prodi->save();

            return Response::success(null, 'Data successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $prodi = ProgramStudi::where('id_prodi', $id)->first();
            if (!$prodi) return Response::error(null, 'Data not found!');

            $prodi->status = !$prodi->status;
            $prodi->save();

            return Response::success(null, 'Status successfully changed!');
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
        ], [
            'import.required' => 'File impor wajib diunggah.',
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
        ]);

        $data = $request->file('import');
        $namafile = $data->getClientOriginalName();
        $data->move('ProdiData', $namafile);
        $import = new ProdiImport(...array_slice($validRequest, 1, count($validRequest) - 1));
        $filePath = public_path('/ProdiData/' . $namafile);

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
        ], 'Sebelum disimpan, data di preview');
    }

    public function preview()
    {
        $data = session('import_results' . auth()->user()->id);
        if (!$data) return redirect()->route('igracias');

        return view('masters.igracias.prodi.preview', compact('data'));
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
                ProgramStudi::updateOrCreate(
                    [
                        ...$record,
                        'id_univ' => $request->input('univ'),
                        'id_fakultas' => $request->input('fakultas'),
                    ]
                );
            }

            return Response::success([
                'error' => false,
                'showConfirmButton' => false,
            ], 'Import data MataKuliah berhasil');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function download_failed_data(Request $request)
    {
        $failedData = json_decode($request->failedData, true);
        $export = new DataFailedExport('Template_Import_Prodi', $failedData, 'data_failed_import_prodi');
        return $export->download();
    }

    public function syncronize(Request $request)
    {
        $request->validate([
            'id_univ' => 'required',
            'id_fakultas' => 'required',
        ], [
            'id_univ.required' => 'Universitas wajib dipilih.',
            'id_fakultas.required' => 'Fakultas wajib dipilih.',
        ]);

        // dd(decrypt(Cache::get(env('AUTH_TOKEN_KEY_IGRACIAS', 'auth_token_igracias'))));

        try {

            $userId = auth()->user()->id;
            $batchId = Cache::get("sync_batch_active_id_$userId");
            $batchInfo = Cache::get("batch_{$batchId}_info");
            $isRead = Cache::get('batch_{$batchId}_isRead');

            if($batchInfo && $batchInfo['progress'] != 100 && $batchInfo['finishedAt'] == null && !$isRead) {
                return Response::error(null, 'Sinkronisasi sedang berlangsung, mohon untuk menunggu sinknronisasi selesai untuk melakukan sinkronisasi baru.');
            }

            $prodiSync = new ProdiSync();
            $prodiSync->synchronize();

            return Response::success(['icon' => 'info', 'title' => 'info'], 'Siknronisasi Data program studio dalam proses');
        } catch (Exception $e) {
            dd($e);
            return Response::errorCatch($e, $e->getMessage());
        }
    }
}
