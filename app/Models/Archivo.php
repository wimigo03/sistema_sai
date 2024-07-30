<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoArchivo;

class Archivo extends Model
{
    protected $table = 'archivos';
    protected $primaryKey= 'idarchivo';
    public $timestamps = true;
    protected $fillable = [
        'idarea',
        'dea_id',
        'idtipo',
        'nombrearchivo',
        'documento',
        'estado1',
        'referencia',
        'gestion',
        'id',
        'fecha'
    ];

    public function tipo(){
        return $this->belongsTo(TipoArchivo::class,'idtipo','idtipo');
    }

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

    public function scopeByGestion($query, $gestion){
        if($gestion != null){
            return $query->where('gestion', $gestion);
        }
    }

    public function scopeByFecha($query, $fecha){
        if($fecha != null){
            $fecha = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $fecha)));
            return $query->where('fecha', $fecha);
        }
    }

    public function scopeByNumero($query, $numero){
        if($numero != null){
            return $query->where('nombrearchivo', 'like', $numero . '%');
        }
    }

    public function scopeByReferencia($query, $referencia){
        if($referencia != null){
            return $query->where('referencia', 'like', '%' . $referencia . '%');
        }
    }

    public function scopeByTipo($query, $tipo_id){
        if($tipo_id != null){
            return $query->where('idtipo', $tipo_id);
        }
    }
}
