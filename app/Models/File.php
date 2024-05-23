<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\EscalaSalarial;
use App\Models\Canasta\Dea;
use DB;

class File extends Model
{
    protected $table = 'file';
    protected $primaryKey= 'idfile';
    protected $fillable = [
        'numfile',
        'nombrecargo',
        'tipofile',
        'estadofile',
        'idarea',
        'dea_id',
        'escala_salarial_id'
    ];

    const ESTADOS = [
        '1' => 'ASIGNADO',
        '2' => 'NO ASIGNADO',
        '3' => 'INHABILITADO'
    ];

    const TIPOS = [
        '1' => 'PLANTA',
        '2' => 'CONTRATO'
    ];

    public function getStatusAttribute(){
        switch ($this->estadofile) {
            case '1':
                return "ASIGNADO";
            case '2':
                return "NO ASIGNADO";
            case '3':
                return "INHABILITADO";
        }
    }

    public function getTiposAttribute(){
        switch ($this->tipofile) {
            case '1':
                return "P";
            case '2':
                return "C";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estadofile) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
            case '3':
                return "badge-with-padding badge badge-secondary";
        }
    }

    public function getEmpleadoActualAttribute(){
        $contrato = DB::table('empleados_contratos')
                            ->where('idfile',$this->idfile)
                            ->where('estado','1')
                            ->first();
        if($contrato != null){
            $empleado = DB::table('empleados')->where('idemp',$contrato->idemp)->first();
            if($empleado != null){
                return $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat;
            }else{
                return ['[Error]'];
            }
        }else{
            return '[Error]';
        }
    }

    public function dea()
    {
        return $this->belongsTo(Dea::class, 'dea_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'idarea', 'idarea');
    }

    public function escala_salarial()
    {
        return $this->belongsTo(EscalaSalarial::class, 'escala_salarial_id', 'id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByNroFile($query, $nro_file){
        if($nro_file){
            return $query->where('numfile', $nro_file);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeByCargo($query, $cargo_id){
        if($cargo_id){
            return $query->where('idfile', $cargo_id);
        }
    }

    public function scopeByEscalaSalarial($query, $escala_salarial_id){
        if($escala_salarial_id){
            return $query->where('escala_salarial_id', $escala_salarial_id);
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipofile', $tipo);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estadofile', $estado);
        }
    }
}
