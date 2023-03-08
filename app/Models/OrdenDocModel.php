<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDocModel extends Model
{
    protected $table = 'ordendoc';
    
    protected $primaryKey= 'idordendoc';

    public $timestamps = false;

    protected $fillable = [
        'iddoc',
        'idorden'
    ];

    protected $guarded = [

        
    ];
}