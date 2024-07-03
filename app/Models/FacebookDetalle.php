<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Facebook;
use App\Models\Area;
use App\Models\Empleado;
use DB;

class FacebookDetalle extends Model
{
    use HasFactory;

    protected $table = 'facebook_detalles';
    protected $fillable = [
        'facebook_id',
        'dea_id',
        'idemp',
        'idarea',
        'user_id',
        '_share',
        '_like',
        '_comment',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'ELIMINADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "ELIMINADO";
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

    public function facebook(){
        return $this->belongsTo(Facebook::class,'facebook_id','id');
    }

    public function area(){
        return $this->belongsTo(Area::class,'idarea','idarea');
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class,'idemp','idemp');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    /*public function scopeByArea($query, $area_id){
        if($area_id != null){
            return $query->where('idarea', $area_id);
        }
    }*/

    public function scopeByArea($query, $area_id)
    {
        if ($area_id != null) {
            $areaModel = new Area();
            $children = $areaModel->getAllChildren($area_id);
            $childrenIds = $children->pluck('idarea')->toArray();

            if (empty($childrenIds)) {
                return $query->where('idarea', $area_id);
            } else {
                $childrenIds[] = $area_id;
                return $query->whereIn('idarea', $childrenIds);
            }
        }
        return $query;
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }

    public function scopeByEntreFechas($query, $from, $to){
        if ($from && $to) {
                $from = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $from)));
                $to = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $to)));
                return $query
                    ->whereIn('facebook_id', function ($subquery) use($from, $to) {
                        $subquery->select('id')
                            ->from('facebook')
                            ->where('estado','1')
                            ->where('fecha','>=',$from)
                            ->where('fecha','<=',$to);
                    });
        }
    }
}
