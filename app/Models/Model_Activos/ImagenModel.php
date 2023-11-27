<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenModel extends Model
{
    use HasFactory;

    protected $table = 'imagen';
    protected $primaryKey = 'idimagen';
    public $timestamps = true;

    protected $fillable = [
    
        'imagenactivos',
        'nombreimagen',
        'rutaimagen',
        'estadoimagen',
    ];
}

