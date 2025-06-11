<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Canasta\Dea;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\IngresoAlmacen;

class InventarioInicial extends Model
{
    use HasFactory;

    protected $table = 'inventarios_iniciales';
    protected $fillable = [
        'dea_id',
        'almacen_id',
        'ingreso_almacen_id',
        'gestion'
    ];

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function ingreso_almacen(){
        return $this->belongsTo(IngresoAlmacen::class,'ingreso_almacen_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByAlmacenes($query, $almacenes)
    {
        if ($almacenes != null && $almacenes->isNotEmpty()) {
            $almacenIds = $almacenes->pluck('id');

            return $query->whereIn('almacen_id', $almacenIds);
        }

        return $query;
    }

    public function scopeBySucursal($query, $sucursal){
        if (!is_null($sucursal)) {
            return $query
                ->whereIn('almacen_id', function ($subquery) use($sucursal) {
                    $subquery->select('id')
                        ->from('almacenes')
                        ->where(DB::raw('UPPER(nombre)'), 'LIKE', '%' . strtoupper($sucursal) . '%');
                });
        }
    }

    public function scopeByGestion($query, $gestion){
        if($gestion != null){
            return $query->where('gestion', $gestion);
        }
    }
}
