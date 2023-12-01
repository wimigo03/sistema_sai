<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActualModel;
use App\Models\AuxiliarModel;

class UnidadadminModel extends Model
{
    use HasFactory;

    protected $table = 'unidadadmin';
    protected $primaryKey = 'idunidadadmin';
    public $timestamps = true;

    protected $fillable = [
        'entidad',
        'unidad',
        'descrip',
        'ciudad',
        'estadounidadadmin',
    ];

    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'idunidadadmin');

    }
    public function auxiliars()
    {
        return $this->hasMany(AuxiliarModel::class, 'idunidadadmin');
        
    }
    public function entidades()
    {
        return $this->belongsTo(EntidadesModel::class, 'identidades');
    }
}
