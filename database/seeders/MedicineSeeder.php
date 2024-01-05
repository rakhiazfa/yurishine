<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medicine::create([
            'name' => 'Melanox',
            'price' => 43500,
        ]);

        Medicine::create([
            'name' => 'Nutrafor White Beauty',
            'price' => 196000,
        ]);
    }
}
