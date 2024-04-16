<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdCombModel extends Model
{
    use HasFactory;
    protected $table = 'prodcomb';
    
    protected $primaryKey= 'idprodcomb';

    public $timestamps = false;

    protected $fillable = [
 

        'codigoprodcomb',
        'nombreprodcomb',
        'detalleprodcomb',
        'precioprodcomb',
        'estadoprodcomb'
    ];

    protected $guarded = [

        
    ];
}
