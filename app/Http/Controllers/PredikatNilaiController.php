<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\PredikatNilaiRequest;
use App\Models\PredikatNilai;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PredikatNilaiController extends Controller
{    
    public function __construct()
    {
        $this->middleware('permission:predikat_nilai_fahp.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $predikatNilai = PredikatNilai::all();
        return view('masters.predikat_nilai.index', compact('predikatNilai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PredikatNilaiRequest $request)
    {
        try {
            PredikatNilai::create([
                'nama' => $request->nama,              
                'nilai' => $request->nilai,              
            ]);

            return Response::success(null, 'Predikat Nilai berhasil ditambahkan');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $predikatNilai = PredikatNilai::all();
        
        return DataTables::of($predikatNilai)
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

                $url = route('predikatnilai.status', $row->id_predikat_nilai);
                $btn = "<div class='text-center'><a data-bs-toggle='modal' data-id='{$row->id_predikat_nilai}' onclick=edit($(this)) class='cursor-pointer mx-1 text-warning'><i class='tf-icons ti ti-edit' ></i>
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
        $predikatNilai = PredikatNilai::where('id_predikat_nilai', $id)->first();
        return $predikatNilai;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $predikatNilai = PredikatNilai::where('id_predikat_nilai', $id)->first();
            if (!$predikatNilai) return Response::error(null, 'Predikat Nilai not found!');

            $predikatNilai->nama = $request->nama;
            $predikatNilai->nilai = $request->nilai;
            $predikatNilai->update();        

            return Response::success(null, 'Predikat Nilai berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function status($id)
    {
        try {
            $predikatNilai = PredikatNilai::where('id_predikat_nilai', $id)->first();
            $predikatNilai->status = !$predikatNilai->status;
            $predikatNilai->save();

            return Response::success(null, 'Status Predikat Nilai berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
