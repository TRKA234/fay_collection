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
         User::updateOrCreate(
            ['email' => 'admin@faycollection.test'], // cek by email
            [
                'name' => 'Fay Admin',
                'password' => Hash::make('password123'), // password bisa diganti nanti
            ]
        );
    }
}
