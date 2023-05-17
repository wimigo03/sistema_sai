<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalAlmacenModel extends Model
{
    protected $table = 'temporalalmacen';

    protected $primaryKey= 'idtemporalalmacen';

    public $timestamps = false;

    protected $fillable = [
        'idusuario',
        'idingresoalmacen'
    ];

    protected $guarded = [


    ];
}
