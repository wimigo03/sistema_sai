<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transporte\TipomovilidadModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;

use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use Illuminate\Support\Facades\Auth;

class TipoMovilidadController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
   
     return view('transportes.tipo.index', ['idd' => $personalArea]);
  
    }
  
    public function listado()
    {
        $data = DB::table('tipomovilidad') 
        -> where('estadomovilidad','=', 1);
       // -> get();
  
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','transportes.tipo.btn')
                ->rawColumns(['btn'])
                ->make(true);
  
    }
  
 
    public function create()
    {
        return view('transportes.tipo.create');
    }
  
    public function store(Request $request)
    {
        $tipomovilidads = new TipomovilidadModel();

        $tipomovilidads ->nombremovilidad = $request->input('nombremo');
        $tipomovilidads ->descripcionmovilidad = $request->input('descripcionmo');
        
        $tipomovilidads -> estadomovilidad = 1;
      
      
        if($tipomovilidads->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
         
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
           
        }
        return redirect()->route('tipo.index');
    }
  
   
    public function show($id)
    {
        //
    }
  
  
    public function editar($idtipomovilidad)
    {
        $tipomovilidads = TipomovilidadModel::find($idtipomovilidad);
    
        return view('transportes/tipo/edit')->with('tipomovilidads', $tipomovilidads);
    }
  
   
    public function update(Request $request, $idtipomovilidad)
    {
        $tipomovilidads = TipomovilidadModel::find($idtipomovilidad);
        
        $tipomovilidads -> nombremovilidad = $request->input('nombremo');
        $tipomovilidads ->descripcionmovilidad = $request->input('descripcionmo');
        //$medida->update();
        if($tipomovilidads->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('transportes/tipo/index');
    }
  
   
    public function destroy($id)
    {
        //
    }
  }

