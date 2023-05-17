<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngresoModel extends Model
{
    protected $table = 'detalleingreso';

    protected $primaryKey= 'iddetalleingreso';

    public $timestamps = false;

    protected $fillable = [
        'idingreso',
        'idprodserv',
        'ingresos',
        'salidas',
        'saldo'
    ];

    protected $guarded = [


    ];
}
