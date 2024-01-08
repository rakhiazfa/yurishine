<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            'registrasion_number' => Patient::generateRegistrasionNumber(),
            'name' => 'Daffarel Fauzan',
            'age' => 19,
            'gender' => 'Pria',
            'skin_type' => 'Oily',
            'address' => 'Jl. Kresna No. 24-42c, Kel. Durman, Kec. Andir',
            'phone' => '082482429401',
        ]);

        Patient::factory()->count(150)->create();
    }
}
