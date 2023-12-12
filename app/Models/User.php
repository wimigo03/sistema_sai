<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Canasta\Dea;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'idemp',
        'estadouser',
        'dea_id'
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

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

    static function boot(){
        parent::boot();

        static::created(function(Model $model){
            if($model->role_id == ""){
                $model->update([
                    'role_id' => Role::where('title','user')->first()->id,
                ]);
            }
        });

    }

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
        $status_icono = ['badge-secondary','badge-success'];
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
