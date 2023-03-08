<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivosActual extends Model{
    protected $connection = 'pgsql_activos';
    protected $table = 'actual';
    protected $primaryKey = 'id';

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
        'id'
    ];

    public $timestamps = false;

    public function scopeByUnidad($query, $unidad){
        if($unidad) 
        return $query->where('unidad','LIKE','%'.strtoupper($unidad).'%');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo) 
        return $query->where('codigo','LIKE','%'.strtoupper($codigo).'%');
    }

    public function scopeByDescripcion($query, $descripcion){
        if($descripcion) 
        return $query->where('descrip','LIKE','%'.strtoupper($descripcion).'%');
    }

}