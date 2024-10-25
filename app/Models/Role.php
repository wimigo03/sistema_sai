<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Canasta\Dea;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_code',
        'estado',
        'dea_id'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    public function dea()
    {
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function permissions(){
        return $this->belongsToMany('App\Models\Permission', 'role_permissions',  'role_id', 'permission_id');
    }


    public function roleusers(){
        return $this->belongsToMany('App\Models\Permission', 'user_roles',  'id_role', 'id');
    }




    static function boot(){
        parent::boot();
        static::deleting(function (Model $model){
           User::where('role_id', $model->id)->update(['role_id' => null]);
        });
    }

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "NO HABILITADO";
        }
    }

    public function scopeByCodigoId($query, $codigo_id){
        if($codigo_id){
            return $query->where('id', $codigo_id);
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('dea_id',$dea_id);
        }
    }

    public function scopeByTitulo($query, $titulo){
        if($titulo){
            return $query->whereRaw('upper(title) like ?', ['%'.strtoupper($titulo).'%']);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->whereRaw('upper(short_code) like ?', ['%'.strtoupper($codigo).'%']);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado',$estado);
        }
    }
}
