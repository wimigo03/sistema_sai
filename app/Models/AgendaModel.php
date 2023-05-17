<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaModel extends Model
{
    protected $table = 'agenda';

    protected $primaryKey= 'idagenda';

    public $timestamps = true;

    protected $fillable = [

         ];

    protected $guarded = [


    ];
}
