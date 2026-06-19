<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Buat pondasi query
        $query = Product::with('category')->latest();

        // Fitur 1: Filter Kategori
        if ($request->filled('kategori')) {
            $category = Category::where('slug', $request->kategori)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        // Fitur 2: Pencarian (Search Bar)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Fitur 3: Paginasi (tampilkan 8 produk per halaman)
        // withQueryString() berguna agar saat pindah halaman, filter/search-nya tidak hilang
        $products = $query->paginate(8)->withQueryString(); 
        
        return view('front.index', compact('products', 'categories'));
    }

        public function show($id)
    {
        // 1. Ambil data produk yang sedang dilihat
        $product = Product::with('category')->findOrFail($id);
        
        // 2. AMBIL FITUR BARU: 4 Produk serupa dengan kategori sama, kecuali produk itu sendiri
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Supaya produk yang sama tidak muncul lagi di bawah
            ->latest()
            ->take(4) // Batasi cuma muncul 4 produk biar rapi sejajar
            ->get();

        // 3. Lempar kedua data tersebut ke file blade detail produk
        return view('front.show', compact('product', 'relatedProducts'));
    }
}