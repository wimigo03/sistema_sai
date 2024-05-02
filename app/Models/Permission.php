<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'dea_id',
        'descripcion'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
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

    public function scopeByTitulo($query, $titulo){
        if($titulo){
            return $query->where('title', $titulo);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->where('name','like', $nombre . '%');
        }
    }
}
