<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    
    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Coba otentikasi pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Auth::user()->role;

            return redirect()->intended('dashboard');
        }

        // Jika gagal login
        return redirect('/')->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); // Logout pengguna yang sedang aktif

        // Menghapus semua sesi pengguna agar tidak bisa digunakan kembali
        $request->session()->invalidate();

        // Regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman utama setelah logout
        return redirect('/');
    }
}