<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\PaqueteBarrio;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Barrio;
use DB;
use Carbon\Carbon;

class Entrega extends Model
{
    protected $table = 'entrega';
    protected $fillable = [
        'id_barrio',
        'id_beneficiario',
        'id_paquete',
        'tipo_entrega_id',
        'id_ocupacion',
        'distrito_id',
        'dea_id',
        'paquete_barrio_id',
        'fecha',
        'user_id',
        'estado',
        'resagado',
        'observacion'
    ];

    const ESTADOS = [
        '1' => 'NO ENTREGADO',
        '2' => 'ENTREGADO',
        '3' => 'ELIMINADO',
        '4' => 'RESAGADO',
    ];

    const RESAGADOS = [
        '1' => 'Si'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "NO ENTREGADO";
            case '2':
                return "ENTREGADO";
            case '3':
                return "ELIMINADO";
            case '4':
                return "RESAGADO";
        }
    }

    public function getResagaAttribute(){
        switch ($this->estado) {
            case '1':
                return "NO";
            case '2':
                return "SI";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary font-roboto-10";
            case '2':
                return "badge-with-padding badge badge-success font-roboto-10";
            case '3':
                return "badge-with-padding badge badge-danger font-roboto-10";
            case '4':
                return "badge-with-padding badge badge-success font-roboto-10";
        }
    }

    const ESTADOS_ANTERIOR = [
        '1' => 'NO ENTREGADO.(SIN IMPRESION)',
        '2' => 'ENTREGADO.(IMPRESO)',
        '3' => 'ENTREGADO'
    ];

    public function getStatusAnteriorAttribute(){
        switch ($this->estado) {
            case '1':
                return "NO ENTREGADO";

            case '2':
                return "NO ENTREGADO";

                case '3':
                    return "ENTREGADO";
        }
    }

    public function getcolorStatusAnteriorAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-danger";
            case '2':
                return "badge-with-padding badge badge-warning";
            case '3':
                return "badge-with-padding badge badge-success";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function paquete_barrio(){
        return $this->belongsTo(PaqueteBarrio::class,'paquete_barrio_id','id');
    }

    public function name(){
       $barrios_entrega = DB::table('barriosEntrega')
                      ->where('id_barrio',$this->id_barrio)
                    ->where('id_paquete',$this->id_paquete)
                     ->select('estado')
                        ->first();
        if($barrios_entrega != null){
            $estados =$barrios_entrega->estado;
       }else{
             $estados = null;
         }
         return $estados;
     }


    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo != null){
            return $query->where('id', $codigo);
        }
    }

    public function scopeByDistritos($query, $distrito_id){
        if($distrito_id != null){
            return $query->where('entrega.distrito_id', $distrito_id);
        }
    }

    public function scopeByBarrios($query, $barrio_id){
        if($barrio_id != null){
            return $query->where('entrega.id_barrio', $barrio_id);
        }
    }

    public function scopeByGestion($query, $gestion){
        if($gestion){
            return $query->where('gestion', $gestion);

        }
    }

    public function scopeByPeriodo($query, $periodo){
        if($periodo){
            return $query->whereRaw('upper(periodo) like ?', ['%'.strtoupper($periodo).'%']);

        }
    }

    public function scopeByNombre($query, $nombre){
        if ($nombre != null) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($nombre) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);
                    });
        }
    }

    public function scopeByApellidoPaterno($query, $ap){
        if ($ap != null) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($ap) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);
                    });
        }
    }

    public function scopeByApellidoMaterno($query, $am){
        if ($am != null) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($am) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);
                    });
        }
    }

    public function scopeByNroCarnet($query, $nro_carnet){
        if ($nro_carnet != null) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($nro_carnet) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('ci like ?', $nro_carnet . '%');
                    });
        }
    }

    public function scopeByExtension($query, $extension){
        if ($extension != null) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($extension) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(expedido) like ?', [strtoupper($extension)]);
                    });
        }
    }

    public function scopeByFechaNacimiento($query, $fecha_nacimiento){
        if ($fecha_nacimiento != null) {
            $fecha_nacimiento = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_nacimiento)));
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($fecha_nacimiento) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->where('fecha_nac', $fecha_nacimiento);
                    });
        }
    }

    public function scopeByEdad($query, $edad_inicial, $edad_final){
        if ($edad_inicial != null && $edad_final != null) {
            $fecha_actual = Carbon::now();
            $fecha_nacimiento_final = $fecha_actual->copy()->subYears($edad_final + 1)->startOfDay();
            $fecha_nacimiento_inicial = $fecha_actual->copy()->subYears($edad_inicial)->addDay()->startOfDay();
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($fecha_nacimiento_inicial,$fecha_nacimiento_final) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereBetween('fecha_nac', [$fecha_nacimiento_final, $fecha_nacimiento_inicial]);
                    });
        }
    }

    public function scopeBySexo($query, $sexo){
        if ($sexo != null) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($sexo) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->where('sexo', $sexo);
                    });
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('entrega.estado',$estado);
        }
    }

    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
                return $query
                    ->whereIn('entrega.id_barrio', function ($subquery) use($barrio) {
                        $subquery->select('barrios.id')
                            ->from('barrios')
                            //->whereRaw('upper(nombre) like ?', [strtoupper($barrio)]);
                            ->where('nombre','like',$barrio);
                    });
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
            return $query->where('entrega.dea_id',$dea_id);
        }
    }

    public function scopeByPaqueteBarrio($query, $paquete_barrio_id){
        if($paquete_barrio_id != null){
            return $query->where('paquete_barrio_id',$paquete_barrio_id);
        }
    }

    public function scopeByPaquete($query, $paquete_id){
        if($paquete_id != null){
            return $query->where('id_paquete',$paquete_id);
        }
    }

    public function scopeById($query, $id){
        if($id){
            return $query->where('id',$id);
        }
    }

    public function beneficiario(){
        return $this->belongsTo(Beneficiario::class,'id_beneficiario','id');
    }

    public function distrito(){
        return $this->belongsTo(Distrito::class,'distrito_id','id');
    }

    public function barrio(){
        return $this->belongsTo(Barrio::class,'id_barrio','id');
    }

    public function paquete(){
        return $this->belongsTo(Paquetes::class,'id_paquete','id');
    }
}
