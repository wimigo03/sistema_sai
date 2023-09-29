<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DerivCorrespModel extends Model
{
    protected $table = 'derivCorresp';

    protected $primaryKey= 'idderivacion';

    public $timestamps = false;

    protected $fillable = [
        'fechaderivacion',
        'idarea',
        'id_recepcion'
    ];

    public function recepcion(){
       // return $this->belongsTo('App\Models\Recepcion2Model','id_recepcion');
        return $this->belongsTo(Recepcion2Model::class, 'id_recepcion');
    }
}
