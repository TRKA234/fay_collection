<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin utama
        $admin = User::updateOrCreate(
            ['email' => 'admin@faycollection.test'],
            [
                'name' => 'Fay Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $this->command->info('✓ Admin user created/updated:');
        $this->command->info('  Email: admin@faycollection.test');
        $this->command->info('  Password: admin123');
        $this->command->warn('  ⚠️  PENTING: Ganti password setelah login pertama kali!');

        // Optional: Admin kedua (jika diperlukan)
        // $admin2 = User::updateOrCreate(
        //     ['email' => 'admin2@faycollection.test'],
        //     [
        //         'name' => 'Admin 2',
        //         'password' => Hash::make('admin123'),
        //         'role' => 'admin',
        //     ]
        // );
    }
}
