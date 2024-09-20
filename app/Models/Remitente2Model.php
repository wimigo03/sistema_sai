<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnidadModel;

class Remitente2Model extends Model
{
    protected $table = 'remitente';
    protected $primaryKey= 'id_remitente';
    public $timestamps = false;
    protected $fillable = [
        'nombres_remitente',
        'apellidos_remitente',
        'ci_remitente',
        'id_unidad',
        'estado_remitente',
    ];

    public function unidad()
    {
        return $this->belongsTo(UnidadModel::class,'id_unidad','id_unidad');
    }
}
