<?php

namespace App\Models\Model_Activos;

use App\Models\ActualModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionactivoModel extends Model
{
    use HasFactory;

    protected $table = 'ubicacion_activos';

    protected $fillable = [
        'latitude',
        'longitude',
        'activo_id',
        'user_id',
    ];

    public function activo()
    {
        return $this->belongsTo(ActualModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
