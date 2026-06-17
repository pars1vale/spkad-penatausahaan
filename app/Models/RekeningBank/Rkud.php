<?php

namespace App\Models\RekeningBank;

use App\Models\Bank;
use App\Models\JenisRkud;
use Illuminate\Database\Eloquent\Model;

class Rkud extends Model
{
    protected $table = 'rkud';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_rkud',
        'id_bank',
        'nama_bank',
        'id_jenis_rkud',
        'nama_jenis_rkud',
        'no_rekening',
        'nama_rekening',
        'is_locked',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'id_bank');
    }

    public function jenisRkud()
    {
        return $this->belongsTo(JenisRkud::class, 'id_jenis_rkud');
    }
}
