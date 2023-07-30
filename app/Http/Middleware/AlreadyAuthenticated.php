<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->organization == "CDRRMO")
                return redirect()->route('dashboard.cdrrmo')->with('warning', 'Request Can`t Perform.');

            else if (auth()->user()->organization == "CSWD")
                return redirect()->route('dashboard.cswd')->with('warning', 'Request Can`t Perform.');
        }

        return $next($request);
    }
}
