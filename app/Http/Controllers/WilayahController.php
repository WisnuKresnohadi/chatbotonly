<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\WilayahKota;
use App\Models\WilayahNegara;
use App\Models\WilayahProvinsi;
use Yajra\DataTables\Facades\DataTables;

class WilayahController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:wilayah.view', ['except' => ['getChildren']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.wilayah.index');
    }

    public function create($type)
    {
        if($type == 'province'){
            $wilayah = WilayahNegara::all();
        }elseif($type == 'city'){
            $wilayah = WilayahProvinsi::all();
        }

        return $wilayah ?? '';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            if($request->type == 'province'){
                $wilayah = new WilayahProvinsi();
                $wilayah->country_id = $request->parent;
            }elseif($request->type == 'city'){
                $wilayah = new WilayahKota();
                $wilayah->province_id = $request->parent;
            }else{
                $wilayah = new WilayahNegara();
            }
            
            $wilayah->name = $request->name;
            $wilayah->save();
            DB::commit();
            return Response::success(['type' => $request->type], 'Wilayah successfully Created!');
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
        if($request->type == 'provinces'){
            $wilayah = WilayahProvinsi::with('negara');
            $type = 'province';
        }elseif($request->type == 'cities'){
            $wilayah = WilayahKota::with('provinsi');
            $type = 'city';
        }else{
            $wilayah = new WilayahNegara();
            $type = 'country';
        }

        $datatables = DataTables::of($wilayah->get())
        ->addIndexColumn()
        ->addColumn('aksi', function ($id) use($type){
            $btn = "<div class='d-flex justify-content-center'>";
            $btn .= "<a data-bs-toggle='modal' data-id='{$id->id}' data-type='{$type}' onclick=edit($(this)) class='mx-1 text-warning cursor-pointer'><i class='ti ti-edit' ></i>";
            $btn .= "</div>";

            return $btn;
        });

        if($request->type == 'provinces'){
            $datatables->addColumn('parent', function($provinsi){
                return $provinsi->negara->name;
            });
        }elseif($request->type == 'cities'){
            $datatables->addColumn('parent', function($kota){
                return $kota->provinsi->name;
            });
        }

        return $datatables->rawColumns(['aksi'])
        ->make(true);
    }

    public function getChildren(Request $request)
    {
        if($request->type == 'provinces'){
            $wilayah = WilayahKota::where('province_id', $request->id);
        }elseif($request->type == 'countries'){
            $wilayah = WilayahProvinsi::where('country_id', $request->id);
        }else{
            $wilayah = new WilayahNegara();
        }

        return $wilayah->get();
    }

    public function edit($id)
    {
        if(request()->type == 'province'){
            $wilayah = WilayahProvinsi::where('id', $id)->select('id', 'name','country_id as parent')->first();
        }elseif(request()->type == 'city'){
            $wilayah = WilayahKota::where('id', $id)->select('id', 'name','province_id as parent')->first();
        }else{
            $wilayah = WilayahNegara::where('id', $id)->first();
        }

        return $wilayah ?? '';
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            if($request->type == 'province'){
                $wilayah = WilayahProvinsi::where('id', $request->id)->first();
                $wilayah->country_id = $request->parent;
            }elseif($request->type == 'city'){
                $wilayah = WilayahKota::where('id', $request->id)->first();
                $wilayah->province_id = $request->parent;
            }else{
                $wilayah = WilayahNegara::where('id', $request->id)->first();
            }

            $wilayah->name = $request->name;
            $wilayah->save();

            DB::commit();
            return Response::success(['type' => $request->type, 'edit' => true], 'Data Successfully Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }
}