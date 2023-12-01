<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodcontModel extends Model
{
    use HasFactory;

    protected $table = 'codcont';
    protected $primaryKey = 'idcodcont';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
    
        'codcont',
        'nombre',
        'vidautil',
        'observ',
        'depreciar',
        'actualizar',
        'feult',
        'usuar',
        'estadocodcont',
    ];

    // Relaciones con otros modelos
    public function auxiliar()
    {
        return $this->belongsTo(Auxiliar::class, 'idcodcont');
    }
    public function actuals()
    {
        return $this->hasMany(ActualModel::class, 'codcont', 'codcont');
    }
    
}


