<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CanastaAdminModel;

class CanastaHistorialModModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'historialmod';
    protected $primaryKey= 'idHistorialMod';
    protected $fillable = [
        'ip',
        'fecha',
        'observacion',
        'estado',
        'idUsuario',
        'idAdmin'
    ];

    const ESTADOS = [
        'A' => 'A',
        'F' => 'F'
    ];

    public function admin(){
        return $this->belongsTo(CanastaAdminModel::class,'idAdmin');
    }
}
