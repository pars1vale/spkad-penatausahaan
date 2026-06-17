<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerbitanSpd extends Model
{
    protected $table = 'penerbitan_spd';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_penerbitan_spd',
        'nama_penerbitan_spd',
    ];
}
