<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;
use App\Models\Compra\UnidadMedida;

class UnidadMedida extends Model
{
    protected $table = 'unidades';
    protected $fillable = [
        'dea_id',
        'nombre',
        'alias',
        'tipo',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
    ];

    const TIPOS = [
        '1' => 'PRODUCTO',
        '2' => 'SERVICIO',
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
                return "PRODUCTO";
            case '2':
                return "SERVICIO";
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

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','like', '%' . $nombre . '%');
        }
    }

    public function scopeByAlias($query, $alias){
        if($alias){
            return $query->where('alias', $alias);
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
