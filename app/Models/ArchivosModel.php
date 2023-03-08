<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivosModel extends Model
{
    protected $table = 'archivos';

    protected $primaryKey= 'idarchivo';

    public $timestamps = true;

    protected $fillable = [

        'nombrearchivo',
        'documento',
        'estado1',
        'idtipo',
        'referencia',
        'idarea'
    ];

    protected $guarded = [


    ];
}
