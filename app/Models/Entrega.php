<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model{
    protected $connection = 'pgsql_discapacidad';
    protected $table = 'entrega';
    protected $primaryKey= 'id_ent';

    protected $fillable = [
        'codigo',
        'id_us',
        'fecha_e',
        'confirmacion',
        'mes1',
        'mes2',
        'mes3'
    ];

    public $timestamps = false;

    public function afiliado(){
        return $this->belongsTo('App\Models\Afiliado','codigo');
    }

    //SCOPES
    public function scopeByNroCarnet($query, $nro_carnet){
        if ($nro_carnet) {
                return $query
                    ->whereIn('codigo', function ($subquery) use($nro_carnet) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('carnet','LIKE','%'.$nro_carnet.'%');
                    });
        }
    }

    public function scopeByNombres($query, $nombres){
        if ($nombres) {
                return $query
                    ->whereIn('codigo', function ($subquery) use($nombres) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('nombres','LIKE','%'.strtoupper($nombres).'%');
                    });
        }
    }

    public function scopeByApellidos($query, $apellidos){
        if ($apellidos) {
                return $query
                    ->whereIn('codigo', function ($subquery) use($apellidos) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('apellidos','LIKE','%'.strtoupper($apellidos).'%');
                    });
        }
    }

    public function scopeByEdad($query, $edad){
        if ($edad) {
                return $query
                    ->whereIn('codigo', function ($subquery) use($edad) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('edad','LIKE','%'.$edad.'%');
                    });
        }
    }

    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
                return $query
                    ->whereIn('codigo', function ($subquery) use($barrio) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('barrio_com','LIKE','%'.strtoupper($barrio).'%');
                    });
        }
    }

    public function scopeByCarnetDiscapacitado($query, $carnet_disc){
        if ($carnet_disc) {
                return $query
                    ->whereIn('codigo', function ($subquery) use($carnet_disc) {
                        $subquery->select('codigo')
                            ->from('afiliados')
                            ->where('carnet_discap','LIKE','%'.strtoupper($carnet_disc).'%');
                    });
        }
    }

    public function scopeByPendiente($query, $codigo){
        if($codigo) return $query->where('codigo',$codigo);
    }

    public function scopeByFechas($query, $from, $to){
        if($from&&$to){
            $datosFrom = explode('/',$from);
            $datosTo = explode('/',$to);
            $from = $datosFrom[2] . '-' . $datosFrom[1] . '-' . $datosFrom[0];
            $to = $datosTo[2] . '-' . $datosTo[1] . '-' . $datosTo[0];
            return $query->whereBetween('fecha_e',[$from, $to]);
        }
    }

    public function scopeByMes1($query, $mes1){
        if($mes1) return $query->where('mes1',$mes1);
    }

    public function scopeByMes2($query, $mes2){
        if($mes2) return $query->where('mes2',$mes2);
    }

    public function scopeByMes3($query, $mes3){
        if($mes3) return $query->where('mes3',$mes3);
    }
}