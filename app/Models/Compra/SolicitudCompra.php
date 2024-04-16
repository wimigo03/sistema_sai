<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AreasModel;
use App\Models\User;
use App\Models\Canasta\Dea;

class SolicitudCompra extends Model
{
    use HasFactory;

    protected $table = 'solicitud_compras';
    protected $fillable = [
        'idarea',
        'user_id',
        'dea_id',
        'user_aprob_id',
        'codigo',
        'detalle',
        'tipo',
        'c_interno',
        'fecha_registro',
        'fecha_aprob',
        'obs',
        'estado'
    ];

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

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
            case '3':
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

    public function area(){
        return $this->belongsTo(AreasModel::class,'idarea','idarea');
    }

    public function solicitante(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function aprobante(){
        return $this->belongsTo(User::class,'user_aprob_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByNroSolicitud($query, $nro_solicitud){
        if($nro_solicitud){
            return $query->where('codigo', $nro_solicitud);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeBySolicitante($query, $user_id){
        if($user_id){
            return $query->where('user_id', $user_id);
        }
    }

    public function scopeByAprobante($query, $user_id){
        if($user_id){
            return $query->where('user_aprob_id', $user_id);
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByControlInterno($query, $control_interno){
        if($control_interno){
            return $query->where('c_interno', $control_interno);
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
