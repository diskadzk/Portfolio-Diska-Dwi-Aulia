<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $mitra = User::where('role', 'mitra')->first();

        if ($mitra) {
            Product::create([
                'user_id' => $mitra->id,
                'name' => 'Beras Merah Organik',
                'category' => 'Beras Merah',
                'price' => 25000,
                'stock' => 100,
                'image' => 'products/beras-merah.jpg' // Nanti kita siapkan gambarnya
            ]);

            Product::create([
                'user_id' => $mitra->id,
                'name' => 'Beras Putih Cianjur',
                'category' => 'Beras Putih',
                'price' => 15000,
                'stock' => 500,
                'image' => 'products/beras-putih.jpg'
            ]);
        }
    }
}