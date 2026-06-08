<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Midtrans\Config;
use Midtrans\Snap;

class CartController extends Controller
{
    public function index()
    {
        // Ambil data keranjang dari Session
        $cart = session()->get('cart', []);
        
        // Hitung total harga semua barang di keranjang
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('front.cart', compact('cart', 'totalPrice'));
    }

    public function add(Request $request, $id)
    {
        // Pastikan user benar-benar memilih ukuran
        $request->validate([
            'size' => 'required'
        ]);

        $product = Product::findOrFail($id);

        // Ambil data keranjang dari memori sementara (Session), jika kosong jadikan array []
        $cart = session()->get('cart', []);

        // Buat ID unik kombinasi produk dan ukuran (Misal: Sepatu ID 22 ukuran 41 -> "22-41")
        $cartKey = $id . '-' . $request->size;

        // Jika sepatu dengan ukuran yang sama sudah ada di keranjang, tambah jumlahnya
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            // Jika belum ada, masukkan sebagai barang baru di keranjang
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'size'       => $request->size,
                'price'      => $product->price,
                'image'      => $product->image,
                'quantity'   => 1
            ];
        }

        // Simpan kembali ke dalam Session
        session()->put('cart', $cart);

        // Kembalikan user ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Berhasil masuk keranjang!');
    }

    // Menghapus produk dari keranjang
    public function remove($key)
    {
        // Ambil data keranjang saat ini
        $cart = session()->get('cart', []);

        // Cek apakah produk dengan ID unik (key) tersebut ada di keranjang
        if (isset($cart[$key])) {
            unset($cart[$key]); // Hapus dari array
            session()->put('cart', $cart); // Simpan kembali array yang sudah diperbarui ke memori
        }

        return redirect()->route('cart.index')->with('success', 'Sepatu berhasil dihapus dari keranjang!');
    }

    // Menampilkan halaman form pengisian alamat
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        // Jika keranjang kosong, paksa kembali ke halaman keranjang
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('front.checkout', compact('cart', 'totalPrice'));
    }

    // Memproses data form dan menyimpannya ke database
    // Memproses data form dan menyimpannya ke database
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home');
        }

        // 1. TAMBAHAN BARU: Validasi shipping_cost agar wajib diisi dan berupa angka
        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'shipping_cost' => 'required|numeric' 
        ]);

        // 2. Hitung harga sepatu saja (Subtotal)
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // 3. KODE BARU: Tangkap ongkir dan hitung Total Akhir
        $shippingCost = $request->shipping_cost;
        $finalTotal   = $subtotal + $shippingCost;

        // 4. Simpan Data Induk transaksi
        $transaction = Transaction::create([
            'user_id'     => auth()->id(), 
            'name'        => $request->name,
            'phone'       => $request->phone,
            'address'     => $request->address,
            // Gunakan $finalTotal agar angka yang masuk DB sudah termasuk ongkir
            'total_price' => $finalTotal, 
            'status'      => 'PENDING'
        ]);

        // 5. Simpan Rincian Barang dan Potong Stok
        foreach ($cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['product_id'],
                'size'           => $item['size'],
                'price'          => $item['price'],
                'quantity'       => $item['quantity']
            ]);

            $product = Product::find($item['product_id']);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        // 6. Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 7. Buat Parameter Pembayaran untuk Midtrans
        $params = array(
            'transaction_details' => array(
                'order_id' => 'TRX-' . $transaction->id . '-' . time(),
                // Angka yang dilempar ke Midtrans akan persis sama dengan $finalTotal
                'gross_amount' => $transaction->total_price, 
            ),
            'customer_details' => array(
                'first_name' => $transaction->name,
                'phone' => $transaction->phone,
            ),
        );

        // 8. Dapatkan Snap Token dari Midtrans dan simpan ke database
        $snapToken = Snap::getSnapToken($params);
        $transaction->snap_token = $snapToken;
        $transaction->save();

        // 9. Kosongkan keranjang
        session()->forget('cart');

        // 10. Arahkan pembeli ke halaman khusus pembayaran
        return redirect()->route('checkout.pay', $transaction->id);
    }
    // Menampilkan halaman tombol pembayaran Midtrans
    public function pay($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('front.pay', compact('transaction'));
    }

    // Menerima notifikasi otomatis dari Midtrans (Webhook)
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        // Validasi keamanan dari Midtrans
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            // Kita pisahkan 'TRX-12-16000000' untuk mengambil angka 12 (ID Transaksi)
            $parts = explode('-', $request->order_id);
            $trx_id = $parts[1];
            $transaction = Transaction::find($trx_id);
            
            if ($transaction) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $transaction->update(['status' => 'SUCCESS']);
                } else if (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                    $transaction->update(['status' => 'CANCELED']);
                    
                    // Kembalikan stok jika batal
                    foreach ($transaction->details as $detail) {
                        if ($detail->product) {
                            $detail->product->stock += $detail->quantity;
                            $detail->product->save();
                        }
                    }
                }
            }
        }
        
        return response()->json(['message' => 'Callback received']);
    }
}