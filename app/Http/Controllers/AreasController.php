<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreasModel;
use App\Models\NivelModel;
use App\Models\FileModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use DataTables;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



         return view('compras.areas.index');
    }

    public function listado(Request $request)
    {

            $data = DB::table('areas')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('btn','compras.areas.btn')
            ->addColumn('btn2','compras.areas.btn2')
            ->addColumn('btn3','compras.areas.btn3')
            ->rawColumns(['btn','btn2','btn3'])
            ->make(true);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area = AreasModel::where('estadoarea','=', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();

        //return view('compras.empleados.create', ["areas" => $areas]);
        return view('compras.areas.create', ["niveles" => $niveles,"area" => $area]);
    }


    public function crearFile($idArea)
    {

        return view('compras.areas.crearFile', ["idarea" => $idArea]);
    }

    public function crearFile2($idArea)
    {

        return view('compras.areas.crearFile2', ["idarea" => $idArea]);
    }

    public function guardarfile(Request $request)
    {
        $file = new FileModel();
        $file -> numfile = $request->input('numfile');
        $file -> cargo = $request->input('cargo');
        $file -> nombrecargo = $request->input('nombrecargo');
        $file -> habbasico = $request->input('habbasico');
        $file -> categoria = $request->input('categoria');
        $file -> niveladm = $request->input('niveladm');
        $file -> clase = $request->input('clase');
        $file -> nivelsal = $request->input('nivelsal');
        $file -> tipofile = 1;
        $file -> estadofile = 1;


        $file -> idarea = $request->input('idarea');

        $idarea=$request->input('idarea');
        if($file->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
       // return redirect()->route('areas.index');

       // return route('areas.crearFile', $idarea);
        //return redirect()->action('AreasController@crearFile', $idarea);
        return redirect()->action('App\Http\Controllers\AreasController@file', ['id' => $idarea]);
        //return view('compras.areas.crearFile', ["idarea" => $idArea]);
    }



    public function guardarfile2(Request $request)
    {
        $file = new FileModel();
        $file -> numfile = $request->input('numfile');
        $file -> cargo = $request->input('cargo');
        $file -> nombrecargo = $request->input('nombrecargo');
        $file -> habbasico = $request->input('habbasico');
        $file -> categoria = $request->input('categoria');
        $file -> niveladm = $request->input('niveladm');
        $file -> clase = $request->input('clase');
        $file -> nivelsal = $request->input('nivelsal');
        $file -> tipofile = 2;
        $file -> estadofile = 1;


        $file -> idarea = $request->input('idarea');

        $idarea=$request->input('idarea');
        if($file->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
       // return redirect()->route('areas.index');

       // return route('areas.crearFile', $idarea);
        //return redirect()->action('AreasController@crearFile', $idarea);
        return redirect()->action('App\Http\Controllers\AreasController@file2', ['id' => $idarea]);
        //return view('compras.areas.crearFile', ["idarea" => $idArea]);
    }



    public function file($id)
    {
        $file = DB::table('file as f')
        ->join('areas as a', 'a.idarea', '=', 'f.idarea')
        ->select('f.idfile','f.numfile','f.cargo','f.nombrecargo','f.habbasico','f.categoria','f.niveladm','f.clase','f.nivelsal','a.nombrearea','f.estadofile')
        -> where('f.tipofile','=', 1)
        -> where('a.idarea','=', $id)
        -> paginate(5);
       // dd($docproveedor);

         return view('compras.areas.file', ["file" => $file,"id" => $id]);

    }

    public function file2($id)
    {
        $file = DB::table('file as f')
        ->join('areas as a', 'a.idarea', '=', 'f.idarea')
        ->select('f.idfile','f.numfile','f.cargo','f.nombrecargo','f.habbasico','f.categoria','f.niveladm','f.clase','f.nivelsal','a.nombrearea','f.estadofile')
        -> where('f.tipofile','=', 2)
        -> where('a.idarea','=', $id)
        -> paginate(5);
       // dd($docproveedor);

         return view('compras.areas.file2', ["file" => $file,"id" => $id]);

    }


    public function byCategory($id){
        return FileModel::where('idarea','=',$id)->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $areas = new AreasModel();
        $areas -> nombrearea = $request->input('nombre');
        $areas -> idnivel = $request->input('idnivel');


        $areas -> estadoarea = 1;


        if($areas->save()){
            $request->session()->flash('message', 'Registro Procesado Exitosamente');
            //echo 'Cliente salvo com sucesso';
        }else{
            $request->session()->flash('message', 'Error al procesar el registro');
            //echo 'Houve um erro ao salvar';
        }
        return redirect()->route('areas.index');
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
    public function edit($idarea)
    {
        $areas = AreasModel::find($idarea);

        return view('compras/areas/edit')->with('areas', $areas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idarea)
    {
        $areas = AreasModel::find($idarea);
        $areas -> nombrearea = $request->input('nombre');

        //$medida->update();
        if($areas->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
        return redirect('compras/areas/index');
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


    public function editfile($idfile)
    {
        $files = FileModel::find($idfile);
        $areas = DB::table('areas')->get();
    //dd($files);
    return view('compras/areas/actualizarfile', ["areas" => $areas,"file" => $files]);
       // return view('compras/areas/actualizarfile')->with('areas', $areas,'file',$files);
    }

    public function editfile2($idfile)
    {
        $files = FileModel::find($idfile);
        $areas = DB::table('areas')->get();
    //dd($files);
    return view('compras/areas/actualizarfile2', ["areas" => $areas,"file" => $files]);
       // return view('compras/areas/actualizarfile')->with('areas', $areas,'file',$files);
    }


    public function updatefile(Request $request)
    {
        $file = FileModel::find($request->input('idfile'));

        $file -> numfile = $request->input('numfile');
        $file -> cargo = $request->input('cargo');
        $file -> nombrecargo = $request->input('nombrecargo');
        $file -> habbasico = $request->input('habbasico');
        $file -> categoria = $request->input('categoria');
        $file -> niveladm = $request->input('niveladm');
        $file -> clase = $request->input('clase');
        $file -> nivelsal = $request->input('nivelsal');
        $file -> idarea = $request->input('idarea2');
       // $file -> tipofile = 1;
       // $file -> estadofile = 1;

        //$medida->update();
        if($file->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->action('App\Http\Controllers\AreasController@file', [$request->input('idarea')]);
    }


    public function updatefile2(Request $request)
    {
        $file = FileModel::find($request->input('idfile'));

        $file -> numfile = $request->input('numfile');
        $file -> cargo = $request->input('cargo');
        $file -> nombrecargo = $request->input('nombrecargo');
        $file -> habbasico = $request->input('habbasico');
        $file -> categoria = $request->input('categoria');
        $file -> niveladm = $request->input('niveladm');
        $file -> clase = $request->input('clase');
        $file -> nivelsal = $request->input('nivelsal');
        $file -> idarea = $request->input('idarea2');
       // $file -> tipofile = 1;
       // $file -> estadofile = 1;

        //$medida->update();
        if($file->save()){
          $request->session()->flash('message', 'Registro Procesado');
      }else{
          $request->session()->flash('message', 'Error al Procesar Registro');
      }
      return redirect()->action('App\Http\Controllers\AreasController@file2', [$request->input('idarea')]);
    }
}
