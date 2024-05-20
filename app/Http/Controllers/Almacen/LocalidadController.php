<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Almacen\LocalidadModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\User;
class LocalidadController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

     return view('almacenes.localidad.index', ['idd' => $personalArea]);

    }

    public function listado()
    {
        $data = DB::table('localidad')
        -> where('estadolocalidad','=', 1);
       // -> get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn','almacenes.localidad.btn')
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
        return view('almacenes.localidad.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $localidads = new LocalidadModel();
        $localidads ->codlocalidad = $request->input('codigo');
        $localidads ->nombrelocalidad = $request->input('nombre');
        $localidads ->distancialocalidad = $request->input('distancia');

        $localidads -> estadolocalidad = 1;


        if($localidads->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('localidad.index');
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
    public function editar($idlocalidad)
    {
        $localidads = LocalidadModel::find($idlocalidad);

        return view('almacenes/localidad/edit')->with('localidads', $localidads);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idlocalidad)
    {
        $localidads = LocalidadModel::find($idlocalidad);

        $localidads -> codlocalidad = $request->input('codigo');
        $localidads -> nombrelocalidad = $request->input('nombre');
        $localidads ->distancialocalidad = $request->input('distancia');
        //$medida->update();
        if($localidads->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('almacenes/localidad/index');
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

