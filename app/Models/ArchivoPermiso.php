<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoPermiso extends Model
{
    protected $table = 'archivos_permisos';
    protected $fillable = [
        'idarchivo',
        'idarea',
        'dea_id',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'AUTORIZADO',
        '2' => 'NO AUTORIZADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "AUTORIZADO";
            case '2':
                return "NO AUTORIZADO";
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
