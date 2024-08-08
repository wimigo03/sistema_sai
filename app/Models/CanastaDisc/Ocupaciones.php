<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocupaciones extends Model
{
    protected $table = 'ocupaciones';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'ocupacion',
        'estado'
    ];
}
