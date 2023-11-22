<?php

namespace App\Models\Fexpo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CredencialModel extends Model
{
    protected $table = 'credenciales';

    protected $primaryKey= 'idcredencial';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
