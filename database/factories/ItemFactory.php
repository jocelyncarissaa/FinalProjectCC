<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Nama model yang terkait dengan factory ini.
     */
    protected $model = Item::class;

    /**
     * Definisi state default untuk model Item.
     */
    public function definition(): array
    {
        return [
            'name'         => $this->faker->words(2, true), // Contoh: "Paracetamol Tablet"
            'price'        => $this->faker->numberBetween(10000, 200000), // Antara 10rb - 200rb
            'category'     => $this->faker->randomElement(['Obat Bebas', 'Obat Keras', 'Vitamin']),
            'dosage_form'  => $this->faker->randomElement(['Tablet', 'Sirup', 'Kapsul']),
            'strength'     => $this->faker->numberBetween(10, 500) . 'mg',
            'manufacturer' => $this->faker->company(),
            'indication'   => $this->faker->sentence(),
            'image_path'   => null,
        ];
    }
}