<?php

namespace App\Models\Fexpo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SolicitudModel extends Model
{

    use HasFactory, Notifiable;


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




    public function schedules(){
        return $this->belongsTo('App\Models\Fexpo\RubroModel','idrubro');
    }
}
