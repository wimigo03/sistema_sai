<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\UfvModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UfvController extends Controller
{
    public function index()
    {
        return view('activo.ufv.index');
    }

    public function listado()
    {
        $data = DB::table('ufv')->where('estadoufv', 1)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.ufv.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        return view('activo.ufv.create');
    }

    public function store(Request $request)
    {
        $ufv = new UfvModel();
        $this->fillUfvModel($ufv, $request);
        $ufv->estadoufv = 1;

        if ($ufv->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.ufv.index');
    }

    public function editar($idufv)
    {
        $ufv = UfvModel::find($idufv);

        return view('activo.ufv.edit')->with('ufv', $ufv);
    }

    public function update(Request $request, $idufv)
    {
        $ufv = UfvModel::find($idufv);
        $this->fillUfvModel($ufv, $request);
        $ufv->estadoufv = 1;

        if ($ufv->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return view('activo.ufv.index')->with('ufv', $ufv);
    }

    public function destroy($id)
    {
        // Implementa la lógica para eliminar un registro de la base de datos
    }

    private function fillUfvModel(UfvModel $ufv, Request $request)
    {
        $ufv->dia = $request->input('dia');
        $ufv->mes = $request->input('mes');
        $ufv->ano = $request->input('ano');
    }
}
