<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;
use DB;

class EscalaSalarial extends Model
{
    protected $table = 'escala_salarial';
    protected $fillable = [
        'dea_id',
        'nombre',
        'categoria',
        'clase',
        'nivel_salarial',
        'haber_basico',
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

    public function getcolorStatusAttribute(){
        switch ($this->estadofile) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function dea()
    {
        return $this->belongsTo(Dea::class, 'dea_id', 'id');
    }
}
