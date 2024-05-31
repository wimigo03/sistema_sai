<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Ocupaciones;
use Carbon\Carbon;
class Beneficiario extends Model
{
    protected $table = 'beneficiarios';
    protected $primaryKey= 'id';
    //public $timestamps = false;
    const CREATED_AT = 'created_att';
    const UPDATED_AT = 'updated_att';
    protected $fillable = [
        'id',
        'nombres',
        'ap',
        'am',
        'fecha_nac',
        'estado_civil',
        'sexo',
        'direccion',
        'dir_foto',
        'firma',
        'obs',
        'id_ocupacion',
        'created_att',
        'updated_att',
        'id_barrio',
        'user_id',
        'dea_id',
        'expedido',
        'ci',
        'estado'
    ];

    const ESTADOS = [
        'A' => 'HABILITADO',
        'F' => 'FALLECIDO',
        'B' => 'BAJA',
        'X' => 'PENDIENTE'
    ];

    const SEXOS = [
        'H' => 'MASCULINO',
        'M' => 'FEMENINO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "HABILITADO";
            case 'F':
                return "FALLECIDO";
            case 'B':
                    return "BAJA";
            case 'X':
                    return "PENDIENTE";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "badge-with-padding badge badge-success";
            case 'F':
                return "badge-with-padding badge badge-danger";
            case 'B':
                return "badge-with-padding badge badge-warning";
            case 'X':
                return "badge-with-padding badge badge-secondary";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function ocupacion(){
        return $this->belongsTo(Ocupaciones::class,'id_ocupacion','id');
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

    public function scopeByApellidoPaterno($query, $ap){
        if($ap){
            return $query->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);

        }
    }

    public function scopeByApellidoMaterno($query, $am){
        if($am){
            return $query->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);

        }
    }

    public function scopeByNumeroCarnet($query, $ci){
        if($ci){
            return $query->whereRaw('upper(ci) like ?', ['%'.strtoupper($ci).'%']);

        }
    }

    public function scopeBySexo($query, $sexo){
        if($sexo){
            return $query->where('sexo',$sexo);

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
        return $this->belongsTo(Barrio::class,'id_barrio','id');
    }

    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
                return $query
                    ->whereIn('id_barrio', function ($subquery) use($barrio) {
                        $subquery->select('id')
                            ->from('barrios')
                            ->whereRaw('upper(nombre) like ?', [strtoupper($barrio)]);
                    });
        }
    }


    public function age()

    {

        return Carbon::parse($this->attributes['fecha_nac'])->age;


    }
}
