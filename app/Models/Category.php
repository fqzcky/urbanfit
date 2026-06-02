<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Mengizinkan kolom ini diisi data (Mass Assignment)
    protected $fillable = ['name', 'slug'];

    // Relasi: 1 Kategori punya banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
