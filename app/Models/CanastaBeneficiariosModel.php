<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanastaBeneficiariosModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'usuarios';

    protected $primaryKey= 'idUsuario';



    protected $fillable = [
        'idBarrio'

    ];

    public function barrios(){
        return $this->belongsTo('App\Models\CanastaBarriosModel','idBarrio');
    }

    public function scopeByNombres($query, $nombres){
        if($nombres)
        return $query->where('nombres','LIKE','%'.strtoupper($nombres).'%');
    }

    public function scopeByAp($query, $ap){
        if($ap)
        return $query->where('ap','LIKE','%'.strtoupper($ap).'%');
    }
    public function scopeByAm($query, $am){
        if($am)
        return $query->where('am','LIKE','%'.strtoupper($am).'%');
    }
    public function scopeByDireccion($query, $direccion){
        if($direccion)
        return $query->where('direccion','LIKE','%'.strtoupper($direccion).'%');
    }

    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
                return $query
                    ->whereIn('idBarrio', function ($subquery) use($barrio) {
                        $subquery->select('idBarrio')
                            ->from('barrios')
                            ->where('barrio','LIKE','%'.strtoupper($barrio).'%');
                    });
        }
    }


    public function scopeByDistrito($query, $distrito){
        if ($distrito) {
                return $query
                    ->whereIn('idBarrio', function ($subquery) use($distrito) {
                        $subquery->select('idBarrio')
                            ->from('barrios')
                            ->where('distrito','LIKE','%'.strtoupper($distrito).'%');
                    });
        }
    }
}
