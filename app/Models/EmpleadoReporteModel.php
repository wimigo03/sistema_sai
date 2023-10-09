<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoReporteModel extends Model
{
    use HasFactory;
    protected $table = 'empleado_reporte';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'empleado_id',
        'reporte_id',
        'total_retrasos',
    ];

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }

    // Relación con el modelo Reporte
    public function reporte()
    {
        return $this->belongsTo(ReporteModel::class, 'reporte_id');
    }
}
