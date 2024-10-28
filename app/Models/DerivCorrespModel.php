<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DerivCorrespModel extends Model
{
    protected $table = 'deriv_corresp';

    protected $primaryKey= 'idderivacion';

    public $timestamps = true;

    protected $fillable = [
        'fechaderivacion',
        'idarea',
        'idinstruccion',
        'estadoderiv1',
        'estadoderiv2',
        'id_recepcion'
    ];

    public function recepcion(){
       // return $this->belongsTo('App\Models\Recepcion2Model','id_recepcion');
        return $this->belongsTo(Recepcion2Model::class, 'id_recepcion');
    }
}
