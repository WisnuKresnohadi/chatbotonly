<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndustriRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Industri;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IndustriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:only.lkm', ['only' => ['index']]);
        $this->middleware('permission:create.industri', ['only' => ['store']]);
        $this->middleware('permission:view.industri', ['only' => ['show']]);
        $this->middleware('permission:edit.industri', ['only' => ['edit']]);
        $this->middleware('permission:update.industri', ['only' => ['update']]);
        $this->middleware('permission:status.industri', ['only' => ['status']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industri = Industri::all();
        return view('masters.mitra.index', compact('industri'));
    }

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
    public function store(IndustriRequest $request)
    {
        try{
            $industri = Industri::create([
            'namaindustri' => $request->namaindustri,
            'notelpon'=> $request->notelepon,
            'alamatindustri' => $request->alamatindustri,
            'kategori_industri' => $request->kategorimitra,
            'statuskerjasama' => $request->statuskerjasama,
            'status' => true,
        ]);

            return response()->json([
                'error' => false,
                'message' => 'Industri successfully Created!',
                'modal' => '#modalTambahMitra',
                'table' => '#table-master-mitra'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Display the spesified resource.
     */
    public function show()
    {
        $industri = Industri::orderBy('namaindustri', 'asc')->get();

        return DataTables::of($industri)
            ->addIndexColumn()
            ->editColumn('status', function ($industri) {
                if ($industri->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-success'>" . "Active" . "</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>" . "Inactive" . "</div></div>";
                }
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "success";

                $url = route('mitra.status', $row->id_industri);
                $btn = "<a data-bs-toggle='modal' data-id='{$row->id_industri}' onclick= edit($(this)) class='btn-icon text-warning waves-effect waves-light'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' class='update-status btn-icon text-{$color} waves-effect waves-light'><i class='tf-icons ti {$icon}'></i></a>";

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
        $industri = Industri::where('id_industri', $id)->first();
        return $industri;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndustriRequest $request, string $id)
    {
        try {
            $industri = Industri::where('id_industri', $id)->first();

            $industri->namaindustri = $request->namaindustri;
            $industri->notelpon = $request->notelepon;
            $industri->email = $request->email;
            $industri->alamatindustri = $request->alamatindustri;
            $industri->kategori_industri = $request->kategorimitra;
            $industri->statuskerjasama = $request->statuskerjasama;
            $industri->save();

            return response()->json([
                'error' => false,
                'message' => 'Industri successfully Updated!',
                'modal' => '#modalTambahMitra',
                'table' => '#table-master-mitra'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $industri = Industri::where('id_industri', $id)->first();
            $industri->status = ($industri->status) ? false : true;
            $industri->save();

            return response()->json([
                'error' => false,
                'message' => 'Status Industri successfully Updated!',
                'modal' => '#modalTambahMitra',
                'table' => '#table-master-mitra'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
