<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

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

        $wallet = Category::firstOrCreate(
            ['slug' => 'dompet-rajut'],
            ['name' => 'Dompet Rajut']
        );

        $hat = Category::firstOrCreate(
            ['slug' => 'topi-rajut'],
            ['name' => 'Topi Rajut']
        );

        $accessories = Category::firstOrCreate(
            ['slug' => 'aksesoris-rajut'],
            ['name' => 'Aksesoris Rajut']
        );

        // Array produk dengan data lengkap
        $products = [
            // Tas Rajut (6 produk)
            [
                'category' => $bags,
                'name' => 'Tas Rajut Fay Classic',
                'slug' => 'tas-rajut-fay-classic',
                'description' => 'Tas rajut handmade dengan motif klasik, cocok untuk sehari-hari. Dibuat dengan benang berkualitas tinggi dan desain yang timeless.',
                'price' => 250000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800&h=800&fit=crop',
            ],
            [
                'category' => $bags,
                'name' => 'Tas Rajut Tote Bag',
                'slug' => 'tas-rajut-tote-bag',
                'description' => 'Tote bag rajut yang roomy dan praktis. Perfect untuk belanja atau aktivitas sehari-hari. Tersedia dalam berbagai warna.',
                'price' => 180000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=800&fit=crop',
            ],
            [
                'category' => $bags,
                'name' => 'Tas Rajut Mini Crossbody',
                'slug' => 'tas-rajut-mini-crossbody',
                'description' => 'Tas kecil yang lucu dan praktis. Cocok untuk membawa essentials seperti dompet, handphone, dan lipstik.',
                'price' => 120000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=800&h=800&fit=crop',
            ],
            [
                'category' => $bags,
                'name' => 'Tas Rajut Backpack',
                'slug' => 'tas-rajut-backpack',
                'description' => 'Backpack rajut yang nyaman dan stylish. Cocok untuk aktivitas outdoor atau sebagai tas sekolah yang unik.',
                'price' => 320000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?w=800&h=800&fit=crop',
            ],
            [
                'category' => $bags,
                'name' => 'Tas Rajut Bucket Bag',
                'slug' => 'tas-rajut-bucket-bag',
                'description' => 'Bucket bag dengan desain modern dan fungsional. Tali yang bisa diatur panjangnya membuatnya sangat fleksibel.',
                'price' => 280000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800&h=800&fit=crop',
            ],
            [
                'category' => $bags,
                'name' => 'Tas Rajut Shoulder Bag',
                'slug' => 'tas-rajut-shoulder-bag',
                'description' => 'Shoulder bag elegan dengan strap yang nyaman. Desain minimalis namun tetap eye-catching.',
                'price' => 200000,
                'stock' => 22,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=800&fit=crop',
            ],

            // Sepatu Rajut (4 produk)
            [
                'category' => $shoes,
                'name' => 'Sepatu Rajut Sneakers',
                'slug' => 'sepatu-rajut-sneakers',
                'description' => 'Sneakers rajut yang nyaman dan stylish. Cocok untuk aktivitas sehari-hari dengan desain yang unik dan eye-catching.',
                'price' => 450000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&h=800&fit=crop',
            ],
            [
                'category' => $shoes,
                'name' => 'Sepatu Rajut Slip On',
                'slug' => 'sepatu-rajut-slip-on',
                'description' => 'Slip on rajut yang praktis dan mudah dipakai. Tanpa tali, sangat cocok untuk aktivitas santai.',
                'price' => 380000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&h=800&fit=crop',
            ],
            [
                'category' => $shoes,
                'name' => 'Sepatu Rajut Boots',
                'slug' => 'sepatu-rajut-boots',
                'description' => 'Boots rajut dengan desain yang trendy. Cocok untuk musim hujan atau style yang lebih bold.',
                'price' => 520000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1608256246200-53bd35f133f0?w=800&h=800&fit=crop',
            ],
            [
                'category' => $shoes,
                'name' => 'Sepatu Rajut Flats',
                'slug' => 'sepatu-rajut-flats',
                'description' => 'Flats rajut yang nyaman untuk berjalan. Desain simple namun elegant, cocok untuk berbagai kesempatan.',
                'price' => 350000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&h=800&fit=crop',
            ],

            // Gantungan Kunci (4 produk)
            [
                'category' => $keychain,
                'name' => 'Gantungan Kunci Bunga Rajut',
                'slug' => 'gantungan-kunci-bunga-rajut',
                'description' => 'Gantungan kunci lucu berbentuk bunga, dibuat full handmade. Perfect sebagai hadiah atau koleksi pribadi.',
                'price' => 35000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=800&fit=crop',
            ],
            [
                'category' => $keychain,
                'name' => 'Gantungan Kunci Karakter Lucu',
                'slug' => 'gantungan-kunci-karakter-lucu',
                'description' => 'Gantungan kunci dengan karakter lucu seperti hewan atau emoji. Sangat menggemaskan dan unik.',
                'price' => 40000,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=800&fit=crop',
            ],
            [
                'category' => $keychain,
                'name' => 'Gantungan Kunci Mini Bag',
                'slug' => 'gantungan-kunci-mini-bag',
                'description' => 'Gantungan kunci berbentuk mini bag yang sangat detail. Cocok untuk para pecinta fashion.',
                'price' => 45000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=800&h=800&fit=crop',
            ],
            [
                'category' => $keychain,
                'name' => 'Gantungan Kunci Heart Shape',
                'slug' => 'gantungan-kunci-heart-shape',
                'description' => 'Gantungan kunci berbentuk hati yang romantis. Perfect untuk hadiah valentine atau anniversary.',
                'price' => 30000,
                'stock' => 55,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=800&fit=crop',
            ],

            // Dompet Rajut (3 produk)
            [
                'category' => $wallet,
                'name' => 'Dompet Rajut Coin Purse',
                'slug' => 'dompet-rajut-coin-purse',
                'description' => 'Dompet kecil untuk koin dan uang receh. Praktis dan mudah dibawa kemana-mana.',
                'price' => 75000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800&h=800&fit=crop',
            ],
            [
                'category' => $wallet,
                'name' => 'Dompet Rajut Card Holder',
                'slug' => 'dompet-rajut-card-holder',
                'description' => 'Card holder rajut yang slim dan compact. Cocok untuk menyimpan kartu ATM, KTP, dan kartu lainnya.',
                'price' => 95000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1622556788540-4a0e8c0a0c0c?w=800&h=800&fit=crop',
            ],
            [
                'category' => $wallet,
                'name' => 'Dompet Rajut Zipper',
                'slug' => 'dompet-rajut-zipper',
                'description' => 'Dompet rajut dengan resleting untuk keamanan lebih. Tersedia beberapa kompartemen untuk organisasi yang lebih baik.',
                'price' => 120000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800&h=800&fit=crop',
            ],

            // Topi Rajut (2 produk)
            [
                'category' => $hat,
                'name' => 'Topi Rajut Beanie',
                'slug' => 'topi-rajut-beanie',
                'description' => 'Beanie rajut yang hangat dan nyaman. Cocok untuk musim hujan atau cuaca dingin. Tersedia berbagai warna.',
                'price' => 150000,
                'stock' => 28,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&h=800&fit=crop',
            ],
            [
                'category' => $hat,
                'name' => 'Topi Rajut Bucket Hat',
                'slug' => 'topi-rajut-bucket-hat',
                'description' => 'Bucket hat rajut yang trendy dan stylish. Perfect untuk melindungi dari sinar matahari sambil tetap fashionable.',
                'price' => 180000,
                'stock' => 22,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&h=800&fit=crop',
            ],

            // Aksesoris Rajut (3 produk)
            [
                'category' => $accessories,
                'name' => 'Scrunchie Rajut Premium',
                'slug' => 'scrunchie-rajut-premium',
                'description' => 'Scrunchie rajut yang lembut dan tidak merusak rambut. Tersedia dalam berbagai warna dan motif.',
                'price' => 55000,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&h=800&fit=crop',
            ],
            [
                'category' => $accessories,
                'name' => 'Headband Rajut',
                'slug' => 'headband-rajut',
                'description' => 'Headband rajut yang nyaman dan stylish. Cocok untuk olahraga atau aktivitas sehari-hari.',
                'price' => 65000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&h=800&fit=crop',
            ],
            [
                'category' => $accessories,
                'name' => 'Sarung Tangan Rajut',
                'slug' => 'sarung-tangan-rajut',
                'description' => 'Sarung tangan rajut yang hangat dan nyaman. Perfect untuk musim hujan atau cuaca dingin.',
                'price' => 85000,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=800&h=800&fit=crop',
            ],
        ];

        // Insert semua produk
        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['slug' => $productData['slug']],
                [
                    'category_id' => $productData['category']->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'main_image' => $productData['image'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✓ ' . count($products) . ' products seeded successfully across ' . Category::count() . ' categories!');
    }
}
