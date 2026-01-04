<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class FayCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat kategori menggunakan firstOrCreate untuk menghindari duplicate
        $bags = Category::firstOrCreate(
            ['slug' => 'tas-rajut'],
            ['name' => 'Tas Rajut']
        );

        $shoes = Category::firstOrCreate(
            ['slug' => 'sepatu-rajut'],
            ['name' => 'Sepatu Rajut']
        );

        $keychain = Category::firstOrCreate(
            ['slug' => 'gantungan-kunci'],
            ['name' => 'Gantungan Kunci']
        );

        // Buat produk menggunakan updateOrCreate untuk menghindari duplicate
        Product::updateOrCreate(
            ['slug' => 'tas-rajut-fay-classic'],
            [
                'category_id' => $bags->id,
                'name'        => 'Tas Rajut Fay Classic',
                'description' => 'Tas rajut handmade dengan motif klasik, cocok untuk sehari-hari.',
                'price'       => 250000,
                'stock'       => 5,
                'main_image'  => 'images/products/tas-fay-classic.jpg',
                'is_active'   => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'gantungan-kunci-bunga-rajut'],
            [
                'category_id' => $keychain->id,
                'name'        => 'Gantungan Kunci Bunga Rajut',
                'description' => 'Gantungan kunci lucu berbentuk bunga, dibuat full handmade.',
                'price'       => 35000,
                'stock'       => 20,
                'main_image'  => 'images/products/ganci-bunga.jpg',
                'is_active'   => true,
            ]
        );

        $this->command->info('✓ Categories and products seeded successfully!');
    }
}
