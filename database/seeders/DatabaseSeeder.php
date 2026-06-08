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

        // 2. Buat Kategori
        $categories = [
            'Running' => Category::create(['name' => 'Running', 'slug' => 'running']),
            'Basketball' => Category::create(['name' => 'Basketball', 'slug' => 'basketball']),
            'Casual Sneakers' => Category::create(['name' => 'Casual Sneakers', 'slug' => 'casual-sneakers']),
        ];

        // 3. Daftar 12 Sepatu Premium (Lengkap dengan Klasifikasi Gender)
        $sneakersData = [
            'Basketball' => [
                ['name' => 'Puma Mb.05 Lo - Green', 'price' => 1999000, 'gender' => 'Pria'],
                ['name' => 'Nike Book 2 Hh Ep - Black', 'price' => 2379000, 'gender' => 'Pria'],
                ['name' => 'Adidas Anthony Edwards 1', 'price' => 2199000, 'gender' => 'Pria'],
            ],
            'Casual Sneakers' => [
                ['name' => 'Adidas Handball Spezial - Earth Str', 'price' => 1950000, 'gender' => 'Unisex'],
                ['name' => 'Nike Air Max Plus TN - Black', 'price' => 2199000, 'gender' => 'Pria'],
                ['name' => 'Asics Gel-NYC - Obsidian Grey', 'price' => 2400000, 'gender' => 'Unisex'],
                ['name' => 'Adidas Samba OG - Cloud White', 'price' => 2200000, 'gender' => 'Unisex'],
                ['name' => 'Nike Dunk Low - Panda W', 'price' => 1549000, 'gender' => 'Wanita'],
                ['name' => 'New Balance 550 - White Green', 'price' => 2099000, 'gender' => 'Pria'],
            ],
            'Running' => [
                ['name' => 'ASICS Gel-Kayano 14 - Cream Black', 'price' => 2399000, 'gender' => 'Unisex'],
                ['name' => 'Nike Pegasus 41 - Volt', 'price' => 2049000, 'gender' => 'Pria'],
                ['name' => 'Adidas UltraBoost 1.0 - Triple White', 'price' => 3300000, 'gender' => 'Wanita'],
            ]
        ];

        // 4. Looping Input Otomatis
        foreach ($sneakersData as $categoryName => $shoes) {
            foreach ($shoes as $shoe) {
                Product::create([
                    'category_id' => $categories[$categoryName]->id,
                    'gender'      => $shoe['gender'], // <-- Menyimpan data gender baru
                    'name'        => $shoe['name'],
                    'description' => "Sepatu kategori $categoryName kelas premium yang dirancang khusus untuk kenyamanan maksimal. Siluet ini sangat cocok untuk menunjang performa kegiatan maupun gaya urban streetwear Anda sehari-hari.",
                    'price'       => $shoe['price'],
                    'stock'       => rand(5, 25),
                    'image'       => 'default-shoes.jpg' 
                ]);
            }
        }
    }
}