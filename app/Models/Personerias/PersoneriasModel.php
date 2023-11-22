<?php

namespace App\Models\Personerias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersoneriasModel extends Model
{
    protected $table = 'personerias';

    protected $primaryKey= 'idpersoneria';

    public $timestamps =true;

    protected $fillable = [


    ];

    protected $guarded = [


    ];

    public function schedules(){
        return $this->belongsTo('App\Models\Personerias\ArchivoPersoneriaModel','idarchivopers');
    }

}
