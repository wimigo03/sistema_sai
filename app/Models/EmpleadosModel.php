<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FileModel;
class EmpleadosModel extends Model
{
    use HasFactory;
    
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

    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'idemp');
    }

    public function file()
    {
        return $this->belongsTo(FileModel::class, 'idfile');
    }

    public function archivoAdjuntos()
    {
        return $this->hasMany(ArchivoAdjunto::class, 'empleado_id');
    }

    // Relación con las transferencias entrantes (desde este empleado)
    public function transferenciasEntrantes()
    {
        return $this->hasMany(Transferencia::class, 'empleado_destino_id');
    }

    // Relación con las transferencias salientes (desde este empleado)
    public function transferenciasSalientes()
    {
        return $this->hasMany(Transferencia::class, 'empleado_origen_id');
    }

    public function getFullNameAttribute()
    {
        return $this->nombres . ' ' . $this->ap_pat . ' ' . $this->ap_mat;
    }
}
