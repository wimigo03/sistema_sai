<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CanastaBeneficiariosModel;
use App\Models\CanastaAdminModel;
use App\Models\CanastaBarriosModel;

class CanastaEntregasModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'entregas';
    protected $primaryKey= 'idEntrega';

    protected $fillable = [
        '_registrado',
        '_modificado',
        'ci',
        'obs',
        'estado',
        'impresion',
        'codigo',
        'idUsuario',
        'idAdmin',
        'idPeriodo',
        'idBarrio',
        'idBrigadista',
        'idRezagado'
    ];

    /*const ESTADOS = [
        'A' => 'A',
        'F' => 'F',
        'P' => 'P'
    ];*/

    /*public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A': 
                return "HABILITADO";
            case 'B': 
                return "NO HABILITADO";
            case 'X': 
                return "ELIMINADO";
        }
    }*/

    public function usuario(){
        return $this->belongsTo(CanastaBeneficiariosModel::class,'idUsuario');
    }

    public function admin(){
        return $this->belongsTo(CanastaAdminModel::class,'idAdmin');
    }

    public function barrio(){
        return $this->belongsTo(CanastaBarriosModel::class,'idBarrio');
    }

    public function brigadista(){
        return $this->belongsTo(CanastaAdminModel::class,'idBrigadista');
    }

    /*public function scopeByPeriodo($query, $periodo){
        if($periodo){
            return $query->where('idPeriodo', $periodo);
        }
    }

    public function scopeByGestion($query, $gestion){
        if($gestion){
            return $query->where('gestion',$gestion);
        }
    }

    public function scopeByMes($query, $mes){
        if($mes){
            return $query->where('mes', $mes);
        }
    }

    public function scopeByNroEntrega($query, $nro_entrega){
        if($nro_entrega){
            return $query->where('nro_entrega', $nro_entrega);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }*/
}
