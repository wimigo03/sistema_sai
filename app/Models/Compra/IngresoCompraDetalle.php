<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Compra\Proveedor;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\SolicitudCompra;
use App\Models\Almacenes\Almacen;
use App\Models\Compra\OrdenCompra;
use App\Models\Compra\IngresoCompra;
use App\Models\Compra\Item;
use App\Models\Compra\PartidaPresupuestaria;
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
        'solicitud_compra_id',
        'idemp',
        'orden_compra_detalle_id',
        'item_id',
        'partida_presupuestaria_id',
        'unidad_id',
        'categoria_programatica_id',
        'solicitud_compra_detalle_id',
        'cantidad',
        'saldo',
        'estado'
    ];

    public function ingresoCompra(){
        return $this->belongsTo(IngresoCompra::class,'ingreso_compra_id','id');
    }

    public function ingresoCompraAprobados(){
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

    public function categoriaProgramatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function solicitud_compra(){
        return $this->belongsTo(SolicitudCompra::class,'solicitud_compra_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function partidaPresupuestaria(){
        return $this->belongsTo(PartidaPresupuestaria::class,'partida_presupuestaria_id','id');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByAlmacen($query, $almacen_id){
        if($almacen_id != null){
            return $query->where('almacen_id', $almacen_id);
        }
    }

    public function scopeByProducto($query, $item_id){
        if($item_id != null){
            return $query->where('item_id', $item_id);
        }
    }

    public function scopeByPartidaPresupuestaria($query, $partida_presupuestaria_id){
        if($partida_presupuestaria_id != null){
            return $query->where('partida_presupuestaria_id', $partida_presupuestaria_id);
        }
    }

    public function scopeByItem($query, $item){
        if ($item != null) {
                return $query
                    ->whereIn('item_id', function ($subquery) use($item) {
                        $subquery->select('id')
                            ->from('items')
                            ->where('nombre','like','%' . $item . '%');
                    });
        }
    }
}
