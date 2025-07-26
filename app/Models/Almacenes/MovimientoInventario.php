<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Canasta\Dea;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Almacenes\PartidaPresupuestaria;
use App\Models\Almacenes\Producto;
use App\Models\Almacenes\IngresoAlmacen;
use App\Models\Almacenes\SalidaAlmacen;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';
    protected $fillable = [
        'dea_id',
        'almacen_id',
        'categoria_programatica_id',
        'partida_presupuestaria_id',
        'producto_id',
        'tipo_movimiento',
        'cantidad',
        'fecha',
        'referencia_id',
        'estado'
    ];

    const HABILITADO = 1;
    const NO_HABILITADO = 2;

    const INGRESO = 1;
    const SALIDA = 2;
    const TRASPASO_ENTRADA = 3;
    const TRASPASO_SALIDA = 4;
    const AJUSTE = 5;

    public function getMovimientoTipoAttribute(){
        switch ($this->tipo_movimiento) {
            case '1':
                if($this->codigo != 0){
                    return "INGRESO POR COMPRA";
                }else{
                    return "BALANCE INICIAL";
                }
            case '2':
                return "SALIDA";
            case '3':
                return "INGRESO POR TRASPASO";
            case '4':
                return "SALIDA POR TRASPASO";
            case '5':
                return "AJUSTE";
        }
    }

    public function getMovimientoTipoBadgeAttribute(){
        switch ($this->tipo_movimiento) {
            case '1':
                if($this->codigo != 0){
                    return "<span class='btn btn-xs btn-success'><i class='fas fa-arrow-alt-circle-left fa-fw'></i></span>";
                }else{
                    return "<span class='btn btn-xs btn-primary'><i class='fas fa-arrow-alt-circle-left fa-fw'></i></span>";
                }
            case '2':
                return "<span class='btn btn-xs btn-danger'><i class='fas fa-arrow-alt-circle-right fa-fw'></i></span>";
            case '3':
                return "INGRESO POR TRASPASO";
            case '4':
                return "SALIDA POR TRASPASO";
            case '5':
                return "AJUSTE";
        }
    }

    public function getReferenciaAttribute(){
        switch ($this->tipo_movimiento) {
            case '1':
                return $this->belongsTo(IngresoAlmacen::class,'referencia_id','id')->first();
            case '2':
                return $this->belongsTo(SalidaAlmacen::class,'referencia_id','id')->first();
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }

    public function categoriaProgramatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function partidaPresupuestaria(){
        return $this->belongsTo(PartidaPresupuestaria::class,'partida_presupuestaria_id','id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
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

    public function scopeByCategoriaProgramatica($query, $categoria_programatica_id){
        if($categoria_programatica_id != null){
            return $query->where('categoria_programatica_id', $categoria_programatica_id);
        }
    }

    public function scopeByPartidaPresupuestaria($query, $partida_presupuestaria_id){
        if($partida_presupuestaria_id != null){
            return $query->where('partida_presupuestaria_id', $partida_presupuestaria_id);
        }
    }

    public function scopeByProducto($query, $producto_id){
        if($producto_id != null){
            return $query->where('producto_id', $producto_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
