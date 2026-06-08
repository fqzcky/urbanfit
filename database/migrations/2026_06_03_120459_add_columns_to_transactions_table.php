<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // nullable() artinya pembeli yang belum login (guest) tetap bisa checkout
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Kolom untuk menyimpan token unik dari Midtrans
            $table->string('snap_token')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'snap_token']);
        });
    }
};