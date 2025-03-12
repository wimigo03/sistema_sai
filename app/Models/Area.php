<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NivelModel;
use App\Models\Canasta\Dea;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Almacenes\Almacen;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';
    protected $primaryKey= 'idarea';
    protected $fillable = [
        'nombrearea',
        'estadoarea',
        'idnivel',
        'dea_id',
        'almacen_id',
        'parent_id',
        'tipo',
        'nivel',
        'categoria_programatica_id',
        'alias'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    const TIPOS = [
        '1' => 'INSTITUCIONAL',
        '2' => 'PROGRAMA'
    ];

    public function getTiposAttribute(){
        switch ($this->tipo) {
            case '1':
                return "INSTITUCIONAL";
            case '2':
                return "PROGRAMA";
        }
    }

    public function getStatusAttribute(){
        switch ($this->estadoarea) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estadoarea) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Empleado', 'idarea', 'idarea');
    }

    public function iPais_all(){
        return $this->hasMany('App\Models\File', 'idarea', 'idarea');
    }

    /* public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'idarea');
    } */

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'idarea');
    }

    public function nivel(){
        return $this->belongsTo(NivelModel::class,'idnivel','idnivel');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id','id');
    }

    public function cprogramatica(){
        return $this->belongsTo(CategoriaProgramatica::class,'categoria_programatica_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function children()
    {
        return $this->hasMany(Area::class, 'parent_id');
    }

    public function getAllChildren($area_id)
    {
        $children = collect();

        $dd = $this->getChildrenRecursively($children, $area_id);

        return $children;
    }

    private function getChildrenRecursively($children, $parent_id)
    {
        $directChildren = $this->where('parent_id', $parent_id)->get();

        foreach ($directChildren as $child) {
            $children->push($child);
            $this->getChildrenRecursively($children, $child->idarea);
        }
    }

    public function getParentAttribute(){
        $area_parent = Area::where('parent_id',$this->idarea)->first();
        if($area_parent != null){
            $parent = $area_parent->nombrearea;
            return $parent;
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByAlmacen($query, $almacen){
        if($almacen){
            return $query->where('almacen_id', $almacen);
        }
    }

    public function scopeByCategoriaProgramatica($query, $categoria_programatica_id){
        if($categoria_programatica_id){
            return $query->where('categoria_programatica_id', $categoria_programatica_id);
        }
    }
}
