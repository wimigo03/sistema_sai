<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartidaCombModel extends Model
{
    protected $table = 'partidacomb';
    
    protected $primaryKey= 'idpartidacomb';

    public $timestamps = false;

    protected $fillable = [
        'codigopartida',
        'nombrepartida',
        'detallepartida',
        'estadopartida'
    ];

    protected $guarded = [

        
    ];
}
