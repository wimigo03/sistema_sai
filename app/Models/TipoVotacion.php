<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVotacion extends Model
{
    protected $table = 'tipos_votacion';
    public $timestamps = false;
    protected $fillable = [
        'nombre'
    ];
}
