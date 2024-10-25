<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Canasta\Dea;
use App\Models\User;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\Almacenes\SolicitudMaterial;
use App\Models\Almacenes\SolicitudMaterialDetalle;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\SalidaAlmacen;
use App\Models\Compra\Item;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\UnidadMedida;

class SalidaAlmacenDetalle extends Model
{
    use HasFactory;

    protected $table = 'salidas_almacen_detalles';
    protected $fillable = [
        'dea_id',
        'salida_almacen_id',
        'solicitud_material_id',
        'solicitud_material_detalle_id',
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
        'partida_presupuestaria_id',
        'item_id',
        'unidad_id',
        'almacen_id',
        'cant_salida',
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

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('almacenes.dea_id', $dea_id);
        }
    }

    /* public function scopeByNombre($query, $nombre){
        if($nombre != null){
            return $query->where('nombre', 'like', '%'.$nombre.'%');
        }
    }

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
