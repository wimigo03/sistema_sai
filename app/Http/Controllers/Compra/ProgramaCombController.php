<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra\ProgramaCombModel;


use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Yajra\DataTables\DataTables;

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
       

        return Datatables::of($data)
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
        $programas->nombreprograma = $request->input('nombre');
        $programas -> codigoprogr = $request->input('codigoprogr');


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

        if ($programas->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect('combustibles/programa/index');
    }

   
}

