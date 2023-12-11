<?php

namespace App\Models\Transporte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoUconsumoModel extends Model
{
    protected $table = 'docuconsumo';
    
    protected $primaryKey= 'iddocuconsumo';

    public $timestamps = true;

    protected $fillable = [
        'documento',
        'idunidadconsumo',
        'estadoduconsumo',
        'nombredocumento'
    ];

    protected $guarded = [

        
    ];
}

