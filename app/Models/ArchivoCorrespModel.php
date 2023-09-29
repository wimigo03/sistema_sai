<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoCorrespModel extends Model
{
    protected $table = 'archivocorresp';

    protected $primaryKey= 'id_archivo';

    public $timestamps = false;

    protected $fillable = [

         ];

    protected $guarded = [


    ];
}
