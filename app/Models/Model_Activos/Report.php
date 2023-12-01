<?php

namespace App\Models\Model_Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';
    protected $primaryKey = 'idreport';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        
        'contenido',
        'notas',
        'cb1',
        'cb2',
        'cb3',
        'cb4',
        'cb5',
        'cb6',
        'cb7',
        'cb8',
        'cb9',
        'cb10',
        'cb11',
        'cb12',
        'cb13',
        'cb14',
        'cb15',
        'cb16',
        'cb17',
        'cb18',
        'cb19',
        'cb20',
        'cb21',
        'cb22',
        'cb23',
        'cb24',
        'cb25',
        'cb27',
        'cb28',
        'estadoreport'
    ];

    // Relaciones con otros modelos
    public function codcont()
    {
        return $this->belongsTo(Codcont::class);
    }

    public function entidad()
    {
        return $this->belongsTo(Entidades::class);
    }

    public function unidad_admin()
    {
        return $this->belongsTo(UnidadAdmin::class);
    }

    public function resp()
    {
        return $this->belongsTo(Resp::class);
    }
}

