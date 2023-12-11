<?php

namespace App\Models\Almacen\Ingreso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporal7Model extends Model
{
    protected $table = 'temporal7';
    
    protected $primaryKey= 'idtemporal7';

    public $timestamps = false;

    protected $fillable = [
        'idingreso',
        'idusuario',
        'fechaini',
        'fechafi'
    ];

    protected $guarded = [

        
    ];
}