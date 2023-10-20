<?php

namespace App\Models\Fexpo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubroModel extends Model
{
    protected $table = 'rubro';

    protected $primaryKey= 'idrubro';

    public $timestamps = false;

    protected $fillable = [
        'nombrerubro'
    ];

    protected $guarded = [


    ];
}
