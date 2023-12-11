<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadesModel extends Model
{
    use HasFactory;

    protected $table = 'entidades';
    protected $primaryKey = 'identidades';
    public $timestamps = true;

    protected $fillable = [
        'gestion',
        'entidad',
        'desc_ent',
        'sigla_ent',
        'sector_ent',
        'subsector_ent',
        'area_ent',
        'subareaent',
        'nivel_inst',
        'estadoentidades',
       
    ];
    public function unidadadmins()
    {
        return $this->hasMany(UnidadadminModel::class, 'identidades');
    }

    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'identidades');
    }
}

