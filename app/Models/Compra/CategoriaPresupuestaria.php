<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;

class CategoriaPresupuestaria extends Model
{
    use HasFactory;

    protected $table = 'categorias_presupuestarias';
    protected $fillable = [
        'dea_id',
        'categoria_programatica_id',
        'partida_presupuestaria_id',
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

    public function categoriaProgramatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function partidaPresupuestaria(){
        return $this->belongsTo(PartidaPresupuestaria::class,'partida_presupuestaria_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByCategoriaProgramatica($query, $categoria_programatica_id){
        if($categoria_programatica_id){
            return $query->where('categoria_programatica_id',$categoria_programatica_id);
        }
    }

    public function scopeByPartidaPresupuestaria($query, $partida_presupuestaria_id){
        if($partida_presupuestaria_id){
            return $query->where('partida_presupuestaria_id',$partida_presupuestaria_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
