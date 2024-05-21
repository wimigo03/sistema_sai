<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivos';
    protected $primaryKey= 'idarchivo';
    public $timestamps = true;
    protected $fillable = [
        'nombrearchivo',
        'documento',
        'estado1',
        'idtipo',
        'referencia',
        'idarea',
        'fecha',
        'dea_id'
    ];

    protected $guarded = [


    ];
}
