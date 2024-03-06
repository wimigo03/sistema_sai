<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\Compra\PartidaCombModel;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

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
        
         return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('btn', 'combustibles.partida.btn')
                ->rawColumns(['btn'])
                ->make(true);
   }

   public function create()
   {
       return view('combustibles.partida.create');
   }

   public function store(Request $request)
   {
       $programas = new PartidaCombModel();
       $programas -> codigopartida = $request->input('codigopartida');
       $programas->nombrepartida = $request->input('nombre');
       $programas->detallepartida = $request->input('direccion');

       $programas->estadopartida = 1;


       if ($programas->save()) {
           $request->session()->flash('message', 'Registro Procesado Exitosamente');
           //echo 'Cliente salvo com sucesso';
       } else {
           $request->session()->flash('message', 'Error al procesar el registro');
           //echo 'Houve um erro ao salvar';
       }
       return redirect()->route('partidacomb.index');
   }

   public function edit($idpartidacomb)
   {
       $programas = PartidaCombModel::find($idpartidacomb);

       return view('combustibles/partida/edit')->with('programas', $programas);
   }

   public function update(Request $request, $idpartidacomb)
   {
       $programas = PartidaCombModel::find($idpartidacomb);
       $programas -> codigopartida = $request->input('codigopartida');
       $programas->nombrepartida = $request->input('nombre');
       $programas->detallepartida = $request->input('direccion');

       if ($programas->save()) {
           $request->session()->flash('message', 'Registro Procesado');
       } else {
           $request->session()->flash('message', 'Error al Procesar Registro');
       }
       return redirect()->route('partidacomb.index');
   }


   public function respuesta11(Request $request)    {
    $ot_antigua=$_POST['ot_antigua'];
        $data = "hola";
        $data2 = "holaSSSS";
        $validarci = DB::table('partidacomb as s')
        ->select('s.codigopartida')
       ->where('s.codigopartida', $ot_antigua)
        ->get();
           if($validarci->count()>0){
        return ['success' => true, 'data' => $data];
    } else  return ['success' => false, 'data' => $data2];
}

}
