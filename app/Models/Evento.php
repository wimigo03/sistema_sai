<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table= 'evento';
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'horaini',
        'lugar',
        'coordinar',
        'representante',
        'usuario'
    ];

    public $timestamps = false;
}
