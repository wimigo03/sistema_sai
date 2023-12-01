<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OficinaModel extends Model
{
    use HasFactory;

    protected $table = 'oficina';
    protected $primaryKey = 'idoficina';
    public $timestamps = true;

    protected $fillable = [
        
        'entidad',
        'unidad',
        'codofic',
        'nomofic',
        'observ',
        'feult',
        'usuar',
        'api_estado',
    ];
}
