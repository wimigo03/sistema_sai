<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipio;

class Recinto extends Model
{
    protected $table = 'recintos';
    public $timestamps = false;
    protected $fillable = [
        'municipio_id',
        'nombre',
        'zona',
        'estado',
    ];

    const URBANA = 1;
    const RURAL = 2;

    const HABILITADO = 1;
    const NO_HABILITADO = 2;

    const ZONAS = [
        '1' => 'URBANA',
        '2' => 'RURAL',
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
    ];

    public function getZoneAttribute(){
        switch ($this->zona) {
            case '1':
                return "URBANA";
            case '2':
                return "RURAL";
        }
    }

    public function getStatusAttribute(){
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
                return "badge-with-padding badge badge-secondary";
        }
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class,'municipio_id','id');
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
