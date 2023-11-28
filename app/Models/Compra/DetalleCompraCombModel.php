<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompraCombModel extends Model
{
    protected $table = 'detallecompracomb';
    
    protected $primaryKey= 'iddetallecompracomb';

    public $timestamps = false;

    protected $fillable = [
        'idprodcomb',
        'idcompracomb',
        'cantidad',
        'subtotal',
        'precio'
    ];

    protected $guarded = [

        
    ];
}
