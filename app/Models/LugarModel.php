<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarModel extends Model
{
    protected $connection = 'pgsql_correspondencia';
    protected $table = 'unidad';

    protected $primaryKey= 'id_unidad';

    public $timestamps = false;

    protected $fillable = [
        'nombre_unidad',
        'estado_unidad'
    ];

    protected $guarded = [


    ];
}
