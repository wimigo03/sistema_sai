<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanastaAdminModel extends Model
{
    protected $connection = 'mysql_canasta';
    protected $table = 'admin';
    protected $primaryKey= 'idAdmin';
    protected $fillable = [
        'nombre',
        'ap',
        'am',
        'ci',
        'login',
        'pass',
        'estado',
        'idRol'
    ];

    public function getNombreCompletoAttribute(){
        $nombre_completo = strtoupper($this->nombre) . ' ' . strtoupper($this->ap) . ' ' . strtoupper($this->am);
        return $nombre_completo;
    }

    public function getNombreBrigadistaAttribute(){
        $nombre_completo = strtoupper($this->nombre) . ' ' . strtoupper($this->ap);
        return $nombre_completo;
    }
}
