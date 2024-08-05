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
        'estado',
        'created_att',
        'updated_att',
        'id_barrio',
        'user_id',
        'dea_id',
        'ci',
        'expedido',
        'id_ocupacion',
        'id_tipo',
        'codigo',
        'id_discgrado',
        'tutor',
        'parentesco',
        'distrito_id'
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

    const EXTENSIONES = [
        'TJA' => 'TARIJA',
        'SCZ' => 'SANTA CRUZ',
        'BN' => 'BENI',
        'LPZ' => 'LA PAZ',
        'CBBA' => 'COCHABAMBA',
        'SC' => 'CHUQUISACA',
        'ORU' => 'ORURO',
        'PTS' => 'POTOSI',
        'PND' => 'PANDO',
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

    public function distrito(){
        return $this->belongsTo(Distrito::class,'distrito_id','id');
    }

    public function barrio(){
        return $this->belongsTo(Barrio::class,'id_barrio','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('id', $codigo);
        }
    }

    public function scopeByDistrito($query, $distrito){
        if($distrito != null){
            return $query->where('distrito_id', $distrito);
        }
    }

    public function scopeByBarrio($query, $barrio){
        if($barrio != null){
            return $query->where('id_barrio', $barrio);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre != null){
            return $query->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);

        }
    }

    public function scopeByApellidoPaterno($query, $ap){
        if($ap != null){
            return $query->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);

        }
    }

    public function scopeByApellidoMaterno($query, $am){
        if($am != null){
            return $query->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);

        }
    }

    public function scopeByNumeroCarnet($query, $ci){
        if($ci != null){
            return $query->whereRaw('upper(ci) like ?', ['%'.strtoupper($ci).'%']);

        }
    }

    public function scopeBySexo($query, $sexo){
        if($sexo != null){
            return $query->where('sexo',$sexo);

        }
    }

    public function scopeByEdad($query, $edad_inicial, $edad_final){
        if ($edad_inicial != null && $edad_final != null) {
            $fecha_actual = Carbon::now();
            $fecha_nacimiento_final = $fecha_actual->copy()->subYears($edad_final + 1)->startOfDay();
            $fecha_nacimiento_inicial = $fecha_actual->copy()->subYears($edad_inicial)->addDay()->startOfDay();

            return $query->whereBetween('fecha_nac', [$fecha_nacimiento_final, $fecha_nacimiento_inicial]);
        }
    }

    public function scopeByUsuario($query, $usuario){
        if ($usuario != null) {
                return $query
                    ->whereIn('user_id', function ($subquery) use($usuario) {
                        $subquery->select('id')
                            ->from('users')
                            ->whereRaw('upper(name) like ?', [strtoupper($usuario)]);
                    });
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByTipoSistema($query, $tipo){
        if($tipo != null){
            return $query->where('id_tipo',$tipo);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado',$estado);
        }
    }

    public function age()
    {
        return Carbon::parse($this->attributes['fecha_nac'])->age;
    }
}
