<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmpleadosModel;
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


class ArchivosController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {


            $data = DB::table('archivos as a')
                ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('a.idarchivo', 'a.referencia','a.fecha','a.gestion', 'a.nombrearchivo', 'a.documento', 'a.idarea', 't.nombretipo')
                ->where('ar.idarea', $personalArea->idarea)
                ->orderBy('a.gestion', 'desc');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn', 'archivos2.btn')
                ->addColumn('btn2', 'archivos2.btn2')
                ->rawColumns(['btn','btn2'])



                ->make(true);

            //return response()->json($id);

        }

        return view('archivos2.index', ['idd' => $personalArea]);
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }



    public function create()

    {



        $date = Carbon::now();

        $date = $date->format('Y');


        $tipos = DB::table('tipoarchivo')->get();
        $anio = DB::table('anio')->get();
        return view('archivos2.createArchivo', ["tipos" => $tipos, "date" => $date, "anio" => $anio]);
    }






    public function insertar(Request $request)
    {
        // try{
        //  ini_set('memory_limit','-1');
        // ini_set('max_execution_time','-1');

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        $fecha_gestion = substr($request->fecha, 6, 4);


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

        //for ($i = 1; $i <= 3000; $i++) {


            //$nombre2='hola';
            $archivos = new ArchivosModel();
            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            $archivos->gestion = $fecha_gestion;
            $archivos->documento = $personalArea->nombrearea . '/' . $nombre;
            $archivos->idarea = $personalArea->idarea;
            $archivos->estado1 = 1;
            $archivos->idtipo = $request->input('tipodocumento');
            $archivos->id = $personal->id;
            $archivos->fecha = $fecha_recepcion;
            $archivos->save();
      // }



        return redirect()->action('App\Http\Controllers\ArchivosController2@index');

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
        $archivos = ArchivosModel::find($idarchivo)->first();
        $date = Carbon::now();

        $date = $date->format('Y');

        $date22 = $archivos->fecha;

       $date2 = Carbon::createFromFormat('Y-m-d', $date22)
       ->format('d/m/Y');


        $anio = DB::table('anio')->get();

        return view('archivos2.edit', ["date2" => $date2,"tipos" => $tipos, "archivos" => $archivos, "date" => $date, "anio" => $anio]);
    }


    public function update(Request $request, $idarchivo)
    {



        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        //$fecha_recepcion = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        $fecha_gestion = substr($request->fecha, 6, 4);

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
            $archivos->gestion = $fecha_gestion;
            $archivos->fecha = $request->input('fecha');
            $archivos->idtipo = $request->input('tipodocumento');


            $archivos->save();
        } else {
            $archivos->nombrearchivo = $request->input('nombredocumento');
            $archivos->referencia = $request->input('referencia');
            //$archivos->documento = $personalArea->nombrearea . '/' . $nombre;
            $archivos->idarea = $personalArea->idarea;
            $archivos->estado1 = 1;
            $archivos->gestion = $fecha_gestion;
            $archivos->fecha = $request->input('fecha');
            $archivos->idtipo = $request->input('tipodocumento');


            $archivos->save();
        }

        return redirect()->action('App\Http\Controllers\ArchivosController2@index');
    }
}
