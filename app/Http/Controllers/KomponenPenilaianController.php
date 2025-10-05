<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use App\Models\JenisMagang;
use Illuminate\Http\Request;
use App\Models\KomponenNilai;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\KomponenNilaiRequest;

class KomponenPenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:komponen_penilaian.view');
    }

    public function index()
    {
        $penilaian = KomponenNilai::all();
        $id_jenismagang = JenisMagang::whereExists(function ($q) {
            $q->select(DB::raw(1))->from('tahun_akademik')->where('status', 1)->whereColumn('jenis_magang.id_year_akademik', 'id_year_akademik');
        })->get();

        return view('masters.komponen_penilaian.index', compact('id_jenismagang', 'penilaian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(KomponenNilaiRequest $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->komponen as $d) {
                KomponenNilai::create([
                    'id_jenismagang' => $request->id_jenismagang,
                    'aspek_penilaian' =>$d['aspek_penilaian'],
                    'deskripsi_penilaian' => $d['deskripsi_penilaian'],
                    'scored_by' => $d['scored_by'],
                    'nilai_max' => $d['nilai_max'],
                    'status' => true,
                ]);
            }

            DB::commit();

            return Response::success(null, 'Komponen Nilai successfully Add!');
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
        $penilaian = KomponenNilai::select('komponen_nilai.*', DB::raw('CONCAT(jenis_magang.namajenis, " (", jenis_magang.durasimagang,")") as namajenis'))
        ->join('jenis_magang', 'komponen_nilai.id_jenismagang', '=', 'jenis_magang.id_jenismagang');

        if ($request->tahun_ajaran) {
            $penilaian = $penilaian->where('jenis_magang.id_year_akademik', $request->tahun_ajaran);
        }

        if ($request->id == 'table-akademik') {
            $penilaian = $penilaian->where("scored_by", 1);
        } else if ($request->id == 'table-lapangan') {
            $penilaian = $penilaian->where("scored_by", 2);
        } else {
            return Response::error(null, 'Not Found.', 404);
        }

        return DataTables::of($penilaian->orderBy('namajenis', "asc")->get())
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-success'>Active</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
                }
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "primary";

                $url = route('komponen-penilaian.status', ['id' => $row->id_kompnilai]);
                $btn = "<div class='d-flex justify-content-center'><a data-bs-toggle='modal-komponen-nilai' data-id='{$row->id_kompnilai}' onclick=edit($(this)) class='cursor-pointer mx-1 text-warning'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' class='cursor-pointer mx-1 update-status text-{$color}' data-function='afterUpdateStatus'><i class='tf-icons ti {$icon}'></a></div>";

                return $btn;
            })
            ->rawColumns(['action', 'status'])

            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $nilai = KomponenNilai::with('jenismagang')->where('id_kompnilai', $id)->first();
            if (!$nilai) return Response::error(null, 'Not Found.', 404);

            $totalNilaiMax = KomponenNilai::where('komponen_nilai.id_jenismagang', $nilai->id_jenismagang)
                            ->where('komponen_nilai.status', 1)
                            ->where('scored_by', $nilai->scored_by)
                            ->sum('nilai_max');            

            if(($nilai->nilai_max + $totalNilaiMax) > 100 && !$nilai->status == true) throw new Exception("Nilai maksimal sudah 100 untuk <br>{$nilai->jenismagang->namajenis}.");

            $nilai->status = !$nilai->status;
            $nilai->save();

            return Response::success(null, 'Status successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penilaian = KomponenNilai::where('id_kompnilai', $id)->first();
        return Response::success($penilaian, 'Success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KomponenNilaiRequest $request, string $id)
    {
        try {
            foreach ($request->komponen as $d) {
                KomponenNilai::where('id_kompnilai',$id)->first()->update([
                    'id_jenismagang' => $request->id_jenismagang,
                    'aspek_penilaian' =>$d['aspek_penilaian'],
                    'deskripsi_penilaian' => $d['deskripsi_penilaian'],
                    'scored_by' => $d['scored_by'],
                    'nilai_max' => $d['nilai_max'],
                    'status' => true,
                ]);
            }
            
            return Response::success(null, 'Komponen Nilai successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}