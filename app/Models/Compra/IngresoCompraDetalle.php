<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Compra\Proveedor;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\Programa;
use App\Models\Compra\SolicitudCompra;
use App\Models\Almacenes\Almacen;
use App\Models\Compra\OrdenCompra;
use App\Models\Compra\IngresoCompra;
use App\Models\Compra\Item;
use App\Models\Compra\Partida;
use App\Models\Compra\UnidadMedida;

class IngresoCompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'ingresos_compras_detalles';
    protected $fillable = [
        'ingreso_compra_id',
        'almacen_id',
        'user_id',
        'dea_id',
        'proveedor_id',
        'idarea',
        'orden_compra_id',
        'categoria_programatica_id',
        'programa_id',
        'solicitud_compra_id',
        'orden_compra_detalle_id',
        'item_id',
        'partida_id',
        'unidad_id',
        'solicitud_compra_detalle_id',
        'cantidad'
    ];

    public function ingreso_compra(){
        return $this->belongsTo(IngresoCompra::class,'ingreso_compra_id','id');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor_id','id');
    }

    public function area(){
        return $this->belongsTo(Area::class,'idarea','idarea');
    }

    public function orden_compra(){
        return $this->belongsTo(OrdenCompra::class,'idarea','idarea');
    }

    public function programatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function programa(){
        return $this->belongsTo(Programa::class,'programa_id','id');
    }

    public function solicitud_compra(){
        return $this->belongsTo(SolicitudCompra::class,'solicitud_compra_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function partida(){
        return $this->belongsTo(Partida::class,'partida_id','id');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }
}
