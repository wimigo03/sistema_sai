<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\AgendaModel;
use App\Models\AnioModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use DataTables;

class AgendaController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $hora1 = '15:45';
            $hora2 = '18:00';
            $fecha_ayer = date("Y-m-d", strtotime("yesterday"));
            $fecha_actual = date("Y-m-d", strtotime("yesterday"));
            $fecha_maniana = date("Y-m-d", strtotime("tomorrow"));
            $data = DB::table('agenda as ag')
                // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
                //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
                //->where('ag.fecha2', $fecha_maniana)
                //->whereBetween('ag.hora1', [$hora1, $hora2])
                //->WhereBetween('ag.hora2', [$hora1, $hora2])
                // ->where('ag.hora1', $hora)
                ->orderBy('ag.fecha2', 'desc')
                ->orderBy('ag.hora1', 'desc');
            //$data->fecha2->format('Y-m-d');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('btn', 'agenda.btn')
                ->addColumn('btn2', 'agenda.btn2')
                ->addColumn('btn3', 'agenda.btn3')
                ->rawColumns(['btn', 'btn2', 'btn3'])
                ->make(true);

            //return response()->json($id);

        }
        //dd($data2);
        return view('agenda.ej.index');
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }



    public function create()

    {



        $date = Carbon::now();

        $date = $date->format('Y');


        $tipos = DB::table('tipoarchivo')->get();
        $anio = DB::table('anio')->get();
        return view('agenda.createArchivo', ["tipos" => $tipos, "date" => $date, "anio" => $anio]);
    }



    public function insertar(Request $request)
    {

        //$personal = User::find(Auth::user()->id);
        //$id = $personal->id;
        // $userdate = User::find($id)->usuariosempleados;
        // $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $fecha = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);
        //$fecha_final = substr($request->fechafin, 6, 4) . '-' . substr($request->fechafin, 3, 2) . '-' . substr($request->fechafin, 0, 2);
        // $fecha_gestion = substr($request->fecha, 6, 4);

        // $fechaini=$fecha .' '.$request->horaini;
        // $fechafin=$fecha .' '.$request->horafin;
        $agenda = new AgendaModel();
        $agenda->evento = $request->input('evento');
        $agenda->descripcion = $request->input('descripcion');
        //$agenda->fechaini = $fechaini;
        // $agenda->fechafin = $fechafin;
        $agenda->fecha2 = $fecha;
        $agenda->hora1 = $request->horaini;
        $agenda->hora2 = $request->horafin;
        // $agenda->estado1 = 1;
        // $agenda->idtipo = $request->input('tipodocumento');
        // $agenda->id = $personal->id;
        //$agenda->fecha = $fecha_recepcion;
        $dataini = DB::table('agenda as ag')
            // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
            // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
            ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
            //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
            ->whereBetween('ag.hora1', [$request->horaini, $request->horafin])
            // ->WhereBetween('ag.hora2', [$request->horaini, $request->horafin])
            ->where('ag.fecha2', $fecha)
            ->get();

        $datafin = DB::table('agenda as ag')
            // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
            // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
            ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
            //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
            //->whereBetween('ag.hora1', [$request->horaini, $request->horafin])
            ->WhereBetween('ag.hora2', [$request->horaini, $request->horafin])
            ->where('ag.fecha2', $fecha)
            ->get();

        //dd($datafin);
        if ($dataini->isEmpty() && $datafin->isEmpty()) {
            $agenda->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'Ya exite un evento en los rangos de fecha y hora');
        }


        // $agenda->save();



        return redirect()->action('App\Http\Controllers\AgendaController@index');
    }


    public function editar($idagenda)
    {
        $agenda = AgendaModel::find($idagenda);
        // $date = Carbon::now();
        // $date = $date->format('Y');

        $date22 = $agenda->fecha2;

        $date2 = Carbon::createFromFormat('Y-m-d', $date22)
            ->format('d/m/Y');


        // $anio = DB::table('anio')->get();
        //dd($agenda->descripcion);
        return view('agenda.edit', ["agenda" => $agenda, "date2" => $date2]);
    }

    public function editar2($idagenda)
    {
        $agenda = AgendaModel::find($idagenda);
        // $date = Carbon::now();
        // $date = $date->format('Y');

        $date22 = $agenda->fecha2;

        $date2 = Carbon::createFromFormat('Y-m-d', $date22)
            ->format('d/m/Y');


        // $anio = DB::table('anio')->get();
        //dd($agenda->descripcion);
        return view('agenda.edit2', ["agenda" => $agenda, "date2" => $date2]);
    }


    public function update(Request $request, $idagenda)
    {


        $fecha = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        // $fechaini=$fecha .' '.$request->horaini;
        //$fechafin=$fecha .' '.$request->horafin;



        $agenda = AgendaModel::find($idagenda);

        $agenda->evento = $request->input('evento');
        $agenda->descripcion = $request->input('descripcion');
        //$agenda->fechaini = $fechaini;
        // $agenda->fechafin = $fechafin;
        // $agenda->fecha2 = $fecha;
        //$agenda->hora1 = $request->horaini;
        //$agenda->hora2 = $request->horafin;


        // $dataini = DB::table('agenda as ag')
        // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
        // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
        // ->select('ag.idagenda','ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
        //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
        // ->whereBetween('ag.hora1', [$request->horaini, $request->horafin])
        // ->WhereBetween('ag.hora2', [$request->horaini, $request->horafin])
        //->where('ag.fecha2', $fecha)
        // ->get();

        // $datafin = DB::table('agenda as ag')
        // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
        // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
        //->select('ag.idagenda','ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
        //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
        //->whereBetween('ag.hora1', [$request->horaini, $request->horafin])
        //->WhereBetween('ag.hora2', [$request->horaini, $request->horafin])
        // ->where('ag.fecha2', $fecha)
        // ->get();

        //dd($datafin);
        //if ($dataini->isEmpty() && $datafin->isEmpty() ) {
        // $agenda->save();
        // $request->session()->flash('message', 'Registro Agregado');
        // }

        //  else {
        // $request->session()->flash('message', 'Ya exite un evento en los rangos de fecha y hora');
        //  }



        $agenda->save();


        return redirect()->action('App\Http\Controllers\AgendaController@index');
    }





    public function update2(Request $request, $idagenda)
    {


        $fecha = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

        // $fechaini=$fecha .' '.$request->horaini;
        //$fechafin=$fecha .' '.$request->horafin;



        $agenda = AgendaModel::find($idagenda);

        // $agenda->evento = $request->input('evento');
        // $agenda->descripcion = $request->input('descripcion');
        //$agenda->fechaini = $fechaini;
        // $agenda->fechafin = $fechafin;
        $agenda->fecha2 = $fecha;
        $agenda->hora1 = $request->horaini;
        $agenda->hora2 = $request->horafin;


        $dataini = DB::table('agenda as ag')
            // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
            // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
            ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
            //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
            ->whereBetween('ag.hora1', [$request->horaini, $request->horafin])
            // ->WhereBetween('ag.hora2', [$request->horaini, $request->horafin])
            ->where('ag.fecha2', $fecha)
            ->get();

        $datafin = DB::table('agenda as ag')
            // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
            // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
            ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
            //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
            //->whereBetween('ag.hora1', [$request->horaini, $request->horafin])
            ->WhereBetween('ag.hora2', [$request->horaini, $request->horafin])
            ->where('ag.fecha2', $fecha)
            ->get();

        //dd($datafin);
        if ($dataini->isEmpty() && $datafin->isEmpty()) {
            $agenda->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'Ya exite un evento en los rangos de fecha y hora');
        }



        // $agenda->save();


        return redirect()->action('App\Http\Controllers\AgendaController@index');
    }






    public function indexayer(Request $request)
    {

        if ($request->ajax()) {
            $hora1 = '15:45';
            $hora2 = '18:00';
            $fecha_ayer = date("Y-m-d", strtotime("yesterday"));
            $fecha_actual = date("Y-m-d", strtotime("yesterday"));
            $fecha_maniana = date("Y-m-d", strtotime("tomorrow"));
            $data = DB::table('agenda as ag')
                // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
                //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
                ->where('ag.fecha2', $fecha_ayer)
                //->whereBetween('ag.hora1', [$hora1, $hora2])
                //->WhereBetween('ag.hora2', [$hora1, $hora2])
                // ->where('ag.hora1', $hora)
                ->orderBy('ag.fecha2', 'desc')
                ->orderBy('ag.hora1', 'desc');
            //$data->fecha2->format('Y-m-d');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('btn', 'agenda.btn')
                //->addColumn('btn2', 'archivos2.btn2')
                ->rawColumns(['btn'])
                ->make(true);

            //return response()->json($id);

        }
        //dd($data2);
        return view('agenda.indexayer');
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }


    public function indexhoy(Request $request)
    {

        if ($request->ajax()) {
            $hora1 = '15:45';
            $hora2 = '18:00';
            $fecha_ayer = date("Y-m-d", strtotime("yesterday"));
            $fecha_actual = date("Y-m-d", strtotime("today"));
            $fecha_maniana = date("Y-m-d", strtotime("tomorrow"));
            $data = DB::table('agenda as ag')
                // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
                //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
                ->where('ag.fecha2', $fecha_actual)
                //->whereBetween('ag.hora1', [$hora1, $hora2])
                //->WhereBetween('ag.hora2', [$hora1, $hora2])
                // ->where('ag.hora1', $hora)
                ->orderBy('ag.fecha2', 'desc')
                ->orderBy('ag.hora1', 'desc');
            //$data->fecha2->format('Y-m-d');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('btn', 'agenda.btn')
                //->addColumn('btn2', 'archivos2.btn2')
                ->rawColumns(['btn'])
                ->make(true);

            //return response()->json($id);

        }
        //dd($data2);
        return view('agenda.indexhoy');
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }


    public function indexmaniana(Request $request)
    {

        if ($request->ajax()) {
            $hora1 = '15:45';
            $hora2 = '18:00';
            $fecha_ayer = date("Y-m-d", strtotime("yesterday"));
            $fecha_actual = date("Y-m-d", strtotime("today"));
            $fecha_maniana = date("Y-m-d", strtotime("tomorrow"));
            $data = DB::table('agenda as ag')
                // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
                //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
                ->where('ag.fecha2', $fecha_maniana)
                //->whereBetween('ag.hora1', [$hora1, $hora2])
                //->WhereBetween('ag.hora2', [$hora1, $hora2])
                // ->where('ag.hora1', $hora)
                ->orderBy('ag.fecha2', 'desc')
                ->orderBy('ag.hora1', 'desc');
            //$data->fecha2->format('Y-m-d');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('btn', 'agenda.btn')
                //->addColumn('btn2', 'archivos2.btn2')
                ->rawColumns(['btn'])
                ->make(true);

            //return response()->json($id);

        }
        //dd($data2);
        return view('agenda.indexmaniana');
        //return view("archivos2.index2")->with("idd", $personalArea);

        // return view('archivos2.index');
    }


    public function delete($idagenda)
    {
        $agenda =AgendaModel::find($idagenda);

        $agenda->delete();

        return redirect()->route('agenda.ej.index');
    }



    public function indextotal(Request $request)
    {

      //  if ($request->ajax()) {

            $query=($request->get('searchText'));
            $fecha = substr($request->fecha, 6, 4) . '-' . substr($request->fecha, 3, 2) . '-' . substr($request->fecha, 0, 2);

            $hora1 = '15:45';
            $hora2 = '18:00';
            $fecha_ayer = date("Y-m-d", strtotime("yesterday"));
            $fecha_actual = date("Y-m-d", strtotime("yesterday"));
            $fecha_maniana = date("Y-m-d", strtotime("tomorrow"));
            $data = DB::table('agenda as ag')
                // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('ag.idagenda', 'ag.evento', 'ag.descripcion', 'ag.fecha2', 'ag.hora1', 'ag.hora2')
                //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
                ->where('ag.fecha2', $query)
                //->where('ag.fecha2', $fecha)
                //->whereBetween('ag.hora1', [$hora1, $hora2])
                //->WhereBetween('ag.hora2', [$hora1, $hora2])
                // ->where('ag.hora1', $hora)
                ->orderBy('ag.fecha2', 'desc')
                ->orderBy('ag.hora1', 'desc');
            //$data->fecha2->format('Y-m-d');
            return Datatables::of($data)

                ->addIndexColumn()
                ->make(true);

       // }


        //dd($data2);
       // return view('agenda.indextotal');

    }
}
