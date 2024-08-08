<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dea extends Model
{
    protected $table = 'deas';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    const ESTADOS = [
        '0' => 'HABILITADO',
        '1' => 'NO HABILITADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '0':
                return "HABILITADO";
            case '1':
                return "NO HABILITADO";
        }
    }
}
