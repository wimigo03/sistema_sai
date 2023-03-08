<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraModel extends Model
{
    protected $table = 'compra';

    protected $primaryKey= 'idcompra';

    public $timestamps = true;

    protected $fillable = [
        'idproveedor',
        'objeto',
        'justificacion',
        'preventivo',
        'estadocompra',
        'tipo',
        'estado1',
        'estado2',
        'estado3',
        'numcompra',
        'controlinterno',
        'created_at',
        'updated_at',
        'idarea'
    ];

    protected $guarded = [


    ];
}
