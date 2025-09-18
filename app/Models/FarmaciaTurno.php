<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Farmacia;

class FarmaciaTurno extends Model
{
    protected $table = 'farmacias_turno';
    // public $timestamps = false;
    protected $fillable = [
        'farmacia_id',
        'fecha_i',
        'fecha_f',
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

    public function farmacia(){
        return $this->belongsTo(Farmacia::class,'farmacia_id','id');
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estado', $estado);
        }
    }

    public function scopeByFechas($query, ?string $fecha_i, ?string $fecha_f)
    {
        if ($fecha_i && $fecha_f) {
            try {
                $inicio = Carbon::createFromFormat('d-m-Y', $fecha_i)->startOfDay();
                $fin    = Carbon::createFromFormat('d-m-Y', $fecha_f)->endOfDay();

                return $query->whereBetween('fecha_i', [$inicio, $fin]);
            } catch (\Exception $e) {
                return $query;
            }
        }

        return $query;
    }

    public function scopeByFarmacia($query, $farmacia)
    {
        if (filled($farmacia)) {
            return $query->whereHas('farmacia', function ($q) use ($farmacia) {
                $q->where('nombre', 'ILIKE', '%'.$farmacia.'%');
            });
        }

        return $query;
    }
}
