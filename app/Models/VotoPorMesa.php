<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mesa;
use App\Models\PartidosYEspeciales;
use App\Models\TipoVotacion;

class VotoPorMesa extends Model
{
    protected $table = 'votos_por_mesa';
    public $timestamps = false;
    protected $fillable = [
        'mesa_id',
        'partido_id',
        'tipo_votacion_id',
        'cantidad',
        'estado',
    ];

    const HABILITADO = 1;
    const NO_HABILITADO = 2;

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
                return "badge-with-padding badge badge-secondary";
        }
    }

    public function mesa(){
        return $this->belongsTo(Mesa::class,'mesa_id','id');
    }

    public function partido(){
        return $this->belongsTo(PartidosYEspeciales::class,'partido_id','id');
    }

    public function tipo_votacion(){
        return $this->belongsTo(TipoVotacion::class,'tipo_votacion_id','id');
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
