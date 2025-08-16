<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Circunscripcion;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $fillable = [
        'circunscripcion_id',
        'nombre',
        'estado',
    ];

    const HABILITADO = 1;
    const NO_HABILITADO = 2;

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
    ];

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
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
        }
    }

    public function circunscripcion(){
        return $this->belongsTo(Circunscripcion::class,'circunscripcion_id','id');
    }
}
