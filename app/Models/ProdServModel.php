<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdServModel extends Model
{
    protected $table = 'prodserv';
    
    protected $primaryKey= 'idprodserv';

    public $timestamps = false;

    protected $fillable = [
        'umedida_idumedida',
        'partida_idpartida',
        'nombreprodserv',
        'detalleprodserv',
        'precioprodserv',
        'estadoprodserv'
    ];

    protected $guarded = [

        
    ];
}
