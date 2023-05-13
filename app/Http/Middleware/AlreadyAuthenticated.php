<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AlreadyAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) 
            return back()->with('message', 'Request Can`t Perform.');
            
        return $next($request);
    }
}
