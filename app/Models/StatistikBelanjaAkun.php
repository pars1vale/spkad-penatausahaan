<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikBelanjaAkun extends Model
{
    protected $table = 'statistik_belanja_akun';

    protected $fillable = [
        'id_daerah',
        'tahun',
        'id_skpd',
        'id_sub_skpd',
        'kode_sub_skpd',
        'nama_sub_skpd',
        'nama_skpd',
        'kode_skpd',
        'id_urusan',
        'id_bidang_urusan',
        'kode_bidang_urusan',
        'nama_bidang_urusan',
        'id_program',
        'kode_program',
        'nama_program',
        'id_giat',
        'kode_giat',
        'nama_giat',
        'id_sub_giat',
        'kode_sub_giat',
        'nama_sub_giat',
        'anggaran',
        'realisasi_rencana',
        'realisasi_rill',
        'id_unit',
        'id_rak_belanja',
        'id_akun',
        'kode_akun',
        'nama_akun',
        'is_blokir',
    ];

    protected $casts = [
        'is_blokir' => 'boolean',
    ];
}
