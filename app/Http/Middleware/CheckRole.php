<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        // Periksa apakah pengguna telah terotentikasi
        // if (!auth()->check()) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }
        // Mendapatkan role pengguna saat ini
        // $userRole = auth()->user()->permission;
        $userRole = auth()->user()->hasRole($role);

        // Memeriksa apakah role pengguna saat ini sesuai dengan salah satu dari roles yang diizinkan
        // if (!in_array($userRole, $roles)) {
        //     return response()->json(['message' => 'Anda tidak bisa akses halaman ini.'], 403);
        // }

        if (!in_array($userRole, $role)) {
            return redirect('dashboard')->with('error', 'You do not have access to this section');
        }

        // Lanjutkan ke rute jika role pengguna sesuai
        return $next($request);
    }
}
