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
        $header = fgetcsv($file);
        $columnMap = array_flip($header);




        DB::transaction(function () use ($file, $columnMap) {
            $count = 0;
            $bucket = env('AWS_BUCKET', 'pharmaplus-img-2025');
            $region = env('AWS_DEFAULT_REGION', 'us-east-1');
            $baseS3Url = "https://{$bucket}.s3.{$region}.amazonaws.com";

            while (($row = fgetcsv($file)) !== FALSE) {
                if (!isset($columnMap['Name']) || empty($row[$columnMap['Name']])) continue;

                $itemName = $row[$columnMap['Name']];

                // Dummy buat harga sama stock
                // Generate harga random
                $randomPrice = round(rand(100, 1000) * 100, 2);
                // Generate stock random
                $randomStock = rand(50, 300);
                // Buat gambar
                $imageFile = 'medicine-' . (($count % 8) + 1) . '.jpg';
                // $imageUrl  = "{$baseS3Url}/{$imageFile}";


                $item = Item::create([//from csv
                    'name' => $itemName,
                    'price' => $randomPrice,
                    'category' => $row[$columnMap['Category']] ?? null,
                    'dosage_form' => $row[$columnMap['Dosage Form']] ?? null,
                    'strength' => $row[$columnMap['Strength']] ?? null,
                    'manufacturer' => $row[$columnMap['Manufacturer']] ?? null,
                    'indication' => $row[$columnMap['Indication']] ?? null,
                    'image_path' => $imageFile, // Simpan nama file saja

                ]);

                Inventory::create([
                    'item_id' => $item->id,
                    'stock' => $randomStock,
                ]);

                $count++;
            }
            $this->command->info("Seeding complete. {$count} items and inventory records added from CSV.");
        });

        fclose($file);
    }
}