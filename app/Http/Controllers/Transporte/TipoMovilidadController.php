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
        $data = DB::table('tipomovilidad'); 

        // -> where('estadomovilidad','=', 1);
        $data =$data-> get();
  
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nombremovilidad', function ($data) {
                    return $data->nombremovilidad;
                })
                
                ->addColumn('estadomovilidad', function ($data) {

                    switch ($data->estadomovilidad ) {
                       
                            case '1':
                            return '<b style="color: blue">ACTIVO</b>';
                        case '2':
                            return '<b style="color: purple">INACTIVO</b>';
                       
                        default:
                        
                            break;
                        }   
                    }   

                    )
                    ->addColumn('actions', function ($data) {

                        return '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar" href="' . route('tipo.edit', $data->idtipomovilidad) . '">
                        <button class="btn btn-sm btn-primary font-verdana" type="button">
                            <i class="fa fa-pencil fa-fw"></i>
                        </button>
                    </a>';
        })

                      
                    ->rawColumns(['actions', 'estadomovilidad'])
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
        // $tipomovilidads ->descripcionmovilidad = $request->input('descripcionmo');
        
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
        $tipomovilidads -> estadomovilidad = $request->input('estadomovilidad');
        // $tipomovilidads ->descripcionmovilidad = $request->input('descripcionmo');
        //$medida->update();
        if($tipomovilidads->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->route('tipo.index');;
    }
  
   
    public function destroy($id)
    {
        //
    }
  }

