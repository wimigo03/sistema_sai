<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoAlmacenModel extends Model
{
    protected $table = 'ingresoalmacen';

    protected $primaryKey= 'idingresoalmacen';

    public $timestamps = true;

    protected $fillable = [
        'idcompra',
        'estadoingreso',
        'fechaingreso'
    ];

    protected $guarded = [


    ];
}
