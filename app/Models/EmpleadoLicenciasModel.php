<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoLicenciasModel extends Model
{
    use HasFactory;

    protected $table = 'empleado_licencia';
    protected $primaryKey = 'id';
    public $incrementing = false; // Ya que no es autoincremental
    public $timestamps = false; // No hay columnas de timestamps
    protected $fillable = ['fecha_solicitud', 'dias_utilizados','asunto','usuario_creacion','usuario_modificacion'];

    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }

    public function licencia()
    {
        return $this->belongsTo(LicenciasRipModel::class, 'licencia_id');
    }
}
