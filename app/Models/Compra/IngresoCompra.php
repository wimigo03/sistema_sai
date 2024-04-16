<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AreasModel;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Compra\Proveedor;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\Programa;
use App\Models\Compra\SolicitudCompra;
use App\Models\Almacenes\Almacen;
use App\Models\Compra\OrdenCompra;

class IngresoCompra extends Model
{
    use HasFactory;

    protected $table = 'ingresos_compras';
    protected $fillable = [
        'almacen_id',
        'user_id',
        'dea_id',
        'proveedor_id',
        'idarea',
        'orden_compra_id',
        'categoria_programatica_id',
        'programa_id',
        'solicitud_compra_id',
        'codigo',
        'fecha_ingreso',
        'obs',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'EN ESPERA',
        '2' => 'INGRESADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "EN ESPERA";
            case '2':
                return "INGRESADO";
        }
    }

    public function getcolorBadgeStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
        }
    }

    public function getcolorInputStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "text-white bg-secondary";
            case '2':
                return "text-white bg-success";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "text-secondary";
            case '2':
                return "text-success";
        }
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor_id','id');
    }

    public function area(){
        return $this->belongsTo(AreasModel::class,'idarea','idarea');
    }

    public function orden_compra(){
        return $this->belongsTo(OrdenCompra::class,'idarea','idarea');
    }

    public function programatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function programa(){
        return $this->belongsTo(Programa::class,'programa_id','id');
    }

    public function solicitud_compra(){
        return $this->belongsTo(SolicitudCompra::class,'solicitud_compra_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('codigo', $codigo);
        }
    }

    public function scopeByAlmacen($query, $almacen_id){
        if($almacen_id){
            return $query->where('almacen_id', $almacen_id);
        }
    }

    public function scopeByProveedor($query, $proveedor_id){
        if($proveedor_id){
            return $query->where('proveedor_id', $proveedor_id);
        }
    }

    public function scopeByCodigoOC($query, $codigo_oc){
        if ($codigo_oc) {
                return $query
                    ->whereIn('orden_compra_id', function ($subquery) use($codigo_oc) {
                        $subquery->select('id')
                            ->from('orden_compras')
                            ->where('codigo', $codigo_oc);
                    });
        }
    }

    public function scopeByCategoriaProgramatica($query, $categoria_programatica_id){
        if($categoria_programatica_id){
            return $query->where('categoria_programatica_id', $categoria_programatica_id);
        }
    }

    public function scopeByPrograma($query, $programa_id){
        if($programa_id){
            return $query->where('programa_id', $programa_id);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
