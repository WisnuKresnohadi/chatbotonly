<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCompanyReq;
use App\Models\User;
use App\Models\Industri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;
use Ramsey\Uuid\Uuid;

class RegisterMitraController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME; 


    public function showRegistrationForm()
    {
        $industri = Industri::all();
        return view('auth.register_mitra');
    }

    public function store(RegisterCompanyReq $request)
    {
        
        try{
            $industri = Industri::create([
            'namaindustri' => $request->namaindustri,
            'email' => $request->email,
            'kategori_industri' => $request->kategori_industri,
            'statuskerjasama' => $request->statuskerjasama,
            'penanggung_jawab' => $request->name,
            'status' => true,
            'notelpon' => $request->notelpon
        ]);


        $code = Str::random(64);
        $admin = User::create([
            'name' => $request->name,
            'username' => $industri->namaindustri,
            'email' => $request->email,
            'password' => Hash::make($industri->penanggung_jawab),
            'remember_token' => $code,
            'isAdmin'=>1,
            'id_industri' => $industri->id_industri,
            'penanggung_jawab' => $industri->id_industri,
        ]);
        $admin->assignRole('admin');

        return view('auth.message-verify-email');
        
    } catch (Exception $e) {
        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
            
        ]);
    }
    }

}


