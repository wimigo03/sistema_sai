<?php

namespace App\Models\Almacen\Ingreso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaIngresoModel extends Model
{
    protected $table = 'notaingreso';
    
    protected $primaryKey= 'idnotaingreso';

    public $timestamps = false;

    protected $fillable = [
        'numcompra ',
        'numsolicitud ',
        'codigoproducto ',
        'nombreproducto ',
        'ingreso ',
        'precio ',
        'subtotal ',
        'num_comprobante',
        'factura_comprobante',
        'nombreprobeedor ',
        'idingreso',
        'idarea',
        'idproveedor',
        'fechaentra'
      
        
    ];

}


