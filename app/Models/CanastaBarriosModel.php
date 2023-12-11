<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanastaBarriosModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'barrios';
    protected $primaryKey= 'idBarrio';

    protected $fillable = [
        'barrio',
        'tipo',
        'distrito',
        'estado'
    ];

    const TIPOS_BARRIO = [
        'Barrio' => 'BARRIO',
        'Comunidad' => 'COMUNIDAD'
    ];

    const DISTRITOS = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8'
    ];

    const ESTADOS = [
        'A' => 'HABILITADOS',
        'B' => 'NO HABILITADOS',
        'X' => 'ELIMINADOS'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A': 
                return "HABILITADO";
            case 'B': 
                return "NO HABILITADO";
            case 'X': 
                return "ELIMINADO";
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('idBarrio', $codigo);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->where('barrio', 'like', '%'.$nombre.'%');
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByDistrito($query, $distrito){
        if($distrito){
            return $query->where('distrito', $distrito);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
