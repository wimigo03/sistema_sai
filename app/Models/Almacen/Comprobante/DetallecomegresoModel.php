<?php

namespace App\Models\Almacen\Comprobante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallecomegresoModel extends Model
{
    use HasFactory;
    protected $table = 'detallecomegreso';
    
    protected $primaryKey= 'iddetallecomegreso';

    public $timestamps = false;

    protected $fillable = [
        'cantidadegreso',
        'subtotalegreso',
        'precioegreso',
        'idprodcomb',
        'idcomegreso',
        'estadoegreso'
        
    ];

}
