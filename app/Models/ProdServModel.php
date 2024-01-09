<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MedidaModel;

class ProdServModel extends Model
{
    protected $table = 'prodserv';    
    protected $primaryKey= 'idprodserv';
    public $timestamps = false;
    protected $fillable = [
                    'umedida_idumedida',
                    'partida_idpartida',
                    'nombreprodserv',
                    'detalleprodserv',
                    'precioprodserv',
                    'estadoprodserv'
                ];

    public function getUnidadMedidaAttribute(){
        $unidad_medida = MedidaModel::find($this->umedida_idumedida);
        if($unidad_medida != null){
            return $unidad_medida->nombreumedida;
        }
    }
}
