<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProgModel extends Model
{
    protected $table = 'catprogramatica';
    
    protected $primaryKey= 'idcatprogramatica';

    public $timestamps = false;

    protected $fillable = [
        'codcatprogramatica',
        'nombrecatprogramatica',
        'estadocatprogramatica'
    ];

    protected $guarded = [

        
    ];
}
