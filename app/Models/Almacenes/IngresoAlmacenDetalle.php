<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Almacenes\IngresoAlmacen;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Almacenes\PartidaPresupuestaria;
use App\Models\Almacenes\Producto;

class IngresoAlmacenDetalle extends Model
{
    use HasFactory;

    protected $table = 'ingresos_almacen_detalles';
    protected $fillable = [
        'ingreso_almacen_id',
        'categoria_programatica_id',
        'partida_presupuestaria_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'estado'
    ];

    const HABILITADO = '1';
    const NO_HABILITADO = '2';

    public function ingreso_almacen(){
        return $this->belongsTo(IngresoAlmacen::class,'ingreso_almacen_id','id');
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
