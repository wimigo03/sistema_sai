<?php

namespace App\Models\Almacen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleValeModel extends Model
{
    protected $table = 'detallevale';
    
    protected $primaryKey= 'iddetallevale';

    public $timestamps = false;

    protected $fillable = [
        'idconsumo',
        'idvale',

        'cantidadsol',
        'preciosol',
        'subtotalsol'
    ];

    protected $guarded = [

        
    ];
}

