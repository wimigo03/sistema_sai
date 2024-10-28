<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Compra\Proveedor;
use App\Models\Compra\SolicitudCompra;
use App\Models\Almacenes\Almacen;
use DB;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'orden_compras';
    protected $fillable = [
        'dea_id',
        'proveedor_id',
        'user_id',
        'almacen_id',
        'solicitud_compra_id',
        'idemp',
        'categoria_programatica_id',
        'idarea',
        'user_aprob_id',
        'codigo',
        'objeto',
        'justificacion',
        'nro_preventivo',
        'tipo',
        'c_interno',
        'fecha_registro',
        'fecha_aprob',
        'estado'
    ];

    const ALMACEN_CENTRAL = 1;
    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'APROBADO',
        '3' => 'RECHAZADO',
    ];

    const TIPOS = [
        '1' => 'PRODUCTO',
        '2' => 'SERVICIO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "APROBADO";
            case '3':
                return "RECHAZADO";
        }
    }

    public function getTiposAttribute(){
        switch ($this->tipo) {
            case '1':
                return "PRODUCTO";
            case '2':
                return "SERVICIO";
        }
    }

    public function getcolorBadgeStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
            case '3':
                return "badge-with-padding badge badge-danger";
            case '4':
                return "badge-with-padding badge badge-info";
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
            case '4':
                return "text-white bg-info";
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
            case '4':
                return "text-info";
        }
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

    public function solicitante(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }

    public function solicitud_compra(){
        return $this->belongsTo(SolicitudCompra::class,'solicitud_compra_id','id');
    }

    public function aprobante(){
        return $this->belongsTo(User::class,'user_aprob_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByNroOrdenCompra($query, $nro_oc){
        if($nro_oc){
            return $query->where('codigo', $nro_oc);
        }
    }

    public function scopeByNroSolicitud($query, $nro_solicitud){
        if ($nro_solicitud) {
                return $query
                    ->whereIn('solicitud_compra_id', function ($subquery) use($nro_solicitud) {
                        $subquery->select('id')
                            ->from('solicitud_compras')
                            ->where('codigo', $nro_solicitud);
                    });
        }
    }

    public function scopeByNroPreventivo($query, $nro_preventivo){
        if($nro_preventivo){
            return $query->where('nro_preventivo', $nro_preventivo);
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeByProveedor($query, $proveedor_id){
        if($proveedor_id){
            return $query->where('proveedor_id', $proveedor_id);
        }
    }

    public function scopeBySolicitante($query, $user_id){
        if($user_id){
            return $query->where('user_id', $user_id);
        }
    }

    public function scopeByFechaRegistro($query, $from){
        if ($from) {
            $from = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $from)));
            $to = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $from)));
            return $query->where(
                'fecha_registro','>=',$from
            )
            ->where('fecha_registro', '<=', $to);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
