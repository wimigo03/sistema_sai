<?php

namespace App\Models\informatica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeModel extends Model
{
    protected $table = 'informetecnico';

    protected $primaryKey= 'id';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
