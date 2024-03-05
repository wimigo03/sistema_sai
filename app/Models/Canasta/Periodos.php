<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodos extends Model
{
    protected $table = 'periodos';
    protected $primaryKey= 'id';
    protected $fillable = [
        'id',
        'mes'
    ];


}
