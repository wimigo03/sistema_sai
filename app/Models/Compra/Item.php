<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;
use App\Models\Compra\UnidadMedida;
use App\Models\Compra\Partida;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'partida_id',
        'dea_id',
        'user_id',
        'unidad_id',
        'nombre',
        'detalle',
        'precio',
        'tipo',
        'fecha_registro',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
    ];

    const TIPOS = [
        '1' => 'PRODUCTO',
        '2' => 'SERVICIO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1': 
                return "HABILITADO";
            case '2': 
                return "NO HABILITADO";
        }
    }

    public function getTiposAttribute(){
        switch ($this->tipo) {
            case '1': 
                return "PRODUCTO";
            case '2': 
                return "SERVICIO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1': 
                return "badge-with-padding badge badge-success";
            case '2': 
                return "badge-with-padding badge badge-danger";
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
    }

    public function partida(){
        return $this->belongsTo(Partida::class,'partida_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByCodigoPartidaPresupuestaria($query, $codigo_partida_presupuestaria){
        if ($codigo_partida_presupuestaria) {
                return $query
                    ->whereIn('partida_id', function ($subquery) use($codigo_partida_presupuestaria) {
                        $subquery->select('id')
                            ->from('partidas')
                            ->where('codigo',$codigo_partida_presupuestaria);
                    });
        }
    }

    public function scopeByPartidaPresupuestaria($query, $partida_presupuestaria){
        if ($partida_presupuestaria) {
                return $query
                    ->whereIn('partida_id', function ($subquery) use($partida_presupuestaria) {
                        $subquery->select('id')
                            ->from('partidas')
                            ->where('nombre','LIKE','%'.$partida_presupuestaria.'%');
                    });
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','like', '%' . $nombre . '%');
        }
    }

    public function scopeByDetalle($query, $detalle){
        if($detalle){
            return $query->where('detalle','like', '%' . $detalle . '%');
        }
    }

    public function scopeByPrecio($query, $precio){
        if($precio){
            $precio = floatval(str_replace(",", "", $precio));
            return $query->where('precio','like', $precio . '%');
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByUnidadMedida($query, $unidad_id){
        if($unidad_id){
            return $query->where('unidad_id', $unidad_id);
        }
    }

    public function scopeByFechaRegistro($query, $from){
        if ($from) {
            $from = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $from)));
            $to = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $from)));
            return $query->where(
                'fecha_registro','>=',$from
            )
            ->where('fecha_registro', '<=', $to);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
