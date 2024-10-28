<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstruccionvModel extends Model
{
         //
         protected $table = 'instruccion';

         protected $primaryKey= 'idinstruccion';

         public $timestamps = false;

         protected $fillable = [
             'nombreinstruccion'

         ];

         protected $guarded = [


         ];
}
