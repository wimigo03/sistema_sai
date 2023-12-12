<?php

namespace App\Models\Personerias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoPersoneriaModel extends Model
{
    protected $table = 'archivopersoneria';

    protected $primaryKey= 'idarchivopers';

    public $timestamps =false;

    protected $fillable = [


    ];

    protected $guarded = [


    ];
}
