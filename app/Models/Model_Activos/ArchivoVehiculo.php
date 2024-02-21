<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoVehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'ruta',
        'vehiculo_id',
    ];
}
