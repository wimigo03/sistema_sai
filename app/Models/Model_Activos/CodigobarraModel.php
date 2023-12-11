<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigobarraModel extends Model
{
    use HasFactory;

    protected $table = 'codigobarras';
    public $timestamps = true;

    protected $fillable = [
        'codigobarra',
        'estadocodigobarra',
    ];

    public function activosFijos()
    {
        return $this->belongsTo(ActivosFijos::class, 'activos_fijos_id');
    }

    public function dea()
    {
        return $this->belongsTo(Dea::class, 'dea');
    }
}
