<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Model_Activos\AuxiliarModel;
use App\Models\AreasModel;
use App\Models\Model_Activos\CodcontModel;
use App\Models\EmpleadosModel;

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

    public function areas()
    {
        return $this->belongsTo(AreasModel::class, 'codarea');
    }

    public function empleados()
    {
        return $this->belongsTo(EmpleadosModel::class, 'codemp', 'idemp');
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
}
