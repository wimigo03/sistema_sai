<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoluconsumoModel extends Model
{
    protected $table = 'soluconsumo';

    protected $primaryKey= 'idsoluconsumo';

    public $timestamps = false;

    protected $fillable = [
       


        'cominterna',
    
        'idarea' , //de forma automatica del que tiene acceso
        'idusuario' ,  //de forma automatica del que tiene acceso
        'idlocalidad' ,  //el lugar de ida

       'dirigidoa',    //via
       'dirnombre',    //via
       'diracargo',    //via

       'viauno', //departe de 
       'viaunonombre', //departe de 
       'viaunocargo', //departe de 

       'usuarionombre' ,  //de forma automatica del que tiene acceso
       'usuariocargo' ,  //de forma automatica del que tiene acceso

        'oficina', //nombre de la oficina
        'referencia' ,
        'fechasol',
        'detallesouconsumo',
        'fechasalida',
        'fecharetorno' ,
        'tipo' ,
        'estadosoluconsumo' ,
        'estado1',
        'estado2' ,
        'estado3', 
        'tsalida' ,
        'tllegada'
        
    ];

    protected $guarded = [


    ];

}

