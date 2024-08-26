<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocupaciones extends Model
{
    protected $table = 'ocupaciones';
    protected $fillable = [
        'estado',
        'ocupacion',
        'tipo'
    ];

    const PROFESIONES = 1;
    const OCUPACIONES = 2;
    
    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    const TIPOS = [
        '1' => 'PROFESION',
        '2' => 'OCUPACION'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
        }
    }

    public function getTiposAttribute(){
        switch ($this->tipo) {
            case '1':
                return "PROFESION";
            case '2':
                return "OCUPACION";
        }
    }

    public function scopeByOcupacion($query, $ocupacion){
        if($ocupacion != null){
            return $query->where('ocupacion', 'like', '%' . $ocupacion . '%');
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo != null){
            return $query->where('tipo',$tipo);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado',$estado);
        }
    }
}
