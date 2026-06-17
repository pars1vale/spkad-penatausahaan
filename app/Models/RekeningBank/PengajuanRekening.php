<?php

namespace App\Models\RekeningBank;

use Illuminate\Database\Eloquent\Model;

class PengajuanRekening extends Model
{
    protected $table = 'pengajuan_rekening';

    public $timestamps = false;

    protected $fillable = [
        'id_pengajuan',
        'id_daerah',
        'tahun',
        'id_skpd',
        'nama_skpd',
        'is_persetujuan',
        'persetujuan_by',
        'persetujuan_by_nama',
        'waktu_mulai_jadwal',
        'is_aktif',
        'aktif_by',
        'aktif_by_nama',
        'aktif_at',
        'id_bank',
        'nama_bank',
        'no_rekening',
        'nama_rekening',
        'saldo_tunai',
        'saldo_bank',
        'created_by',
        'created_by_nama',
        'created_at',
        'updated_by',
        'updated_by_nama',
        'updated_at',
    ];

    protected $casts = [
        'is_persetujuan' => 'boolean',
        'is_aktif' => 'boolean',
        'saldo_tunai' => 'integer',
        'saldo_bank' => 'integer',
        'waktu_mulai_jadwal' => 'datetime',
        'aktif_at' => 'datetime',
    ];

    public function scopePengajuan($query)
    {
        return $query->where('is_persetujuan', 0)->where('is_aktif', 0);
    }

    public function scopeBelumAktif($query)
    {
        return $query->where('is_persetujuan', 1)->where('is_aktif', 0);
    }

    public function scopeAktif($query)
    {
        return $query->where('is_persetujuan', 1)->where('is_aktif', 1);
    }

    public function getSaldoTunaiFormattedAttribute(): string
    {
        return 'Rp'.number_format($this->saldo_tunai, 2, ',', '.');
    }

    public function getSaldoBankFormattedAttribute(): string
    {
        return 'Rp'.number_format($this->saldo_bank, 2, ',', '.');
    }
}
