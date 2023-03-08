<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedidaModel extends Model
{
               //
               protected $table = 'umedida';
    
               protected $primaryKey= 'idumedida';
           
               public $timestamps = false;
           
               protected $fillable = [
                   'nombreumedida',
                   'estadoumedida'
               ];
           
               protected $guarded = [
           
                   
               ];
}