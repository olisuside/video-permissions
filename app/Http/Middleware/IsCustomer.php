<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You do not have access to this area.');
    }
}


