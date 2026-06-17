<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PangGol extends Model
{
    protected $table = 'pangkat_golongan';

    protected $fillable = [
        'nama_pangkat',
        'nama_golongan',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_pang_gol');
    }
}
