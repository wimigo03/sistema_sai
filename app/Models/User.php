<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Canasta\Dea;
use App\Models\AreasModel;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'idarea',
        'dea_id',
        'name',
        'email',
        'password',
        'idemp',
        'estadouser'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($input){
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function area()
    {
        return $this->belongsTo(AreasModel::class,'idarea','idarea');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('title', $role)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles','id_user','id_role');
    }

    /*public function permissions(){
        return $this->belongsToMany('App\Models\Permission', 'role_permissions',  'role_id', 'permission_id');
    }*/

    public function usuariosEmpleados(){
       return $this->belongsTo(EmpleadosModel::class, 'idemp', 'idemp');
    }

    public function dea(){
        return $this->belongsTo(Dea::class, 'dea_id', 'id');
     }

    public function getNombreCompletoAttribute(){
        if($this->idemp != null){
            $empleado = EmpleadosModel::where('idemp',$this->idemp)->first();
            if($empleado != null){
                $nombre_completo = $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat;
                return $nombre_completo;
            }
        }
    }

    public function getIconoEstadoAttribute() {
        $status_icono = ['badge-with-padding badge badge-secondary','badge-with-padding badge badge-success'];
        return $status_icono[$this->estadouser];
    }

    public function getStatusAttribute() {
        $status = ['NO HABILITADO','HABILITADO'];
        return $status[$this->estadouser];
    }

    public function scopeByNombre($query, $nombre){
        if ($nombre) {
                return $query
                    ->whereIn('idemp', function ($subquery) use($nombre) {
                        $subquery->select('idemp')
                            ->from('empleados')
                            ->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);
                    });
        }
    }

    public function scopeByApPaterno($query, $ap_pat){
        if ($ap_pat) {
                return $query
                    ->whereIn('idemp', function ($subquery) use($ap_pat) {
                        $subquery->select('idemp')
                            ->from('empleados')
                            ->whereRaw('upper(ap_pat) like ?', ['%'.strtoupper($ap_pat).'%']);
                    });
        }
    }

    public function scopeByApMaterno($query, $ap_mat){
        if ($ap_mat) {
                return $query
                    ->whereIn('idemp', function ($subquery) use($ap_mat) {
                        $subquery->select('idemp')
                            ->from('empleados')
                            ->whereRaw('upper(ap_mat) like ?', ['%'.strtoupper($ap_mat).'%']);
                    });
        }
    }

    public function scopeByUsername($query, $username){
        if($username != null){
            return $query->whereRaw('upper(name) like ?', ['%'.strtoupper($username).'%']);
        }
    }

    public function scopeByEmail($query, $email){
        if($email != null){
            return $query->whereRaw('upper(email) like ?', ['%'.strtoupper($email).'%']);
        }
    }

    public function scopeByRole($query, $role){
        if ($role) {
                return $query
                    ->whereIn('role_id', function ($subquery) use($role) {
                        $subquery->select('id')
                            ->from('roles')
                            ->where('title',$role);
                    });
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('estadouser',$estado);
        }
    }
}
