<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolesModel extends Model
{
    protected $table = 'user_roles';
    protected $fillable = [
        'id_user',
        'id_role'
    ];

    public $timestamps = false;
}
