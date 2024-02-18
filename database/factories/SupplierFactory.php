<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->name(),
            'email' => fake()->unique()->email(),
            'alamat' => fake()->unique()->sentence(5),
            'telp' => fake()->unique()->randomNumber(5, true),
        ];
    }
}
