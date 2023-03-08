<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaModel extends Model
{
    protected $table = 'programa';
    
    protected $primaryKey= 'idprograma';

    public $timestamps = false;

    protected $fillable = [
        'nombreprograma',
        'estadoprograma'
    ];

    protected $guarded = [

        
    ];
}
