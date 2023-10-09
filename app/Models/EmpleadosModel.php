<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadosModel extends Model
{
    //
    protected $table = 'empleados';

    protected $primaryKey = 'idemp';

    public $timestamps = true;

    protected $fillable = [

        'numfile',
        'nombres',
        'ap_pat',
        'ap_mat',
        'cargo',
        'nombrecargo',
        'habbasico',
        'categoria',
        'nivadmin',
        'clase',
        'nivsalarial',
        'fechingreso',
        'natalicio',
        'edad',
        'ci',
        'poai',
        'exppoai',
        'decjurada',
        'expdecjurada',
        'sippase',
        'expsippase',
        'servmilitar',
        'idioma',
        'induccion',
        'expinduccion',
        'progvacacion',
        'expprogvacacion',
        'vacganadas',
        'vacpendientes',
        'vacusasdas',
        'segsalud',
        'inamovilidad',
        'aservicios',
        'cvitae',
        'telefono',
        'biometrico',
        'gradacademico',
        'rae',
        'regprofesional',
        'evdesempenio',
        'estadoemp1',
        'estadoemp2',
        'tipo',

        'idfile',
        'idarea',

        'totalpresupuesto',
        'fechafinal',
        'ncontrato',
        'npreventivo',
        'progproy',
        'rejap',
        'aportesafp',
        'cuentabanco',
        'filecontrato',
        'nit',
        'sigep'

    ];

    protected $guarded = [];

    public function empleadosareas()
    {
        // return $this->belongsTo('App\Models\EmpleadosModel', 'id', 'idemp');
        // return $this->belongsTo(Profession::class, 'profession_name', 'name');
        //return $this->hasMany('App\Models\EmpleadosModel', 'id');
        //return $this->belongsTo(User::class,'id','idusuario');
        return $this->belongsTo(AreasModel::class, 'idarea', 'idarea');
    }
    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'idemp');
    }

    public function horarios()
    {
        return $this->belongsToMany(HorarioModel::class, 'empleado_horario', 'empleado_id', 'horario_id');
        //,'empleado_horario','empleado_id','horario_id'
    }
    public function reportes()
    {
        return $this->belongsToMany(ReporteModel::class, 'empleado_reporte', 'empleado_id', 'reporte_id')
            ->withPivot('total_retrasos', 'observaciones');
    }

    public function permisos()
    {
        return $this->belongsToMany(PermisoModel::class, 'empleado_permiso', 'empleado_id', 'permiso_id')
            ->withPivot(['hora_salida', 'hora_retorno', 'fecha_solicitud', 'horas_utilizadas']);
    }



    public function registrosAsistencia()
    {
        return $this->hasMany(RegistroAsistencia::class, 'empleado_id');
    }
    public function retrasos()
    {
        return $this->hasMany(RetrasosEmpleado::class, 'empleado_id');
    }
}
