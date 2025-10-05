<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogBookMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:logbook_magang_fakultas.view', ['only' => ['viewMagangFakultas', 'detailMagangFakultas', 'showMagangFakultas']]);
        $this->middleware('permission:logbook_magang_mandiri.view', ['only' => ['viewMagangMandiri', 'detailMagangMandiri', 'showMagangMandiri']]);
    }

    public function viewMagangFakultas()
    {
        return view('logbook_mahasiswa.magang_fakultas.index');
    }

    public function viewMagangMandiri()
    {
        return view('logbook_mahasiswa.magang_mandiri.index');
    }

    public function detailMagangFakultas()
    {
        return view('logbook_mahasiswa.magang_fakultas.detail_logbook');
    }

    public function detailMagangMandiri()
    {
        return view('logbook_mahasiswa.magang_mandiri.detail_logbook');
    }

    public function showMagangFakultas()
    {
        return view('logbook_mahasiswa.magang_fakultas.view_logbook');
    }

    public function showMagangMandiri()
    {
        return view('logbook_mahasiswa.magang_mandiri.view_logbook');
    }
}
