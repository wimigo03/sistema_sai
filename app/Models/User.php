<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'idemp',
        'estadouser',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function role(){
        return $this->belongsTo(Role::class);
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

    public function usuariosEmpleados()
    {
       // return $this->belongsTo('App\Models\EmpleadosModel', 'id', 'idemp');
       // return $this->belongsTo(Profession::class, 'profession_name', 'name');
       //return $this->hasMany('App\Models\EmpleadosModel', 'id');
       //return $this->belongsTo(User::class,'id','idusuario');
       return $this->belongsTo(EmpleadosModel::class, 'idemp', 'idemp');
    }
}
