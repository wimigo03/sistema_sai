<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Barrio;

class Farmacia extends Model
{
    protected $table = 'farmacias';
    // public $timestamps = false;
    protected $fillable = [
        'barrio_id',
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

    public function barrio(){
        return $this->belongsTo(Barrio::class,'barrio_id','id');
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }

    public function scopeByBarrio($query, $barrio)
    {
        if (filled($barrio)) {
            return $query->whereHas('barrio', function ($q) use ($barrio) {
                $q->where('nombre', 'ILIKE', '%'.$barrio.'%');
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
