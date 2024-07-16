<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArchivo extends Model
{
    protected $table = 'tipoarchivo';
    protected $primaryKey= 'idtipo';
    protected $fillable = [
        'codigo',
        'nombretipo',
        'subtipo',
        'estado'
    ];

    const SUBTIPOS = [
        '1' => 'SALIDA',
        '2' => 'ENTRADA'
    ];
}
