<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsablesModel extends Model
{
    protected $primaryKey= 'idresponsable';

    public $timestamps = false;

    protected $fillable = [
        'nombrerespcontrat',
        'cargorespcontrat',
        'nombrerespadminist',
        'cargorespadminist',
        'nombrerespcompr',
        'cargorespcompr'
    ];

    protected $guarded = [

        
    ]; 
     
}
