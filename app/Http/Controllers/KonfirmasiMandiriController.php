<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanMandiri;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use Exception;
use Illuminate\Support\Facades\Auth;

class KonfirmasiMandiriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengajuan_magang.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $mandiri = PengajuanMandiri::where("nim",$user->nim)->get();
        $mahasiswa = Mahasiswa::all();
        
        $nim = Mahasiswa::find($user->nim);
        $nim = $nim->nim;

        $mandiri_nim = $mandiri->pluck('nim')->toArray();

        return view('pengajuan_magang.mandiri.index',  compact('mandiri','mahasiswa', 'nim', 'mandiri_nim'));
    }
    
    public function store(Request $request)
    {
        try {
            $mandiri = PengajuanMandiri::create([
                'nim' => $request->nim,
                'tglpeng' => $request->tglpeng,
                'nama_industri' => $request->nama_industri,
                'posisi_magang' => $request->posisi_magang,
                'jabatan' => $request->jabatan,
                'alamat_industri' => $request->alamat_industri,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'startdate' => $request->startdate,
                'enddate' => $request->enddate,
                'alasan' => '-',
                'statusapprove' => false,
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Data successfully Created!',
                'url' => url('pengajuan/surat')

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
    public function show($mandiri)
    {
        $mandiri = $mandiri->with();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mandiri = PengajuanMandiri::where('id_pengajuan', $id)->first();
        return $mandiri;
        
    }

    public function detail($id)
    {
        $mandiri = PengajuanMandiri::where('id_pengajuan', $id)->first();
        return $mandiri;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $mandiri = PengajuanMandiri::where('id_pengajuan', $id)->first();

            $mandiri->nim = $request->nim;
            $mandiri->tglpeng = $request->tglpeng;
            $mandiri->nama_industri = $request->nama_industri;
            $mandiri->posisi_magang = $request->posisi_magang;
            $mandiri->jabatan = $request->jabatan;
            $mandiri->alamat_industri = $request->alamat_industri;
            $mandiri->nohp = $request->nohp;
            $mandiri->email = $request->email;
            $mandiri->startdate = $request->startdate;
            $mandiri->enddate = $request->enddate;
            $mandiri->alasan = $request->alasan;
            $mandiri->save();

            return response()->json([
                'error' => false,
                'message' => 'Data successfully Updated!',
                'modal' => '#modalEdit',
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
    public function status($id)
    {
        
    }

}