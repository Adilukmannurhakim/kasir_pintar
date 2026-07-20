<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user ada di dalam daftar yang diizinkan
        $user = Auth::user();
        // MENGUBAH SEMUA PARAMETER MENJADI HURUF KECIL AGAR AMAN
        $lowerRoles = array_map('strtolower', $roles);
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya hak akses, kembalikan ke dashboard
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini!');
    }
}