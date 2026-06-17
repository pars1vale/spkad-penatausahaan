<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatDaerah extends Model
{
    protected $table = 'perangkat_daerah';

    protected $fillable = [
        'id_daerah',
        'tahun',
        'id_skpd',
        'nama_skpd',
        'kode_skpd',
        'nilai',
        'nilai_rak',
        'status',
    ];
}
