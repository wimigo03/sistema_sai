<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarrioEntregaDisc extends Model
{
    protected $table = 'barriosEntrega';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_barrio',
        'id_paquete',
        'estado'
    ];
}
