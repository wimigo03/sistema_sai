<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosContModel extends Model
{
    protected $table = 'movimientoscontrato';
    
    protected $primaryKey= 'idmovcont';

    public $timestamps = false;

    protected $fillable = [
        
        'idemp',
        'fechamovcont',
        'motivocont',
        'fileactualcont',
        'cargoactualcont',
        'nombrecargoactualcont',
        'haberbasicoactualcont',
        'nombreareaactualcont',
        'filenuevocont',
        'cargonuevocont',
        'nombrecargonuevocont',
        'haberbasiconuevocont',
        'nombreareanuevocont'
        
    ];

    protected $guarded = [

        
    ];
}
