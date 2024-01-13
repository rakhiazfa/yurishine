<?php

namespace Database\Seeders;

use App\Models\Skincare;
use Illuminate\Database\Seeder;

class SkincareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skincare::factory()->count(20)->create();
    }
}
