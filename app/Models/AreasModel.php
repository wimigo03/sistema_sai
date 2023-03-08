<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasModel extends Model
{
    protected $table = 'areas';
    
    protected $primaryKey= 'idarea';

    public $timestamps = false;

    protected $fillable = [
        'nombrearea',
        'estadoarea',
        'idnivel'
    ];

    protected $guarded = [

        
    ];

    public function purchases()
    {
        return $this->hasMany('App\Models\EmpleadosModel', 'idarea', 'idarea');
    }
    public function iPais_all(){
        return $this->hasMany('App\Models\FileModel', 'idarea', 'idarea');
    }
}
