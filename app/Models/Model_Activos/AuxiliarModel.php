<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\CodcontModel;
use App\Models\Model_Activos\UnidadadminModel;

class AuxiliarModel extends Model
{
    use HasFactory;

    protected $table = 'auxiliar';
    protected $primaryKey = 'idauxiliar';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'entidad',
        'unidad',
        'codcont',
        'codaux',
        'observ',
        'feult',
        'usuar',
        'estadoauxiliar',
    ];

    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'idauxiliar');
    }
 
    public function codcont()
    {
        return $this->belongsTo(CodcontModel::class, 'idcodcont');
    }
    public function unidadadmin()
    {
        return $this->belongsTo(UnidadadminModel::class, 'idunidadadmin');
    }
}
