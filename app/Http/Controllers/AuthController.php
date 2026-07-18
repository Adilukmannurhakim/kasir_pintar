<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard'); // Jika sudah login, langsung ke dashboard
        }
        return view('auth.login');
    }

    // Memproses aksi login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Proses autentikasi menggunakan Auth Laravel
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Jika salah, kembali ke login dengan pesan error
        return back()->withErrors([
            'loginError' => 'Username atau password yang Anda masukkan salah!',
        ])->withInput();
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}