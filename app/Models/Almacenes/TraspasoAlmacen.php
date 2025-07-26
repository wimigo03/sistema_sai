<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Area;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Almacenes\IngresoAlmacen;
use App\Models\Almacenes\Almacen;

class TraspasoAlmacen extends Model
{
    use HasFactory;

    protected $table = 'traspasos_almacen';
    protected $fillable = [
        'dea_id',
        'ingreso_almacen_id',
        'almacen_origen_id',
        'almacen_destino_id',
        'user_traspaso_id',
        'user_salida_id',
        'user_ingreso_id',
        'codigo',
        'fecha_traspaso',
        'fecha_salida',
        'fecha_ingreso',
        'obs',
        'estado'
    ];

    const GENERADO = '1';
    const TRASPASO_SALIENTE = '2';
    const TRASPASO_ENTRANTE = '3';
    const ANULADO = '4';

    const ESTADOS = [
        '1' => 'GENERADO',
        '2' => 'TRASPASO_SALIENTE',
        '3' => 'TRASPASO_ENTRANTE',
        '4' => 'ANULADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "GENERADO";
            case '2':
                return "TRASPASO SALIENTE";
            case '3':
                return "TRASPASO ENTRANTE";
            case '4':
                return "ANULADO";
        }
    }

    public function getcolorBadgeStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-warning";
            case '3':
                return "badge-with-padding badge badge-warning";
            case '4':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function ingreso_almacen(){
        return $this->belongsTo(IngresoAlmacen::class,'ingreso_almacen_id','id');
    }

    public function almacen_origen(){
        return $this->belongsTo(Almacen::class,'almacen_origen_id','id');
    }

    public function almacen_destino(){
        return $this->belongsTo(Almacen::class,'almacen_destino_id','id');
    }

    public function user_traspaso(){
        return $this->belongsTo(User::class,'user_traspaso_id','id');
    }

    public function user_salida(){
        return $this->belongsTo(User::class,'user_salida_id','id');
    }

    public function user_ingreso(){
        return $this->belongsTo(User::class,'user_ingreso_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo != null){
            return $query->where('codigo', 'like', '%' . $codigo . '%');
        }
    }

    public function scopeByAlmacenesSalida($query, $almacenes)
    {
        if ($almacenes != null && $almacenes->isNotEmpty()) {
            $almacenIds = $almacenes->pluck('id');

            return $query->whereIn('almacen_destino_id', $almacenIds);
        }

        return $query;
    }

    /*public function scopeByFechaRegistro($query, $fecha_registro){
        if(!is_null($fecha_registro)){
            $finicial = Carbon::createFromFormat('d-m-Y', $fecha_registro)->format('Y-m-d 00:00:00');
            $ffinal = Carbon::createFromFormat('d-m-Y', $fecha_registro)->format('Y-m-d 23:59:59');
            return $query->whereBetween('created_at',[$finicial,$ffinal]);
        }
    }

    public function scopeByFechaIngreso($query, $fecha_ingreso){
        if(!is_null($fecha_ingreso)){
            $finicial = Carbon::createFromFormat('d-m-Y', $fecha_ingreso)->format('Y-m-d 00:00:00');
            $ffinal = Carbon::createFromFormat('d-m-Y', $fecha_ingreso)->format('Y-m-d 23:59:59');
            return $query->whereBetween('fecha_ingreso',[$finicial,$ffinal]);
        }
    }*/

    public function scopeByEstado($query, $estado){
        if(!is_null($estado)){
            return $query->where('estado', $estado);
        }
    }
}
