<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartidaModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;


class PartidaController extends Controller
{
  
    public function index()
    
        {
        
         return view('compras.partida.index');

        }


    public function listado()
      
        {  
     
             $data = DB::table('partida');
            
             return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
       }


}