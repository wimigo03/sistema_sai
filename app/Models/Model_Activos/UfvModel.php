<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UfvModel extends Model
{
    use HasFactory;

    protected $table = 'ufv';
    protected $primaryKey = 'idufv';
    public $timestamps = true;

    protected $fillable = [
    
        'dia',
        'mes',
        'ano',
        'estadoufv',
        
    ];
}
