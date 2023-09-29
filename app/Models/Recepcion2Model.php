<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcion2Model extends Model
{
    protected $table = 'recepcion';

    protected $primaryKey= 'id_recepcion';

    public $timestamps = true;

    protected $fillable = [


    ];

    protected $guarded = [


    ];
}
