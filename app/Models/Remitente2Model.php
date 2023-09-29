<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remitente2Model extends Model
{
    protected $table = 'remitente';

    protected $primaryKey= 'id_remitente';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [

    ];
}
