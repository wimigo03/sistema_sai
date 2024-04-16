<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\NivelModel;
use App\Models\PersonalFace;


class FacePubli extends Model
{
    protected $table = 'facePubli';
    protected $primaryKey= 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_empleado',
        'id_area',
        'compartido',
        'megusta',
        'like',
        'id_facebook',
        'id_nivel'
    ];

    public function empleado(){
        return $this->belongsTo(PersonalFace::class,'id_empleado','id');
    }

    public function area(){
        return $this->belongsTo(AreasModel::class,'id_area','idarea');
    }

    public function nivel(){
        return $this->belongsTo(NivelModel::class,'id_nivel','idnivel');
    }


    public function scopeByNombre($query, $nombre){
        if ($nombre) {
                return $query
                    ->whereIn('id_empleado', function ($subquery) use($nombre) {
                        $subquery->select('id')
                            ->from('personalface')
                            ->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);
                    });
        }
    }
    public function scopeByAp($query, $ap){
        if ($ap) {
                return $query
                    ->whereIn('id_empleado', function ($subquery) use($ap) {
                        $subquery->select('id')
                            ->from('personalface')
                            ->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);
                    });
        }
    }
    public function scopeByAm($query, $am){
        if ($am) {
                return $query
                    ->whereIn('id_empleado', function ($subquery) use($am) {
                        $subquery->select('id')
                            ->from('personalface')
                            ->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);
                    });
        }
    }

    public function scopeByArea($query, $area){
        if ($area) {
                return $query
                    ->whereIn('id_area', function ($subquery) use($area) {
                        $subquery->select('idarea')
                            ->from('areas')
                            ->whereRaw('upper(nombrearea) like ?', ['%'.strtoupper($area).'%']);
                    });
        }
    }

    public function scopeByNivel($query, $nivell){
        if ($nivell) {
                return $query
                    ->whereIn('id_nivel', function ($subquery) use($nivell) {
                        $subquery->select('idnivel')
                            ->from('niveles')
                            ->whereRaw('upper(nombrenivel) like ?', ['%'.strtoupper($nivell).'%']);
                    });
        }
    }
}
