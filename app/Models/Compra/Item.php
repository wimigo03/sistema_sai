<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;
use App\Models\Compra\UnidadMedida;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\IngresoCompraDetalle;
use DB;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'partida_presupuestaria_id',
        'dea_id',
        'user_id',
        'unidad_id',
        'codigo',
        'codigo_ant',
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
        '3' => 'ELIMINADO',
    ];

    const TIPOS = [
        '1' => 'PRODUCTO',
        //'2' => 'SERVICIO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
            case '3':
                return "ELIMINADO";
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
            case '3':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function ingresoCompraDetalles()
    {
        return $this->hasMany(IngresoCompraDetalle::class);
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class,'unidad_id','id');
    }

    public function partidaPresupuestaria(){
        return $this->belongsTo(PartidaPresupuestaria::class,'partida_presupuestaria_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('items.dea_id', $dea_id);
        }
    }

    public function scopeByCodigoPartidaPresupuestaria($query, $codigo_partida_presupuestaria){
        if ($codigo_partida_presupuestaria != null) {
                return $query
                    ->whereIn('partida_id', function ($subquery) use($codigo_partida_presupuestaria) {
                        $subquery->select('id')
                            ->from('partidas')
                            ->where('codigo',$codigo_partida_presupuestaria);
                    });
        }
    }

    public function scopeByPartidaPresupuestaria($query, $partida_presupuestaria_id){
        if ($partida_presupuestaria_id != null) {
            return $query->where('partida_presupuestaria_id', $partida_presupuestaria_id);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo != null){
            return $query->where('codigo','like', '%' . $codigo . '%');
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre != null){
            return $query->where('nombre','like', '%' . $nombre . '%');
        }
    }

    public function scopeByDetalle($query, $detalle){
        if($detalle != null){
            return $query->where('detalle','like', '%' . $detalle . '%');
        }
    }

    public function scopeByPrecio($query, $precio){
        if($precio != null){
            $precio = floatval(str_replace(",", "", $precio));
            return $query->where('precio','like', $precio . '%');
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo != null){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByUnidadMedida($query, $unidad_id){
        if($unidad_id != null){
            return $query->where('unidad_id', $unidad_id);
        }
    }

    public function scopeByFechaRegistro($query, $from){
        if ($from != null) {
            $from = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $from)));
            $to = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $from)));
            return $query->where(
                'fecha_registro','>=',$from
            )
            ->where('fecha_registro', '<=', $to);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
