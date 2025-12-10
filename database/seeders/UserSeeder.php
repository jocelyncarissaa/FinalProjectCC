<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User (Untuk Anda login ke Dashboard)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@pharmaplus.com',
            'password' => Hash::make('password'), // passwordnya 'password'
            'phone' => '081298765432',
            'address' => '123 Admin St, Admin City',
            'role' => 'admin', // Pastikan kolom 'role' ada di tabel users, atau gunakan logic lain
        ]);

        // 2. Customer User (Untuk tes checkout)
        User::create([
            'name' => 'Budi Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => '456 Customer Rd, Customer City',
            'role' => 'user',
        ]);
    }
}