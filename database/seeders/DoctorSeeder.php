<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create([
            'name' => 'Dr. Nida Farida, SpKK',
            'specialist' => 'Kecantikan',
            'address' => 'Jl. Margahayu No. 24-42c, Kel. Mekar Galih, Kec. Bandung Selatan',
            'phone' => '081221773164',
            'user_id' => User::factory()->create()->id,
        ]);

        Doctor::factory()->count(4)->create();
    }
}
