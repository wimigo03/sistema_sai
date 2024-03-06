<?php

namespace App\Models\Almacen\Comprobante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComingresoModel extends Model
{
    use HasFactory;
    protected $table = 'comingreso';
    
    protected $primaryKey= 'idcomingreso';

    public $timestamps = false;

    protected $fillable = [
        'fechaingreso',
        'numcompra',
        'numsolicitud',
        'numpreventivo',
        'numfactura',
        'idproveedor',
        'idarea',
        'detallecomingreso',
        'idcatprogramaticacomb',
        'idprogramacomb',
        'estadoingreso',
        'estado1',
        'estado2'
        
    ];

}
