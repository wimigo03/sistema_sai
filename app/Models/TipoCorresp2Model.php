<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCorresp2Model extends Model
{
    protected $table = 'tipocorresp';

    protected $primaryKey= 'idtipo_corresp';

    public $timestamps = false;

    protected $fillable = [


    ];

    protected $guarded = [


    ];
}
