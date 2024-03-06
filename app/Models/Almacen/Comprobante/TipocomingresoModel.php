<?php

namespace App\Models\Almacen\Comprobante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipocomingresoModel extends Model
{
    use HasFactory;
    protected $table = 'tipocomingreso';
    
    protected $primaryKey= 'idtipocomin';

    public $timestamps = false;

    protected $fillable = [
        'codigocomin',
        'nombrecoming',
        'estado1',
        'estado2'
       
    ];

    protected $guarded = [

        
    ];
}
