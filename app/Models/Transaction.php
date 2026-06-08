<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Tambahkan user_id, snap_token, dan tracking_number
    protected $fillable = [
        'user_id', 
        'name', 
        'phone', 
        'address', 
        'total_price', 
        'status', 
        'snap_token', 
        'tracking_number' // <--- INI DIA KUNCI AGAR RESI BISA TERSIMPAN
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Relasi baru: Satu transaksi dimiliki oleh satu user (jika login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}