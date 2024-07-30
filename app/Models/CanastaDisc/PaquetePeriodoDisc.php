<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaquetePeriodoDisc extends Model
{
    protected $table = 'paquete_periodo';
    //protected $primaryKey= 'id';
    //public $timestamps = false;
    protected $fillable = [
        'id_paquete',
        'id_periodo',
        'dea_id',
        'estado'
    ];

    public function periodo(){
        return $this->belongsTo(Periodos::class,'id_periodo','id');
    }
    public function paquete(){
        return $this->belongsTo(Paquetes::class,'id_paquete','id');
    }
}
