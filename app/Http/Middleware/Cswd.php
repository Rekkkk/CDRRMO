<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cswd
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->organization == "CSWD")
            return $next($request);

        return back()->with('warning', "Request Can't Perform.");
    }
}
