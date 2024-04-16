<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasModel extends Model
{
    use HasFactory;
    
    protected $table = 'areas';
    
    protected $primaryKey= 'idarea';

    public $timestamps = false;

    protected $fillable = [
        'nombrearea',
        'estadoarea',
        'idnivel',
        'dea_id'
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
    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'idarea');
    }
    public function empleados()
    {
        return $this->hasMany(EmpleadosModel::class, 'idarea');
    }
}
