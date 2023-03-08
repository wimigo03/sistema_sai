<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposModel extends Model
{
    protected $table = 'tipoarchivo';

    protected $primaryKey= 'idtipo';

    public $timestamps = false;

    protected $fillable = [
        'nombretipo'
    ];

    protected $guarded = [


    ];
}
