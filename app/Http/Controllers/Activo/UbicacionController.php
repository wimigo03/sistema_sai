<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Activos\ubicacionactivoModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UbicacionController extends Controller
{
    public function index()
    {
        return view('activo.ubicacion.index');
    }

    public function listado()
    {
        $data = DB::table('ubicacionactivos')
            ->where('estadoubicacion', '=', 1);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.ubicacion.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        return view('activo.ubicacion.create');
    }

    public function store(Request $request)
    {
        $ubicacionactivos = new ubicacionactivoModel();
        $ubicacionactivos = $this->fillUbicacionactivoModel($request, $ubicacionactivos);

        if ($ubicacionactivos->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.ubicacion.index');
    }

    public function show($id)
    {
        //
    }

    public function editar($idubicacionactivos)
    {
        $ubicacionactivos = ubicacionactivoModel::find($idubicacionactivos);

        return view('activo/ubicacion/edit')->with('ubicacion', $idubicacionactivos);
    }

    public function update(Request $request, $idubicacionactivos)
    {
        $ubicacionactivos = ubicacionactivoModel::find($idubicacionactivos);
        $ubicacionactivos = $this->fillUbicacionactivoModel($request, $ubicacionactivos);

        if ($ubicacionactivos->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo/ubicacion/index')->with('ubicacion', $ubicacionactivos);
    }

    public function destroy($id)
    {
        //
    }

    private function fillUbicacionactivoModel(Request $request, ubicacionactivoModel $ubicacionactivos)
    {
        $ubicacionactivos->ubicacionactivo = $request->input('ubicacionactivo');
        $ubicacionactivos->estadoubicacion = 1;

        // Agrega aquí cualquier otro campo que necesites asignar al modelo

        return $ubicacionactivos;
    }
}
