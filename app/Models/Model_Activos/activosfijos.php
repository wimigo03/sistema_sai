<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivosFijos extends Model
{
    use HasFactory;

    protected $table = 'activosfijos';
    protected $primaryKey = 'idactivos';
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
        'codofic',
        'codresp',
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
        'id',
        'estadoactivos',
    ];

  
}
