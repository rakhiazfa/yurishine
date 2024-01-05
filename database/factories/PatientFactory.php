<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registrasion_number' => Patient::generateRegistrasionNumber(),
            'name' => fake()->name(),
            'age' => fake()->numberBetween(16, 30),
            'gender' => 'Pria',
            'skin_type' => 'Oily',
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
