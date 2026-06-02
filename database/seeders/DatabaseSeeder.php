<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@urbanfit.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Buat Kategori Pakaian
        $catTees = Category::create(['name' => 'Boxy Tees', 'slug' => 'boxy-tees']);
        $catPants = Category::create(['name' => 'Baggy Pants', 'slug' => 'baggy-pants']);
        $catShoes = Category::create(['name' => 'Sneakers', 'slug' => 'sneakers']);

        // 3. Masukkan Produk Dummy
        Product::create([
            'category_id' => $catTees->id,
            'name' => 'Puremind Cupid Oversize Boxy Tee',
            'description' => 'Kaos Hitam Polos Boxy Fit 16S Heavyweight. Cocok untuk daily wear.',
            'price' => 145000,
            'stock' => 20,
            'image' => 'default-tee.jpg' // Nanti kita atur gambarnya
        ]);

        Product::create([
            'category_id' => $catPants->id,
            'name' => 'Baggy Pants Denim Moodday Project',
            'description' => 'Celana denim baggy ala skena retro yang nyaman untuk mobilitas tinggi.',
            'price' => 280000,
            'stock' => 15,
            'image' => 'default-pants.jpg'
        ]);

        Product::create([
            'category_id' => $catShoes->id,
            'name' => 'Nike Air Max 95',
            'description' => 'Sneakers retro klasik dengan cushioning maksimal untuk gaya urban.',
            'price' => 1850000,
            'stock' => 5,
            'image' => 'default-shoes.jpg'
        ]);
        
        Product::create([
            'category_id' => $catShoes->id,
            'name' => 'ASICS Gel-Kayano 14',
            'description' => 'Running shoes retro dengan teknologi GEL untuk kenyamanan ekstra.',
            'price' => 2200000,
            'stock' => 8,
            'image' => 'default-asics.jpg'
        ]);
    }
}