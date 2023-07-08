<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cswd
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->getName() === 'generate.evacuee.data')
            return $next($request);

        if (auth()->check() && auth()->user()->organization == "CSWD")
            return $next($request);

        return back()->with('error', "Request Can't Perform.");
    }
}
