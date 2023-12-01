<?php

namespace App\Models\Almacen\Ingreso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteAreaModel extends Model
{
    protected $table = 'reportarea';

    protected $primaryKey= 'idreportarea';

    public $timestamps = false;

    protected $fillable = [
        'idingreso',
        'idarea'

    ];

    protected $guarded = [


    ];
}
