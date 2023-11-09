<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosPtModel extends Model
{
    protected $table = 'movimientosplanta';
    
    protected $primaryKey= 'idmovpt';

    public $timestamps = false;

    protected $fillable = [
        
        'idemp',
        'fechamovpt',
        'motivopt',
        'fileactualpt',
        'cargoactualpt',
        'nombrecargoactualpt',
        'haberbasicoactualpt',
        'nombreareaactualpt',
        'filenuevopt',
        'cargonuevopt',
        'nombrecargonuevopt',
        'haberbasiconuevopt',
        'nombreareanuevopt'
        
    ];

    protected $guarded = [

        
    ];
    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'idemp');
    }
}
