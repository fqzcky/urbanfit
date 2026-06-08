<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'size', 'price', 'quantity'];

    // Relasi: Rincian ini milik sebuah transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi: Rincian ini merujuk ke produk sepatu tertentu
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}