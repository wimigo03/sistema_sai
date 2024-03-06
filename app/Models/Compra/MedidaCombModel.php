<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedidaCombModel extends Model
{
    use HasFactory;
    protected $table = 'umedidacomb';
    
    protected $primaryKey= 'idmedida';

    public $timestamps = false;

    protected $fillable = [
        'nombremedida'
      
    ];

    protected $guarded = [

        
    ];
}

