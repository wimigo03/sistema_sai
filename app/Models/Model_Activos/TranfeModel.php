<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranfeModel extends Model
{
    use HasFactory;

    protected $table = 'tranfe';
    protected $primaryKey = 'idtranfe';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
    
        'entidad',
        'unidad',
        'codigo',
        'codofic',
        'codresp',
        'feult',
        'usuar',
        'unidadini',
        'estadotranferencia',
    ];

    
    
}