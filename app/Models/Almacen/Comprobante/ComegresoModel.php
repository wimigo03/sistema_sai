<?php

namespace App\Models\Almacen\Comprobante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComegresoModel extends Model
{
    use HasFactory;
    protected $table = 'comegreso';
    
    protected $primaryKey= 'idcomegreso';

    public $timestamps = false;

    protected $fillable = [
        'idtipocomin',
        'idcatprogramaticacomb',
        'idcomingreso',
        'detallecomegreso',
        'idempleado',
        'idproveedor',
        'idarea',
        'idvale',
        'fechaegreso'
        
    ];

}

