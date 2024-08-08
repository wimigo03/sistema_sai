<?php

namespace App\Models\CanastaDisc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialBaja extends Model
{
    protected $table = 'historialbaja';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'observacion',
        'id_beneficiario',
        'user_id',
        'dea_id',
        'created_at',
        'updated_at',
    ];
}
