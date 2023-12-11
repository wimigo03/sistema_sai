<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\OrganismofinModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrganismofinController extends Controller
{
    public function index()
    {
        return view('activo.organismo.index');
    }

    public function listado()
    {
        $data = DB::table('organismofin')->where('estadoorganismo', 1)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.organismo.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        return view('activo.organismo.create');
    }

    public function store(Request $request)
    {
        $organismofin = new OrganismofinModel();
        $this->fillOrganismofinModel($organismofin, $request);
        $organismofin->estadoorganismo = 1;

        if ($organismofin->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.organismo.index');
    }

    public function editar($idorganismo)
    {
        $organismofin = OrganismofinModel::find($idorganismo);

        return view('activo.organismo.edit')->with('organismofin', $organismofin);
    }

    public function update(Request $request, $idorganismo)
    {
        $organismofin = OrganismofinModel::find($idorganismo);
        $this->fillOrganismofinModel($organismofin, $request);
        $organismofin->estadoorganismo = 1;

        if ($organismofin->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo.organismo.index')->with('organismofin', $organismofin);
    }

    public function destroy($id)
    {
        // Implementa la lógica para eliminar un registro de la base de datos
    }

    private function fillOrganismofinModel(OrganismofinModel $organismofin, Request $request)
    {
        $organismofin->gestion = $request->input('gestion');
        $organismofin->of = $request->input('of');
        $organismofin->sigla = $request->input('sigla');
    }
}

