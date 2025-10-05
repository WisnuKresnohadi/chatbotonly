<?php

namespace App\Http\Controllers;

use App\Models\Seleksi;
use App\Models\Industri;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use App\Models\PendaftaranMagang;

class MitraJadwalController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:only.lkm,', ['only' => ['index']]);
    }
    
    public function index()
    {
        $mitra = LowonganMagang::all();

        return view('company.jadwal_seleksi.mitra_seleksi', compact('mitra'));
    }

    public function show()
    {
        $mitra = Industri::with('total_lowongan')->get();

        return DataTables::of($mitra)
            ->addIndexColumn()
            ->addColumn('status', function ($mitra) {
                if ($mitra->statuskerjasama == "Ya") {
                    return "<span class='badge bg-label-success me-1'>Ya</span>";
                } else if ($mitra->statuskerjasama == "Tidak") {
                    return "<span class='badge bg-label-secondary me-1'>Tidak</span>";
                } else {
                    return "<span class='badge bg-label-info me-1'>Internal Telyu</span>";
                }
            })
            ->addColumn('action', function ($row) {
                return "<a href='" .route('jadwal_seleksi.detail', ['id' => $row->id_industri]). "' class='btn-icon text-success'><i class='tf-icons ti ti-file-invoice'></a>";
            })
            ->editColumn('total_lowongan', function ($row) {
                return $row->total_lowongan->count();
            })
            ->editColumn('total_pelamar', function ($row) {
                return PendaftaranMagang::leftJoin('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
                    ->where('id_industri', $row->id_industri)
                    ->count();
            })

            ->rawColumns(['action', 'status'])

            ->make(true);
    }

    public function detail(Request $request,$id) {
        if ($request->ajax() && $request->component == "card") {
            $lowongan = LowonganMagang::where('id_industri', $id)->get();

            $seleksi = Seleksi::where('id_seleksi_lowongan', $id)->get();
            $industri = Industri::where('id_industri', $id)->first();

            $picture = $industri?->image ? url('assets/images/' . $industri->image) : '\assets\images\no-pictures';
            $img = $picture . '.png';

            $lowongan->transform(function ($item) {
                $now = Carbon::now();
                if ($now->lessThan($item->enddate) && $now->greaterThan($item->startdate)) {
                    $item->status = true;
                } elseif ($now->greaterThan($item->enddate)) {
                    $item->status = false;
                }

                if ($item->status == 'true') {
                    $item->status = 'Aktif';
                    $item->color = 'success';
                } else {
                    $item->status = 'Non-aktif';
                    $item->color = 'danger';
                }

                $item->kandidat = $item->total_pelamar->count();
                $item->screening = $item->total_pelamar->where('current_step', 'screening')->count();
                $item->tahap1 = $item->total_pelamar->where('current_step', 'tahap1')->count();
                $item->tahap2 = $item->total_pelamar->where('current_step', 'tahap2')->count();
                $item->tahap3 = $item->total_pelamar->where('current_step', 'tahap3')->count();
                return $item;
            });

            return view('company.jadwal_seleksi.jadwal_card ', compact('lowongan', 'seleksi', 'img'))->render();
        }
        $urlGetCard = url('jadwal-seleksi/lowongan', $id);
        $LMagang = LowonganMagang::where('id_industri', $id)->get();
        $lowongan_count = $LMagang->count();

        $lowongan = LowonganMagang::where('id_industri', $id)->first();
        $seleksi = Seleksi::all();
        $urlBack = route('jadwal_seleksi');

        return view('company.jadwal_seleksi.jadwal', compact('seleksi', 'lowongan', 'urlGetCard', 'lowongan_count'));
    }
}
