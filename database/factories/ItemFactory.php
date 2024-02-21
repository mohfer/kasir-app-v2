<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_barang' => fake()->unique()->randomNumber(5, true),
            'nama_barang' => fake()->unique()->name(),
            'category_id' => fake()->numberBetween(1, 50),
            'harga_beli' => fake()->randomNumber(6, true),
            'harga_jual_awal' => fake()->randomNumber(6, true),
            'diskon' => 5,
            'harga_jual_akhir' => fake()->randomNumber(6, true),
        ];
    }
}
