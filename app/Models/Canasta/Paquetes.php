<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquetes extends Model
{

    protected $table = 'paquete';
    protected $primaryKey= 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'gestion',
        'periodo',
        'items',
        'user_id',
        'dea_id',
        'estado'
    ];

    const ESTADOS = [
        'A' => 'ACTIVO',
        'F' => 'FALLECIDO',
        'B' => 'BAJA'
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

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function barrios_entrega(){
        return $this->belongsTo(Dea::class,'idPaquete','idPaquete');
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
