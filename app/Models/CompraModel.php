<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Compra\ProveedorModel;
use App\Models\Area;
use App\Models\CatProgModel;
use App\Models\ProgramaModel;
use App\Models\User;
use App\Models\Canasta\Dea;
class CompraModel extends Model
{
    protected $table = 'compra';
    protected $primaryKey= 'idcompra';
    protected $fillable = [
                            'objeto',
                            'justificacion',
                            'preventivo',
                            'estadocompra',
                            'tipo',
                            'estado1',
                            'estado2',
                            'estado3',
                            'numcompra',
                            'controlinterno',
                            'created_at',
                            'updated_at',
                            'idproveedor',
                            'idarea',
                            'idcatprogramatica',
                            'idprograma',
                            'idusuario',
                            'dea_id'
                            ,'fecha_preventivo'
                        ];

    const ESTADOS_COMPRA = [
        '1' => 'PENDIENTE',
        '2' => 'APROBADO',
        '3' => 'RECHAZADO',
        '4' => 'ANULADO'
    ];

    public function proveedor(){
        return $this->belongsTo(ProveedorModel::class,'idproveedor','idproveedor');
    }

    public function area(){
        return $this->belongsTo(Area::class,'idarea','idarea');
    }

    public function cat_prog(){
        return $this->belongsTo(CatProgModel::class,'idcatprogramatica','idcatprogramatica');
    }

    public function programa(){
        return $this->belongsTo(ProgramaModel::class,'idprograma','idprograma');
    }

    public function user(){
        return $this->belongsTo(User::class,'idusuario','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function getEstadoAttribute(){
        switch ($this->estadocompra) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "APROBADO";
            case '3':
                return "RECHAZADO";
            case '4':
                return "ANULADO";
        }
    }

    public function getColorEstadoAttribute(){
        switch ($this->estadocompra) {
            case '1':
                return "text-secondary";
            case '2':
                return "text-success";
            case '3':
                return "text-danger";
            case '4':
                return "text-warning";
        }
    }

    public function getTipoCompraAttribute(){
        switch ($this->tipo) {
            case '1':
                return "PRODUCTO";
            case '2':
                return "SERVICIO";
        }
    }

    public static function verificarControlInterno($nro_control, $area_id){
        return self::where('controlinterno', $nro_control)
                    ->where('idarea', $area_id)
                    ->exists();
    }

    public static function verificarControlInternoUpdate($nro_control, $area_id, $compra_id){
        return self::where('controlinterno', $nro_control)
                    ->where('idarea', $area_id)
                    ->where('idcompra','!=', $compra_id)
                    ->exists();
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id != null){
            return $query->where('idarea',$area_id);
        }
    }

    public function scopeByCodigoId($query, $codigo_id){
        if($codigo_id != null){
            return $query->where('idcompra',$codigo_id);
        }
    }

    public function scopeByControlInterno($query, $nro_control){
        if($nro_control != null){
            return $query->where('controlinterno',$nro_control);
        }
    }

    public function scopeByPreventivo($query, $nro_preventivo){
        if($nro_preventivo != null){
            return $query->where('preventivo',$nro_preventivo);
        }
    }

    public function scopeByFechaPreventivo($query, $fecha){
        if ($fecha) {
                $fecha_i = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $fecha)));
                $fecha_f = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $fecha)));
                return $query->where(
                    'fecha_preventivo','>=',$fecha_i
                )
                ->where('fecha_preventivo', '<=',$fecha_f);
        }
    }

    public function scopeByPrograma($query, $programa_id){
        if($programa_id != null){
            return $query->where('idprograma',$programa_id);
        }
    }

    public function scopeByCategoriaProgramatica($query, $programatica_id){
        if($programatica_id != null){
            return $query->where('idcatprogramatica',$programatica_id);
        }
    }

    public function scopeByObjeto($query, $objeto){
        if($objeto){
            return $query->whereRaw('upper(objeto) like ?', ['%'.strtoupper($objeto).'%']);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estadocompra',$estado);
        }
    }
}
