<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Paquetes;
use App\Models\Canasta\Dea;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Distrito;
use Illuminate\Support\Facades\Auth;
use DB;

class PaqueteBarrio extends Model
{
    protected $table = 'paquete_barrios';
    protected $fillable = [
        'id_paquete',
        'dea_id',
        'id_barrio',
        'distrito_id',
        'lugar_entrega',
        'fecha_entrega',
        'hora_inicio',
        'hora_final',
        'estado'
    ];
    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'FINALIZADO'
    ];

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
                return "badge-with-padding badge badge-secondary font-roboto-10";
            case '2':
                return "badge-with-padding badge badge-success font-roboto-10";
        }
    }

    public function getperiodosAttribute(){
        $paquete_periodos = DB::table('paquete_periodo as a')
                    ->join('periodos as b','b.id','a.id_periodo')
                    ->where('a.id_paquete',$this->id_paquete)
                    ->select('b.mes')
                    ->get();

        $periodos = array();

        if($paquete_periodos != null){
            foreach($paquete_periodos as $datos){
                $periodos[] = $datos->mes;
            }
        }

        $periodos_str = implode(' - ', $periodos);

        return $periodos_str;
    }

    public function getTotalRegistradosAttribute(){
        $beneficiarios_registrados = DB::table('entrega')
                                    ->select('id')
                                    ->where('paquete_barrio_id',$this->id)
                                    ->where('estado','!=','3')
                                    ->get();
        if($beneficiarios_registrados != null){
            return count($beneficiarios_registrados);
        }
    }

    public function getTotalNoRegistradosAttribute(){
        $beneficiarios = DB::table('beneficiarios')
                            ->select('id')
                            ->where('dea_id',Auth::user()->dea->id)
                            ->where('distrito_id',$this->distrito_id)
                            ->where('id_barrio',$this->id_barrio)
                            ->where('estado','A')
                            ->get();

        $beneficiarios_registrados = DB::table('entrega')
                                        ->select('id')
                                        ->where('paquete_barrio_id',$this->id)
                                        ->where('estado','!=','3')
                                        ->get();
        $total = 0;

        if($beneficiarios != null && $beneficiarios_registrados != null){
            $total = count($beneficiarios) - count($beneficiarios_registrados);
        }
        return $total;
    }

    public function getTotalHabilitadosAttribute(){
        $beneficiarios = DB::table('beneficiarios')
                            ->select('id')
                            ->where('dea_id',Auth::user()->dea->id)
                            ->where('distrito_id',$this->distrito_id)
                            ->where('id_barrio',$this->id_barrio)
                            ->where('estado','A')
                            ->get();

        if($beneficiarios != null){
            return count($beneficiarios);
        }
    }

    public function getTotalEntregadosAttribute(){
        $entregados = DB::table('entrega')
                                        ->select('id')
                                        ->where('paquete_barrio_id',$this->id)
                                        ->where('estado','2')
                                        ->get();
        if($entregados != null){
            return count($entregados);
        }
    }

    public function getTotalNoEntregadosAttribute(){
        $no_entregados = DB::table('entrega')
                                        ->select('id')
                                        ->where('paquete_barrio_id',$this->id)
                                        ->where('estado','1')
                                        ->get();
        if($no_entregados != null){
            return count($no_entregados);
        }
    }

    public function getTotalResagadosAttribute(){
        $resagados = DB::table('entrega')
                                        ->select('id')
                                        ->where('paquete_barrio_id',$this->id)
                                        ->where('estado','4')
                                        ->get();
        if($resagados != null){
            return count($resagados);
        }
    }

    public function paquete(){
        return $this->belongsTo(Paquetes::class,'id_paquete','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function barrio(){
        return $this->belongsTo(Barrio::class,'id_barrio','id');
    }

    public function distrito(){
        return $this->belongsTo(Distrito::class,'distrito_id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByPaquete($query, $paquete_id){
        if($paquete_id != null){
            return $query->where('id_paquete', $paquete_id);
        }
    }

    public function scopeByDistrito($query, $distrito_id){
        if($distrito_id != null){
            return $query->where('distrito_id', $distrito_id);
        }
    }

    public function scopeByBarrio($query, $barrio_id){
        if($barrio_id != null){
            return $query->where('id_barrio', $barrio_id);
        }
    }

    public function scopeByLugarEntrega($query, $lugar_entrega){
        if($lugar_entrega != null){
            if($lugar_entrega != 'LUGARES NO DEFINIDOS')
            {
                return $query->where('lugar_entrega', $lugar_entrega);
            }else{
                return $query->where('lugar_entrega', null);
            }
        }
    }

    public function scopeByFechaEntrega($query, $fecha_inicial, $fecha_final){
        if ($fecha_inicial != null && $fecha_final != null) {
            $fecha_inicial = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_inicial)));
            $fecha_final = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_final)));
            return $query->where(
                'fecha_entrega','>=',$fecha_inicial
            )
            ->where('fecha_entrega', '<=', $fecha_final);
        }
    }

    public function scopeByEstado($query, $estado){
        if ($estado != null) {
            return $query->where('estado', $estado);
        }
    }
}
