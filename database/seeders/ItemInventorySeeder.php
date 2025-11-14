<?php

// database/seeders/ItemInventorySeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class ItemInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('database/seeders/medicine_dataset.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found. Please ensure 'medicine_dataset.csv' is in the database/seeders/ folder.");
            return;
        }

        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Ambil header: Name,Category,Dosage Form,Strength,Manufacturer,Indication,Classification

        // Tentukan indeks kolom dari header CSV
        $columnMap = array_flip($header); 

        DB::transaction(function () use ($file, $columnMap) {
            $count = 0;
            
            while (($row = fgetcsv($file)) !== FALSE) {
                // Pastikan kolom 'Name' ada
                if (!isset($columnMap['Name']) || empty($row[$columnMap['Name']])) continue;
                
                $itemName = $row[$columnMap['Name']];
                
                // *** Penyesuaian: Menambahkan data dummy untuk PRICE dan STOCK ***
                // Generate harga acak
                $randomPrice = round(rand(100, 1000) * 100, 2); 
                // Generate stok acak
                $randomStock = rand(50, 300);

                // 1. Buat data Item (Obat) - Menggunakan data dari CSV
                $item = Item::create([
                    'name' => $itemName,
                    'price' => $randomPrice, // Dummy Price
                    'category' => $row[$columnMap['Category']] ?? null,
                    'dosage_form' => $row[$columnMap['Dosage Form']] ?? null,
                    'strength' => $row[$columnMap['Strength']] ?? null,
                    'manufacturer' => $row[$columnMap['Manufacturer']] ?? null,
                    'indication' => $row[$columnMap['Indication']] ?? null,
                ]);

                // 2. Buat data Inventory (Stok)
                Inventory::create([
                    'item_id' => $item->id,
                    'stock' => $randomStock, // Dummy Stock
                ]);
                
                $count++;
            }
            $this->command->info("Seeding complete. {$count} items and inventory records added from CSV.");
        });

        fclose($file);
    }
}