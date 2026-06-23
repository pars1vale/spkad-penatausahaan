<?php

namespace App\Models\Pengeluaran\Dpa\Penerimaan;

use Illuminate\Database\Eloquent\Model;

class DpaPenerimaanPendapatanDetail extends Model
{
    protected $table = 'dpa_penerimaan_pendapatan_detail';

    protected $fillable = [
        'id_skpd',
        'nama_skpd',
        'kode_skpd',
        'id_daerah',
        'tahun',
        'id_unit',
        'id_sub_skpd',
        'kode_sub_skpd',
        'nama_sub_skpd',
        'id_akun',
        'kode_akun',
        'nama_akun',
        'nilai',
        'nilai_rak',
        'januari',
        'februari',
        'maret',
        'april',
        'mei',
        'juni',
        'juli',
        'agustus',
        'september',
        'oktober',
        'november',
        'desember',
        'id_rak_pendapatan',
        'is_valid_skpd',
        'is_valid_sekda',
        'is_valid_bud',
    ];

    protected $casts = [
        'nilai' => 'integer',
        'nilai_rak' => 'integer',
        'januari' => 'integer',
        'februari' => 'integer',
        'maret' => 'integer',
        'april' => 'integer',
        'mei' => 'integer',
        'juni' => 'integer',
        'juli' => 'integer',
        'agustus' => 'integer',
        'september' => 'integer',
        'oktober' => 'integer',
        'november' => 'integer',
        'desember' => 'integer',
        'is_valid_skpd' => 'boolean',
        'is_valid_sekda' => 'boolean',
        'is_valid_bud' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function induk()
    {
        return $this->belongsTo(DpaPenerimaanPendapatan::class, 'id_skpd', 'id_skpd');
    }
}
