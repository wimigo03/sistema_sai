<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelModel extends Model
{
    protected $table = 'niveles';
    
    protected $primaryKey= 'idnivel';

    public $timestamps = false;

    protected $fillable = [
        'nivel',
        'nombrenivel'
    ];

    protected $guarded = [

        
    ];
}
