<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioActivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'activo_id',
        'formulario_id'
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function activo()
    {
        return $this->belongsTo(ActualModel::class);
    }
}
