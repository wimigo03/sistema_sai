<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanastaBarriosModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'barrios';

    protected $primaryKey= 'idBarrio';



    protected $fillable = [

    ];
}
