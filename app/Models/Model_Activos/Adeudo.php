<?php

namespace App\Models\Model_Activos;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adeudo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ci',
        'fecha_inicio',
        'fecha_fin',
        'nro_contrato',
        'cantidad_activos',
        'motivo_retiro',
        'respaldo',
        'empleado_id'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'idemp');
    }

    public function scopeByNombre($query, $nombre)
    {
        if ($nombre) {
            return $query
                ->whereIn('empleado_id', function ($subquery) use ($nombre) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('nombres', 'like', '%' . $nombre . '%');
                });
        }
    }

    public function scopeByApPaterno($query, $ap_pat)
    {
        if ($ap_pat) {
            return $query
                ->whereIn('empleado_id', function ($subquery) use ($ap_pat) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ap_pat', 'like', '%' . $ap_pat . '%');
                });
        }
    }

    public function scopeByCi($query, $ci)
    {
        if ($ci) {
            return $query
                ->whereIn('empleado_id', function ($subquery) use ($ci) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ci', 'like', '%' . $ci . '%');
                });
        }
    }

    public function scopeByApMaterno($query, $ap_mat)
    {
        if ($ap_mat) {
            return $query
                ->whereIn('empleado_id', function ($subquery) use ($ap_mat) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ap_mat', 'like', '%' . $ap_mat . '%');
                });
        }
    }


    public function scopeByOficina($query, $oficina)
    {
      if ($oficina) {
          return $query->whereHas('empleado', function ($subquery) use ($oficina) {
              $subquery->whereHas('empleadosareas', function ($oficinaQuery) use ($oficina) {
                  $oficinaQuery->where('nombrearea', 'like', '%' . $oficina . '%');
              });
          });
      }
    }

    public function scopeByCargo($query, $cargo)
    {
        if ($cargo) {
            return $query->whereHas('empleado', function ($subquery) use ($cargo) {
                $subquery->whereHas('file', function ($cargoQuery) use ($cargo) {
                    $cargoQuery->where('nombrecargo', 'like', '%' . $cargo . '%');
                });
            });
        }
    }

}
