<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra\ProgramaCombModel;


use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;

class ProgramaCombController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('combustibles.programa.index', ['idd' => $personalArea]);
    }


    public function listado()
    {
        $data = DB::table('programacomb')
            ->where('estadoprograma', '=', 1);
       

        return DataTables::of($data)
            ->addIndexColumn()
        
            ->addIndexColumn()
            ->addColumn('btn', 'combustibles.programa.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        return view('combustibles.programa.create');
    }

    public function store(Request $request)
    {
        $programas = new ProgramaCombModel();
        $programas -> codigoprogr = $request->input('codigoprogr');
        $programas->nombreprograma = $request->input('nombre');
        $programas->direccion = $request->input('direccion');


        $programas->estadoprograma = 1;


        if ($programas->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('programa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

   
    public function edit($idprogramacomb)
    {
        $programas = ProgramaCombModel::find($idprogramacomb);

        return view('combustibles/programa/edit')->with('programas', $programas);
    }

    public function update(Request $request, $idprogramacomb)
    {
        $programas = ProgramaCombModel::find($idprogramacomb);
        $programas->nombreprograma = $request->input('nombre');
        $programas -> codigoprogr = $request->input('codigoprogr');
        $programas->direccion = $request->input('direccion');
        if ($programas->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('programa.index');
    }

   
    public function respuesta10(Request $request)    {
        $ot_antigua=$_POST['ot_antigua'];
            $data = "hola";
            $data2 = "holaSSSS";
            $validarci = DB::table('programacomb as s')
            ->select('s.codigoprogr')
           ->where('s.codigoprogr', $ot_antigua)
            ->get();
               if($validarci->count()>0){
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }

}

