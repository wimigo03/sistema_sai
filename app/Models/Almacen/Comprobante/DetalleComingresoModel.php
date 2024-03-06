<?php

namespace App\Models\Almacen\Comprobante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleComingresoModel extends Model
{
    use HasFactory;
    protected $table = 'detallecomingreso';
    
    protected $primaryKey= 'iddetallecomingreso';

    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'subtotal',
        'precio',
        'idcomingreso',
        'idproducto',
        'cantidadsalida',
        'subtotalsalida',
        'estado1',
        'estado2'
        
    ];

}
