<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login admin buku tamu.
     */
    public function showLoginForm()
    {
        // Pastikan Anda sudah membuat file resources/views/login.blade.php
        return view('login');
    }

    /**
     * Menangani permintaan login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        /**
         * 2. Mencoba Autentikasi
         * Laravel akan otomatis mengecek ke database yang dikonfigurasi di .env
         * (db_diskominfo) pada tabel 'users' sesuai Model User kita.
         */
        if (Auth::attempt($credentials)) {
            // Jika berhasil, buat sesi baru (regenerate) untuk keamanan
            $request->session()->regenerate();

            // Arahkan ke halaman dashboard admin
            return redirect()->intended('admin');
        }

        // 3. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password tidak terdaftar di sistem Agenda.',
        ])->onlyInput('email');
    }

    /**
     * Menangani permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hancurkan sesi dan buat ulang token CSRF agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}