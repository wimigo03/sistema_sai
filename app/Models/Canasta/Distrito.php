<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;

class Distrito extends Model
{
    protected $table = 'distritos';
    protected $fillable = [
        'nombre',
        'user_id',
        'dea_id',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
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

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->whereRaw('upper(nombre) like ?', ['%'.strtoupper($nombre).'%']);

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

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado',$estado);
        }
    }
}
