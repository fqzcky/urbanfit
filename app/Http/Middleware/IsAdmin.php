<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika sudah login DAN emailnya adalah email admin, silakan lewat
        if (auth()->check() && auth()->user()->email === 'admin@urbansneakers.com') {
            return $next($request);
        }

        // Jika pembeli biasa mencoba mengakses rute admin, tendang ke halaman depan!
        return redirect()->route('home')->with('success', 'Akses ditolak. Anda bukan admin.');
    }
}