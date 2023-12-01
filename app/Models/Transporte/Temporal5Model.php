<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporal5Model extends Model
{
    protected $table = 'temporal5';
    
    protected $primaryKey= 'idtemporal5';

    public $timestamps = false;

    protected $fillable = [
        'idusuario',
        'idsoluconsumo'
    ];

    protected $guarded = [

        
    ];
}

