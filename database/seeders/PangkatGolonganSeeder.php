<?php

namespace Database\Seeders;

use App\Models\PangGol;
use Illuminate\Database\Seeder;

class PangkatGolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panggol = PangGol::insert([
            [
                'id' => 1,
                'nama_pangkat' => 'Belum Dipilih',
                'nama_golongan' => 'Belum Dipilih',
            ],
            [
                'id' => 2,
                'nama_pangkat' => 'Juru Muda',
                'nama_golongan' => 'I/a',
            ],
            [
                'id' => 3,
                'nama_pangkat' => 'Juru Muda Tingkat I',
                'nama_golongan' => 'I/b',
            ],
            [
                'id' => 4,
                'nama_pangkat' => 'Juru',
                'nama_golongan' => 'I/c',
            ],
            [
                'id' => 5,
                'nama_pangkat' => 'Juru Tingkat I',
                'nama_golongan' => 'I/d',
            ],
            [
                'id' => 6,
                'nama_pangkat' => 'Pengatur Muda',
                'nama_golongan' => 'II/a',
            ],
            [
                'id' => 7,
                'nama_pangkat' => 'Pengatur Muda Tingkat I',
                'nama_golongan' => 'II/b',
            ],
            [
                'id' => 8,
                'nama_pangkat' => 'Pengatur',
                'nama_golongan' => 'II/c',
            ],
            [
                'id' => 9,
                'nama_pangkat' => 'Pengatur Tingkat I',
                'nama_golongan' => 'II/d',
            ],
            [
                'id' => 10,
                'nama_pangkat' => 'Penata Muda',
                'nama_golongan' => 'III/a',
            ],
            [
                'id' => 11,
                'nama_pangkat' => 'Penata Muda Tingkat I',
                'nama_golongan' => 'III/b',
            ],
            [
                'id' => 12,
                'nama_pangkat' => 'Penata',
                'nama_golongan' => 'III/c',
            ],
            [
                'id' => 13,
                'nama_pangkat' => 'Penata Tingakt I',
                'nama_golongan' => 'III/d',
            ],
            [
                'id' => 14,
                'nama_pangkat' => 'Pembina',
                'nama_golongan' => 'IV/a',
            ],
            [
                'id' => 15,
                'nama_pangkat' => 'Pembina Tingkat I',
                'nama_golongan' => 'IV/b',
            ],
            [
                'id' => 16,
                'nama_pangkat' => 'Pembina Utama Muda',
                'nama_golongan' => 'IV/c',
            ],
            [
                'id' => 17,
                'nama_pangkat' => 'Pembina Utama',
                'nama_golongan' => 'IV/d',
            ],
        ]);
    }
}
