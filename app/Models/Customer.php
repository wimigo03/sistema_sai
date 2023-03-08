<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
              //
              protected $table = 'customers';
    
              protected $primaryKey= 'id';
          
              public $timestamps = false;
          
              protected $fillable = [
                  'first_name',
                  'last_name',
                  'email',
                  'created_at',
                  'update_at'
              ];
          
              protected $guarded = [
          
                  
              ];



              public function purchases()
    {
        return $this->hasMany('App\Models\Purchase', 'customer_id', 'id');
    }
}
