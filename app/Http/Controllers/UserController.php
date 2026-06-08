<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ==================================================
    // 1. FITUR REGISTRASI AKUN BARU
    // ==================================================
    public function showRegister()
    {
        // KODE DIPERBAIKI: Mengarah ke resources/views/front/register.blade.php
        return view('front.register'); 
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Langsung login-kan user setelah berhasil daftar
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // ==================================================
    // 2. FITUR RIWAYAT PESANAN
    // ==================================================
    public function orders()
    {
        $transactions = Transaction::where('user_id', auth()->id())
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        // KODE DIPERBAIKI: Mengarah ke resources/views/front/orders.blade.php
        return view('front.orders', compact('transactions'));
    }

    // ==================================================
    // 3. FITUR PEMBATALAN PESANAN OLEH USER
    // ==================================================
    public function cancelOrder($id)
    {
        // 1. Pastikan pesanan ini benar-benar milik user yang sedang login
        $transaction = Transaction::where('id', $id)
                                  ->where('user_id', auth()->id())
                                  ->firstOrFail();

        // 2. Cek apakah statusnya masih PENDING
        if ($transaction->status == 'PENDING') {
            // Ubah status jadi CANCELED
            $transaction->update(['status' => 'CANCELED']);

            // 3. Kembalikan stok produk ke etalase toko
            foreach ($transaction->details as $detail) {
                if ($detail->product) {
                    $detail->product->increment('stock', $detail->quantity);
                }
            }

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan. Stok barang telah dikembalikan.');
        }

        return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
    }
}