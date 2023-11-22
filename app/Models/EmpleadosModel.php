<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FileModel;
class EmpleadosModel extends Model
{
        protected $table = 'empleados';
        protected $primaryKey= 'idemp';
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

        public function empleadosareas(){
           return $this->belongsTo(AreasModel::class, 'idarea', 'idarea');
        }

        public function area(){
            return $this->belongsTo(AreasModel::class, 'idarea', 'idarea')->select('nombrearea');
         }

        public function file(){
            return $this->belongsTo(FileModel::class, 'idfile', 'idfile');
        }
}
