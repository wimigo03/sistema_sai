<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\EmpleadoContrato;
use App\Models\File;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'idemp';
    protected $fillable = [
        'dea_id',
        'idarea',
        'nombres',
        'ap_pat',
        'ap_mat',
        'natalicio',
        'edad',
        'ci',
        'servmilitar',
        'idioma',
        'inamovilidad',
        'aservicios',
        'cvitae',
        'telefono',
        'gradacademico',
        'rae',
        'regprofesional',
        'estado',
        'cuentabanco',
        'filecontrato',
        'nit',
        'sigep',
        'extension',
        'url_foto',
        'kua'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    const EXTENSIONES = [
        'TJ' => 'TARIJA',
        'SC' => 'SANTA CRUZ',
        'BN' => 'BENI',
        'LP' => 'LA PAZ',
        'CB' => 'COCHABAMBA',
        'CH' => 'CHUQUISACA',
        'OR' => 'ORURO',
        'PT' => 'POTOSI',
        'PA' => 'PANDO',
    ];

    const GRADOS_ACADEMICOS = [
        'SIN GRADO ACADEMICO' => 'SIN GRADO ACADEMICO',
        'PRIMARIA' => 'PRIMARIA',
        'SECUNDARIA' => 'SECUNDARIA',
        'SUPERIOR' => 'SUPERIOR'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "H";
            case '2':
                return "N H";
        }
    }

    public function getStatusCompletoAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function getUltimoContratoIngresoAttribute(){
        $contratos = EmpleadoContrato::select('fecha_ingreso')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contratos){
            return $contratos->fecha_ingreso;
        }
    }

    public function getUltimoContratoRetiroAttribute(){
        $contratos = EmpleadoContrato::select('fecha_retiro')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contratos){
            return $contratos->fecha_retiro;
        }
    }

    public function getUltimoTipoContratoAttribute(){
        $contratos = EmpleadoContrato::select('tipo')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contratos){
            $tipo = $contratos->tipo == '1' ? 'P' : 'C';
            return $tipo;
        }
    }

    public function getUltimoTipoContratoFullAttribute(){
        $contratos = EmpleadoContrato::select('tipo')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contratos){
            $tipo = $contratos->tipo == '1' ? 'PLANTA' : 'CONTRATO';
            return $tipo;
        }
    }

    public function getUltimoContratoConclusionAttribute(){
        $contratos = EmpleadoContrato::select('fecha_conclusion_contrato')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contratos){
            return $contratos->fecha_conclusion_contrato;
        }
    }

    public function getFileCargoAttribute(){
        $contrato = EmpleadoContrato::select('idfile')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contrato){
            $cargo = File::where('idfile',$contrato->idfile)->first();
            if($cargo){
                return $cargo->nombrecargo;
            }
        }
    }

    public function getCargoFileAttribute(){
        $contrato = EmpleadoContrato::select('idfile')->where('idemp',$this->idemp)->orderBy('id','desc')->take(1)->first();
        if($contrato){
            $cargo = File::where('idfile',$contrato->idfile)->first();
            if($cargo){
                return $cargo->cargo;
            }
        }
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'idarea', 'idarea');
    }

    /*public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'codemp');
    }*/

    /*public function file()
    {
        return $this->belongsTo(File::class, 'idfile');
    }*/

    /*public function archivoAdjuntos()
    {
        return $this->hasMany(ArchivoAdjunto::class, 'empleado_id');
    }*/

    // Relación con las transferencias entrantes (desde este empleado)
    /*public function transferenciasEntrantes()
    {
        return $this->hasMany(Transferencia::class, 'empleado_destino_id');
    }*/

    // Relación con las transferencias salientes (desde este empleado)
    /*public function transferenciasSalientes()
    {
        return $this->hasMany(Transferencia::class, 'empleado_origen_id');
    }*/

    public function getFullNameAttribute()
    {
        return $this->nombres . ' ' . $this->ap_pat . ' ' . $this->ap_mat;
    }

    public function adeudo()
    {
        return $this->hasOne(Adeudo::class, 'empleado_id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeByCargo($query, $file_id){
        if ($file_id) {
                return $query
                    ->whereIn('idemp', function ($subquery) use($file_id) {
                        $subquery->select('idemp')
                            ->from('empleados_contratos')
                            ->where('estado','1')
                            ->where('idfile', $file_id);
                    });
        }
    }

    public function scopeByApellidoPaterno($query, $apellido_paterno){
        if($apellido_paterno){
            return $query->where('ap_pat', 'like' , '%' . $apellido_paterno . '%');
        }
    }

    public function scopeByApellidoMaterno($query, $apellido_materno){
        if($apellido_materno){
            return $query->where('ap_mat', 'like' , '%' . $apellido_materno . '%');
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->where('nombres', 'like' , '%' . $nombre . '%');
        }
    }

    public function scopeByNroCarnet($query, $nro_carnet){
        if($nro_carnet){
            return $query->where('ci', $nro_carnet);
        }
    }

    public function scopeByTipo($query, $tipo){
        if ($tipo) {
                return $query
                    ->whereIn('idemp', function ($subquery) use($tipo) {
                        $subquery->select('idemp')
                            ->from('empleados_contratos')
                            ->where('estado','1')
                            ->where('tipo', $tipo);
                    });
        }
    }

    public function scopeByFechaIngreso($query, $fecha_ingreso){
        if ($fecha_ingreso) {
            $fecha_ingreso = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_ingreso)));
                return $query
                    ->whereIn('idemp', function ($subquery) use($fecha_ingreso) {
                        $subquery->select('idemp')
                            ->from('empleados_contratos')
                            ->where('estado','1')
                            ->where('fecha_ingreso', $fecha_ingreso);
                    });
        }
    }

    public function scopeByFechaRetiro($query, $fecha_retiro){
        if ($fecha_retiro) {
            $fecha_retiro = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_retiro)));
                return $query
                    ->whereIn('idemp', function ($subquery) use($fecha_retiro) {
                        $subquery->select('idemp')
                            ->from('empleados_contratos')
                            ->where('fecha_retiro', $fecha_retiro);
                    });
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
