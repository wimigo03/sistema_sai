<?php

namespace App\Models\sereges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoRegistroModel extends Model
{
    protected $table = 'foto_registro';

    protected $primaryKey= 'id';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
