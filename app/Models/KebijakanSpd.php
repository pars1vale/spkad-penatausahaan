<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KebijakanSpd extends Model
{
    protected $table = 'kebijakan_spd';

    protected $fillable = [
        'id_kebijakan_spd',
        'id_daerah',
        'tahun',
        'id_periode',
        'nama_periode',
        'id_penerbitan_spd',
        'nama_penerbitan_spd',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'id_kebijakan_spd' => 'integer',
        'id_daerah' => 'integer',
        'id_periode' => 'integer',
        'id_penerbitan_spd' => 'integer',
    ];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }

    public function penerbitanSpd(): BelongsTo
    {
        return $this->belongsTo(PenerbitanSpd::class, 'id_penerbitan_spd');
    }

    public function getBadgePeriodeAttribute(): array
    {
        return match (strtolower($this->nama_periode ?? '')) {
            'bulan' => ['label' => 'Setiap 1 Bulan',  'color' => 'primary'],
            'triwulan' => ['label' => 'Setiap 3 Bulan',  'color' => 'warning'],
            'semester' => ['label' => 'Setiap 6 Bulan',  'color' => 'info'],
            default => ['label' => ucfirst($this->nama_periode ?? '-'), 'color' => 'secondary'],
        };
    }
}
