<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenciasRipModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'licencias';
    protected $primaryKey = 'id';   
    protected $fillable = [
        'licencia', // Agrega 'permiso' aquí si deseas permitir la asignación en masa
        'dias_permitidos',
    ];

    public function empleados()
    {
        return $this->belongsToMany(EmpleadosModel::class,'empleado_licencia', 'licencia_id', 'empleado_id')
            ->withPivot(['fecha_solicitud', 'dias_utilizados']);
    }
}