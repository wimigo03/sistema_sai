<?php

namespace App\Models\Almacen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporal2Model extends Model
{
    protected $table = 'temporal2';
    
    protected $primaryKey= 'idtemporal2';

    public $timestamps = false;

    protected $fillable = [
        'idusuario',
        'idvale'
    ];

    protected $guarded = [

        
    ];
}
