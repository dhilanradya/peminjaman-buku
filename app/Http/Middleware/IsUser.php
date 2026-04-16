<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            if (Auth::check()) {
                Auth::logout();
            }
            return redirect()->route('user.login')
                ->with('error', 'Tidak dapat diakses');
        }

        return $next($request);
    }
}
