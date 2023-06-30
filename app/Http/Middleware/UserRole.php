<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cdrrmo
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1 = CDRRMO, 2 = CSWD
        if (auth()->user()->organization == 'CDRRMO' || auth()->user()->organization == 'CSWD')
            return $next($request);

        else
            return back();
    }
}
