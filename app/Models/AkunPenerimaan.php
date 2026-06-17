<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunPenerimaan extends Model
{
    protected $table = 'akun_penerimaan';

    protected $fillable = [
        'id_skpd',
        'id_akun',
        'kode_akun',
        'nama_akun',
        'is_checked',
        'metode_input',
    ];

    protected $casts = [
        'is_checked' => 'boolean',
    ];

    const METODE_OPTIONS = [
        'harian' => 'Harian',
        'mingguan' => 'Mingguan',
        'bulanan' => 'Bulanan',
        'per_wajib_pajak' => 'Per Wajib Pajak',
        'per_wajib_retribusi' => 'Per Wajib Retribusi',
    ];

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_skpd', 'id');
    }
}
