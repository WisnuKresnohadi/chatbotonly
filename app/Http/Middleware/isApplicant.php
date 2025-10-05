<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isApplicant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && auth()->user()->roles && count(auth()->user()->roles) > 0 && auth()->user()->roles[0]->name == 'applicant') {
            return $next($request);
        }
        else if (!Auth::check()){
            return redirect('Login');
        }

        return redirect('dashboard');
    }
}
