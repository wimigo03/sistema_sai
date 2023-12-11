<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\EntidadesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EntidadController extends Controller
{
    public function index()
    {
        return view('activo.entidad.index');
    }

    public function listado()
    {
        $data = DB::table('entidades');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.entidad.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        return view('activo.entidad.create');
    }

    public function store(Request $request)
    {
        try {
            $entidades = new EntidadesModel();
            $this->fillEntidadesModel($entidades, $request);
            $entidades->estadoentidades = 1;
            if ($entidades->save()) {
                return redirect()->route('activo.entidad.index')
                    ->with('success', '  creado exitosamente');
            }
        } catch (\Exception $e) {
            // Catch any exception that may occur and return an error message
            return redirect()->back()
                ->with('error', 'No se pudo crear el reporte: ' . $e->getMessage());
        }
    }

    public function editar($identidades)
    {
        $entidades = EntidadesModel::find($identidades);

        return view('activo.entidad.edit')->with('entidades', $entidades);
    }

    public function update(Request $request, $identidades)
    {
        $entidades = EntidadesModel::find($identidades);
        $this->fillEntidadesModel($entidades, $request);
        $entidades->estadoentidades = 1;

        if ($entidades->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo.entidad.index')->with('entidades', $entidades);
    }

    public function destroy($id)
    {
        // Implementa la lógica para eliminar un registro de la base de datos
    }

    private function fillEntidadesModel(EntidadesModel $entidades, Request $request)
    {
        $entidades->gestion = $request->input('gestion');
        $entidades->entidad = $request->input('entidad');
        $entidades->desc_ent = $request->input('desc_ent');
        $entidades->sigla_ent = $request->input('sigla_ent');
        $entidades->sector_ent = $request->input('sector_ent');
        $entidades->subsec_ent = $request->input('subsector_ent');
        $entidades->area_ent = $request->input('area_ent');
        $entidades->subareaent = $request->input('subarea_ent');
        $entidades->nivel_inst = $request->input('nivel_inst');
    }
}
