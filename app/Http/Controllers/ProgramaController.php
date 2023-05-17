<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramaModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;



class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //index
    public function index()
    {

        return view('compras.programas.index');
    }


    public function listado()
    {
        $data = DB::table('programa')
            ->where('estadoprograma', '=', 1);
        //-> get();
        // return view('compras.medidas.index', ["medidas" => $medidas]);
        // return view('compras.programas.index',compact('programas'));

        return Datatables::of($data)
            ->addIndexColumn()
            //->addColumn('btn', function($row){
            // $btn = '<a href="'. route('programas.edit', $row->idprograma) .'" style="color:#017EBE;" class="fas fa-pencil-alt fa-lg" title="Editar"></a>';
            // return $btn;
            // })
            //->rawColumns(['btn'])
            //->make(true);
            ->addIndexColumn()
            ->addColumn('btn', 'compras.programas.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.programas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $programas = new ProgramaModel();
        $programas->nombreprograma = $request->input('nombre');


        $programas->estadoprograma = 1;


        if ($programas->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('programas.index');
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
    public function edit($idprograma)
    {
        $programas = ProgramaModel::find($idprograma);

        return view('compras/programas/edit')->with('programas', $programas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idprograma)
    {
        $programas = ProgramaModel::find($idprograma);
        $programas->nombreprograma = $request->input('nombre');

        //$medida->update();
        if ($programas->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect('compras/programas/index');
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
