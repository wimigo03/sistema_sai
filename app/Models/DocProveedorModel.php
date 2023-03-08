<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocProveedorModel extends Model
{
    protected $table = 'docproveedor';
    
    protected $primaryKey= 'iddocproveedor';

    public $timestamps = false;

    protected $fillable = [
        'documento',
        'idproveedor',
        'estadodocproveedor'
    ];

    protected $guarded = [

        
    ];
}
