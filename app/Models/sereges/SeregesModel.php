<?php

namespace App\Models\sereges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeregesModel extends Model
{
    protected $table = 'sereges';

    protected $primaryKey= 'id';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
