<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware

{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && (in_array('superadmin', Auth::user()->roles->pluck('name')->toArray()) || in_array('admin', Auth::user()->roles->pluck('name')->toArray()))) {
            return $next($request);
        }

        // return redirect('/')->with('error', 'You have not admin access');
        abort(403, 'Unauthorized');
    }
}
