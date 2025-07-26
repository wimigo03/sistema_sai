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

class InventarioAlmacen extends Model
{
    use HasFactory;

    protected $table = 'inventario_almacen';
    protected $fillable = [
        'dea_id',
        'almacen_id',
        'categoria_programatica_id',
        'partida_presupuestaria_id',
        'producto_id',
        'stock_actual',
        'stock_reservado'
    ];

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

    public function scopeByInventarioAlmacen($query, $inventario_almacen_id){
        if($inventario_almacen_id != null){
            return $query->where('id', $inventario_almacen_id);
        }
    }

    public function scopeByAlmacen($query, $almacen_id){
        if($almacen_id != -1){
            return $query->where('almacen_id', $almacen_id);
        }
    }

    public function scopeByCategoriaProgramatica($query, $categoria_programatica_id){
        if ($categoria_programatica_id != -1) {
            return $query->where('categoria_programatica_id', $categoria_programatica_id);
        }
    }

    public function scopeByPartidaPresupuestaria($query, $partida_presupuestaria_id){
        if($partida_presupuestaria_id != -1){
            return $query->where('partida_presupuestaria_id', $partida_presupuestaria_id);
        }
    }

    public function scopeByProducto($query, $producto_id){
        if($producto_id != -1){
            return $query->where('producto_id', $producto_id);
        }
    }
}
