<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Cdrrmo
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1 = CDRRMO, 2 = CSWD
        if (auth()->user()->user_role == 'CDRRMO' || auth()->user()->user_role == 'CSWD')
            return $next($request);

        else
            return back();
    }
}
