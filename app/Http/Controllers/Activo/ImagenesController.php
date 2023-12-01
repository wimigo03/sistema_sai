<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\ImagenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;

class ImagenesController extends Controller
{
    public function index()
    {
        return view('activo.imagenes.index');
    }

    public function listado()
    {
        $data = DB::table('imagen')
            ->where('estadoimagen', '=', 1);

        return datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn', 'activo.imagenes.btn')
                ->rawColumns(['btn'])
                ->make(true);
    }

    public function create()
    {
        return view('activo.imagenes.create');
    }

    public function store(Request $request)
    {
        $imagen = $this->fillImagenModel($request);

        if ($imagen->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->route('activo.imagenes.index');
    }

    public function show($id)
    {
        //
    }

    public function editar($idimagen)
    {
        $imagen = ImagenModel::find($idimagen);
        return view('activo/imagenes/edit')->with('imagen', $imagen);
    }

    public function update(Request $request, $idimagen)
    {
        $imagen = ImagenModel::find($idimagen);
        $imagen = $this->fillImagenModel($request);

        if ($imagen->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->route('activo/imagenes/index')->with('imagen', $imagen);
    }

    public function destroy($id)
    {
        //
    }

    private function fillImagenModel(Request $request)
    {
        $imagen = new ImagenModel();
        $imagen->imagenactivos = $request->input('imagenactivos');
        $imagen->nombreimagen = $request->input('nombreimagen');
        $imagen->rutaimagen = $request->input('rutaimagen');
        $imagen->estadoimagen = 1;

        return $imagen;
    }
}
