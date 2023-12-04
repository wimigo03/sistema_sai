<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HuellasDigitalesModel extends Model
{
    use HasFactory;
    protected $fillable = [
        // Otras propiedades fillable aquí
        'id',
        'fid',
        'usuario_creac',
        'usuario_mod',
      
    ];
    protected $table = 'huellasdigitales';
    public $timestamps = false;

    
  
    public function empleado()
    {
        return $this->belongsTo(EmpleadosModel::class, 'empleado_id');
    }
}
 


