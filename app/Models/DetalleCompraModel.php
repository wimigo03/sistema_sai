<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProdServModel;

class DetalleCompraModel extends Model
{
    protected $table = 'detallecompra';    
    protected $primaryKey= 'iddetallecompra';
    public $timestamps = false;
    protected $fillable = [
        'cantidad',
        'subtotal',
        'precio',
        'idprodserv',
        'idcompra',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'ELIMINADO'
    ];
    public function producto(){
        return $this->belongsTo(ProdServModel::class,'idprodserv','idprodserv');
    }
}
