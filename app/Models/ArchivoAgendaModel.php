<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoAgendaModel extends Model
{
    protected $table = 'archivoagenda';

    protected $primaryKey= 'id_archivo';

    public $timestamps = false;

    protected $fillable = [

         ];

    protected $guarded = [


    ];
}
