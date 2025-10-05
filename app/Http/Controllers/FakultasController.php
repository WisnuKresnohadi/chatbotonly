<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Helpers\Response;
use App\Models\Universitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FakultasRequest;
use Yajra\DataTables\Facades\DataTables;


class FakultasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fakultas.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universitas = Universitas::active()->get();
        $fakultas = Fakultas::active()->get();
        return view('masters.fakultas.index', compact('fakultas','universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FakultasRequest $request)
    {
        try {
            $fakultas = Fakultas::create([
                'id_univ' => $request->namauniv,
                'namafakultas' => $request->namafakultas,
                'status' => true,
            ]);

            return Response::success(null, 'Fakultas berhasil ditambahkan');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_univ)
    {
        $fakultas = Fakultas::query();
        if ($id_univ !== 'all'){
            $fakultas = $fakultas->where('id_univ',$id_univ);
        }
        $fakultas->with('univ')->orderBy('id_fakultas', 'asc')->get();

        return DataTables::of($fakultas)
            ->addIndexColumn()
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

                $url = route('fakultas.status', $row->id_fakultas);
                $btn = "<div class='text-center'><a data-bs-toggle='modal' data-id='{$row->id_fakultas}' onclick=edit($(this)) class='cursor-pointer mx-1 text-warning'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' data-function='afterUpdateStatus' class='cursor-pointer mx-1 update-status text-{$color}'><i class='tf-icons ti {$icon}'></i></a></div>";

                return $btn;
            })
            ->rawColumns(['action', 'status'])

            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fakultas = Fakultas::where('id_fakultas', $id)->first();
        return $fakultas;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $fakultas = Fakultas::where('id_fakultas', $id)->first();
            if (!$fakultas) return Response::error(null, 'Fakultas not found!');

            $fakultas->id_univ = $request->namauniv;
            $fakultas->namafakultas = $request->namafakultas;
            $fakultas->save();

            return Response::success(null, 'Fakultas berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status($id)
    {
        try {
            $fakultas = Fakultas::where('id_fakultas', $id)->first();
            $fakultas->status = !$fakultas->status;
            $fakultas->save();

            return Response::success(null, 'Status fakultas berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}