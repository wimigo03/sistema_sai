<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    
    protected $table = 'purchases';
    
    protected $primaryKey= 'id';

    public $timestamps = false;

    protected $fillable = [
        'bank_acc_number',
        'customer_id',
        'company',
        'created_at',
        'update_at'
    ];

    protected $guarded = [

        
    ];
}
