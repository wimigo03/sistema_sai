<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemitenteModel extends Model
{

    protected $connection = 'pgsql_correspondencia';
    protected $table = 'empleados';

    protected $primaryKey= 'id_emp';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
