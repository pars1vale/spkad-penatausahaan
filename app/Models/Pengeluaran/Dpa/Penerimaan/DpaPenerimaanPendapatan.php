<?php

namespace App\Models\Pengeluaran\Dpa\Penerimaan;

use App\Models\PerangkatDaerah;
use Illuminate\Database\Eloquent\Model;

class DpaPenerimaanPendapatan extends Model
{
    protected $table = 'dpa_penerimaan_pendapatan';

    protected $fillable = [
        'id_daerah',
        'tahun',
        'id_skpd',
        'kode_skpd',
        'nama_skpd',
        'nilai',
        'nilai_rak',
        'status',
    ];

    protected $casts = [
        'nilai' => 'integer',
        'nilai_rak' => 'integer',
        'status' => 'integer',
        'tahun' => 'integer',
    ];

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_skpd');
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            1 => '<span class="badge badge-light-danger">Terkunci</span>',
            default => '<span class="badge badge-light-warning">Belum Dikunci</span>',
        };
    }
}
