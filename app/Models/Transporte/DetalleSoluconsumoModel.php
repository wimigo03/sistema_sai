<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSoluconsumoModel extends Model
{
    protected $table = 'detallesoluconsumo';

    protected $primaryKey= 'iddetallesoluconsumo';

    public $timestamps = false;

    protected $fillable = [
       


        'idunidadconsumo',
        'idsoluconsumo' , //de forma automatica del que tiene acceso


        'fecharesp' ,  //de forma automatica del que tiene acceso
        'codigoconsumo' ,  //el lugar de ida

       'idtipomovilidad',    //via
       'marcaconsumo',    //via
       'kilometrajeactual'
     
        
        
    ];

    protected $guarded = [


    ];

}
