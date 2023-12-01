<?php

namespace App\Models\Almacen\Ingreso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrarModel extends Model
{
    protected $table = 'borrar';
    
    protected $primaryKey= 'idborrar';

    public $timestamps = false;

    protected $fillable = [
       'nombreborrar',
       'estadoborrar',
    ];

}

