<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaLowonganController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lowongan_magang.kelola_lowongan_magang_admin.halaman_lowongan_magang');
    }
}
