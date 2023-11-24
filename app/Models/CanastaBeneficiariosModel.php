<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CanastaBarriosModel;
class CanastaBeneficiariosModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'usuarios';
    protected $primaryKey= 'idUsuario';
    protected $fillable = [
        'ci',
        'expedido',
        'nombres',
        'ap',
        'am',
        'fechaNac',
        'estadoCivil',
        'sexo',
        'direccion',
        'dirFoto',
        'firma',
        'obs',
        '_registrado',
        '_modificado',
        'estado',
        'idBarrio',
        'idAdmin',
        'idOcupacion'
    ];

    const EXPEDICIONES = [
        'TJA' => 'TARIJA',
        'SC' => 'SUCRE',
        'PTS' => 'POTOSI',
        'SCZ' => 'SANTA CRUZ',
        'CBBA' => 'COCHABAMBA',
        'LPZ' => 'LA PAZ',
        'ORU' => 'ORURO',
        'PND' => 'PANDO',
        'BN' => 'BENI'
    ];

    const ESTADOS = [
        'A' => 'A',
        'B' => 'B',
        'F' => 'F',
        'X' => 'X'
    ];

    const SEXOS = [
        'H' => 'MASCULINO',
        'M' => 'FEMENINO'
    ];

    public function barrios(){
        return $this->belongsTo(CanastaBarriosModel::class,'idBarrio');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('idUsuario',$codigo);
        }
    }

    public function scopeByNombres($query, $nombres){
        if($nombres){
            return $query->where('nombres','LIKE','%'.strtoupper($nombres).'%');   
        }
    }

    public function scopeByAp($query, $ap){
        if($ap){
            return $query->where('ap','LIKE','%'.strtoupper($ap).'%');
        }
    }

    public function scopeByAm($query, $am){
        if($am){
            return $query->where('am','LIKE','%'.strtoupper($am).'%');   
        }
    }

    public function scopeByNroCarnet($query, $nro_carnet){
        if($nro_carnet){
            return $query->where('ci',$nro_carnet);   
        }
    }

    public function scopeByExpedicion($query, $expedido){
        if($expedido){
            return $query->where('expedido',$expedido);
        }
    }

    public function scopeByNatalicio($query, $fecha){
        if($fecha){
            $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
            return $query->where('fechaNac',$fecha);
        }
    }

    public function scopeBySexo($query, $sexo){
        if($sexo){
            return $query->where('sexo',$sexo);
        }
    }

    public function scopeByDireccion($query, $direccion){
        if($direccion){
            return $query->where('direccion','LIKE','%'.strtoupper($direccion).'%');
        }
    }

    public function scopeByBarrio($query, $barrio){
        if($barrio){
            return $query->where('idBarrio',$barrio);
        }
    }

    public function scopeByDistrito($query, $distrito){
        if ($distrito) {
                return $query
                    ->whereIn('idBarrio', function ($subquery) use($distrito) {
                        $subquery->select('idBarrio')
                            ->from('barrios')
                            ->where('distrito',$distrito);
                    });
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado',$estado);
        }
    }

    public function getEdadAttribute(){
        if($this->fechaNac != null){
            $fecha_inicial = $this->fechaNac;
            $fecha_actual = date('Y-m-d');
            $dif_segundos = strtotime($fecha_actual) - strtotime($fecha_inicial);
            $edad = floor($dif_segundos / (365 * 24 * 60 * 60));
            return $edad;
        }
    }
}
