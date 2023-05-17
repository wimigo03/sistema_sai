<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoModel extends Model
{
    protected $table = 'ingreso';

    protected $primaryKey= 'idingreso';

    public $timestamps = true;

    protected $fillable = [
        'idcompra',
        'estadoingreso',
        'fechaingreso'
    ];

    protected $guarded = [


    ];
}
