<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidaddConsumoModel extends Model
{
    protected $table = 'unidadconsumo';
    
    protected $primaryKey= 'idunidadconsumo';

    public $timestamps = true;
   
           
    protected $fillable = [

             
        'idtipomovilidad',
        'idarea',
        'idprograma',
        'idusuario',

        'codigoconsumo',
       
        'desconsumo',
     
        'colorconsumo',
        
        'marcaconsumo',
        'modeloconsumo',
        'placaconsumo',
        'kilometrajeinicialconsumo',
      
        'estadoconsumo'
    ];

    protected $guarded = [

        
    ];
}

