<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Canasta\Dea;
use App\Models\User;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\Almacenes\SolicitudMaterial;
use App\Models\Almacenes\Almacen;

class SalidaAlmacen extends Model
{
    use HasFactory;

    protected $table = 'salidas_almacen';
    protected $fillable = [
        'dea_id',
        'solicitud_material_id',
        'user_solicitud_id',
        'solicitud_idemp',
        'solicitud_idarea',
        'user_aprobado_id',
        'aprobado_idemp',
        'aprobado_idarea',
        'categoria_programatica_id',
        'user_salida_id',
        'salida_idemp',
        'salida_idarea',
        'almacen_id',
        'cod_salida',
        'fcreate',
        'fsalida',
        'obs',
        'estado',
    ];

    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'ENTREGADO',
        '3' => 'ANULADO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "ENTREGADO";
            case '3':
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
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id != null){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeByFechas($query, $finicial, $ffinal){
        if(!is_null($finicial) && !is_null($ffinal)){
            $finicial = Carbon::createFromFormat('d/m/Y', $finicial)->format('Y-m-d 00:00:00');
            $ffinal = Carbon::createFromFormat('d/m/Y', $ffinal)->format('Y-m-d 23:59:59');
            return $query->whereBetween('created_at',[$finicial,$ffinal]);
        }
    }

    /*

    public function scopeByDireccion($query, $direccion){
        if($direccion != null){
            return $query->where('direccion', 'like', '%'.$direccion.'%');
        }
    }

    public function scopeByEncargado($query, $user_id){
        if($user_id != null){
            return $query->where('user_id', $user_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    } */
}
