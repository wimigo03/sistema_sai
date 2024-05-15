<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaModel;
use App\Models\Evento;
use App\Models\Event2;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ArchivoAgendaModel;

use App\Models\Empleado;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;

class ControllerEvent2 extends Controller
{
   //
    // formulario de evento
    public function form($fecha)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        //dd($userdate);
        // return view("evento/form");
        return view("evento2/form", [
            "fecha" => $fecha, "personal" => $userdate
        ]);
    }

    // guardar evento
    public function create(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        // validacion
        //$this->validate($request, [
           // 'titulo'     =>  'required',
           // 'descripcion'  =>  'required',
           // 'fecha' =>  'required',
           // 'hora'  =>  'required',
           // 'lugar'  =>  'required',
           // 'coordinar'  =>  'required',
           // 'representante'  =>  'required'
        //]);

        // guarda la base de datos
        Event2::insert([
            'titulo'       => $request->input("titulo"),
            'descripcion'  => $request->input("descripcion"),
            'fecha'        => $request->input("fecha"),
            'horaini'        => $request->input("hora"),
            'lugar'        => $request->input("lugar"),
            'coordinar'        => $request->input("coordinar"),
            'representante'        => $request->input("representante"),
            'usuario'        => $request->input("usuario"),
            'idusuario'        => $personal->id,
            'idarea'        => $personalArea->idarea,
            'estadoarchivo'        => 0
        ]);

        // devuelve el mensaje de exito
        return back()->with('success', 'Enviado exitosamente!');
    }

    public function editar($id)
    {

        // llamar evento por id
        $event = Event2::find($id);

        return view("evento2/actualizar", [
            "evento" => $event
        ]);
    }

    public function retornararea()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        // llamar evento por id
        $area =  $personalArea->idarea;

        return $area;

    }



     public function actualizar(Request $request, $idevent)
     {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        $event = Event2::find($idevent);


         $event->titulo = $request->input('nombre');

         $event->titulo = $request->input("titulo");
         $event->descripcion = $request->input("descripcion");
         $event->fecha= $request->input("fecha");
         $event->horaini= $request->input("hora");
         $event->lugar=$request->input("lugar");
         $event->coordinar= $request->input("coordinar");
         $event->representante = $request->input("representante");
         $event->usuario = $request->input("usuario");
         $event->idusuario = $personal->id;
         $event->idarea = $personalArea->idarea;

         if ($event->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return back()->with('success', 'Actualizado exitosamente!');
     }

    public function details($dia, $mes, $anio)
    {







        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
        // $mess=mesnumero($id2);
        $mess = $this->getmesnumero($mes);
        // llamar evento por id
        //$event = Event::find($id);

        $myDate = $anio . '/' . $mess . '/' . $dia;
        $date = Carbon::createFromFormat('Y/m/d', $myDate)->format('Y-m-d');


        $event= Event2::where('fecha', '=', $date)
        //->where('that', '=', 1)
    //->where('idusuario', '=', $personal->id )
    ->where('idarea', '=', $personalArea->idarea)
        //->where('that_too', '=', 1)
        //->where('this_as_well', '=', 1)
        //->where('that_as_well', '=', 1)
        //->where('this_one_too', '=', 1)
       // ->where('that_one_too', '=', 1)
        //->where('this_one_as_well', '=', 1)
        //->where('that_one_as_well', '=', 1)
        //->orderby('horaini', 'desc')
        ->orderby('horaini', 'desc')
        ->get();

        //$event = Event2::where('fecha', $date)
           // ->orderby('horaini', 'desc')
           // ->get();


        //dd($event);

        $fecha2 = Carbon::parse($date);
   // $date = $fecha2->locale();
//dd($fecha->monthName);
      $fechaliteral = $fecha2->dayName.' '.$fecha2->day.' '.'de'.' '.$fecha2->monthName.' '.'del'.' '.$fecha2->year;


  return view("evento2/evento", ["event" => $event, "date" => $date,"fechaliteral" => $fechaliteral]);
    }


    public function details2($fecha)
    {
        // $mess=mesnumero($id2);
        //$mess = $this->getmesnumero($mes);
        // llamar evento por id
        //$event = Event::find($id);

       // $myDate = $anio . '/' . $mess . '/' . $dia;
        ///$date = Carbon::createFromFormat('Y/m/d', $myDate)->format('Y-m-d');
        $event = Event2::where('fecha', $fecha)
            ->orderby('horaini', 'desc')
            ->get();
        //dd($event);
       // return view("evento/pdf-evento", ["event" => $event, "fecha" => $fecha]);
      // $fechaliteral = Carbon::parse($fecha)->format('l jS \\of F Y');
      //$date = Carbon::create($fecha)->locale('es');

      $fecha2 = Carbon::parse($fecha);
   // $date = $fecha2->locale();
//dd($fecha->monthName);
      $fechaliteral = $fecha2->dayName.' '.$fecha2->day.' '.'de'.' '.$fecha2->monthName.' '.'del'.' '.$fecha2->year;
      //$mes = $fecha2->monthName;


        $pdf = PDF::loadView('evento2/pdf-evento', compact(['event', 'fecha', 'fechaliteral']));
            $pdf->setPaper('LETTER', 'landscape'); //landscape
            return $pdf->stream();
    }

    // ======================== CANDELARIO =================
    public function index()
    {

        $month = date("Y-m");
        //
        $data = $this->calendar_month($month);
        $mes = $data['month'];
        // obtener mes en espanol
        $mespanish = $this->spanish_month($mes);
        $mes = $data['month'];

        return view("evento2/calendario", [
            'data' => $data,
            'mes' => $mes,
            'mespanish' => $mespanish
        ]);
    }

    public function index_month($month)
    {

        $data = $this->calendar_month($month);
        $mes = $data['month'];
        // obtener mes en espanol
        $mespanish = $this->spanish_month($mes);
        $mes = $data['month'];

        return view("evento2/calendario", [
            'data' => $data,
            'mes' => $mes,
            'mespanish' => $mespanish
        ]);
    }

    public static function calendar_month($month)
    {
        //$mes = date("Y-m");
        $mes = $month;
        //sacar el ultimo de dia del mes
        $daylast =  date("Y-m-d", strtotime("last day of " . $mes));
        //sacar el dia de dia del mes
        $fecha      =  date("Y-m-d", strtotime("first day of " . $mes));
        $daysmonth  =  date("d", strtotime($fecha));
        $montmonth  =  date("m", strtotime($fecha));
        $yearmonth  =  date("Y", strtotime($fecha));
        // sacar el lunes de la primera semana
        $nuevaFecha = mktime(0, 0, 0, $montmonth, $daysmonth, $yearmonth);
        $diaDeLaSemana = date("w", $nuevaFecha);
        $nuevaFecha = $nuevaFecha - ($diaDeLaSemana * 24 * 3600); //Restar los segundos totales de los dias transcurridos de la semana
        $dateini = date("Y-m-d", $nuevaFecha);
        //$dateini = date("Y-m-d",strtotime($dateini."+ 1 day"));
        // numero de primer semana del mes
        $semana1 = date("W", strtotime($fecha));
        // numero de ultima semana del mes
        $semana2 = date("W", strtotime($daylast));
        // semana todal del mes
        // en caso si es diciembre
        if (date("m", strtotime($mes)) == 12) {
            $semana = 5;
        } else {
            $semana = ($semana2 - $semana1) + 1;
        }
        // semana todal del mes
        $datafecha = $dateini;
        $calendario = array();
        $iweek = 0;
        while ($iweek < $semana) :
            $iweek++;
            //echo "Semana $iweek <br>";
            //
            $weekdata = [];
            for ($iday = 0; $iday < 7; $iday++) {
                // code...
                $datafecha = date("Y-m-d", strtotime($datafecha . "+ 1 day"));
                $datanew['mes'] = date("M", strtotime($datafecha));
                $datanew['dia'] = date("d", strtotime($datafecha));
                $datanew['fecha'] = $datafecha;
                //AGREGAR CONSULTAS EVENTO
                // consulta evento y filtra por fecha
                //$datanew = DB::table('evento2 as e')
                //->join('areas as ar', 'ar.idarea', '=', 'e.idarea')
                 //->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
                 //->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
                // ->where("e.fecha", $datafecha)
                // ->where('tt.idarea','=', $personalArea->idarea)
                 //->orderby('e.horaini', 'desc')
                // ->get();

               $personal = User::find(Auth::user()->id);
                $id = $personal->id;
               $userdate = User::find($id)->usuariosempleados;
                $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

                $datanew['evento'] = Event2::where('fecha', '=', $datafecha)
                //->where('that', '=', 1)
            ->where('idarea', '=', $personalArea->idarea)
                //->where('that_too', '=', 1)
                //->where('this_as_well', '=', 1)
                //->where('that_as_well', '=', 1)
                //->where('this_one_too', '=', 1)
               // ->where('that_one_too', '=', 1)
                //->where('this_one_as_well', '=', 1)
                //->where('that_one_as_well', '=', 1)
                //->orderby('horaini', 'desc')
                ->get();
//dd( $personal->id);
              // $datanew['evento'] = Event2::where("fecha", $datafecha)
                   // ->orderby('horaini', 'desc')
                   // ->get();
                array_push($weekdata, $datanew);
            }
            $dataweek['semana'] = $iweek;
            $dataweek['datos'] = $weekdata;
            //$datafecha['horario'] = $datahorario;
            array_push($calendario, $dataweek);
        endwhile;
        $nextmonth = date("Y-M", strtotime($mes . "+ 1 month"));
        $lastmonth = date("Y-M", strtotime($mes . "- 1 month"));
        $month = date("M", strtotime($mes));
        $yearmonth = date("Y", strtotime($mes));
        //$month = date("M",strtotime("2019-03"));
        $data = array(
            'next' => $nextmonth,
            'month' => $month,
            'year' => $yearmonth,
            'last' => $lastmonth,
            'calendar' => $calendario,
        );
        return $data;
    }

    public static function spanish_month($month)
    {

        $mes = $month;
        if ($month == "Jan") {
            $mes = "Enero";
        } elseif ($month == "Feb") {
            $mes = "Febrero";
        } elseif ($month == "Mar") {
            $mes = "Marzo";
        } elseif ($month == "Apr") {
            $mes = "Abril";
        } elseif ($month == "May") {
            $mes = "Mayo";
        } elseif ($month == "Jun") {
            $mes = "Junio";
        } elseif ($month == "Jul") {
            $mes = "Julio";
        } elseif ($month == "Aug") {
            $mes = "Agosto";
        } elseif ($month == "Sep") {
            $mes = "Septiembre";
        } elseif ($month == "Oct") {
            $mes = "Octubre";
        } elseif ($month == "Oct") {
            $mes = "December";
        } elseif ($month == "Dec") {
            $mes = "Diciembre";
        } else {
            $mes = $month;
        }
        return $mes;
    }

    private function getmesnumero($month)
    {

        $mes = $month;
        if ($month == "Enero") {
            $mes = "1";
        } elseif ($month == "Febrero") {
            $mes = "2";
        } elseif ($month == "Marzo") {
            $mes = "3";
        } elseif ($month == "Abril") {
            $mes = "4";
        } elseif ($month == "Mayo") {
            $mes = "5";
        } elseif ($month == "Junio") {
            $mes = "6";
        } elseif ($month == "Julio") {
            $mes = "7";
        } elseif ($month == "Agosto") {
            $mes = "8";
        } elseif ($month == "Septiembre") {
            $mes = "9";
        } elseif ($month == "Octubre") {
            $mes = "10";
        } elseif ($month == "Noviembre") {
            $mes = "11";
        } elseif ($month == "Diciembre") {
            $mes = "12";
        } else {
            $mes = $month;
        }
        return $mes;
    }



    public function cargarpdf($idevento2)

    {

        return view('evento2.cargarpdf', ["idevento2" => $idevento2]);
    }


    public function storepdf(Request $request)
    {


        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/agenda/" . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }

        $archivos = new ArchivoAgendaModel();
        $archivos->id_evento = $request->input('idevento2');
        $archivos->documento = $nombre;
        $archivos->estado = 1;
        $archivos->save();

        $evento2 = Event2::find($request->input('idevento2'));
        $evento2->estadoarchivo = 1;
        $evento2->save();
        //return redirect()->route('correspondencia.local.gestionar',$request->input('idrecepcion'));
        return redirect()->action('App\Http\Controllers\ControllerEvent2@index');


    }

    public function actualizarpdf($idevento)

    {
        return view('evento2.updatepdf', ["idevento" => $idevento]);
    }


    public function updatepdf(Request $request)
    {


        if ($request->hasFile("documento")) {
            $file = $request->file("documento");
            $file_name = $file->getClientOriginalName();
            $nombre = "pdf_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/agenda/" . '/' . $nombre);

            if ($file->guessExtension() == "pdf") {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }

        $data = DB::table('archivoagenda as a')
        ->join('evento2 as e', 'e.id', '=', 'a.id_evento')
        //->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
        ->select('a.id_evento', 'a.documento', 'a.id_archivo')
        ->where('a.id_evento', $request->input('idevento'))
        ->first();
//dd($data->id_evento);
        $evento = ArchivoAgendaModel::find($data->id_archivo);
       // $archivos = new ArchivoCorrespModel();
       //$evento->id_evento = $data->id_evento;


       $evento->documento = $nombre;
        //$archivos->estado_envio = 1;
        $evento->save();

        return redirect()->action('App\Http\Controllers\ControllerEvent2@index');



    }

    public function urlfile($idevento){
        // $file = ThesisFile::where('thesis_id',$thesis_id)->where('state',1)->first();
        // return response()->json(['response' => [
            // 'url' => $file->url,
            // 'name' => $file->name,
            // ]
        // ], 201);

        $data = DB::table('archivoagenda as a')
        ->join('evento2 as e', 'e.id', '=', 'a.id_evento')
        //->join('unidad as u', 'u.id_unidad', '=', 're.id_unidad')
        ->select('a.id_evento', 'a.documento')
        ->where('a.id_evento', $idevento)
        ->first();

        //dd($data->documento);

        $redirect='../public/agenda/';
       // return Redirect::to($redirect);
       //return Redirect::to($redirect)->with('_blank');
       return redirect()->to($redirect.$data ->documento);
     }

}
