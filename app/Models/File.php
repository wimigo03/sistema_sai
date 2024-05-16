<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Canasta\Dea;

class File extends Model
{
    protected $table = 'file';
    protected $primaryKey= 'idfile';
    protected $fillable = [
        'numfile',
        'cargo',
        'nombrecargo',
        'habbasico',
        'categoria',
        'niveladm',
        'clase',
        'nivelsal',
        'tipofile',
        'estadofile',
        'idarea',
        'dea_id'
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

    public function dea()
    {
        return $this->belongsTo(Dea::class, 'dea_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'idarea', 'idarea');
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

    public function scopeByCargo($query, $cargo){
        if($cargo){
            return $query->where('cargo', $cargo);
        }
    }

    public function scopeByHaberBasico($query, $haber_basico){
        if($haber_basico){
            $haber_basico = floatval(str_replace(",", "", $haber_basico));
            return $query->where('habbasico', $haber_basico);
        }
    }

    public function scopeByCategoria($query, $categoria){
        if($categoria){
            return $query->where('cargo', $categoria);
        }
    }

    public function scopeByNivelAdministrativo($query, $n_adm){
        if($n_adm){
            return $query->where('niveladm', $n_adm);
        }
    }

    public function scopeByClase($query, $clase){
        if($clase){
            return $query->where('clase', $clase);
        }
    }

    public function scopeByNivelSalarial($query, $n_salarial){
        if($n_salarial){
            return $query->where('nivelsal', $n_salarial);
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
