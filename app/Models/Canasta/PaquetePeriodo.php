<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaquetePeriodo extends Model
{
    protected $table = 'paquete_periodo';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_paquete',
        'id_periodo'
    ];

    public function periodo(){
        return $this->belongsTo(Periodos::class,'id_periodo','id');
    }
    public function paquete(){
        return $this->belongsTo(Paquetes::class,'id_paquete','id');
    }
}
