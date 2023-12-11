<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ubicacionactivo extends Model
{
    use HasFactory;

    protected $table = 'ubicacionactivos';
    protected $primaryKey = 'idubicacionactivos';
    public $timestamps = true;

    protected $fillable = [
        
        'ubicacionactivo',
        'estadoubicacion'
        
    ];
}
