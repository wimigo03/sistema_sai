<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Canasta\Dea;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Almacenes\PartidaPresupuestaria;

class Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'presupuestos';
    protected $fillable = [
        'dea_id',
        'categoria_programatica_id',
        'partida_presupuestaria_id',
        'monto',
        'trimestre',
        'gestion'
    ];

    const TRIMESTRES = [
        '1' => '1°',
        '2' => '2°',
        '3' => '3°',
        '4' => '4°',
    ];

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function categoria_programatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }


    public function partida_presupuestaria(){
        return $this->belongsTo(PartidaPresupuestaria::class,'partida_presupuestaria_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
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

    public function scopeByTrimestre($query, $trimestre){
        if($trimestre != null){
            return $query->where('trimestre', $trimestre);
        }
    }

    public function scopeByGestion($query, $gestion){
        if($gestion != null){
            return $query->where('gestion', $gestion);
        }
    }

    /*public function scopeBySucursal($query, $sucursal){
        if (!is_null($sucursal)) {
            return $query
                ->whereIn('almacen_id', function ($subquery) use($sucursal) {
                    $subquery->select('id')
                        ->from('almacenes')
                        ->where(DB::raw('UPPER(nombre)'), 'LIKE', '%' . strtoupper($sucursal) . '%');
                });
        }
    }*/
}
