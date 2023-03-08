<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompraModel extends Model
{
    protected $table = 'detallecompra';
    
    protected $primaryKey= 'iddetallecompra';

    public $timestamps = false;

    protected $fillable = [
        'idprodserv',
        'idcompra',
        'cantidad',
        'subtotal',
        'precio'
    ];

    protected $guarded = [

        
    ];
}
