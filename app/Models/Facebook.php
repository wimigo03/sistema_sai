<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
    protected $table = 'facebook';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'fecha',
        'publicacion'
    ];

}
