<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cdrrmo
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->organization == 'CDRRMO')
            return $next($request);

        return back()->with('error', "Requdasst Can't Perform.");
    }
}
