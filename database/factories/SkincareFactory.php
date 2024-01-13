<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skincare>
 */
class SkincareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucwords(implode(" ", fake()->words(3))),
            'price' => fake()->numberBetween(100, 200) * 1000,
            'stock' => fake()->randomNumber(1, 10) * 5,
            'created_at' => fake()->date(),
        ];
    }
}
