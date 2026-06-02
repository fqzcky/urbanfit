<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Mengizinkan kolom ini diisi data
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock', 'image'];

    // Relasi: 1 Produk dimiliki oleh 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}