<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Industri;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;

class InformasiLowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $active_menu = 'informasi_lowongan';
        if ($request->ajax() && $request->component == "card") {
            $lowongan = LowonganMagang::where('id_industri', $id)->get();
            $industri = Industri::where('id_industri', $id)->first();

            $picture = $industri?->image ? url('assets/images/' . $industri->image) : '\assets\images\no-pictures';
            $img = $picture . '.png';

            // dd($img);

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
                $item->penawaran = $item->total_pelamar->where('current_step', 'penawaran')->count();
                $item->diterima = $item->total_pelamar->where('current_step', 'diterima')->count();
                $item->ditolak = $item->total_pelamar->where('current_step', 'ditolak')->count();

                return $item;
            });


            return view('lowongan_magang.informasi_lowongan.lowongan_card', compact('active_menu', 'lowongan', 'img'))->render();
        }

        $lowongan = LowonganMagang::where('id_industri', $id)->get();
        $magang = LowonganMagang::where('id_industri', $id)->with('industri')->first();

        $industri = Industri::where('id_industri', $id)->with('total_lowongan')->first();
        $pelamar =
            PendaftaranMagang::where('id_lowongan', $magang->id_lowongan ?? "")->with('lowongan_magang')->first();
        $lowongan_count = $lowongan->count();
        $pendaftar_count = $pelamar?->count() ?? "0";
        $urlGetCard = url('informasi/lowongan', $id);
        // dd($lowongan_count);
        return view('lowongan_magang.informasi_lowongan.informasi_lowongan', compact('active_menu', 'industri', 'urlGetCard', 'lowongan_count', 'pendaftar_count', 'magang', 'lowongan'));
    }

    
    public function show(Request $request)
    {
        $lowongan = LowonganMagang::query();
        if ($request->industri != null) {
            $lowongan->where("id_industri", $request->industri);
        } else if ($request->thnakademik != null) {
            $lowongan->where("id_year_akademik", $request->thnakademik);
        } else if ($request->jenisMagang != null) {
            $lowongan->where("id_jenismagang", $request->jenisMagang);
        } else if ($request->lokasi != null) {
            $lowongan->where("id_lokasi", $request->lokasi);
        }

        $lowongan = $lowongan->with("industri", "tahunAkademik", "jenisMagang", "lokasi");

        return $lowongan;
    }

    
    public function add(string $id)
    {
        $date = LowonganMagang::where('id_lowongan', $id)->first();
        return $date;
    }

    public function date(Request $request, string $id_lowongan)
    {
        try {
            $date = LowonganMagang::where('id_lowongan', $id_lowongan)->first();
            // dd($id_lowongan);

            if ($date->id_lowongan == $id_lowongan) {
                $date->date_confirm_closing =   Carbon::parse($request->date)->format('Y-m-d');
            }

            $date->save();


            return response()->json([
                'error' => false,
                'message' => 'Confirmation cutoff date added successfully!!',
                'modal' => '#modalKonfirmasi',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
