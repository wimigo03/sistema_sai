<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\NivelModel;
use App\Models\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;

class AreasController extends Controller
{
    public function index()
    {
        return view('compras.areas.index');
    }

    public function listado(Request $request)
    {
        $data = DB::table('areas')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('btn', 'compras.areas.btn')
            //->addColumn('btn2','compras.areas.btn2')
            //->addColumn('btn3','compras.areas.btn3')
            //->rawColumns(['btn','btn2','btn3'])
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function create()
    {
        $area = Area::where('estadoarea', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();
        return view('compras.areas.create', ["niveles" => $niveles, "area" => $area]);
    }

    public function crearFile($idArea)
    {
        $idarea = $idArea;
        $area = Area::find($idarea);
        return view('compras.areas.crearFile', compact('idarea', 'area'));
    }

    public function crearFile2($idArea)
    {
        $idarea = $idArea;
        $area = Area::find($idarea);
        return view('compras.areas.crearFile2', compact('idarea', 'area'));
    }

    public function guardarfile(Request $request)
    {
        $file = new File();
        $file->numfile = $request->input('numfile');
        $file->cargo = $request->input('cargo');
        $file->nombrecargo = $request->input('nombrecargo');
        $file->habbasico = $request->input('habbasico');
        $file->categoria = $request->input('categoria');
        $file->niveladm = $request->input('niveladm');
        $file->clase = $request->input('clase');
        $file->nivelsal = $request->input('nivelsal');
        $file->tipofile = 1;
        $file->estadofile = 1;
        $file->idarea = $request->input('idarea');

        $idarea = $request->input('idarea');
        if ($file->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->action('App\Http\Controllers\AreasController@file', ['id' => $idarea]);
    }

    public function guardarfile2(Request $request)
    {
        $file = new File();
        $file->numfile = $request->input('numfile');
        $file->cargo = $request->input('cargo');
        $file->nombrecargo = $request->input('nombrecargo');
        $file->habbasico = $request->input('habbasico');
        $file->categoria = $request->input('categoria');
        $file->niveladm = $request->input('niveladm');
        $file->clase = $request->input('clase');
        $file->nivelsal = $request->input('nivelsal');
        $file->tipofile = 2;
        $file->estadofile = 1;

        $file->idarea = $request->input('idarea');
        $idarea = $request->input('idarea');
        if ($file->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }

        return redirect()->action('App\Http\Controllers\AreasController@file2', ['id' => $idarea]);
    }



    public function file($id)
    {
        $area = Area::find($id);
        $file = DB::table('file as f')
            ->join('areas as a', 'a.idarea', 'f.idarea')
            ->select('f.idfile', 'f.numfile', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 'f.niveladm', 'f.clase', 'f.nivelsal', 'a.nombrearea', 'f.estadofile')
            ->where('f.tipofile', '=', 1)
            ->where('a.idarea', '=', $id)
            ->orderBy('f.cargo', 'asc')
            ->get();
        //->paginate(5);

        return view('compras.areas.file', ["area" => $area, "file" => $file, "id" => $id]);
    }

    public function file2($id)
    {
        $area = Area::find($id);
        $file = DB::table('file as f')
            ->join('areas as a', 'a.idarea', '=', 'f.idarea')
            ->select('f.idfile', 'f.numfile', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 'f.niveladm', 'f.clase', 'f.nivelsal', 'a.nombrearea', 'f.estadofile')
            ->where('f.tipofile', 2)
            ->where('a.idarea', $id)
            ->get();

        return view('compras.areas.file2', ["area" => $area, "file" => $file, "id" => $id]);
    }

    public function byCategory($id)
    {
        return File::where('idarea', $id)->get();
    }

    public function store(Request $request)
    {
        $areas = new Area();
        $areas->nombrearea = $request->input('nombre');
        $areas->idnivel = $request->input('idnivel');
        $areas->estadoarea = 1;
        if ($areas->save()) {
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
        } else {
            $request->session()->flash('message', 'Error al procesar el registro');
        }
        return redirect()->route('areas.index');
    }

    public function show($id)
    {
    }

    public function edit($idarea)
    {
        $areas = Area::find($idarea);
        return view('compras.areas.edit', ["areas" => $areas]);
    }

    public function update(Request $request, $idarea)
    {
        $areas = Area::find($idarea);
        $areas->nombrearea = $request->input('nombre');
        if ($areas->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect('compras/areas/index');
    }

    public function destroy($id)
    {
    }

    public function editfile($idfile)
    {
        $files = File::find($idfile);
        $file = $files;
        $area = Area::find($files->idarea);
        $areas = DB::table('areas')->get();
        return view('compras.areas.actualizarfile', compact('areas', 'file', 'area'));
    }

    public function editfile2($idfile)
    {
        $files = File::find($idfile);
        $file = $files;
        $area = Area::find($files->idarea);
        $areas = DB::table('areas')->get();

        return view('compras.areas.actualizarfile2', compact('areas', 'file', 'area'));
    }


    public function updatefile(Request $request)
    {
        $file = File::find($request->input('idfile'));
        $file->numfile = $request->input('numfile');
        $file->cargo = $request->input('cargo');
        $file->nombrecargo = $request->input('nombrecargo');
        $file->habbasico = $request->input('habbasico');
        $file->categoria = $request->input('categoria');
        $file->niveladm = $request->input('niveladm');
        $file->clase = $request->input('clase');
        $file->nivelsal = $request->input('nivelsal');
        $file->idarea = $request->input('idarea2');

        if ($file->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->action('App\Http\Controllers\AreasController@file', [$request->input('idarea')]);
    }

    public function updatefile2(Request $request)
    {
        $file = File::find($request->input('idfile'));
        $file->numfile = $request->input('numfile');
        $file->cargo = $request->input('cargo');
        $file->nombrecargo = $request->input('nombrecargo');
        $file->habbasico = $request->input('habbasico');
        $file->categoria = $request->input('categoria');
        $file->niveladm = $request->input('niveladm');
        $file->clase = $request->input('clase');
        $file->nivelsal = $request->input('nivelsal');
        $file->idarea = $request->input('idarea2');

        if ($file->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }

        return redirect()->action('App\Http\Controllers\AreasController@file2', [$request->input('idarea')]);
    }
}
