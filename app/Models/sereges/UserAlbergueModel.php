<?php

namespace App\Models\sereges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAlbergueModel extends Model
{
    protected $table = 'user_albergue';

    protected $primaryKey= 'id';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];
}
