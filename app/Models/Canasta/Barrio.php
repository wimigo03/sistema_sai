<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\BarrioEntrega;


class Barrio extends Model
{
    protected $table = 'barrios';
    protected $primaryKey= 'id';
    protected $fillable = [
        'id',
        'tipo',
        'nombre',
        'distrito_id',
        'user_id',
        'dea_id',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    const TIPOS = [
        '1' => 'BARRIO',
        '2' => 'COMUNIDAD'
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

    public function getTipoBAttribute(){
        switch ($this->tipo) {
            case '1':
                return "BARRIO";
            case '2':
                return "COMUNIDAD";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function beneficiariosA(){
        return $this->belongsTo(Beneficiario::class,'id','idBarrio')->where('estado','A');
    }
    public function beneficiariosB(){
        return $this->belongsTo(Beneficiario::class,'id','idBarrio')->where('estado','B');
    }

    public function beneficiariosF(){
        return $this->belongsTo(Beneficiario::class,'id','idBarrio')->where('estado','F');
    }

    public function beneficiariosX(){
        return $this->belongsTo(Beneficiario::class,'id','idBarrio')->where('estado','X');
    }



    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function distrito(){
        return $this->belongsTo(Distrito::class,'distrito_id','id');
    }

    public function barrio_entrega(){
        return $this->belongsTo(BarrioEntrega::class,'id','idBarrio');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('id', $codigo);
        }
    }

    public function scopeByTipo($query, $tipo){
        if($tipo){
            return $query->where('tipo', $tipo);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->whereRaw('upper(nombre) like ?', ['%'.strtoupper($nombre).'%']);
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByDistrito($query, $distrito_id){
        if($distrito_id){
            return $query->where('distrito_id',$distrito_id);
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

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado',$estado);
        }
    }
}
