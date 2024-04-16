<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'codigo_interno',
        'costo_historico',
        'documento',
        'nombre_propietario',
        'municipio_radicatoria',
        'clase_vehiculo',
        'tipo_combustible',
        'gnv',
        'nro_placa',
        'tipo',
        'marca',
        'modelo',
        'color',
        'pais_procedencia',
        'uso_bien',
        'nro_motor',
        'nro_chasis',
        'cilindrada',
        'traccion',
        'nro_plazas',
        'nro_puertas',
        'capacidad_carga',
        'nro_poliza_procedencia',
        'fecha_poliza',
        'ultimo_soat',
        'ultima_itv',
        'b_sisa',
        'nro_ruat',
        'documento_ruat',
        'nro_crpva',
        'nro_poliza_seguro',
        'vencimiento_poliza_seguro',
        'departamento',
        'provincia',
        'municipio',
        'localidad',
        'distrito',
        'canton',
        'comunidad',
        'zona',
        'direccion',
        'kardex_aclaracion',
        'ubicacion_satelital',
        'imagen',
        'actual_id'
    ];

    public function actual()
    {
        return $this->belongsTo(ActualModel::class);
    }

    public function scopeByCodigo($query, $codigo)
    {
        if ($codigo) {
            return $query->where('codigo', 'like', '%' . $codigo . '%');
        }
    }

    public function scopeByNombre($query, $nombre)
    {
        if ($nombre) {
            return $query->whereHas('actual', function ($subquery) use ($nombre) {
                $subquery->whereHas('empleados', function ($nombreQuery) use ($nombre) {
                    $nombreQuery->where('nombres', 'like', '%' . $nombre . '%');
                });
            });
        }
    }

    public function scopeByApPaterno($query, $ap_pat)
    {
        if ($ap_pat) {
            return $query->whereHas('actual', function ($subquery) use ($ap_pat) {
                $subquery->whereHas('empleados', function ($ap_patQuery) use ($ap_pat) {
                    $ap_patQuery->where('ap_pat', 'like', '%' . $ap_pat . '%');
                });
            });
        }
    }

    public function scopeByApMaterno($query, $ap_mat)
    {
        if ($ap_mat) {
            return $query->whereHas('actual', function ($subquery) use ($ap_mat) {
                $subquery->whereHas('empleados', function ($ap_matQuery) use ($ap_mat) {
                    $ap_matQuery->where('ap_mat', 'like', '%' . $ap_mat . '%');
                });
            });
        }
    }

    public function scopeByOficina($query, $oficina)
    {
        if ($oficina) {
            return $query->whereHas('actual', function ($subquery) use ($oficina) {
                $subquery->whereHas('areas', function ($oficinaQuery) use ($oficina) {
                    $oficinaQuery->where('nombrearea', 'like', '%' . $oficina . '%');
                });
            });
        }
    }

}
