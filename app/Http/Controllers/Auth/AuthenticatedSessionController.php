<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();
        if($user->can('dashboard.dashboard_admin')) {
            $url = RouteServiceProvider::ADMIN;
        } elseif($user->can('dashboard.dashboard_mitra')) {
            $url = RouteServiceProvider::MITRA;
        } elseif($user->can('approval_mhs_kaprodi.view')) {
            $url = RouteServiceProvider::KAPRODI;
        } elseif($user->can('approval_mhs_doswal.view') && count($user->dosen->mahasiswaDiampu) > 0) {
            $url = RouteServiceProvider::DOSEN;
        } elseif($user->can('kelola_mhs_pemb_akademik.view') && count($user->dosen->mahasiswaBimbingan) > 0) {
            $url = RouteServiceProvider::PEMB_AKADEMIK;
        } elseif($user->can('kelola_magang_pemb_lapangan.view')) {
            $url = RouteServiceProvider::PEMB_LAPANGAN;
        } else {
            $url = RouteServiceProvider::LANDINGPAGE;
        }
        
        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
