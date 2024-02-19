<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_member' => fake()->unique()->randomNumber(5, true),
            'nama' => fake()->unique()->name(),
            'email' => fake()->unique()->email(),
            'telp' => fake()->unique()->randomNumber(5, true),
            'diskon' => fake()->unique()->randomNumber(5, true),
            'tgl_berlangganan' => now()->toDateString(),
            'aktif' => 'Ya',
        ];
    }
}
