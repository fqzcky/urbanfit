<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    // Menampilkan Tabel Produk
    public function index()
    {
        // Ambil produk dan kategorinya, urutkan dari yang terbaru
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Menampilkan Form Tambah Produk
    public function create()
    {
        // Ambil data kategori untuk pilihan di dropdown form
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    
    // ... (biarkan fungsi store, show, edit, update, destroy kosong untuk saat ini)

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi keamanan (pastikan format input sesuai)
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Proses upload gambar ke folder 'storage/app/public/products'
        $imagePath = $request->file('image')->store('products', 'public');

        // 3. Simpan semua data ke tabel 'products'
        Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        // 4. Kembalikan pengguna ke halaman tabel dengan pesan sukses
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk baru berhasil ditambahkan beserta fotonya!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Menampilkan Form Edit
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Memproses Perubahan Data
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Boleh kosong jika tidak ganti foto
        ]);

        $product = Product::findOrFail($id);
        $imagePath = $product->image; // Simpan path gambar lama secara default

        // Jika admin mengupload foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama dari server
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan foto baru
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    // Menghapus Data Produk
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Hapus foto fisik dari server agar memori tidak bengkak
        if (Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete(); // Hapus data dari database

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
