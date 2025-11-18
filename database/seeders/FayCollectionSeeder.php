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
        $bags = Category::create([
            'name' => 'Tas Rajut',
            'slug' => 'tas-rajut',
        ]);

        $shoes = Category::create([
            'name' => 'Sepatu Rajut',
            'slug' => 'sepatu-rajut',
        ]);

        $keychain = Category::create([
            'name' => 'Gantungan Kunci',
            'slug' => 'gantungan-kunci',
        ]);

        Product::create([
            'category_id' => $bags->id,
            'name'        => 'Tas Rajut Fay Classic',
            'slug'        => 'tas-rajut-fay-classic',
            'description' => 'Tas rajut handmade dengan motif klasik, cocok untuk sehari-hari.',
            'price'       => 250000,
            'stock'       => 5,
            'main_image'  => 'images/products/tas-fay-classic.jpg',
            'is_active'   => true,
        ]);

        Product::create([
            'category_id' => $keychain->id,
            'name'        => 'Gantungan Kunci Bunga Rajut',
            'slug'        => 'gantungan-kunci-bunga-rajut',
            'description' => 'Gantungan kunci lucu berbentuk bunga, dibuat full handmade.',
            'price'       => 35000,
            'stock'       => 20,
            'main_image'  => 'images/products/ganci-bunga.jpg',
            'is_active'   => true,
        ]);
    }
}
