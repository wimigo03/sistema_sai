<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Canasta\Dea;
use App\Models\User;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\Compra\CategoriaProgramatica;;

class SolicitudMaterial extends Model
{
    use HasFactory;

    protected $table = 'solicitud_materiales';
    protected $fillable = [
        'dea_id',
        'user_solicitud_id',
        'solicitud_idemp',
        'solicitud_idarea',
        'user_aprobado_id',
        'aprobado_idarea',
        'aprobado_idemp',
        'categoria_programatica_id',
        'almacen_id',
        'cod_solicitud',
        'fsolicitud',
        'faprobacion',
        'obs',
        'estado',
    ];

    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'APROBADO',
        '3' => 'RECHAZADO',
        '4' => 'ANULADO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "APROBADO";
            case '3':
                return "RECHAZADO";
            case '4':
                return "ENTREGADO";
            case '5':
                return "ANULADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
            case '3':
                return "badge-with-padding badge badge-danger";
            case '4':
                return "badge-with-padding badge badge-info";
            case '5':
                return "badge-with-padding badge badge-warning";
        }
    }

    public function getInputStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "bg-secondary text-white";
            case '2':
                return "bg-success text-white";
            case '3':
                return "bg-danger text-white";
            case '4':
                return "bg-info";
            case '5':
                return "bg-warning";
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function solicitante(){
        return $this->belongsTo(User::class,'user_solicitud_id','id');
    }

    public function aprobante(){
        return $this->belongsTo(User::class,'user_aprobado_id','id');
    }

    public function area(){
        return $this->belongsTo(Area::class,'solicitud_idarea','idarea');
    }

    public function cprogramatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo != null){
            return $query->where('cod_solicitud', 'like','%' . $codigo . '%');
        }
    }

    /* public function scopeByFechas($query, $finicial, $ffinal){
        if(!is_null($finicial) && !is_null($ffinal)){
            $finicial = Carbon::createFromFormat('d/m/Y', $finicial)->format('Y-m-d 00:00:00');
            $ffinal = Carbon::createFromFormat('d/m/Y', $ffinal)->format('Y-m-d 23:59:59');
            return $query->whereBetween('created_at',[$finicial,$ffinal]);
        }
    } */

    public function scopeByFecha($query, $fecha){
        if(!is_null($fecha)){
            $finicial = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d 00:00:00');
            $ffinal = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d 23:59:59');
            return $query->whereBetween('fsolicitud',[$finicial,$ffinal]);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id != null){
            return $query->where('solicitud_idarea', $area_id);
        }
    }

    public function scopeBySolicitante($query, $user_id){
        if($user_id != null){
            return $query->where('user_solicitud_id', $user_id);
        }
    }

    public function scopeByPrograma($query, $programa_id){
        if($programa_id != null){
            return $query->where('categoria_programatica_id', $programa_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
