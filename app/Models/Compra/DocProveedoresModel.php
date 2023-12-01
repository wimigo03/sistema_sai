<?php

namespace App\Models\Compra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocProveedoresModel extends Model
{
    protected $table = 'docproveedores';
    
    protected $primaryKey= 'iddocproveedores';

    public $timestamps = false;

    protected $fillable = [
        'documento',
        'idproveedor',
        'estadodocproveedores'
    ];

    protected $guarded = [

        
    ];
}
