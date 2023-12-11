<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjgastoModel extends Model
{
    use HasFactory;

    protected $table = 'objgasto';
    protected $primaryKey = 'idobjgasto';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
    
        'gestion',
        'partida',
        'descrip',
        
    ];

    
    
}