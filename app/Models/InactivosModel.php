<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InactivosModel extends Model
{
    protected $table = 'empleadosinactivos';
    
    protected $primaryKey= 'idinactivos';

    public $timestamps = false;

    protected $fillable = [
        'empleados_idemp',
        'fechainactivo',
        'motivo',
        'file',
        'cargo',
        'nombrecargo',
        'haberbasico',
        'nombrearea'
        
    ];

    protected $guarded = [

        
    ];
}
