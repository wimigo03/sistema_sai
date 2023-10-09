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
    public function registroAsistencias()
    {
        return $this->hasMany(RegistroAsistencia::class,'horario_id');
    }
}
