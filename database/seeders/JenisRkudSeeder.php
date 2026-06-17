<?php

namespace Database\Seeders;

use App\Models\JenisRkud;
use Illuminate\Database\Seeder;

class JenisRkudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $JenisRkud = JenisRkud::insert([
            [
                'id' => 1,
                'id_jenis_rkud' => 1,
                'nama_jenis_rkud' => 'Rekening Kas Umum Daerah (RKUD)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'id_jenis_rkud' => 4,
                'nama_jenis_rkud' => 'Rekening Kas Umum Daerah - OTSUS BLOCKGRANT 1%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'id_jenis_rkud' => 5,
                'nama_jenis_rkud' => 'Rekening Kas Umum Daerah - OTSUS DBH MIGAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'id_jenis_rkud' => 6,
                'nama_jenis_rkud' => 'Rekening Kas Umum Daerah - OTSUS SPECIFIC GRANT 1,25%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'id_jenis_rkud' => 7,
                'nama_jenis_rkud' => 'Rekening Kas Umum Daerah - DTI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
