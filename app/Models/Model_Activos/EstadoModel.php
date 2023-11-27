<?php

namespace App\Models\Model_Activos;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoModel extends Model
{
    use HasFactory;

    protected $table = 'estado';
    protected $primaryKey = 'idestado';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        
        'codestado',
        'nomestado',
        'estado',
    ];

    
}

