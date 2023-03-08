<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model{
    protected $connection = 'pgsql_discapacidad';
    protected $table = 'afiliados';
    protected $primaryKey= 'codigo';

    protected $fillable = [
        'carnet',
        'nombres',
        'apellidos',
        'f_nacimiento',
        'edad',
        'direccion',
        'barrio_com',
        'telf',
        'f_registro',
        'activo',
        'carnet_discap',
        'f_registro2',
        'f_vencimiento',
        'tipo_disc',
        'nombre_tutor',
        'tipo_parentesco',
        'observacion',
        'estado1',
        'estado2',
        'det_estado'
    ];

    public $timestamps = false;

}