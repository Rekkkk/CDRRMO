<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) 
            return back()->with('message', 'Request Can`t Perform.');
            
        return $next($request);
    }
}
