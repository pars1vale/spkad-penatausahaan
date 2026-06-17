<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'id_pegawai',
        'id_daerah',
        'id_skpd',
        'id_user',
        'id_role',
        'nama_role',
        'tahun_pegawai',
        'id_pegawai_kpa',
        'status',
        'id_pegawai_ref',
        'id_user_kpa',
        'nama_user',
        'nip_user',
    ];

    /**
     * Badge status pegawai.
     */
    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'aktif' => '<span class="badge badge-light-success">Aktif</span>',
            'nonaktif' => '<span class="badge badge-light-danger">Nonaktif</span>',
            default => '<span class="badge badge-light-secondary">'.e($this->status).'</span>',
        };
    }
}
