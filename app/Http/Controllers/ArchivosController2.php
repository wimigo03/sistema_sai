<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\ProveedoresModel;
use App\Models\DocProveedorModel;
use App\Models\TipoAreaModel;
use App\Models\ArchivosModel;
use App\Models\TiposModel;
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
    public function index2(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;



        return view('archivos2.index2', ['idd' => $personalArea]);
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }
    public function index22(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        $data = DB::table('archivos as a')
        ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
        ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
        ->select('a.idarchivo', 'a.referencia', 'a.fecha', 'a.gestion','a.created_at', 'a.nombrearchivo', 'a.documento', 'ar.nombrearea','ar.idarea', 't.nombretipo')
        //->where('a.referencia','=', $request->get('start_date'))
        ->orderBy('a.gestion', 'desc');



            return DataTables::of($data)

            ->addIndexColumn()

            ->addColumn('btn2', 'archivos2.btn2')
            ->rawColumns(['btn2'])



            ->make(true);
    }




    public function index(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {


            $data = DB::table('archivos as a')
                ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('a.idarchivo', 'a.referencia', 'a.fecha', 'a.gestion', 'a.nombrearchivo', 'a.documento', 'ar.idarea', 't.nombretipo')
                ->where('ar.idarea', $personalArea->idarea)
                ->orderBy('a.gestion', 'desc');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('btn', 'archivos2.btn')
                ->addColumn('btn2', 'archivos2.btn2')
                ->rawColumns(['btn', 'btn2'])



                ->make(true);

            //return response()->json($id);

        }

        return view('archivos2.index', ['idd' => $personalArea]);
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }





    public function create()

    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $tipoarea = DB::table('tipoarea as tt')
       ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
        ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
        ->where('tt.idarea','=', $personalArea->idarea)
        ->orderBy('tt.idtipoarea', 'desc')
        ->get();


        $date = Carbon::now();

        $date = $date->format('Y');


        //$tipos = DB::table('tipoarchivo')->get();



        $anio = DB::table('anio')->get();
        return view('archivos2.createArchivo', ["tipos" => $tipoarea, "date" => $date, "anio" => $anio]);
    }






    public function insertar(Request $request)
    {
        try{
         ini_set('memory_limit','-1');
        ini_set('max_execution_time','-1');

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

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



        return redirect()->route('archivos2.index', ['idd' => $personalArea]);

        } catch (\Throwable $th){
         return '[ERROR_500]';
        }finally{
        ini_restore('memory_limit');
        ini_restore('max_execution_time');
         }
    }


    public function editar($idarchivo)

    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $tipoarea = DB::table('tipoarea as tt')
       ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
        ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
        ->where('tt.idarea','=', $personalArea->idarea)
        ->orderBy('tt.idtipoarea', 'desc')
        ->get();



        //$tipos = DB::table('tipoarchivo')->get();
        $archivos = ArchivosModel::find($idarchivo);
        $date = Carbon::now();

        $date = $date->format('Y');

        $date22 = $archivos->fecha;

        $date2 = Carbon::createFromFormat('Y-m-d', $date22)
            ->format('d/m/Y');


        $anio = DB::table('anio')->get();

        return view('archivos2.edit', ["date2" => $date2, "tipos" => $tipoarea, "archivos" => $archivos, "date" => $date, "anio" => $anio]);
    }


    public function update(Request $request, $idarchivo)
    {



        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

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

        //return view('archivos2.index', ['idd' => $personalArea]);
        return redirect()->route('archivos2.index', ['idd' => $personalArea]);
    }







    public function tipo()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $tipoarea = DB::table('tipoarea as tt')
       ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
        ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
        ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
        ->where('tt.idarea','=', $personalArea->idarea)
        ->orderBy('tt.idtipoarea', 'desc')
        ->get();
//dd($tipoarea);
        $tipos = DB::table('tipoarchivo')->get();
        return view('archivos2.tipoarchivo', ["tipos" => $tipos,"tipoareas" => $tipoarea,"personal" => $personalArea]);
    }



    public function guardartipoarea(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $tipoarea = new TipoAreaModel;
        $tipoarea->idarea = $personalArea->idarea;
        $tipoarea->idtipo = $request->input('tipo');


        $detallito = DB::table('tipoarea as tt')
        ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
         ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
         ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
         ->where('tt.idarea','=', $personalArea->idarea)
         ->where('tt.idtipo', $request->input('tipo'))
         ->get();

//dd($detallito);

        if ($detallito->isEmpty()) {
            $tipoarea->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('archivos2.tipo');
    }


    public function delete($idtipoarea)
    {
        $tipoarea =TipoAreaModel::find($idtipoarea);

        $tipoarea->delete();

        return redirect()->route('archivos2.tipo');
    }


    public function createtipoarchivo()
    {
        return view('archivos2.createtipo');
    }

    public function guardartipoarchivo(request $request)
    {
        $newestUser = TiposModel::orderBy('idtipo', 'desc')->first();
        $maxId = $newestUser->idtipo;
       // for ($i = 1; $i <= 10000; $i++) {
            $tipos2 = new TiposModel();
            $tipos2->idtipo = $maxId + 1;
            $tipos2->nombretipo = $request->input('nombretipo');
            //$tipos->estadoumedida = 1;
            $tipos2->save();
       // }
        return redirect()->route('archivos2.tipo');
    }

}
