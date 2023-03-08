<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncargadosModel extends Model
{
    protected $table = 'encargados';
    
    protected $primaryKey= 'idenc';

    public $timestamps = false;

    protected $fillable = [
        'idarea',
        'idemp',
        'abrev',
        'cargo'
    ];

    protected $guarded = [

        
    ];
}
