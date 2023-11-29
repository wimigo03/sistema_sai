<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanastaPeriodosModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'periodos';
    protected $primaryKey= 'idPeriodo';

    protected $fillable = [
        'gestion',
        'mes',
        'nro_entrega',
        'detalle',
        'obs',
        'estado'
    ];

    const ESTADOS = [
        'A' => 'A',
        'F' => 'F',
        'P' => 'P'
    ];

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

    public function scopeByPeriodo($query, $periodo){
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
    }
}
