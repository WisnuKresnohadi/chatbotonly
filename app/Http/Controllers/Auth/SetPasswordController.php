<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetPasswordReq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SetPasswordController extends Controller
{
    //set password company  
    public function index($token) {
        return view('partials_auth.verifikasi_akun', compact('token'));
    }
    public function update(SetPasswordReq $request) {
        $admin = User::where('remember_token', $request->token)->first();
        if (!$admin) {
            return redirect()->back()->withInput()->withErrors(['token' => 'Token tidak valid']);
        }
        $admin->password = bcrypt($request->password);
        $admin->remember_token=null;
        $admin->save();
        return redirect('/login');
    }

    //set password mahasiswa
    public function setting($token) {

        return view('partials_auth.verify_akun_mahasiswa', compact('token'));
    }

    public function updateset(Request $request) {

        $user = User::where('remember_token', $request->token)->first();
        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['token' => 'Token tidak valid'], 404);
        }
        $user->password = bcrypt($request->password);
        $user->remember_token=null;
        $user->save();
        return redirect('/login');
    }
}
