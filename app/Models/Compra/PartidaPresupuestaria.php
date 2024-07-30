<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;
use App\Models\Compra\CategoriaProgramatica;

class PartidaPresupuestaria extends Model
{
    protected $table = 'partidas_presupuestarias';
    protected $fillable = [
        'dea_id',
        'categoria_programatica_id',
        'numeracion',
        'codigo',
        'parent_id',
        'nombre',
        'descripcion',
        'detalle',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
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

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function categoria_programatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByHijos($query, $parent_id){
        if($parent_id != null){
            return $query->where('parent_id', $parent_id);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo != null){
            return $query->where('codigo', $codigo);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre != null){
            return $query->where('nombre','like', '%' . $nombre . '%');
        }
    }

    public function scopeByDetalle($query, $detalle){
        if($detalle != null){
            return $query->where('detalle','like', '%' . $detalle . '%');
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
