<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            // Pengguna belum login
            return redirect()->route('login');
        }

        // $user = User::find(Auth::id());
        // if (!$user->hasPermission($permission)) {
        //     // Pengguna tidak memiliki izin yang diperlukan
        //     abort(403, 'Anda Tidak Memiliki Izin Mengakses Halaman Ini!');
        // }

        // return $next($request);

        $user = Auth::user();

        // Log::info('User ID: ' . Auth::id());
        // Log::info('Checking permission in middleware: ' . $permission);

        // Cek apakah user punya permission yang sesuai
        if ($user && $user->hasPermission($permission)) {
            return $next($request);
        }


        // Jika tidak punya permission, redirect atau beri respon sesuai keinginan
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
