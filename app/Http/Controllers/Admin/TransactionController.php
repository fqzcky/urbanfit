<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. Menampilkan daftar pesanan dengan Search & Scroll Bablas
    public function index(Request $request)
    {
        $query = Transaction::latest();

        // Jika ada pencarian nama pembeli atau ID (Fitur ini tetap kita pertahankan)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('id', 'like', '%' . $request->search . '%');
        }

        // MENGUBAH PAGINATION MENJADI GET() AGAR TAMPIL SEMUA
        $transactions = $query->get();
        
        return view('admin.transactions.index', compact('transactions'));
    }
    
    // ... (Fungsi show dan updateStatus biarkan sama seperti sebelumnya) ...

    // 2. Menampilkan detail pesanan beserta rincian sepatunya
    public function show($id)
    {
        // Panggil transaksi beserta relasi detail dan produknya
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    // 3. Mengubah status pesanan (PENDING -> SUCCESS / CANCELED)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,SUCCESS,CANCELED'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // Menampilkan halaman khusus untuk dicetak
    public function printInvoice($id)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);
        return view('admin.transactions.print', compact('transaction'));
    }

    // Fungsi Baru: Menyimpan atau memperbarui nomor resi pengiriman
    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
        ]);

        $transaction = Transaction::findOrFail($id);
        
        // Simpan nomor resi ke database
        $transaction->update([
            'tracking_number' => $request->tracking_number
        ]);

        return redirect()->back()->with('success', 'Nomor resi pengiriman berhasil diperbarui!');
    }
}

