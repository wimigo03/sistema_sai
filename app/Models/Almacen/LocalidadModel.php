<?php

namespace App\Models\Almacen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalidadModel extends Model
{
    protected $table = 'localidad';
    
    protected $primaryKey= 'idlocalidad';

    public $timestamps = false;

    protected $fillable = [
        'codlocalidad',
        'nombrelocalidad',
        'distancialocalidad',
        'estadolocalidad'
       
    ];

    protected $guarded = [

        
    ];
}