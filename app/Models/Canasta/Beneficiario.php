<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Barrio;
use Carbon\Carbon;
class Beneficiario extends Model
{
    protected $table = 'beneficiarios';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
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
        'idOcupacion',
        'created_att',
        'updated_att',
        'idBarrio',
        'user_id',
        'dea_id',
        'expedido',
        'ci',
        'estado'
    ];

    const ESTADOS = [
        'A' => 'ACTIVO',
        'F' => 'FALLECIDO',
        'B' => 'BAJA',
        'X' => 'PENDIENTE'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "ACTIVO";
            case 'F':
                return "FALLECIDO";
            case 'B':
                    return "BAJA";
            case 'X':
                    return "PENDIENTE";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }



    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('id', $codigo);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);

        }
    }

    public function scopeByAp($query, $ap){
        if($ap){
            return $query->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);

        }
    }

    public function scopeByAm($query, $am){
        if($am){
            return $query->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);

        }
    }

    public function scopeByCi($query, $ci){
        if($ci){
            return $query->whereRaw('upper(ci) like ?', ['%'.strtoupper($ci).'%']);

        }
    }

    public function scopeByUsuario($query, $usuario){
        if ($usuario) {
                return $query
                    ->whereIn('user_id', function ($subquery) use($usuario) {
                        $subquery->select('id')
                            ->from('users')
                            ->whereRaw('upper(name) like ?', [strtoupper($usuario)]);
                    });
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado',$estado);
        }
    }

    public function barrio(){
        return $this->belongsTo(Barrio::class,'idBarrio','id');
    }

    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
                return $query
                    ->whereIn('idBarrio', function ($subquery) use($barrio) {
                        $subquery->select('id')
                            ->from('barrios')
                            ->whereRaw('upper(nombre) like ?', [strtoupper($barrio)]);
                    });
        }
    }


    public function age()

    {

        return Carbon::parse($this->attributes['fechaNac'])->age;


    }
}
