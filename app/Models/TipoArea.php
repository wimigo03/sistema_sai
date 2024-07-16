<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArea extends Model
{
    protected $table = 'tipoarea';
    protected $primaryKey= 'idtipoarea';
    public $timestamps = false;
    protected $fillable = [
        'idtipo',
        'idarea',
        'dea_id'

    ];

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id != null){
            return $query->where('idarea', $area_id);
        }
    }
}
