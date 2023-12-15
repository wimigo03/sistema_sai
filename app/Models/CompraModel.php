<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Compra\ProveedorModel;
use App\Models\AreasModel;
use App\Models\CatProgModel;
use App\Models\ProgramaModel;
use App\Models\User;
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
                        ];

    const ESTADOS_COMPRA = [
        '1' => 'PENDIENTE',
        '2' => 'APROBADO'
    ];

    const ESTADOS_1 = [
        '' => '',
        '' => '',
        '' => '',
    ];

    const ESTADOS_2 = [
        '' => '',
        '' => '',
        '' => '',
    ];

    const ESTADOS_3 = [
        '' => '',
        '' => '',
        '' => '',
    ];

    public function proveedor(){
        return $this->belongsTo(ProveedorModel::class,'idproveedor','idproveedor');
    }

    public function area(){
        return $this->belongsTo(AreasModel::class,'idarea','idarea');
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

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id',$dea_id);
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

    public function scopeByObjeto($query, $objeto){
        if($objeto){
            return $query->whereRaw('upper(objeto) like ?', ['%'.strtoupper($objeto).'%']);
        }
    }
}
