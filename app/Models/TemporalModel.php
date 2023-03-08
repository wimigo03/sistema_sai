<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalModel extends Model
{
    protected $table = 'temporal';
    
    protected $primaryKey= 'idtemporal';

    public $timestamps = false;

    protected $fillable = [
        'idusuario',
        'idcompra'
    ];

    protected $guarded = [

        
    ];
}
