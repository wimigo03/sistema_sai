<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\Compra\PartidaCombModel;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;
class PartidaCombController extends Controller
{
    //
    public function index()
    
    {
    
     return view('combustibles.partida.index');

    }


public function listado()
  
    {  
 
         $data = DB::table('partidacomb');
        
         return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
   }


}
