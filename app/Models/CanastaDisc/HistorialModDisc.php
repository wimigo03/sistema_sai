<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HistorialModDisc extends Model
{
    protected $table = 'historialmod';
    //protected $primaryKey= 'id';
    //public $timestamps = true;
    protected $fillable = [
        'id',
        'observacion',
        'id_beneficiario',
        'user_id',
        'dea_id',
        'fecha'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
