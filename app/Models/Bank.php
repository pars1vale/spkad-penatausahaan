<?php

namespace App\Models;

use App\Models\RekeningBank\Rkud;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_bank',
        'kode_bank',
        'nama_bank',
    ];

    public function rkud()
    {
        return $this->hasMany(Rkud::class, 'id_bank');
    }
}
