<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Area;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Almacenes\Proveedor;
use App\Models\Almacenes\Almacen;

class IngresoAlmacen extends Model
{
    use HasFactory;

    protected $table = 'ingresos_almacen';
    protected $fillable = [
        'dea_id',
        'almacen_id',
        'user_id',
        'proveedor_id',
        'area_id',
        'codigo',
        'n_preventivo',
        'n_factura',
        'n_orden_compra',
        'n_cotizacion',
        'n_solicitud',
        'fecha_ingreso',
        'obs',
        'estado'
    ];

    const PENDIENTE = '1';
    const INGRESADO = '2';
    const ANULADO = '3';

    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'INGRESADO',
        '3' => 'ANULADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "INGRESADO";
            case '3':
                return "ANULADO";
        }
    }

    public function getcolorBadgeStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function getcolorInputStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "text-white bg-secondary";
            case '2':
                return "text-white bg-success";
            case '3':
                return "text-white bg-danger";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "text-secondary";
            case '2':
                return "text-success";
            case '3':
                return "text-danger";
        }
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
        return $this->belongsTo(Area::class,'area_id','idarea');
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

    public function scopeByProveedor($query, $proveedor){
        if (!is_null($proveedor)) {
            return $query
                ->whereIn('proveedor_id', function ($subquery) use($proveedor) {
                    $subquery->select('id')
                        ->from('proveedor')
                        ->where(DB::raw('UPPER(nombre)'), 'LIKE', '%' . strtoupper($proveedor) . '%');
                });
        }
    }

    public function scopeBySolicitante($query, $solicitante){
        if (!is_null($solicitante)) {
            return $query
                ->whereIn('area_id', function ($subquery) use($solicitante) {
                    $subquery->select('idarea')
                        ->from('areas')
                        ->where(DB::raw('UPPER(nombrearea)'), 'LIKE', '%' . strtoupper($solicitante) . '%');
                });
        }
    }

    public function scopeByNroPreventivo($query, $nro_preventivo){
        if (!is_null($nro_preventivo)) {
            return $query->where('n_preventivo', $nro_preventivo);
        }
    }

    public function scopeByNroOrdenCompra($query, $nro_orden_compra){
        if (!is_null($nro_orden_compra)) {
            return $query->where('n_orden_compra', $nro_orden_compra);
        }
    }

    public function scopeByNroSolicitud($query, $nro_solicitud){
        if (!is_null($nro_solicitud)) {
            return $query->where('n_solicitud', $nro_solicitud);
        }
    }

    public function scopeByFechaRegistro($query, $fecha_registro){
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
    }

    public function scopeByEstado($query, $estado){
        if(!is_null($estado)){
            return $query->where('estado', $estado);
        }
    }
}
