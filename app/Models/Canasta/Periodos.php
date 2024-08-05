<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodos extends Model
{
    protected $table = 'periodos';
    protected $primaryKey= 'id';
    protected $fillable = [
        'id',
        'mes'
    ];

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByTipoSistema($query, $tipo){
        if($tipo != null){
            return $query->where('id_tipo',$tipo);
        }
    }
}
