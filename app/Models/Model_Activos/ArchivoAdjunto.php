<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoAdjunto extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion', 'ruta', 'empleado_id',];

    public function activo()
    {
        return $this->belongsTo(ActualModel::class);
    }
}
