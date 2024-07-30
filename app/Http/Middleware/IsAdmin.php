<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        return $request->expectsJson()
            ? abort(403, 'Unauthorized')
            : redirect()->back()->withErrors(['access' => 'You do not have access to this page.']);
    }
}

