<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Compra\MedidaCombModel;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;

class MedidaCombController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('combustibles.medida.index', ['idd' => $personalArea]);
    }

  public function list(Request $request)
    {

           if ($request->ajax()) {
           $data = DB::table('umedidacomb as p')
          
           ->select('p.idmedida','p.nombremedida')
           ->orderBy('p.idmedida', 'desc');

        return Datatables::of($data)
       ->addIndexColumn()
       ->addColumn('btn', 'combustibles.medida.btn')

       ->rawColumns(['btn'])
       ->make(true);
    }
    }

   
    public function create()
    {
        return view('combustibles.medida.create');
    }

   
    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $productos = new MedidaCombModel();
      
        $productos -> nombremedida = $request->input('nombremedida');
        
        $productos -> estadomedidacomb = 1;
        $productos ->idusuario =$id;
        $productos ->idarea =$personalArea->idarea;

        if($productos->save()){
            $request->session()->flash('message', 'Registro Procesado');
        }else{
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

    
        return redirect()->route('medidacomb.index');

    }

    public function show($id)
    {
        //
    }

    
    public function editar($idmedida){
        $productos = MedidaCombModel::find($idmedida);
       
        return view('combustibles.medida.edit', ["productos" => $productos]);
    }


    public function update(Request $request, $idmedida){

        
        $productos = MedidaCombModel::find($idmedida);

       
        $productos -> nombremedida = $request->input('nombremedida');
          

        if($productos->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->route('medidacomb.index');
    }

}

