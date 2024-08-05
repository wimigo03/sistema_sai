<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodosDisc extends Model
{
    protected $table = 'periodos';
    protected $primaryKey= 'id';
    protected $fillable = [
        'id',
        'mes'
    ];


}
