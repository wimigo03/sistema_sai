<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcaMovilidadModel extends Model
{
    protected $table = 'marcamovilidad';
    
    protected $primaryKey= 'idmarcamovilidad';

    public $timestamps = false;

    protected $fillable = [
      
        'nombremarca',
       
        'estadomarca'   
    ];
    protected $guarded = [    
    ];
}
