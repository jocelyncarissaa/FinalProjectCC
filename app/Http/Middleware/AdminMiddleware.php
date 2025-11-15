<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // belum login → lempar ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // sudah login tapi bukan admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized'); // atau redirect()->route('home');
        }

        return $next($request);
    }
}
