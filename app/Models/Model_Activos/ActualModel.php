<?php

namespace App\Models\Model_Activos;

use App\Models\Ambiente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Model_Activos\AuxiliarModel;
use App\Models\Area;
use App\Models\Model_Activos\CodcontModel;
use App\Models\Empleado;

use App\Models\Model_Activos\EntidadesModel;
use App\Models\Model_Activos\OrganismofinModel;
use App\Models\Model_Activos\UbicacionactivoModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\Transferencia;

class ActualModel extends Model
{
    use HasFactory;

    protected $table = 'actual';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'unidad',
        'entidad',
        'codigo',
        'codcont',
        'codaux',
        'vidautil',
        'descrip',
        'costo',
        'depacu',
        'mes',
        'ano',
        'b_rev',
        'dia',
        'codarea',
        'codemp',
        'dia_ant',
        'mes_ant',
        'ano_ant',
        'vut_ant',
        'costo_ant',
        'band_ufv',
        'codestado',
        'cod_rube',
        'nro_conv',
        'org_fin',
        'feul',
        'usuar',
        'api_estado',
        'codigosec',
        'banderas',
        'estadoactual',
    ];

    public function unidadadmin()
    {
        return $this->belongsTo(UnidadadminModel::class, 'idunidadadmin');
    }

    public function codconts()
    {
        return $this->belongsTo(CodcontModel::class, 'codcont', 'codcont');
    }

    public function auxiliars()
    {
        return $this->belongsTo(AuxiliarModel::class, 'codaux','codaux');
    }

    public function auxiliar()
    {
        return $this->belongsTo(AuxiliarModel::class, 'codaux', 'codaux');
    }

    public function areas()
    {
        return $this->belongsTo(Area::class, 'codarea');
    }

    public function empleados()
    {
        return $this->belongsTo(Empleado::class, 'codemp', 'idemp');
    }

    public function entidades()
    {
        return $this->belongsTo(EntidadesModel::class, 'org_fin');
    }

    public function organismofins()
    {
        return $this->belongsTo(OrganismofinModel::class, 'idorganismofin');
    }

    public function ubicaciones()
    {
        return $this->hasMany(UbicacionactivoModel::class, 'activo_id');
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenActivo::class, 'activo_id');
    }

    public function ultimaImagen()
    {
        return $this->hasOne(ImagenActivo::class, 'activo_id')->latest();
    }

    public function transferencias()
    {
        return $this->hasMany(Transferencia::class, 'activo_id');
    }

    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class);
    }

    public function getIconoEstadoAttribute()
    {
        $status_icono = ['', 'badge-primary', 'badge-success', 'badge-danger'];
        return $status_icono[$this->codestado];
    }

    public function getStatusAttribute()
    {
        $status = ['', 'BUENO', 'REGULAR', 'MALO'];
        return $status[$this->codestado];
    }


    public function scopeByCodigo($query, $codigo)
    {
        if ($codigo != null) {
            return $query->where('codigo', 'like', '%' . $codigo . '%');
        }
    }

    public function scopeByEstado($query, $estado)
    {
        if ($estado != null) {
            return $query->where('codestado', $estado);
        }
    }

    public function scopeByCi($query, $ci)
    {
        if ($ci) {
            return $query
                ->whereIn('codemp', function ($subquery) use ($ci) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ci', 'like', '%' . $ci . '%');
                });
        }
    }

    public function scopeByKardex($query, $kardex)
    {
        if ($kardex != null) {
            if($kardex == 1){
                return $query->where('observaciones', '!=','');
            }else{
                return $query->where('observaciones',null);
            }
        }
    }

    public function scopeByPreventivo($query, $preventivo)
    {
        if ($preventivo != null) {
            return $query->where('cod_rube', 'like', '%' . $preventivo . '%');
        }
    }

    public function scopeByAuxiliar($query, $auxiliar)
    {
        if ($auxiliar) {
            return $query->where('codaux', $auxiliar->codaux)
            ->where('codcont', $auxiliar->codcont)
            ->where('unidad', $auxiliar->unidad);
        }
    }


    public function scopeByAmbiente($query, $ambiente)
    {
        if ($ambiente) {
            return $query
                ->whereIn('ambiente_id', function ($subquery) use ($ambiente) {
                    $subquery->select('id')
                        ->from('ambientes')
                        ->where('nombre', 'like', '%' . $ambiente . '%');
                });
        }
    }


    public function scopeByIdBien($query, $ci)
    {
        if ($ci) {
            return $query
                ->whereIn('codemp', function ($subquery) use ($ci) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ci', 'like', '%' . $ci . '%');
                });
        }
    }

    public function scopeByNombre($query, $nombre)
    {
        if ($nombre) {
            return $query
                ->whereIn('codemp', function ($subquery) use ($nombre) {
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
                ->whereIn('codemp', function ($subquery) use ($ap_pat) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ap_pat', 'like', '%' . $ap_pat . '%');
                });
        }
    }

    public function scopeByApMaterno($query, $ap_mat)
    {
        if ($ap_mat) {
            return $query
                ->whereIn('codemp', function ($subquery) use ($ap_mat) {
                    $subquery->select('idemp')
                        ->from('empleados')
                        ->where('ap_mat', 'like', '%' . $ap_mat . '%');
                });
        }
    }

    public function scopeByGrupo($query, $grupo)
    {
        if ($grupo) {
            return $query
                ->whereIn('codcont', function ($subquery) use ($grupo) {
                    $subquery->select('codcont')
                        ->from('codcont')
                        ->where('nombre', 'like', '%' . $grupo . '%');
                });
        }
    }

    public function scopeByOficina($query, $oficina)
    {
        if ($oficina) {
            return $query
                ->whereIn('codarea', function ($subquery) use ($oficina) {
                    $subquery->select('idarea')
                        ->from('areas')
                        ->where('nombrearea', 'like', '%' . $oficina . '%');
                });
        }
    }

    public function scopeByCargo($query, $cargo)
    {
        if ($cargo) {
            return $query->whereHas('empleados', function ($subquery) use ($cargo) {
                $subquery->whereHas('file', function ($cargoQuery) use ($cargo) {
                    $cargoQuery->where('nombrecargo', 'like', '%' . $cargo . '%');
                });
            });
        }
    }
}
