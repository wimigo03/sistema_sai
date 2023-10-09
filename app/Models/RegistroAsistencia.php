<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAsistencia extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['empleado_id', 'registro_entrada', 'registro_salida', 'minutos_retraso', 'horario_id'];

    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }

    public function horario()
    {
        return $this->belongsTo(HorarioModel::class, 'horario_id');
    }

    
}
