<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dea extends Model
{
    protected $table = 'deas';
    protected $fillable = [
        'nombre',
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
