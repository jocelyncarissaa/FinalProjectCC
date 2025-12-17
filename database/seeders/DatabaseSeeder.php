<?php

//Database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder untuk data obat dan stok
        $this->call([
            UserSeeder::class,
            ItemInventorySeeder::class,
            OrderSeeder::class, // Pastikan ini dipanggil TERAKHIR karena butuh user & items
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
