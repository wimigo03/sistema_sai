<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMod extends Model
{
    protected $table = 'historialmod';
    protected $primaryKey= 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'observacion',
        'id_beneficiario',
        'user_id',
        'dea_id',
        'created_at',
        'updated_at',
    ];

}
