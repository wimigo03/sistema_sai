<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\User;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';
    protected $fillable = [
        'dea_id',
        'idarea',
        'idemp',
        'user_id',
        'codigo',
        'nro_comunicacion_interna',
        'f_h_registro',
        'observaciones',
        'estado',
    ];

    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'FINALIZADO',
    ];

    public function getStatusAliasAttribute(){
        switch ($this->estado) {
            case '1':
                return "P";
            case '2':
                return "F";
        }
    }

    public function getcolorStatusAliasAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-success";
        }
    }

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "FINALIZADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "btn btn-secondary";
            case '2':
                return "btn btn-success";
        }
    }

    public function area(){
        return $this->belongsTo(Area::class,'idarea','idarea');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function funcionario(){
        return $this->belongsTo(Empleado::class,'idemp','idemp');
    }

    public function getAreaCortaAttribute(){
        $area = Area::where('idarea',$this->idarea)->first();
        if($area != null){
            $longitud = strlen($area->nombrearea);
            if($longitud > 15){
                $area_abreviada = mb_substr($area->nombrearea, 0, 20, 'UTF-8') . '...';
            }else{
                $area_abreviada = $area->nombrearea;
            }
            return $area_abreviada;
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByArea($query, $area_id){
        if($area_id != null){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeByNumero($query, $numero){
        if($numero != null){
            return $query->where('nro', $numero);
        }
    }

    public function scopeByTipo($query, $tipo_id){
        if($tipo_id != null){
            return $query->where('idtipo', $tipo_id);
        }
    }

    public function scopeBySolicitante($query, $solicitante){
        if ($solicitante != null) {
                return $query
                    ->whereIn('empleado_solicitante_id', function ($subquery) use($solicitante) {
                        $subquery->select('idemp')
                            ->from('empleados')
                            ->whereRaw("CONCAT(nombres, ' ', ap_pat, ' ', ap_mat) LIKE ?", ["%{$solicitante}%"]);
                    });
        }
    }

    public function scopeByAreaDestino($query, $area_id){
        if($area_id != null){
            return $query->where('destinatario_idarea', $area_id);
        }
    }

    public function scopeByDirigido($query, $dirigido){
        if ($dirigido != null) {
                return $query
                    ->whereIn('empleado_destinatario_id', function ($subquery) use($dirigido) {
                        $subquery->select('idemp')
                            ->from('empleados')
                            ->whereRaw("CONCAT(nombres, ' ', ap_pat, ' ', ap_mat) LIKE ?", ["%{$dirigido}%"]);
                    });
        }
    }

    public function scopeByReferencia($query, $referencia){
        if($referencia != null){
            return $query->where('referencia', 'like', '%' . $referencia . '%');
        }
    }

    public function scopeByFecha($query, $fecha){
        if($fecha != null){
            $fecha_i = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $fecha)));
            $fecha_f = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $fecha)));
            return $query->whereBetween('fecha', [$fecha_i, $fecha_f]);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            if($estado == '3'){
                return $query->whereIn('estado', ['1','2']);
            }else{
                return $query->where('estado', $estado);
            }
        }
    }
}
