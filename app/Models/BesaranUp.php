<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BesaranUp extends Model
{
    protected $table = 'besaran_up';

    protected $fillable = [
        'id_besaran_up',
        'id_daerah',
        'tahun',
        'id_unit',
        'id_skpd',
        'id_sub_skpd',
        'kode_skpd',
        'nama_skpd',
        'pagu',
        'besaran_up',
        'besaran_up_kkpd',
    ];

    protected $casts = [
        'pagu' => 'integer',
        'besaran_up' => 'integer',
        'besaran_up_kkpd' => 'integer',
    ];

    public function getPersentaseUpAttribute(): string
    {
        if (empty($this->pagu) || $this->pagu == 0) {
            return '0,00%';
        }

        $persen = ($this->besaran_up / $this->pagu) * 100;

        return number_format($persen, 3, ',', '.').'%';
    }

    public function getPersentaseUpKkpdAttribute(): string
    {
        if (empty($this->pagu) || $this->pagu == 0) {
            return '0,00%';
        }

        $persen = ($this->besaran_up_kkpd / $this->pagu) * 100;

        return number_format($persen, 2, ',', '.').'%';
    }

    public function getPaguFormatAttribute(): string
    {
        return 'Rp '.number_format($this->pagu, 0, ',', '.');
    }

    public function getBesaranUpFormatAttribute(): string
    {
        return 'Rp '.number_format($this->besaran_up, 0, ',', '.');
    }

    public function getBesaranUpKkpdFormatAttribute(): string
    {
        return 'Rp '.number_format($this->besaran_up_kkpd, 0, ',', '.');
    }
}
