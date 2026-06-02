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

    // Menampilkan Halaman Detail Produk
    public function show($id)
    {
        $product = Product::with(['category', 'galleries'])->findOrFail($id);
        
        // Bonus: Ambil 4 produk acak dari kategori yang sama (kecuali produk ini sendiri)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $id)
                                  ->inRandomOrder()
                                  ->take(4)
                                  ->get();
        
        return view('front.show', compact('product', 'relatedProducts'));
    }
}