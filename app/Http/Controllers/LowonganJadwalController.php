<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Seleksi;
use App\Models\Industri;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;

class LowonganJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
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
        $urlBack = route('');

        return view('company.jadwal_seleksi.jadwal', compact('seleksi', 'lowongan', 'urlGetCard', 'lowongan_count'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
