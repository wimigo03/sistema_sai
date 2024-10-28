<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Remitente2Model;
use DB;

class Recepcion2Model extends Model
{
    protected $table = 'recepcion';
    protected $primaryKey = 'id_recepcion';
    protected $fillable = [
        'id_us',
        'id_remitente',
        'idtipo_corresp',
        'fecha_recepcion',
        'asunto',
        'n_oficio',
        'observaciones',
        'confidencialidad',
        'estado_corresp',
        'estado_derivacion',
    ];

    public function remitente()
    {
        return $this->belongsTo(Remitente2Model::class,'id_remitente','id_remitente');
    }

    public function getUnidadRemitenteAttribute() {
        $unidad = DB::table('remitente as a')
                    ->join('unidad as b','b.id_unidad','a.id_unidad')
                    ->select('b.nombre_unidad')
                    ->where('a.id_remitente',$this->id_remitente)
                    ->first();
        if($unidad != null){
            return $unidad->nombre_unidad;
        }
    }

    public function getRemitenteCompletoAttribute() {
        $remitente = DB::table('remitente')
                    ->select('nombres_remitente', 'apellidos_remitente')
                    ->where('id_remitente',$this->id_remitente)
                    ->first();
        if($remitente != null){
            return $remitente->nombres_remitente . ' ' . $remitente->apellidos_remitente;
        }
    }

    public function scopeByNombreCompleto($query, $nombre_completo){
        if ($nombre_completo != null) {
                return $query
                    ->whereIn('id_remitente', function ($subquery) use($nombre_completo) {
                        $subquery->select('id_remitente')
                            ->from('remitente')
                            ->whereRaw("CONCAT(nombres_remitente, ' ', apellidos_remitente) LIKE ?", [" %{$nombre_completo}% "]);
                    });
        }
    }

    public function scopeByUnidad($query, $unidad){
        if ($unidad != null) {
                return $query
                    ->whereIn('id_remitente', function ($subquery) use($unidad) {
                        $subquery->select('id_remitente')
                            ->from('remitente')
                            ->whereIn('id_unidad', function ($subquery) use($unidad) {
                                $subquery->select('id_unidad')
                                    ->from('unidad')
                                    ->where('nombre_unidad', 'LIKE', '%' . $unidad . '%');
                            });
                    });
        }
    }

    public function scopeByAsunto($query, $asunto){
        if($asunto != null){
            return $query->where('asunto', 'LIKE', '%' . $asunto . '%');
        }
    }

    public function scopeByEntreFechas($query, $fecha_i, $fecha_f){
        if ($fecha_i != null && $fecha_f != null) {
            $fecha_i = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_i)));
            $fecha_f = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_f)));
            return $query->where(
                'fecha_recepcion','>=',$fecha_i
            )
            ->where('fecha_recepcion', '<=', $fecha_f);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo != null){
            return $query->where('n_oficio','like',$codigo . '%');
        }
    }
}
