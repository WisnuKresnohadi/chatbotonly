<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanAkhirRequest;
use App\Models\JenisMagang;
use Exception;
use Carbon\Carbon;
use App\Models\LaporanAkhir;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = LaporanAkhir::all();
        $jenis = JenisMagang::all();
        return view('masters.berkas_akhir.index', compact('laporan', 'jenis'));
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
    public function store(LaporanAkhirRequest $request)
    {
        try {
            LaporanAkhir::create([
                'id_jenismagang' => $request->jenismagang,
                'durasi_magang' => $request->durasimagang,
                'berkas_magang' => json_encode($request->berkas),
                'deadline_pengumpulan' => Carbon::parse($request->pengumpulan)->format('Y-m-d H:i'),
                'deadline_penilaian' => Carbon::parse($request->penilaian)->format('Y-m-d H:i'),
                'status' => true,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Data berhasil dibuat!',
                'modal' => '#modalTambah',
                'table' => '#table-laporan-akhir'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $laporan = LaporanAkhir::with('jenis_magang')->orderBy('durasi_magang', 'asc');

        return DataTables::of($laporan->get())
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-success'>" . "Active" . "</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>" . "Inactive" . "</div></div>";
                }
            })
            ->addColumn('tgl_pengumpulan', function ($row) {
                $tgl = Carbon::parse($row->deadline_pengumpulan)->format('d F Y H:i');
                return $tgl;
            })
            ->addColumn('tgl_penilaian', function ($row) {
                $tgl = Carbon::parse($row->deadline_penilaian)->format('d F Y H:i');
                return $tgl;
            })
            ->addColumn('berkas_magang', function ($row) {
                // Ambil data dari database
                $files = json_decode($row->berkas_magang);

                $result = '';
                // Tampilkan sebagai form input
                foreach ($files as $file) {
                    $result .= '<span> <i class="bi bi-dot"></i>' . $file . '</span><br>';
                }
                return $result;
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "success";

                $url = url('laporan-akhir/status/' . $row->id_lap_akhir);
                $btn = "<a data-bs-toggle='modal' data-id='{$row->id_lap_akhir}' onclick=edit($(this)) class='btn-icon text-warning waves-effect waves-light'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' class='btn-icon update-status text-{$color} waves-effect waves-light'><i class='tf-icons ti {$icon}'></i></a>";

                return $btn;
            })
            ->rawColumns(['berkas_magang', 'action', 'status'])

            ->make(true);
    }

    public function status(string $id)
    {
        try {
            $laporan = LaporanAkhir::where('id_lap_akhir', $id)->first();
            $laporan->status = ($laporan->status) ? false : true;
            $laporan->save();

            return response()->json([
                'error' => false,
                'message' => 'Status berhasil diubah!',
                'modal' => '#modalTambah',
                'table' => '#table-laporan-akhir'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laporan = LaporanAkhir::where('id_lap_akhir', $id)->first();
        $files = json_decode($laporan->berkas_magang);

        return
            response()->json([
                'file' => $files,
                'laporan' => $laporan,

            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaporanAkhirRequest $request, string $id)
    {
        // dd($request->berkas);
        try {
            $laporan = LaporanAkhir::where('id_lap_akhir', $id)->first();

            $laporan->id_jenismagang = $request->jenismagang;
            $laporan->durasi_magang = $request->durasimagang;
            $laporan->berkas_magang = json_encode($request->berkas);
            $laporan->deadline_pengumpulan = Carbon::parse($request->pengumpulan)->format('Y-m-d H:i');
            $laporan->deadline_penilaian = Carbon::parse($request->penilaian)->format('Y-m-d H:i');
            $laporan->save();

            return response()->json([
                'error' => false,
                'message' => 'Data berhasil diubah!',
                'modal' => '#modalTambah',
                'table' => '#table-laporan-akhir'
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
    public function destroy(string $id)
    {
        //
    }
}
