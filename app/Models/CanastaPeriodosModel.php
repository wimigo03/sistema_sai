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
        'A' => 'NO DEFINIDO',
        'F' => 'FINALIZADO',
        'P' => 'INICIO DE ENTREGA'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A': 
                return "NO DEFINIDO";
            case 'F': 
                return "FINALIZADO";
            case 'P': 
                return "INICIO DE ENTREGA";
        }
    }

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
