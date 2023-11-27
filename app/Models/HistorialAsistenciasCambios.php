<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAsistenciasCambios extends Model
{
    use HasFactory;

    protected $table = 'historial_cambios';

    protected $fillable = [
        'registro_asistencia_id',
        'datos_anteriores',
    ];

    public function registroAsistencia()
    {
        return $this->belongsTo(RegistroAsistencia::class);
    }
    
}
