<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::user()->can('dashboard.dashboard_admin')) {
                    $url = RouteServiceProvider::ADMIN;
                } elseif(Auth::user()->can('dashboard.dashboard_mitra')) {
                    $url = RouteServiceProvider::MITRA;
                } elseif(Auth::user()->can('approval_mhs_doswal.view')) {
                    $url = RouteServiceProvider::DOSEN;
                } elseif(Auth::user()->can('approval_mhs_kaprodi.view')) {
                    $url = RouteServiceProvider::KAPRODI;
                } elseif(Auth::user()->can('kelola_magang_pemb_lapangan.view')) {
                    $url = RouteServiceProvider::PEMB_LAPANGAN;
                } else {
                    $url = RouteServiceProvider::LANDINGPAGE;
                }

                return redirect($url);
                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
