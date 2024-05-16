<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
    use HasFactory;

    protected $table = 'facebook';
    protected $fillable = [
        'dea_id',
        'titulo',
        'fecha',
        'publicacion',
        'estado',
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
        '3' => 'ELIMINADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
            case '3':
                return "ELIMINADO";
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

    public function scopeByFecha($query, $from){
        if ($from) {
            $from = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $from)));
            $to = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $from)));
            return $query->where(
                'fecha','>=',$from
            )
            ->where('fecha', '<=', $to);
        }
    }

    public function scopeByTitulo($query, $titulo){
        if($titulo){
            return $query->where('titulo', 'like', '%' . $titulo . '%');
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
