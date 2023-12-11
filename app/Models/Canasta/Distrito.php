<?php

namespace App\Models\Canasta;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        '0' => 'HABILITADO',
        '1' => 'NO HABILITADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '0': 
                return "HABILITADO";
            case '1': 
                return "NO HABILITADO";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }
}
