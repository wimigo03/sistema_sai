<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\File;
use App\Models\EscalaSalarial;
use App\Models\Empleado;
use App\Models\Canasta\Dea;

class EmpleadoContrato extends Model
{
    use HasFactory;

    protected $table = 'empleados_contratos';
    protected $fillable = [
        'idfile',
        'dea_id',
        'idarea',
        'idemp',
        'user_id',
        'fecha_ingreso',
        'poai',
        'exppoai',
        'decjurada',
        'expdecjurada',
        'sippase',
        'expsippase',
        'induccion',
        'expinduccion',
        'progvacacion',
        'expprogvacacion',
        'vacganadas',
        'segsalud',
        'biometrico',
        'evdesempenio',
        'tipo',
        'fecha_conclusion_contrato',
        'fecha_retiro',
        'ncontrato',
        'npreventivo',
        'progproy',
        'rejap',
        'obs_retiro',
        'estado',
        'idarea_asignada',
        'escala_salarial_id'
    ];

    const PLANTA = 1;
    const CONTRATO = 2;

    const HABILITADO = 1;
    const RETIRADO = 2;

    const TIPOS = [
        '1' => 'PLANTA',
        '2' => 'CONTRATO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "RETIRADO";
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

    public function getTiposAttribute(){
        switch ($this->tipo) {
            case '1':
                return "PLANTA";
            case '2':
                return "CONTRATO";
        }
    }

    public function getTiposAbreviadoAttribute(){
        switch ($this->tipo) {
            case '1':
                return "P";
            case '2':
                return "C";
        }
    }

    public function getAreaAsignadaAttribute(){
        $area = Area::where('idarea',$this->idarea_asignada)->first();
        if($area != null){
            return $area->nombrearea;
        }
    }

    public function getAreaAsignadaCortaAttribute(){
        $area = Area::where('idarea',$this->idarea_asignada)->first();
        if($area != null){
            $longitud = strlen($area->nombrearea);
            if($longitud > 20){
                $area_abreviada = mb_substr($area->nombrearea, 0, 20, 'UTF-8') . '...';
            }else{
                $area_abreviada = $area->nombrearea;
            }
            return $area_abreviada;
        }
    }

    public function getFileCargoAttribute(){
        $cargo = File::where('idfile',$this->idfile)->first();
        if($cargo){
            return $cargo->nombrecargo;
        }
    }

    public function getFileCargoCortoAttribute(){
        $cargo = File::where('idfile',$this->idfile)->first();
        if($cargo != null){
            $longitud = strlen($cargo->nombrecargo);
            if($longitud > 20){
                $cargo_abreviado = mb_substr($cargo->nombrecargo, 0, 20, 'UTF-8') . '...';
            }else{
                $cargo_abreviado = $cargo->nombrecargo;
            }
            return $cargo_abreviado;
        }
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'idfile','idfile');
    }

    public function escala_salarial()
    {
        return $this->belongsTo(EscalaSalarial::class, 'escala_salarial_id','id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idemp','idemp');
    }

    public function dea()
    {
        return $this->belongsTo(Dea::class, 'dea_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'idarea', 'idarea');
    }

    public function _area_asignada()
    {
        return $this->belongsTo(Area::class, 'idarea', 'idarea_asignada');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo != null){
            return $query->where('tipo', $tipo);
        }
    }
}
