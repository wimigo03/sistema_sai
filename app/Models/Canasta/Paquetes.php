<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Periodos;
use DB;

class Paquetes extends Model
{

    protected $table = 'paquete';
    //protected $primaryKey= 'id';
    //public $timestamps = true;
    protected $fillable = [
        'gestion',
        'items',
        'user_id',
        'dea_id',
        'estado',
        'id_tipo',
        'numero'
    ];

    const ESTADOS = [
        'A' => 'ACTIVO',
        'F' => 'FALLECIDO',
        'B' => 'BAJA'
    ];

    const TERCERA_EDAD = 1;
    const DISCAPACIDAD = 2;

    const TIPOS = [
        '1' => '3RA EDAD',
        '2' => 'DISCAPACIDAD'
    ];

    const NUMEROS_ENTREGA = [
        '1RA.' => '1RA ENTREGA',
        '2DA.' => '2DA ENTREGA',
        '3RA.' => '3RA ENTREGA',
        '4TA.' => '4TA ENTREGA',
        '5TA.' => '5TA ENTREGA',
        '6TA.' => '6TA ENTREGA',
        '7MA.' => '7MA ENTREGA',
        '8VA.' => '8VA ENTREGA',
        '9NA.' => '9NA ENTREGA',
        '10MA.' => '10MA ENTREGA',
        '10MA.1RA.' => '10MA.1RA. ENTREGA',
        '10MA.2DA.' => '10MA.2DA. ENTREGA'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "ACTIVO";
            case 'F':
                return "FALLECIDO";
            case 'B':
            return "BAJA";
        }
    }

    public function getRegistradosAttribute(){
        $registrados = DB::table('entrega')->select('id')->where('id_paquete',$this->id)->get();
        if($registrados != null){
            return count($registrados);
        }
    }

    public function getEntregadosAttribute(){
        $entregados = DB::table('entrega')->select('id')->where('id_paquete',$this->id)->where('estado','2')->get();
        if($entregados != null){
            return count($entregados);
        }
    }

    public function getNoEntregadosAttribute(){
        $no_entregados = DB::table('entrega')->select('id')->where('id_paquete',$this->id)->where('estado','1')->get();
        if($no_entregados != null){
            return count($no_entregados);
        }
    }

    public function getResagadosAttribute(){
        $resagados = DB::table('entrega')->select('id')->where('id_paquete',$this->id)->where('estado','4')->get();
        if($resagados != null){
            return count($resagados);
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('id', $codigo);
        }
    }

    public function scopeByGestion($query, $gestion){
        if($gestion != null){
            return $query->where('gestion', $gestion);

        }
    }

    public function scopeByPeriodo($query, $periodo){
        if($periodo != null){
            return $query->where('periodo_id', $periodo);

        }
    }

    public function scopeByEntrega($query, $entrega){
        if($entrega != null){
            return $query->where('numero', $entrega);

        }
    }

    public function scopeByUsuario($query, $usuario){
        if ($usuario) {
                return $query
                    ->whereIn('user_id', function ($subquery) use($usuario) {
                        $subquery->select('id')
                            ->from('users')
                            ->whereRaw('upper(name) like ?', [strtoupper($usuario)]);
                    });
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByTipoSistema($query, $tipo){
        if($tipo != null){
            return $query->where('id_tipo',$tipo);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado',$estado);
        }
    }
}
