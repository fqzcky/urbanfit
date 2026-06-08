<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses data login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CEK SIAPA YANG LOGIN
            if (auth()->user()->email === 'admin@urbansneakers.com') {
                // Jika admin, masuk ke dashboard
                return redirect()->route('admin.dashboard');
            } else {
                // Jika pembeli biasa, kembalikan ke halaman utama
                return redirect()->route('home')->with('success', 'Selamat datang kembali!');
            }
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan password salah.',
        ])->onlyInput('email');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}