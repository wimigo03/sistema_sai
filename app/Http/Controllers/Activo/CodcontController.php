<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\CodcontModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CodcontController extends Controller
{
    public function index()
    {
        return view('activo.codcont.index');
    }

    public function listado()
    {
        $data = DB::table('codcont')
        ->orderBy('codcont');

        return DataTables::of($data)
            ->addColumn('btn', 'activo.codcont.btn')
            ->addColumn('btn2', 'activo.codcont.btn2')
            ->rawColumns(['btn','btn2'])
            ->make(true);
    }

    public function create()
    {
        $codigo = CodcontModel::max('codcont');
         
        $newcodigo =  $codigo +1;
        return view('activo.codcont.create',compact('newcodigo','codigo'));
    }

    public function store(Request $request)
    {
        $codcont = new CodcontModel();
        $this->fillCodcontModel($codcont, $request);
        $codcont->estadocodcont = 1;

        if ($codcont->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.codcont.index');
    }

    public function editar($idcodcont)
    {
        $codcont = CodcontModel::find($idcodcont);

        return view('activo.codcont.edit')->with('codcont', $codcont);
    }

    

    public function update(Request $request, $idcodcont)
    {
        $codcont = CodcontModel::find($idcodcont);
        $this->fillCodcontModel($codcont, $request);
        $codcont->estadocodcont = 1;

        if ($codcont->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo.codcont.index')->with('codcont', $codcont);
    }

    public function destroy($id)
    {
        // Implementa la lógica para eliminar un registro de la base de datos
    }

    private function fillCodcontModel(CodcontModel $codcont, Request $request)
    {
        $codcont->codcont = $request->input('codcont');
        $codcont->nombre = $request->input('nombre');
        $codcont->vidautil = $request->input('vidautil');
        $codcont->observ = $request->input('observ');
        $codcont->depreciar = $request->input('depreciar');
        $codcont->actualizar = $request->input('actualizar');
        $codcont->feult = $request->input('feult');
        $codcont->usuar = $request->input('usuar');
    }
}
