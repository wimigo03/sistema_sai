<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanastaOcupacionModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'ocupaciones';
    protected $primaryKey= 'id_ocupacion';

    protected $fillable = [
        'ocupacion',
        'estado'
    ];

    const ESTADOS = [
        'A' => 'A'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "A";
        }
    }
}
