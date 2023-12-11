<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraCombModel extends Model
{
    protected $table = 'compracomb';

    protected $primaryKey= 'idcompracomb';

    public $timestamps = true;

    protected $fillable = [
        'idproveedor',

        'objeto',
        'justificacion',
        'preventivo',
        'estadocompracomb',
        'tipo',
        'estado1',
        'estado2',
        'estado3',
        'numcompra',
        'controlinterno',
        'created_at',
        'updated_at',
        'idarea'
    ];

    public function comprasdetallecomb()
    {
        return $this->hasMany(DetalleCompraCombModel::class, 'idcompracomb', 'idcompracomb');
    }
}

