<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\Compra\PartidaCombModel;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use DB;
use DataTables;

use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;

class PartidaCombController extends Controller
{
    //
    public function index()
    
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


     return view('combustibles.partida.index',['idd' => $personalArea]);

    }


public function listado()
  
    {  
 
         $data = DB::table('partidacomb');
        
         return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
   }


}
