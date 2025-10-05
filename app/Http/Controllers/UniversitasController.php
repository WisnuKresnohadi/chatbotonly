<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use App\Models\Universitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UniversitasRequest;

class UniversitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:universitas.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.universitas.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UniversitasRequest $request)
    {
        try {
            $univ = Universitas::create([
                'namauniv' => $request->namauniv,
                'jalan' => $request->jalan,
                'kota' => $request->kota,
                'telp' => $request->telp,
                'status' => true,
            ]);
            return Response::success(null, 'Universitas successfully created!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $univ = Universitas::orderBy('namauniv', 'asc')->get();

        return DataTables::of($univ)
            ->addIndexColumn()
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

                $url = route('universitas.status', ['id' => $row->id_univ]);

                $btn = "<div><a data-bs-toggle='modal' data-id='{$row->id_univ}' onclick=edit($(this)) class='cursor-pointer text-warning'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' data-function='afterUpdateStatus' class='cursor-pointer update-status text-{$color}'><i class='tf-icons ti {$icon}'></i></a></div>";

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
        $univ = Universitas::where('id_univ', $id)->first();
        return $univ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UniversitasRequest $request, string $id)
    {
        try {
            $univ = Universitas::where('id_univ', $id)->first();
            $univ->namauniv = $request->namauniv;
            $univ->jalan = $request->jalan;
            $univ->kota = $request->kota;
            $univ->telp = $request->telp;
            $univ->save();

            return Response::success(null, 'Universitas successfully Updated!');
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
            $univ = Universitas::where('id_univ', $id)->first();
            if (!$univ) return Response::error(null, 'Universitas not found!');

            $univ->status = !$univ->status;
            $univ->save();

            return Response::success(null, 'Status Universitas successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
