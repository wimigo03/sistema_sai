<?php

namespace App\Models\Model_Activos;

use App\Models\ActualModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganismofinModel extends Model
{
    protected $table = 'organismo_fin';

    protected $primaryKey = 'idorganismofin';

    public $timestamps = false;

    protected $fillable = [

        'gestion',
        'of',
        'des',
        'sigla',
        'estadoorganismo',
    ];
    // public function actuals()
    // {
    //     return $this->h(ActualModel::class, 'idorganismofin');
    // }

    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'idorganismofin');
    }
}
