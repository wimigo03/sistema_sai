<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaModel;
use App\Models\Event;
use Carbon\Carbon;
use App\Models\User;
use App\Models\EmpleadosModel;
use Illuminate\Support\Facades\Auth;
use PDF;
class ControllerEvent extends Controller
{
    //
    // formulario de evento
    public function form($fecha)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        //dd($userdate);
        // return view("evento/form");
        return view("evento/form", [
            "fecha" => $fecha, "personal" => $userdate
        ]);
    }

    // guardar evento
    public function create(Request $request)
    {

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
        Event::insert([
            'titulo'       => $request->input("titulo"),
            'descripcion'  => $request->input("descripcion"),
            'fecha'        => $request->input("fecha"),
            'horaini'        => $request->input("hora"),
            'lugar'        => $request->input("lugar"),
            'coordinar'        => $request->input("coordinar"),
            'representante'        => $request->input("representante"),
            'usuario'        => $request->input("usuario")
        ]);

        // devuelve el mensaje de exito
        return back()->with('success', 'Enviado exitosamente!');
    }

    public function editar($id)
    {

        // llamar evento por id
        $event = Event::find($id);

        return view("evento/actualizar", [
            "evento" => $event
        ]);
    }



     public function actualizar(Request $request, $idevent)
     {

        $event = Event::find($idevent);


         $event->titulo = $request->input('nombre');

         $event->titulo = $request->input("titulo");
         $event->descripcion = $request->input("descripcion");
         $event->fecha= $request->input("fecha");
         $event->horaini= $request->input("hora");
         $event->lugar=$request->input("lugar");
         $event->coordinar= $request->input("coordinar");
         $event->representante = $request->input("representante");
         $event->usuario = $request->input("usuario");

         if ($event->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return back()->with('success', 'Actualizado exitosamente!');
     }

    public function details($dia, $mes, $anio)
    {
        // $mess=mesnumero($id2);
        $mess = $this->getmesnumero($mes);
        // llamar evento por id
        //$event = Event::find($id);

        $myDate = $anio . '/' . $mess . '/' . $dia;
        $date = Carbon::createFromFormat('Y/m/d', $myDate)->format('Y-m-d');
        $event = Event::where('fecha', $date)
            ->orderby('horaini', 'desc')
            ->get();


        //dd($event);

        $fecha2 = Carbon::parse($date);
   // $date = $fecha2->locale();
//dd($fecha->monthName);
      $fechaliteral = $fecha2->dayName.' '.$fecha2->day.' '.'de'.' '.$fecha2->monthName.' '.'del'.' '.$fecha2->year;


  return view("evento/evento", ["event" => $event, "date" => $date,"fechaliteral" => $fechaliteral]);
    }


    public function details2($fecha)
    {
        // $mess=mesnumero($id2);
        //$mess = $this->getmesnumero($mes);
        // llamar evento por id
        //$event = Event::find($id);

       // $myDate = $anio . '/' . $mess . '/' . $dia;
        ///$date = Carbon::createFromFormat('Y/m/d', $myDate)->format('Y-m-d');
        $event = Event::where('fecha', $fecha)
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


        $pdf = PDF::loadView('evento/pdf-evento', compact(['event', 'fecha', 'fechaliteral']));
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

        return view("evento/calendario", [
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

        return view("evento/calendario", [
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
                $datanew['evento'] = Event::where("fecha", $datafecha)
                    ->orderby('horaini', 'desc')
                    ->get();
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
}
