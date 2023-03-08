<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedoresModel extends Model
{
    protected $table = 'proveedores';

    protected $primaryKey= 'idproveedor';

    public $timestamps = false;

    protected $fillable = [
        'nombreproveedor',
        'representante',
        'cedula',
        'nitci',
        'telefonoproveedor',
        'validezci',
        'estadoproveedor'
    ];

    protected $guarded = [


    ];

}
