<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmpleadosModel;
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
            $hora1='15:45';
            $hora2='18:00';
            $fecha_ayer= date("Y-m-d",strtotime("yesterday"));
            $fecha_actual = date("Y-m-d",strtotime("yesterday"));
            $fecha_maniana = date("Y-m-d",strtotime("tomorrow"));
            $data = DB::table('agenda as ag')
                // ->join('areas as ar', 'ar.idarea', '=', 'a.idarea')
                // ->join('tipoarchivo as t', 'a.idtipo', '=', 't.idtipo')
                ->select('ag.idagenda','ag.evento', 'ag.descripcion', 'ag.fecha', 'ag.horaini', 'ag.horafin')
                //->where(DB::raw("(DATE_FORMAT(ag.fecha2,'%Y-%m'))"))
                //->where('ag.fecha2', $fecha_maniana)
                //->whereBetween('ag.hora1', [$hora1, $hora2])
                //->WhereBetween('ag.hora2', [$hora1, $hora2])
               // ->where('ag.hora1', $hora)
                ->orderBy('ag.fecha', 'desc')
                ;
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
        return view('agenda.index');
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
       // $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

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
        $agenda->fecha = $fecha;
        $agenda->horaini = $request->horaini;
        $agenda->horafin = $request->horafin;
       // $agenda->estado1 = 1;
       // $agenda->idtipo = $request->input('tipodocumento');
       // $agenda->id = $personal->id;
        //$agenda->fecha = $fecha_recepcion;
        $agenda->save();



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
        return view('agenda.edit', ["agenda" =>$agenda,"date2" =>$date2]);
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
        $agenda->fecha = $fecha;
        $agenda->horaini = $request->horaini;
        $agenda->horafin = $request->horafin;
        $agenda->save();


        return redirect()->action('App\Http\Controllers\AgendaController@index');
    }

}
