<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioModel extends Model
{
    use HasFactory;
    protected $fillable = [
        // Otras propiedades fillable aquí
        'estado',
    ];
    protected $table = 'horarios';
    
    public function empleados()
    {
        return $this->belongsToMany(EmpleadosModel::class,'empleado_horario','horario_id','empleado_id');
    }
    public function registrosAsistencia()
    {
        return $this->hasMany(RegistroAsistencia::class, 'horario_id'); // Ajusta 'horario_id' según tu columna de clave foránea
    }
    public function asistencias()
    {
        return $this->belongsToMany(AsistenciaModel::class,'registro_asistencia','horario_id','asistencia_id');
    }
}
