<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectorDigitalesModel extends Model
{
    use HasFactory;
    protected $fillable = [
        // Otras propiedades fillable aquí
        'id',
        'serial_lector',
        'model_lector',
        'descrip',
        'estado',
        'updated_at',
        'created_at',
      
    ];
    protected $table = 'lector';
    public $timestamps = false;

    
  
    
}
 


