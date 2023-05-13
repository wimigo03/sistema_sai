<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepcionModel extends Model
{
    protected $connection = 'pgsql_correspondencia';
    protected $table = 'recepcion';
    protected $primaryKey= 'id_recepcion';
    public $timestamps = false;
    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
