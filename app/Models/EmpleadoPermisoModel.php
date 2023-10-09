<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoPermisoModel extends Model
{
    use HasFactory;

    protected $table = 'empleado_permiso';
    protected $primaryKey = 'id';
    public $incrementing = false; // Ya que no es autoincremental
    public $timestamps = false; // No hay columnas de timestamps
    protected $fillable = ['hora_salida', 'hora_retorno', 'fecha_solicitud', 'horas_utilizadas'];

    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }

    public function permiso()
    {
        return $this->belongsTo(PermisoModel::class, 'permiso_id');
    }
}
