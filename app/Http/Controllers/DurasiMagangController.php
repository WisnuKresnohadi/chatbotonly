<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\DurasiMagangRequest;
use App\Models\DurasiMagang;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class DurasiMagangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:durasi_magang.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $durasiMagang = DurasiMagang::all();
        return view('masters.durasi_magang.index', ['durasiMagang' => $durasiMagang]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DurasiMagangRequest $request)
    {
        try {
            DurasiMagang::create([
                'name' => $request->name,              
            ]);

            return Response::success(null, 'Durasi Magang berhasil ditambahkan');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $durasiMagang = DurasiMagang::all();
        
        return DataTables::of($durasiMagang)
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

                $url = route('durasimagang.status', $row->id_durasi_magang);
                $btn = "<div class='text-center'><a data-bs-toggle='modal' data-id='{$row->id_durasi_magang}' onclick=edit($(this)) class='cursor-pointer mx-1 text-warning'><i class='tf-icons ti ti-edit' ></i>
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
        $durasiMagang = DurasiMagang::where('id_durasi_magang', $id)->first();
        return $durasiMagang;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DurasiMagangRequest $request, string $id)
    {
        try {
            $durasiMagang = DurasiMagang::where('id_durasi_magang', $id)->first();
            if (!$durasiMagang) return Response::error(null, 'Durasi Magang not found!');

            $durasiMagang->name = $request->name;
            $durasiMagang->update();        

            return Response::success(null, 'Durasi Magang berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }  

    public function status($id)
    {
        try {
            $durasiMagang = DurasiMagang::where('id_durasi_magang', $id)->first();
            $durasiMagang->status = !$durasiMagang->status;
            $durasiMagang->save();

            return Response::success(null, 'Status Durasi Magang berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
