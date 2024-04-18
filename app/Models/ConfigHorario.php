<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigHorario extends Model
{
    use HasFactory;
    protected $table = 'config-horarios'; // Aquí especificas el nombre de la tabla si difiere del nombre por defecto.
    protected $fillable = [
        'jornadamax',
        'jornadamin',
        'iniciomax',
        'marcadomax',
        'permisosmensuales', // Agrega el atributo aquí
        'licenciasrip', // Agrega el atributo aquí

    ];

}
