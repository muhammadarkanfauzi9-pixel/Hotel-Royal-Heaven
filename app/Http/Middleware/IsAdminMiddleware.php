<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecekan apakah pengguna sudah login DAN level-nya adalah 'admin'.
        if (Auth::check() && Auth::user()->level === 'admin') { 
            return $next($request);
        }

        // Jika tidak, tolak akses dan redirect ke halaman utama.
        return redirect('/')->with('error', 'Akses Ditolak. Anda tidak memiliki izin Admin.');
    }
}