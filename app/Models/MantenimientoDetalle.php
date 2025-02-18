<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\Mantenimiento;
use App\Models\User;

class MantenimientoDetalle extends Model
{
    protected $table = 'mantenimientos_detalles';
    protected $fillable = [
        'mantenimiento_id',
        'dea_id',
        'idarea',
        'idemp',
        'user_id',
        'user_asignado_id',
        'codigo_serie',
        'clasificacion',
        'fecha_r',
        'fecha_d',
        'problema_equipo',
        'diagnostico',
        'solucion_equipo',
        'estado',
    ];

    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'REALIZADO',
        '3' => 'ELIMINADO',
    ];

    const CLASIFICACIONES = [
        '1' => 'EQUIPO ESTACIONADO',
        '2' => 'EQUIPO PORTATIL',
        '3' => 'IMPRESORA',
        '4' => 'ESCANER',
        '5' => 'ACCESORIO',
        '6' => 'UPS',
        '7' => 'SWITCH',
        '8' => 'ROUTER',
        '9' => 'TECLADO',
        '10' => 'MONITOR',
        '11' => 'DATA-SHOW',
        '12' => 'ESTABILIZADOR',
        '13' => 'MOUSE',
        '14' => 'CAMARA WEB',
        '15' => 'CAMARA',
        '16' => 'CARGADOR',
        '17' => 'ANTENA WIFI',
        '18' => 'OTRO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "PENDIENTE";
            case '2':
                return "REALIZADO";
            case '3':
                return "ELIMINADO";
        }
    }

    public function getClasificacionEquipoAttribute(){
        switch ($this->clasificacion) {
            case '1':
                return "EQUIPO ESTACIONADO";
            case '2':
                return "EQUIPO PORTATIL";
            case '3':
                return "IMPRESORA";
            case '4':
                return "ESCANER";
            case '5':
                return "ACCESORIO";
            case '6':
                return "UPS";
            case '7':
                return "SWITCH";
            case '8':
                return "ROUTER";
            case '9':
                return "TECLADO";
            case '10':
                return "MONITOR";
            case '11':
                return "DATA-SHOW";
            case '12':
                return "ESTABILIZADOR";
            case '13':
                return "MOUSE";
            case '14':
                return "CAMARA WEB";
            case '15':
                return "CAMARA";
            case '16':
                return "CARGADOR";
            case '17':
                return "ANTENA WIFI";
            case '18':
                return "OTRO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-secondary";
            case '2':
                return "badge-with-padding badge badge-warning";
            case '3':
                return "badge-with-padding badge badge-success";
            case '4':
                return "badge-with-padding badge badge-info";
        }
    }

    public function area(){
        return $this->belongsTo(Area::class,'idarea','idarea');
    }

    public function funcionario(){
        return $this->belongsTo(Empleado::class,'idemp','idemp');
    }

    public function user_asignado(){
        return $this->belongsTo(User::class,'user_asignado_id','id');
    }

    public function mantenimiento(){
        return $this->belongsTo(Mantenimiento::class,'mantenimiento_id','id');
    }

    public function getAreaCortaAttribute(){
        $area = Area::where('idarea',$this->idarea)->first();
        if($area != null){
            $longitud = strlen($area->nombrearea);
            if($longitud > 10){
                $area_abreviada = mb_substr($area->nombrearea, 0, 10, 'UTF-8') . '...';
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

    public function scopeByCodigo($query, $codigo){
        if ($codigo != null) {
                return $query
                    ->whereIn('mantenimiento_id', function ($subquery) use($codigo) {
                        $subquery->select('id')
                            ->from('mantenimientos')
                            ->where('codigo', 'like' , '%' . $codigo . '%');
                    });
        }
    }

    public function scopeByCodigoSerie($query, $codigo_serie){
        if($codigo_serie != null){
            return $query->where('codigo_serie', 'like', '%' . $codigo_serie . '%');
        }
    }

    public function scopeByProcedencia($query, $area_id){
        if($area_id != null){
            return $query->where('idarea', $area_id);
        }
    }

    public function scopeByEncargado($query, $idemp){
        if($idemp != null){
            return $query->where('idemp', $idemp);
        }
    }

    public function scopeByClasificacion($query, $clasificacion){
        if($clasificacion != null){
            return $query->where('clasificacion', $clasificacion);
        }
    }

    public function scopeByFechaRecepcion($query, $fecha){
        if($fecha != null){
            $fecha_i = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $fecha)));
            $fecha_f = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $fecha)));
            return $query->whereBetween('fecha_r', [$fecha_i, $fecha_f]);
        }
    }

    public function scopeByEstado($query, $estado){
        if ($estado != null) {
                return $query
                    ->whereIn('mantenimiento_id', function ($subquery) use($estado) {
                        $subquery->select('id')
                            ->from('mantenimientos')
                            ->where('estado',$estado);
                    });
        }
    }

    public function scopeByEstadoDetalle($query, $estado_detalle){
        if($estado_detalle != null){
            return $query->where('estado', $estado_detalle);
        }
    }

    public function scopeByAsignado($query, $usuario){
        if ($usuario != null) {
                return $query
                    ->whereIn('user_asignado_id', function ($subquery) use($usuario) {
                        $subquery->select('id')
                            ->from('users')
                            ->where('name', 'like' , '%' . $usuario . '%');
                    });
        }
    }
}
