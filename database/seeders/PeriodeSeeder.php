<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Periode = Periode::insert([
            [
                'id' => 1,
                'id_periode' => 1,
                'nama_periode' => 'Bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'id_periode' => 2,
                'nama_periode' => 'Triwulan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'id_periode' => 3,
                'nama_periode' => 'Semester',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
