<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'permisos_mensuales';
    protected $primaryKey = 'id';   
    protected $fillable = [
        'mes', // Agrega 'permiso' aquí si deseas permitir la asignación en masa
        'horas_permitidas',
    ];

    public function permiso()
    {
        return $this->belongsTo(PermisoModel::class, 'id');
    }


    public function empleados()
    {
        return $this->belongsToMany(EmpleadosModel::class,'empleado_permiso', 'permiso_id', 'empleado_id')
            ->withPivot(['hora_salida', 'hora_retorno', 'fecha_solicitud', 'horas_utilizadas']);
    }
}
