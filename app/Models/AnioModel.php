<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnioModel extends Model
{
    protected $table = 'anio';

    protected $primaryKey= 'idanio';

    public $timestamps = false;

    protected $fillable = [

        'anio'
    ];

    protected $guarded = [


    ];
}
