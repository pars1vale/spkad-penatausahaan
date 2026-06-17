<?php

namespace Database\Seeders;

use App\Models\PenerbitanSpd;
use Illuminate\Database\Seeder;

class PenerbitanSpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = PenerbitanSpd::firstOrCreate(
            [
                'id_penerbitan_spd' => 1,
                'nama_penerbitan_spd' => 'Per - OPD',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
