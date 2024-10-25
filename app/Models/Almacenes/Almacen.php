<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $fillable = [
        'dea_id',
        'user_id',
        'nombre',
        'direccion',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
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

    /*public function getSaldoTotalAttribute(){
        $ingreso_compra_detalles = IngresoCompraDetalle::query()
                                            ->whereHas('ingresoCompra', function ($query) {
                                                $query->where('estado', '2');
                                            })
                                            ->byDea(Auth::user()->dea->id)
                                            ->byItem($this->id)
                                            ->byAlmacen($this->almacen_id)
                                            ->select('item_id',DB::raw("sum(saldo) as saldo_total"))
                                            ->groupBy('item_id')
                                            ->get()->sum('saldo_total');
        return $ingreso_compra_detalles;
    }*/

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('almacenes.dea_id', $dea_id);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre != null){
            return $query->where('nombre', 'like', '%'.$nombre.'%');
        }
    }

    public function scopeByDireccion($query, $direccion){
        if($direccion != null){
            return $query->where('direccion', 'like', '%'.$direccion.'%');
        }
    }

    public function scopeByEncargado($query, $user_id){
        if($user_id != null){
            return $query->where('user_id', $user_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }
}
