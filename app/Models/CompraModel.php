<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class CompraModel extends Model
{
    protected $table = 'compra';
    protected $primaryKey= 'idcompra';
    //public $timestamps = true;

    protected $fillable = [
        'idproveedor',
        'objeto',
        'justificacion',
        'preventivo',
        'estadocompra',
        'tipo',
        'estado1',
        'estado2',
        'estado3',
        'numcompra',
        'controlinterno',
        'created_at',
        'updated_at',
        'idarea',
        'dea_id'
    ];

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id',$dea_id);
        }
    }
}
