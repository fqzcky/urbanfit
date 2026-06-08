<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\OngkirController;

// ==========================================
// 1. HALAMAN PUBLIK (Bisa diakses siapa saja)
// ==========================================
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/product/{id}', [FrontController::class, 'show'])->name('product.show');

// Rute Keranjang & Checkout
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [CartController::class, 'process'])->name('checkout.process');
Route::get('/checkout/pay/{id}', [CartController::class, 'pay'])->name('checkout.pay');

// Rute Webhook Midtrans (Notifikasi otomatis dari server ke server)
Route::post('/midtrans/callback', [CartController::class, 'callback']);

// ==========================================
// RUTE API INTERNAL KOMERCE (ONGKIR)
// ==========================================
Route::get('/ongkir/provinces', [OngkirController::class, 'getProvinces'])->name('ongkir.provinces');
Route::get('/ongkir/cities/{provinceId}', [OngkirController::class, 'getCities'])->name('ongkir.cities');
Route::get('/ongkir/districts/{cityId}', [OngkirController::class, 'getDistricts'])->name('ongkir.districts');
Route::post('/ongkir/cost', [OngkirController::class, 'checkCost'])->name('ongkir.cost');



// ==========================================
// 2. HALAMAN TAMU (Belum Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'processRegister'])->name('register.process');
});


// ==========================================
// 3. HALAMAN TERPROTEKSI (Wajib Login)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Rute Global (Pembeli maupun Admin bisa akses)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rute Khusus Pembeli
    Route::get('/riwayat-pesanan', [UserController::class, 'orders'])->name('user.orders');
    // Rute untuk membatalkan pesanan oleh User
    Route::put('/riwayat-pesanan/{id}/cancel', [\App\Http\Controllers\UserController::class, 'cancelOrder'])->name('user.order.cancel');
    
    // ==========================================
    // 3.B. RUTE KHUSUS ADMIN (Hanya admin@urbansneakers.com)
    // ==========================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', function () {
            // Hitung data langsung dari Model
            $totalProducts = \App\Models\Product::count();
            $successfulOrders = \App\Models\Transaction::where('status', 'SUCCESS')->count();
            $totalRevenue = \App\Models\Transaction::where('status', 'SUCCESS')->sum('total_price');
            
            // Lempar datanya ke tampilan dashboard
            return view('admin.dashboard', compact('totalProducts', 'successfulOrders', 'totalRevenue'));
        })->name('dashboard');
        
        // CRUD Produk
        Route::resource('products', ProductController::class);
        
        // Manajemen Pesanan & Cetak
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::put('/transactions/{id}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
        Route::get('/transactions/{id}/print', [TransactionController::class, 'printInvoice'])->name('transactions.print');

        // JALUR RUTE Untuk menyimpan nomor resi ekspedisi
        Route::put('/transactions/{id}/tracking', [TransactionController::class, 'updateTracking'])->name('transactions.updateTracking');
        
        Route::get('/transactions/{id}/print', [TransactionController::class, 'printInvoice'])->name('transactions.print');
        
    });
});