<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalEntrega extends Model{
    protected $connection = 'pgsql_discapacidad';
    protected $table = 'entrega_temp';
    protected $primaryKey= 'id_e_temp';

    protected $fillable = [
        'id_ent'
    ];

    public $timestamps = false;

    public function Afiliado(){
        return $this->belongsTo('App\Models\Afiliado','id_ent');
    }

    public function scopeByNroCarnet($query, $nro_carnet){
        if ($nro_carnet) {
                return $query
                    ->whereIn('id_ent', function ($subquery) use($nro_carnet) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('carnet','LIKE','%'.$nro_carnet.'%');
                    });
        }
    }

    public function scopeByNombres($query, $nombres){
        if ($nombres) {
                return $query
                    ->whereIn('id_ent', function ($subquery) use($nombres) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('nombres','LIKE','%'.strtoupper($nombres).'%');
                    });
        }
    }

    public function scopeByApellidos($query, $apellidos){
        if ($apellidos) {
                return $query
                    ->whereIn('id_ent', function ($subquery) use($apellidos) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('apellidos','LIKE','%'.strtoupper($apellidos).'%');
                    });
        }
    }

    public function scopeByEdad($query, $edad){
        if ($edad) {
                return $query
                    ->whereIn('id_ent', function ($subquery) use($edad) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('edad','LIKE','%'.$edad.'%');
                    });
        }
    }

    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
                return $query
                    ->whereIn('id_ent', function ($subquery) use($barrio) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('barrio_com','LIKE','%'.strtoupper($barrio).'%');
                    });
        }
    }

    public function scopeByCarnetDiscapacitado($query, $carnet_disc){
        if ($carnet_disc) {
                return $query
                    ->whereIn('id_ent', function ($subquery) use($carnet_disc) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('carnet_discap','LIKE','%'.strtoupper($carnet_disc).'%');
                    });
        }
    }
}