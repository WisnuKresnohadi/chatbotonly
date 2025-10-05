<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\BidangPekerjaanIndustriRequest;
use App\Models\BidangPekerjaanIndustri;
use App\Models\PegawaiIndustri;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class BidangPekerjaanIndustriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bidang_pekerjaan_industri.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.bidang_pekerjaan_industri.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BidangPekerjaanIndustriRequest $request)
    {
        try {
            $idIndustri = PegawaiIndustri::where('id_user', auth()->user()->id)->pluck('id_industri')->first();
            BidangPekerjaanIndustri::create([
                'namabidangpekerjaan' => $request->namabidangpekerjaan,
                'deskripsi' => $request->deskripsi,
                'id_industri' => $idIndustri
            ]);

            return Response::success(null, 'Bidang Pekerjaan berhasil ditambahkan');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $idIndustri = PegawaiIndustri::where('id_user', auth()->user()->id)->pluck('id_industri')->first();
        $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_industri', $idIndustri)->get();

        return DataTables::of($bidangPekerjaanIndustri)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = "<div class='text-center'><a data-bs-toggle='modal' data-id='{$row->id_bidang_pekerjaan_industri}' onclick=edit($(this)) class='mx-1 cursor-pointer text-warning'><i class='tf-icons ti ti-edit' ></i></div>";
                return $btn;
            })                  
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_bidang_pekerjaan_industri', $id)->first();
        if (!$bidangPekerjaanIndustri) return Response::error(null, 'Not Found', 404);

        return Response::success($bidangPekerjaanIndustri, 'Success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BidangPekerjaanIndustriRequest $request, string $id)
    {
        try {
            $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_bidang_pekerjaan_industri', $id)->first();
            if (!$bidangPekerjaanIndustri) return Response::error(null, 'Bidang Pekerjaan not found!');

            $bidangPekerjaanIndustri->namabidangpekerjaan = $request->namabidangpekerjaan;
            $bidangPekerjaanIndustri->deskripsi = $request->deskripsi;
            $bidangPekerjaanIndustri->update();

            return Response::success(null, 'Bidang Pekerjaan berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
