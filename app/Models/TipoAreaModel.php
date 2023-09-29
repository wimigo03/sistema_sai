<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAreaModel extends Model
{
    protected $table = 'tipoarea';

    protected $primaryKey= 'idtipoarea';

    public $timestamps = false;

    protected $fillable = [


    ];

    protected $guarded = [


    ];
}
