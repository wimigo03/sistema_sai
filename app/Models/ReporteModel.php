<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteModel extends Model
{
    protected $table = 'reportes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'fecha_inicio',
        'fecha_final',
    ];

    // Relación con la tabla empleados_reportes
    public function empleados()
    {
        return $this->belongsToMany(EmpleadosModel::class, 'empleado_reporte', 'reporte_id', 'empleado_id')
            ->withPivot('total_retrasos','observaciones');
    }
}
