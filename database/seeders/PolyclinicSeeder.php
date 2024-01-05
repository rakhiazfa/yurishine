<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use App\Models\User;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Polyclinic::create([
            'name' => 'Yurishine Skincare',
            'address' => 'Apotik K24, Jl. Raya Batujajar, Perum. Batujajar Regency Ruko No. R02, Lantai 2, Kabupaten Bandung Barat, Jawa Barat 40553',
            'user_id' => User::factory()->create()->id,
        ]);
    }
}
