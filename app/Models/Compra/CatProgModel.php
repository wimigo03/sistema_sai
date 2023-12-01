<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProgModel extends Model
{
    protected $table = 'catprogramaticacomb';
    
    protected $primaryKey= 'idcatprogramaticacomb';

    public $timestamps = false;

    protected $fillable = [
        'codcatprogramatica',
        'nombrecatprogramatica',
        'estadocatprogramatica'
    ];

    protected $guarded = [

        
    ];
}

