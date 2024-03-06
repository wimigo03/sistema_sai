<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transporte\MarcaMovilidadModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use Illuminate\Support\Facades\Auth;

class MarcaMovilidadController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
   
     return view('transportes.marca.index', ['idd' => $personalArea]);
  
    }
  
    public function listado()
    {
        $data = DB::table('marcamovilidad'); 

        // -> where('estadomovilidad','=', 1);
        $data =$data-> get();
  
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nombremarca', function ($data) {
                    return $data->nombremarca;
                })
                
                ->addColumn('estadomarca', function ($data) {

                    switch ($data->estadomarca ) {
                       
                            case '1':
                            return '<b style="color: green">ACTIVO</b>';
                        case '2':
                            return '<b style="color: red">INACTIVO</b>';
                       
                        default:
                        
                            break;
                        }   
                    }   

                    )
                    ->addColumn('actions', function ($data) {

                        return '<a class="tts:left tts-slideIn tts-custom" aria-label=" Editar" href="' . route('marca.edit', $data->idmarcamovilidad) . '">
                        <button class="btn btn-sm btn-primary font-verdana" type="button">
                            <i class="fa fa-pencil fa-fw"></i>
                        </button>
                    </a>';
        })

                      
                    ->rawColumns(['actions', 'estadomarca'])
                    ->make(true);

                }
    
  
 
    public function create()
    {
        return view('transportes.marca.create');
    }
  
    public function store(Request $request)
    {
        $tipomovilidads = new MarcaMovilidadModel();

        $tipomovilidads ->nombremarca = $request->input('marca');
        // $tipomovilidads ->descripcionmovilidad = $request->input('descripcionmo');
        
        $tipomovilidads -> estadomarca = 1;
      
      
        if($tipomovilidads->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
         
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
           
        }
        return redirect()->route('marca.index');
    }
  
   
    public function show($id)
    {
        //
    }
  
  
    public function editar($idmarcamovilidad)
    {
        $tipomovilidads = MarcaMovilidadModel::find($idmarcamovilidad);
    
        return view('transportes/marca/edit')->with('tipomovilidads', $tipomovilidads);
    }
  
   
    public function update(Request $request, $idmarcamovilidad)
    {
        $tipomovilidads = MarcaMovilidadModel::find($idmarcamovilidad);
        
        $tipomovilidads -> nombremarca = $request->input('marca');
        $tipomovilidads -> estadomarca = $request->input('estadomarca');
        // $tipomovilidads ->descripcionmovilidad = $request->input('descripcionmo');
        //$medida->update();
        if($tipomovilidads->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->route('marca.index');;
    }
  
   
    public function destroy($id)
    {
        //
    }
  }
