<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGallery;
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
        // 1. Validasi Input Data (Disamakan huruf besar di depan)
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'sizes'       => 'required|array|min:1',
            'category_id' => 'required|exists:categories,id',
            'gender'      => 'required|in:Men,Women,Unisex', // PENYAKIT GENDER DISEMBUHKAN DI SINI
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galleries.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 2. Proses Upload Foto Utama
        $imagePath = $request->file('image')->store('products', 'public');

        // 3. Simpan Data Produk Baru ke Database
        $product = \App\Models\Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'sizes'       => $request->sizes, // TANPA json_encode() AGAR TIDAK ERROR DI HALAMAN DETAIL
            'category_id' => $request->category_id,
            'gender'      => $request->gender,
            'image'       => $imagePath,
        ]);

        // 4. Proses Upload Galeri Tambahan (Jika Ada)
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $galleryPath = $file->store('galleries', 'public');
                $product->galleries()->create([
                    'image' => $galleryPath
                ]);
            }
        }

        // 5. Kembalikan ke halaman manajemen produk
        return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil ditambahkan!');
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
    // Memproses Perubahan Data
    public function update(Request $request, $id)
    {
        // 1. Validasi Input Data (Disamakan huruf besar di depan sesuai edit.blade.php)
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'sizes'       => 'required|array|min:1',
            'category_id' => 'required|exists:categories,id',
            'gender'      => 'required|in:Men,Women,Unisex', // SENSITIF HURUF BESAR KECIL!
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galleries.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 2. Ambil Data Produk dari Database
        $product = \App\Models\Product::findOrFail($id);

        // 3. Proses Upload Foto Utama Jika Ada Penggantian
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus foto lama jika filenya ada di storage
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 4. Perbarui Data Produk ke Database
        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'sizes'       => $request->sizes, 
            'category_id' => $request->category_id,
            'gender'      => $request->gender,
            'image'       => $imagePath,
        ]);

        // 5. Proses Upload Galeri Tambahan Jika Ada Penggantian
        if ($request->hasFile('galleries')) {
            // Hapus riwayat galeri lama di tabel ProductGallery (jika relasi model kamu ada)
            if (method_exists($product, 'galleries')) {
                foreach ($product->galleries as $gallery) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->image)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->image);
                    }
                    $gallery->delete();
                }

                // Masukkan foto galeri baru
                foreach ($request->file('galleries') as $file) {
                    $galleryPath = $file->store('galleries', 'public');
                    $product->galleries()->create([
                        'image' => $galleryPath
                    ]);
                }
            }
        }

        // 6. Kembalikan ke halaman manajemen produk dengan notifikasi sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
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
