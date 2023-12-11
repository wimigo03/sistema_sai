<?php

namespace App\Models\Model_Activos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'activo_id',
        'empleado_origen_id',
        'empleado_destino_id',
    ];

    public function empleadoEntrante()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_destino_id');
    }

    public function empleadoSaliente()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_origen_id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d-m-Y h:i');
    }
}
