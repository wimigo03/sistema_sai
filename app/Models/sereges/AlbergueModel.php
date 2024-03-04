<?php

namespace App\Models\sereges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbergueModel extends Model
{
    protected $table = 'albergue';

    protected $primaryKey= 'id';

    public $timestamps = false;

    protected $fillable = [

    ];

    protected $guarded = [


    ];

    public function dea(){
        return $this->belongsTo('App\Models\Canasta\Dea','dea_id','id');
    }
}
