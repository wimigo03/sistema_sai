<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaCombModel extends Model
{
    protected $table = 'programacomb';
    
    protected $primaryKey= 'idprogramacomb';

    public $timestamps = false;

    protected $fillable = [
        'nombreprograma',
        'estadoprograma',
        'codigoprogr'
    ];

    protected $guarded = [

        
    ];
}
