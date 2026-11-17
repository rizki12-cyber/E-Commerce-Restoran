<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Nasi Ayam Bakar', 'category_id' => 2, 'price' => 25000, 'stock' => 50],
            ['name' => 'Nasi Ayam Geprek', 'category_id' => 2, 'price' => 22000, 'stock' => 40],
            ['name' => 'Nasi Goreng Spesial', 'category_id' => 3, 'price' => 20000, 'stock' => 30],
            ['name' => 'Mie Goreng Jawa', 'category_id' => 4, 'price' => 18000, 'stock' => 25],
            ['name' => 'Kentang Goreng', 'category_id' => 5, 'price' => 15000, 'stock' => 100],
            ['name' => 'Es Teh Manis', 'category_id' => 6, 'price' => 5000, 'stock' => 200],
            ['name' => 'Es Jeruk', 'category_id' => 6, 'price' => 8000, 'stock' => 150],
            ['name' => 'Paket Hemat Ayam + Es Teh', 'category_id' => 7, 'price' => 28000, 'stock' => 20],
        ];

        foreach ($products as $item) {
            Product::create([
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'sku' => strtoupper(Str::random(8)),
                'description' => 'Deskripsi lezat untuk ' . $item['name'],
                'price' => $item['price'],
                'stock' => $item['stock'],
                'is_active' => true,
                'is_featured' => rand(0, 1) === 1,
                'is_best_seller' => rand(0, 1) === 1,
            ]);
        }
    }
}