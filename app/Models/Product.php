<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Mengizinkan kolom ini diisi data
    protected $fillable = ['category_id', 'gender', 'name', 'description', 'price', 'stock', 'image', 'sizes'];
    
    protected $casts = [
        'sizes' => 'array',
    ];
    // Relasi lama (Kategori)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi BARU: Satu produk punya banyak foto galeri (One-to-Many)
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }
}