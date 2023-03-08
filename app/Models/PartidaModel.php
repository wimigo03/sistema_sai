<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartidaModel extends Model
{
    protected $table = 'partida';
    
    protected $primaryKey= 'idpartida';

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
