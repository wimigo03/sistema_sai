<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Entrega extends Model
{
    protected $table = 'entrega';
    protected $primaryKey= 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'fecha',
        'id_paquete',
        'id_beneficiario',
        'user_id',
        'dea_id',
        'id_barrio',
        'created_at',
        'updated_at',
        'estado'
    ];
    const ESTADOS = [
        '1' => 'SIN ENT.(SIN IMPRESION)',
        '2' => 'SIN ENT.(IMPRESO)',
        '3' => 'ENTREGADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "SIN ENT.(SIN IMPRESION)";

            case '2':
                return "SIN ENT.(IMPRESO)";

                case '3':
                    return "ENTREGADO";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function paquete_periodo(){
        return $this->belongsTo(User::class,'id','id_paquete');
    }

    public function name(){
       $barrios_entrega = DB::table('barriosEntrega')
                      ->where('id_barrio',$this->id_barrio)
                    ->where('id_paquete',$this->id_paquete)
                     ->select('estado')
                        ->first();
        if($barrios_entrega != null){
            $estados =$barrios_entrega->estado;
       }else{
             $estados = null;
         }
         return $estados;
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
        if($gestion){
            return $query->where('gestion', $gestion);

        }
    }

    public function scopeByPeriodo($query, $periodo){
        if($periodo){
            return $query->whereRaw('upper(periodo) like ?', ['%'.strtoupper($periodo).'%']);

        }
    }

    public function scopeByNombre($query, $nombre){
        if ($nombre) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($nombre) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);
                    });
        }
    }

    public function scopeByAp($query, $ap){
        if ($ap) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($ap) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);
                    });
        }
    }

    public function scopeByAm($query, $am){
        if ($am) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($am) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);
                    });
        }
    }

    public function scopeByCi($query, $ci){
        if ($ci) {
                return $query
                    ->whereIn('entrega.id_beneficiario', function ($subquery) use($ci) {
                        $subquery->select('id')
                            ->from('beneficiarios')
                            ->whereRaw('upper(ci) like ?', [strtoupper($ci)]);
                    });
        }
    }


    public function scopeByBarrio($query, $barrio){
        if ($barrio) {
            //dd($barrio);
                return $query
                    ->whereIn('entrega.id_barrio', function ($subquery) use($barrio) {
                        $subquery->select('barrios.id')
                            ->from('barrios')
                            //->whereRaw('upper(nombre) like ?', [strtoupper($barrio)]);
                            ->where('nombre','like',$barrio);
                    });
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
     public function scopeById($query, $id){
        if($id){
            return $query->where('id',$id);
        }
    }

    public function beneficiario(){
        return $this->belongsTo(Beneficiario::class,'id_beneficiario','id');
    }

    public function barrio(){
        return $this->belongsTo(Barrio::class,'id_barrio','id');
    }

    public function paquete(){
        return $this->belongsTo(Paquetes::class,'id_paquete','id');
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('entrega.estado',$estado);
        }
    }
}
