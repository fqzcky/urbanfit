<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;

// Halaman Publik
Route::get('/', [FrontController::class, 'index'])->name('home');

// Halaman Auth (Hanya untuk tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

// Halaman Admin (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Semua rute di dalam grup ini akan ditambahkan awalan /admin dan nama admin.
    Route::prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        // Rute CRUD Produk
        Route::resource('products', ProductController::class);
        
    });
});