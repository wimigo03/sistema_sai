<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;

class Farmacia extends Model
{
    protected $table = 'farmacias';
    // public $timestamps = false;
    protected $fillable = [
        'dea_id',
        'nombre',
        'direccion',
        'whatsapp',
        'facebook',
        'lat',
        'lng',
        'estado'
    ];

    const HABILITADO = 1;
    const NO_HABILITADO = 2;

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
                return "badge-with-padding badge badge-secondary";
        }
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }

    public function scopeByDea($query, $dea)
    {
        if (filled($dea)) {
            return $query->whereHas('dea', function ($q) use ($dea) {
                $q->where('descripcion', 'ILIKE', '%'.$dea.'%');
            });
        }

        return $query;
    }

    public function scopeByFarmacia($query, $farmacia){
        if($farmacia != null){
            return $query->where('nombre', 'like', '%' . $farmacia . '%');
        }
    }
}
