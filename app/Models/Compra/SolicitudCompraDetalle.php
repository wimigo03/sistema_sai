<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Compra\Partida;
use App\Models\Compra\Item;
use App\Models\Compra\UnidadMedida;

class SolicitudCompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'solicitud_compra_detalles';
    protected $fillable = [
        'solicitud_compra_id',
        'idarea',
        'user_id',
        'dea_id',
        'item_id',
        'partida_id',
        'unidad_id',
        'user_aprob_id',
        'cantidad',
        'saldo',
        'estado'
    ];

    public function partida(){
        return $this->belongsTo(Partida::class,'partida_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
    }
}
