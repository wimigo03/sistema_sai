<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArchivo extends Model
{
    protected $table = 'tipoarchivo';
    protected $primaryKey= 'idtipo';
    protected $fillable = [
        'nombretipo',
        'codigo',
        'subtipo',
        'estado'
    ];

    const SUBTIPOS = [
        '1' => 'SALIDA',
        '2' => 'ENTRADA'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    public function getSubTiposAttribute(){
        switch ($this->subtipo) {
            case '1':
                return "SALIDA";
            case '2':
                return "ENTRADA";
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
                return "badge-with-padding badge badge-danger";
        }
    }
}
