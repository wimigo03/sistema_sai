<?php

namespace App\Models\Almacen\Ingreso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoModel extends Model
{
    protected $table = 'ingreso';
    
    protected $primaryKey= 'idingreso';

    public $timestamps = false;

    protected $fillable = [
       'iddetallecompracomb',
       'idcompracomb',
       'idprodcomb',
       'idpartidacomb',
       'idcatprogramaticacomb',
       'idprogramacomb',
       'idproveedor',
       
        'nombreproducto',
        'cantidad',
        'subtotal',
        'precio',

        'estadoingreso',
        'estadocompracomb',
        'estado1',
        'estado2',
        'codigopartida',
        'nombrepartida',
        'nombreprograma',
        'nombreproveedor',

        'codigocatprogramai',
        'nombrecatprogmai'
        
    ];

}

