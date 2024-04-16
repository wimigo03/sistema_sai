<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AreasModel;

class PersonalFace extends Model
{
    protected $table = 'personalface';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombres',
        'ap',
        'am',
        'ci',
        'idArea'
    ];

    public function area(){
        return $this->belongsTo(AreasModel::class,'id_area','idarea');
    }

}
