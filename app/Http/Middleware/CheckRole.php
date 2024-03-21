<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna telah terotentikasi
        // if (!auth()->check()) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }
        // Mendapatkan role pengguna saat ini
        $userRole = auth()->user()->permission;

        // Memeriksa apakah role pengguna saat ini sesuai dengan salah satu dari roles yang diizinkan
        if (!in_array($userRole, $roles)) {
            return response()->json(['message' => 'Anda tidak bisa akses halaman ini.'], 403);
        }

        // Lanjutkan ke rute jika role pengguna sesuai
        return $next($request);
    }
}
