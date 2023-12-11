<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CanastaAdminModel;

class CanastaHistorialBajaModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'historialbaja';
    protected $primaryKey= 'idHistorialBaja';
    protected $fillable = [
        'ip',
        'fecha',
        'idUsuario',
        'obs',
        'estado',
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
