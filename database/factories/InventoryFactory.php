<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Nama model yang terkait dengan factory ini.
     */
    protected $model = Inventory::class;

    /**
     * Definisi state default untuk model Inventory.
     */
    public function definition(): array
    {
        return [
            // Membuat Item baru secara otomatis jika item_id tidak ditentukan
            'item_id' => Item::factory(), 
            'stock'   => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * State khusus untuk membuat stok yang kosong (Out of Stock).
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}