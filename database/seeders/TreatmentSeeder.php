<?php

namespace Database\Seeders;

use App\Models\Treatment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Treatment::create([
            'name' => 'Laser accutoning',
            'price' => 700000,
        ]);

        Treatment::create([
            'name' => 'Facial Premium',
            'price' => 175000,
        ]);

        Treatment::factory()->count(150)->create();
    }
}
