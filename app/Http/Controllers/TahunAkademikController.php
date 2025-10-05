<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Helpers\Response;
use App\Models\Universitas;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TahunAkademikRequest;

class TahunAkademikController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tahun_akademik.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.tahun_akademik.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAkademikRequest $request)
    {
        try {
            // Set all other academic years to inactive
            TahunAkademik::query()->update(['status' => false]);

            // Create new academic year
            $tahun = TahunAkademik::create([
                'tahun' => $request->tahun,
                'semester' => $request->semester,
                'startdate_daftar' => $request->startdate_daftar,
                'enddate_daftar' => $request->enddate_daftar,
                // 'startdate_pengumpulan_berkas' => $request->startdate_pengumpulan_berkas,
                // 'enddate_pengumpulan_berkas' => $request->enddate_pengumpulan_berkas,
                'status' => true,
            ]);

            return Response::success(null, 'Tahun Akademik successfully Created!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $tahunAkademiks = TahunAkademik::orderBy('tahun', 'desc')->orderByRaw("CASE WHEN semester = 'Ganjil' THEN 2 WHEN semester = 'Genap' THEN 1 ELSE 0 END")->get();

        return DataTables::of($tahunAkademiks)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                return $row->status ?
                    "<div class='text-center'><div class='badge rounded-pill bg-label-success'>Active</div></div>" :
                    "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
            })
            ->addColumn('pendaftaran_magang', function ($row) {
                return (($row->startdate_daftar) ? Carbon::parse($row->startdate_daftar)->format('d M Y') : '') . '&ensp;-&ensp;' . (($row->enddate_daftar) ? Carbon::parse($row->enddate_daftar)->format('d M Y') : '');
            })
            // ->addColumn('pengumpulan_berkas', function ($row) {
            //     return Carbon::parse($row->startdate_pengumpulan_berkas)->format('d M Y') . '&ensp;-&ensp;' . Carbon::parse($row->enddate_pengumpulan_berkas)->format('d M Y');
            // })
            ->addColumn('action', function ($row) {
                $url = route('thn-akademik.status', $row->id_year_akademik);
                $btn = "<div class='d-flex justify-content-center'><a data-bs-toggle='modal' data-id='{$row->id_year_akademik}' onclick=edit($(this)) class='cursor-pointer mx-1 text-warning'><i class='tf-icons ti ti-edit' ></i></a>";
                if ($row->status == 0) {
                    $btn .= "<a data-url='{$url}' class='cursor-pointer mx-1 update-status text-success' data-function='afterUpdateStatus'><i class='tf-icons ti ti-circle-check'></i></a>";
                }
                $btn .= "</div>";

                return $btn;
            })
            ->rawColumns(['pendaftaran_magang', 'action', 'status'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tahun = TahunAkademik::where('id_year_akademik', $id)->first();
        return Response::success($tahun, 'Successs');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TahunAkademikRequest $request, string $id)
    {
        try {
            $tahun = TahunAkademik::where('id_year_akademik', $id)->first();
            if (!$tahun) return Response::error(null, 'Tahun Akademik not found!');

            $tahun->tahun = $request->tahun;
            $tahun->semester = $request->semester;
            $tahun->startdate_daftar = Carbon::parse($request->startdate_daftar)->format('Y-m-d');
            $tahun->enddate_daftar = Carbon::parse($request->enddate_daftar)->format('Y-m-d');
            // $tahun->startdate_pengumpulan_berkas = Carbon::parse($request->startdate_pengumpulan_berkas)->format('Y-m-d');
            // $tahun->enddate_pengumpulan_berkas = Carbon::parse($request->enddate_pengumpulan_berkas)->format('Y-m-d');
            $tahun->save();

            return Response::success(null, 'Tahun Akademik successfully Updated!');
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
            $tahun = TahunAkademik::where('id_year_akademik', $id)->first();
            if (!$tahun) return Response::error(null, 'Tahun Akademik not found!');
            if ($tahun->status == 1) return Response::error(null, 'Tahun Akademik already cannot be set to inactive!');

            // Set all other academic years to inactive if the current one is set to active
            if (!$tahun->status) {
                TahunAkademik::query()->update(['status' => false]);
            }

            $tahun->status = !$tahun->status;
            $tahun->save();
            return Response::success(null, 'Status Tahun Akademik successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
