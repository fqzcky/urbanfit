<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@urbansneakers.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Buat Kategori dan simpan di dalam array agar mudah dipanggil
        $categories = [
            'Running' => Category::create(['name' => 'Running', 'slug' => 'running']),
            'Basketball' => Category::create(['name' => 'Basketball', 'slug' => 'basketball']),
            'Casual Sneakers' => Category::create(['name' => 'Casual Sneakers', 'slug' => 'casual-sneakers']),
        ];

        // 3. Daftar Sepatu (Cukup tulis nama dan harga di sini nantinya)
        $sneakersData = [
            'Basketball' => [
                ['name' => 'Puma Mb.05 Lo - Green', 'price' => 1999000],
                ['name' => 'Nike Book 2 Hh Ep - Black', 'price' => 2379000],
            ],
            'Casual Sneakers' => [
                ['name' => 'Adidas Handball Spezial - Earth', 'price' => 1950000],
                ['name' => 'Nike Air Max Plus TN - Black', 'price' => 2199000],
                ['name' => 'Asics Gel-NYC - Obsidian Grey', 'price' => 2400000],
            ],
            'Running' => [
                ['name' => 'ASICS Gel-Kayano 14', 'price' => 2200000],
            ]
        ];

        // 4. Proses Input Otomatis (Looping)
        foreach ($sneakersData as $categoryName => $shoes) {
            foreach ($shoes as $shoe) {
                Product::create([
                    'category_id' => $categories[$categoryName]->id,
                    'name'        => $shoe['name'],
                    // Deskripsi otomatis menyesuaikan nama kategori
                    'description' => "Sepatu $categoryName premium dengan desain ikonik dan material berkualitas tinggi. Sangat nyaman untuk menunjang performa dan gaya urban Anda.",
                    'price'       => $shoe['price'],
                    // Stok diacak otomatis dari angka 5 sampai 25
                    'stock'       => rand(5, 25),
                    'image'       => 'default-shoes.jpg' // Nanti gambar asli bisa diupdate dari panel Admin
                ]);
            }
        }
    }
}