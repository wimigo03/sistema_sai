<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaModel extends Model
{
    use HasFactory;
    protected $fillable = [
        // Otras propiedades fillable aquí
        'fecha',
        'descrip',
        'estado',
        'horario_id',
    ];
    protected $table = 'asistencia';
    public $timestamps = false;

    
    public function empleados()
    {
        return $this->belongsToMany(EmpleadosModel::class,'registro_asistencia','asistencia_id','empleado_id');
    }
    public function registrosAsistencia()
    {
        return $this->hasMany(RegistroAsistencia::class, 'asistencia_id'); // Ajusta 'horario_id' según tu columna de clave foránea
    }
    public function horarios()
    {
        return $this->belongsToMany(HorarioModel::class,'registro_asistencia','asistencia_id','empleado_id');
    }


}
