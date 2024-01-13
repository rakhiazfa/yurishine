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
        $genders = ['Pria', 'Wanita'];
        $skin_types = ['Normal', 'Oily', 'Dry', 'Acne', 'Kombinasi'];
        $kb = ['Ya', 'Tidak'];

        return [
            'registrasion_number' => Patient::generateRegistrasionNumber(),
            'name' => fake()->name(),
            'age' => fake()->numberBetween(16, 30),
            'gender' => $genders[array_rand($genders)],
            'skin_type' => $skin_types[array_rand($skin_types)],
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'is_smoked' => fake()->boolean(),
            'using_kb' => $kb[array_rand($kb)],
            'using_skincare' => fake()->boolean(),
            'already_use_mixed_cream' => fake()->boolean(),
            'created_at' => fake()->date(),
        ];
    }
}
