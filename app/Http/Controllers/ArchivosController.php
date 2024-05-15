<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use App\Models\ArchivosModel;
use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use DataTables;


class ArchivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //index
    public function index()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $data = DB::table('archivos as a')
            ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
            ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
            ->select('a.idarchivo', 'a.referencia', 'a.nombrearchivo', 'a.documento', 'a.idarea', 't.nombretipo')
            ->where('ar.idarea', $personalArea->idarea)
            ->get();


        return view('archivos.index', ['data' => $data, 'idd' => $personalArea]);
    }



    public function create()

    {



        $date = Carbon::now();

        $date = $date->format('Y');


        $tipos = DB::table('tipoarchivo')->get();
        $anio = DB::table('anio')->get();
        return view('archivos.createArchivo', ["tipos" => $tipos, "date" => $date, "anio" => $anio]);
    }

    public function insertar(Request $request)
    {
        // try{
        //  ini_set('memory_limit','-1');
        // ini_set('max_execution_time','-1');

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;



        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/Documentos/" . $personalArea->nombrearea . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }


        //$nombre2='hola';
        $archivos = new ArchivosModel();
        $archivos->nombrearchivo = $request->input('nombredocumento');
        $archivos->referencia = $request->input('referencia');
        $archivos->gestion = $request->input('anio');
        $archivos->documento = $personalArea->nombrearea . '/' . $nombre;
        $archivos->idarea = $personalArea->idarea;
        $archivos->estado1 = 1;
        $archivos->idtipo = $request->input('tipodocumento');
        $archivos->id = $personal->id;


        $archivos->save();


        return redirect()->action('App\Http\Controllers\ArchivosController@index');

        //} catch (\Throwable $th){
        // return '[ERROR_500]';
        //}finally{
        // ini_restore('memory_limit');
        //ini_restore('max_execution_time');
        // }
    }


    public function editar($idarchivo)
    {
        $tipos = DB::table('tipoarchivo')->get();
        $archivos = ArchivosModel::find($idarchivo);
        $date = Carbon::now();

        $date = $date->format('Y');

        // dd($compras);
        return view('archivos.edit', ["tipos" => $tipos, "archivos" => $archivos, "date" => $date]);
    }


    public function update(Request $request, $idarchivo)
    {





        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $archivos = ArchivosModel::find($idarchivo);
        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "pdf_" . time() . "." . $file->guessExtension();

                $ruta = public_path("/Documentos/" . $personalArea->nombrearea . '/' . $nombre);

                if ($file->guessExtension() == "pdf") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }


            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            $archivos->documento = $personalArea->nombrearea . '/' . $nombre;
            $archivos->idarea = $personalArea->idarea;
            $archivos->estado1 = 1;
            $archivos->idtipo = $request->input('tipodocumento');


            $archivos->save();
        } else {
            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            //$archivos->documento = $personalArea->nombrearea . '/' . $nombre;
            $archivos->idarea = $personalArea->idarea;
            $archivos->estado1 = 1;
            $archivos->idtipo = $request->input('tipodocumento');


            $archivos->save();
        }

        return redirect()->action('App\Http\Controllers\ArchivosController@index');
    }
}
