<?php

namespace App\Models;

use App\Models\RekeningBank\Rkud;
use Illuminate\Database\Eloquent\Model;

class JenisRkud extends Model
{
    protected $table = 'jenis_rkud';

    protected $fillable = [
        'id_jenis_rkud',
        'nama_jenis_rkud',
    ];

    public function rkud()
    {
        return $this->hasMany(Rkud::class, 'id_jenis_rkud');
    }
}
