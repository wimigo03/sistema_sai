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
use App\Models\Compra\Item;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\UnidadMedida;

class SolicitudMaterialDetalle extends Model
{
    use HasFactory;

    protected $table = 'solicitud_materiales_detalles';
    protected $fillable = [
        'solicitud_material_id',
        'dea_id',
        'user_solicitud_id',
        'solicitud_idemp',
        'solicitud_idarea',
        'categoria_programatica_id',
        'user_aprobado_id',
        'aprobado_idarea',
        'aprobado_idemp',
        'partida_presupuestaria_id',
        'item_id',
        'unidad_id',
        'almacen_id',
        'cant_solicitada',
        'cant_autorizada',
        'estado',
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'ELIMINADO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "ELIMINADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
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
