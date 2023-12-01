<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\EntidadesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UnidadAdminController extends Controller
{
    public function index()
    {
        $entidad = EntidadesModel::where('entidad', '=', 4601)->first();
        return view('activo.unidadadmin.index', compact('entidad'));
    }

    public function listado()
    {
        $data = DB::table('unidadadmin')->orderBy('idunidadadmin');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.unidadadmin.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        $entidades = EntidadesModel::all();
        return view('activo.unidadadmin.create', compact('entidades'));
    }

    public function store(Request $request)
    {
        $unidadadmin = new UnidadadminModel();
        $this->fillUnidadadminModel($unidadadmin, $request);
        $unidadadmin->estadounidadadmin = 1;
        $unidadadmin->entidad = $request->input('entidad');

        if ($unidadadmin->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.unidadadmin.index');
    }

    public function editar($idunidadadmin)
    {
        $unidadadmin = UnidadadminModel::with('entidades')->find($idunidadadmin);
        $entidades = EntidadesModel::all();

        return view('activo.unidadadmin.edit', compact('unidadadmin', 'entidades'));
    }

    public function update(Request $request, $idunidadadmin)
    {
        $unidadadmin = UnidadadminModel::find($idunidadadmin);
        $this->fillUnidadadminModel($unidadadmin, $request);
        $unidadadmin->estadounidadadmin = 1;

        if ($unidadadmin->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo.unidadadmin.index')->with('unidadadmin', $unidadadmin);
    }

    public function estado($id)
    {
        UnidadadminModel::where('estadouni', 1)->update(['estadouni' => 0]);
        UnidadadminModel::where('idunidadadmin', $id)->update(['estadouni' => 1]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        // Implementa la lógica para eliminar un registro de la base de datos
    }

    private function fillUnidadadminModel(UnidadadminModel $unidadadmin, Request $request)
    {
        $unidadadmin->entidad = $request->input('entidad');
        $unidadadmin->unidad = $request->input('unidad');
        $unidadadmin->descrip = $request->input('descrip');
        $unidadadmin->ciudad = $request->input('ciudad');
    }
}
