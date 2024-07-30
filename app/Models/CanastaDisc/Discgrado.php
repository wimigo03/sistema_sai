<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;

class Discgrado extends Model
{
    protected $table = 'discgrado';
    protected $primaryKey= 'id';
    protected $fillable = [
        'discapacidad',
        'estado'
    ];


}
