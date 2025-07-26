<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Almacenes\SalidaAlmacen;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Almacenes\PartidaPresupuestaria;
use App\Models\Almacenes\Producto;
use App\Models\Almacenes\InventarioAlmacen;

class SalidaAlmacenDetalle extends Model
{
    use HasFactory;

    protected $table = 'salidas_almacen_detalles';
    protected $fillable = [
        'salida_almacen_id',
        'categoria_programatica_id',
        'partida_presupuestaria_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'estado'
    ];

    const HABILITADO = '1';
    const NO_HABILITADO = '2';

    public function salida_almacen(){
        return $this->belongsTo(SalidaAlmacen::class,'salida_almacen_id','id');
    }

    public function categoria_programatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function partida_presupuestaria(){
        return $this->belongsTo(PartidaPresupuestaria::class,'partida_presupuestaria_id','id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }

    public function getStockDisponibleAttribute(){
        $inventario_almacen = InventarioAlmacen::byDea($this->salida_almacen->dea_id)
                            ->byAlmacen($this->salida_almacen->almacen_id)
                            ->byCategoriaProgramatica($this->categoria_programatica_id)
                            ->byPartidaPresupuestaria($this->partida_presupuestaria_id)
                            ->byProducto($this->producto_id)
                            ->first();

        if(isset($inventario_almacen)){
            $cantidad_actual = $inventario_almacen->stock_actual;
            $cantidad_reserva = $inventario_almacen->stock_reservado;
            $inventario_almacen_id = $inventario_almacen->id;
        }else{
            $cantidad_actual = 0;
            $cantidad_reserva = 0;
            $inventario_almacen_id = 0;
        }

        return [
            'cantidad_actual' => $cantidad_actual,
            'cantidad_reserva' => $cantidad_reserva,
            'inventario_almacen_id' => $inventario_almacen_id
        ];
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
