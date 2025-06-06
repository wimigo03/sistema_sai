<?php

namespace App\Models\Almacenes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    protected $fillable = [
        'dea_id',
        'user_id',
        'nombre',
        'representante',
        'nro_ci',
        'nit',
        'telefono',
        'fecha_registro',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO',
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

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id){
            return $query->where('dea_id', $dea_id);
        }
    }

    public function scopeByNro($query, $nro){
        if($nro){
            return $query->where('id', $nro);
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','like', '%' . $nombre . '%');
        }
    }

    public function scopeByRepresentante($query, $representante){
        if($representante){
            return $query->where('representante','like', '%' . $representante . '%');
        }
    }

    public function scopeByNroCi($query, $nro_ci){
        if($nro_ci){
            return $query->where('nro_ci', $nro_ci);
        }
    }

    public function scopeByNit($query, $nit){
        if($nit){
            return $query->where('nit', $nit);
        }
    }

    public function scopeByTelefono($query, $telefono){
        if($telefono){
            return $query->where('telefono', $telefono);
        }
    }

    public function scopeByFechaRegistro($query, $from){
        if ($from) {
            $from = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $from)));
            $to = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $from)));
            return $query->where(
                'fecha_registro','>=',$from
            )
            ->where('fecha_registro', '<=', $to);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}
