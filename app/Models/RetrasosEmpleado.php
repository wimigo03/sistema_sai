<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetrasosEmpleado extends Model
{
    use HasFactory;
    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }
}
