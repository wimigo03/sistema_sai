<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoActivo extends Model
{
    use HasFactory;

    protected $table = 'archivo_activos';
    
    protected $fillable = ['descripcion', 'ruta', 'activo_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
