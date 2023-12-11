<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovilidadModel extends Model
{
    protected $table = 'tipomovilidad';
    
    protected $primaryKey= 'idtipomovilidad';

    public $timestamps = false;

    protected $fillable = [
      
        'nombremovilidad',
        'descripcionmovilidad',
        'estadomovilidad'   
    ];
    protected $guarded = [    
    ];
}
