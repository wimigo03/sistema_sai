<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ufv extends Model
{
    use HasFactory;

    protected $table = 'ufvs';
    public $timestamps = false;

    protected $fillable = [
        'dia',
        'mes',
        'ano',
        'indice_ufv',
    ];
}
