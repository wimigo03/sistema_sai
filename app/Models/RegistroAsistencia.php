<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAsistencia extends Model
{
    use HasFactory;
    protected $table = 'registro_asistencia';
    protected $primaryKey = 'id';
    protected $fillable = ['empleado_id', 'registro_entrada','registro_inicio', 'registro_final','registro_salida', 'minutos_retraso','observ','created_at', 'tipo','horario_id'];

    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }

    public function horario()
    {
        return $this->belongsTo(HorarioModel::class, 'horario_id');
    }

    public function asistencia()
    {
        return $this->belongsTo(AsistenciaModel::class, 'asistencia_id');
    }
    public function historialCambios()
    {
        return $this->hasMany(HistorialAsistenciasCambios::class);
    }
}
