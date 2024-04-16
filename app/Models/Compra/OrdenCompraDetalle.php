<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AreasModel;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Compra\Proveedor;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\Programa;
use App\Models\Compra\SolicitudCompra;
use App\Models\Compra\Item;
use App\Models\Compra\Partida;
use App\Models\Compra\UnidadMedida;
use App\Models\Compra\OrdenCompra;
use App\Models\Compra\SolicitudCompraDetalle;

class OrdenCompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'orden_compra_detalles';
    protected $fillable = [
        'item_id',
        'dea_id',
        'user_id',
        'partida_id',
        'unidad_id',
        'orden_compra_id',
        'proveedor_id',
        'idarea',
        'almacen_id',
        'categoria_programatica_id',
        'programa_id',
        'solicitud_compra_id',
        'solicitud_compra_detalle_id',
        'cantidad',
        'precio',
        'saldo',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function solicitante(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function partida(){
        return $this->belongsTo(Partida::class,'partida_id','id');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
    }

    public function orden_compra(){
        return $this->belongsTo(OrdenCompra::class,'orden_compra_id','id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor_id','id');
    }

    public function area(){
        return $this->belongsTo(AreasModel::class,'idarea','idarea');
    }

    /*public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }*/

    public function programatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function programa(){
        return $this->belongsTo(Programa::class,'programa_id','id');
    }

    public function solicitud_compra(){
        return $this->belongsTo(SolicitudCompra::class,'solicitud_compra_id','id');
    }

    public function solicitud_compra_detalle(){
        return $this->belongsTo(SolicitudCompraDetalle::class,'solicitud_compra_detalle_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    /*public function scopeByNroSolicitud($query, $nro_solicitud){
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
    }*/
}
