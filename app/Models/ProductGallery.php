<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image'];

    // Relasi: Galeri ini milik satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}