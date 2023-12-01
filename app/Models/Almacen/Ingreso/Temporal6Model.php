<?php

namespace App\Models\Almacen\Ingreso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporal6Model extends Model
{
    protected $table = 'temporal6';
    
    protected $primaryKey= 'idtemporal6';

    public $timestamps = false;

    protected $fillable = [
        'idingreso',
        'idusuario',
        'idarea'
    ];

    protected $guarded = [

        
    ];
}