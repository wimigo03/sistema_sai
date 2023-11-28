<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorModel extends Model
{
    use HasFactory;
    protected $table = 'proveedor';

    protected $primaryKey= 'idproveedor';

    public $timestamps = false;

    protected $fillable = [
        'nombreproveedor',
        'representanteproveedor',
        'cedulaproveedor',
        'nitciproveedor',
        'telefonoproveedor',
        'validezciproveedor',
        'estadoproveedor'
    ];

    protected $guarded = [


    ];

}
