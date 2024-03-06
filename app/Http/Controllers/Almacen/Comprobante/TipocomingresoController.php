<?php

namespace App\Http\Controllers\Almacen\Comprobante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Almacen\Comprobante\TipocomingresoModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\User;

class TipocomingresoController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
 
     return view('almacenes.tipocomingreso.index', ['idd' => $personalArea]);
  
    }
  
    public function listado()
    {
        $data = DB::table('tipocomingreso') 
        -> where('estado1','=', 1);
       // -> get();
  
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','almacenes.tipocomingreso.btn')
                ->rawColumns(['btn'])
                ->make(true);
  ;
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('almacenes.tipocomingreso.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $localidads = new TipocomingresoModel();
        $localidads ->codigocomin = $request->input('codigo');
        $localidads ->nombrecoming = $request->input('nombre');
    
        
        $localidads -> estado1 = 1;
        $localidads -> estado2 = 1;
      
        if($localidads->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('tipocomingreso.index');
    }
  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($idtipocomin)
    {
        $localidads = TipocomingresoModel::find($idtipocomin);
    
        return view('almacenes/tipocomingreso/edit')->with('localidads', $localidads);
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idtipocomin)
    {
        $localidads = TipocomingresoModel::find($idtipocomin);
        
        $localidads -> codigocomin = $request->input('codigo');
        $localidads -> nombrecoming = $request->input('nombre');
      
        //$medida->update();
        if($localidads->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->route('tipocomingreso.index');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
  }
