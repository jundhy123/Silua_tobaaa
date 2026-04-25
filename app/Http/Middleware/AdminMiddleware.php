<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Cek apakah sudah login DAN apakah rolenya admin
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }

    // Jika bukan admin, tendang balik ke halaman depan
    return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
}
}