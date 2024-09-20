<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadModel extends Model
{
    protected $table = 'unidad';
    protected $primaryKey = 'id_unidad';
    public $timestamps = false;

    protected $fillable = [
        'nombre_unidad',
        'estado_unidad'
    ];
}
