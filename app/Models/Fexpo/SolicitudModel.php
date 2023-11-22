<?php

namespace App\Models\Fexpo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudModel extends Model
{
    protected $table = 'solicitud';

    protected $primaryKey= 'idsolicitud';

    public $timestamps =false;

    protected $fillable = [
       
        // 'idarea',
        // 'idunidadingreso',

        'nombresolicitud',
        'asociacionsol',
       
        'ci',
        'direccionsol',
        'telefonosol',
        'correosol',
        'idrubro',
        'estadosolicitud'
    ];

    protected $guarded = [


    ];
}
