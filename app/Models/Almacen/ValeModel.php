<?php

namespace App\Models\Almacen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeModel extends Model
{
    protected $table = 'vale';

    protected $primaryKey= 'idvale';

    public $timestamps = true;

    protected $fillable = [
       
        'idarea',
        'idunidadingreso',

        'motivosoli',
        'estadovale',
       
        'estado1',
        'estado2',
        'objeto',
        'controlinterno',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [


    ];

}
