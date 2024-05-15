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
        '1' => 'EN ESPERA',
        '2' => 'CONCLUIDO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "EN ESPERA";
            case '2':
                return "CONCLUIDO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
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
