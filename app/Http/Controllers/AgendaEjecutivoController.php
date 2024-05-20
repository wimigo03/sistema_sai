<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaModel;
use App\Models\Evento;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Empleado;
use Illuminate\Support\Facades\Auth;
use PDF;

class AgendaEjecutivoController extends Controller
{
    public function index()
    {
        $month = date("Y-m");
        $data = $this->calendar_month($month);
        $mes = $data['month'];
        $mespanish = $this->spanish_month($mes);
        $mes = $data['month'];
        return view('agenda-ejecutiva.calendario',compact('data','mes','mespanish'));
    }

    public function index_month($month)
    {
        $data = $this->calendar_month($month);
        $mes = $data['month'];
        $mespanish = $this->spanish_month($mes);
        $mes = $data['month'];
        return view('agenda-ejecutiva.calendario',compact('data','mes','mespanish'));
    }

    public function details($dia, $mes, $anio)
    {
        $mess = $this->getmesnumero($mes);
        $myDate = $anio . '/' . $mess . '/' . $dia;
        $date = Carbon::createFromFormat('Y/m/d', $myDate)->format('Y-m-d');
        $eventos = Evento::where('fecha', $date)->orderby('horaini', 'asc')->get();
        $fecha2 = Carbon::parse($date);
        $fechaliteral = ucfirst($fecha2->dayName) . ' ' . $fecha2->day . ' ' . 'de' . ' ' . $fecha2->monthName . ' ' . 'del' . ' ' . $fecha2->year;
        return view('agenda-ejecutiva.evento',compact('eventos','date','fechaliteral'));
    }

    public function show($id)
    {
        $evento = Evento::find($id);
        $fecha = Carbon::parse($evento->fecha);
        $fechaliteral = ucfirst($fecha->dayName) . ' ' . $fecha->day . ' ' . 'de' . ' ' . $fecha->monthName . ' ' . 'del' . ' ' . $fecha->year;
        return view('agenda-ejecutiva.show',compact('evento','fechaliteral'));
    }

    public function form($fecha)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $personal = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($personal->idemp)->empleadosareas;
        return view('agenda-ejecutiva.form',compact('fecha','personal'));
    }

    public function create(Request $request)
    {
        Evento::insert([
            'titulo'       => $request->input("titulo"),
            'descripcion'  => $request->input("descripcion"),
            'fecha'        => $request->input("fecha"),
            'horaini'        => $request->input("hora"),
            'lugar'        => $request->input("lugar"),
            'coordinar'        => $request->input("coordinar"),
            'representante'        => $request->input("representante"),
            'usuario'        => $request->input("usuario")
        ]);

        $dia = date("d", strtotime($request->fecha));
        $timestamp = strtotime($request->fecha);
        $mes_literal = \IntlDateFormatter::create('es_ES',\IntlDateFormatter::FULL,\IntlDateFormatter::NONE,'UTC',\IntlDateFormatter::GREGORIAN,'MMMM')->format($timestamp);
        $mes = ucfirst($mes_literal);
        $anho = date("Y", strtotime($request->fecha));

        return redirect()->route('agenda.ejecutiva.detalle',['id' => $dia,'id2' => $mes,'id3' => $anho])->with('success_message', '[Evento creado correctamente.]');
    }

    public function details2($fecha)
    {
        $eventos = Evento::where('fecha', $fecha)->orderby('horaini', 'desc')->get();
        $fecha2 = Carbon::parse($fecha);
        $fechaliteral = $fecha2->dayName.' '.$fecha2->day.' '.'de'.' '.$fecha2->monthName.' '.'del'.' '.$fecha2->year;
        $pdf = PDF::loadView('agenda-ejecutiva.pdf-evento', compact(['eventos', 'fecha', 'fechaliteral']));
        $pdf->setPaper('LETTER', 'landscape');
        return $pdf->stream();
    }

    public function editar($id)
    {
        $evento = Evento::find($id);
        return view('agenda-ejecutiva.actualizar',compact('evento'));
    }

    public function actualizar(Request $request)
    {
        $evento = Evento::find($request->evento_id);
        $evento->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'horaini' => $request->hora,
            'lugar' => $request->lugar,
            'coordinar' => $request->coordinar,
            'representante' => $request->representante,
            'usuario' => $request->usuario,
        ]);

        $dia = date("d", strtotime($request->fecha));
        $timestamp = strtotime($request->fecha);
        $mes_literal = \IntlDateFormatter::create('es_ES',\IntlDateFormatter::FULL,\IntlDateFormatter::NONE,'UTC',\IntlDateFormatter::GREGORIAN,'MMMM')->format($timestamp);
        $mes = ucfirst($mes_literal);
        $anho = date("Y", strtotime($request->fecha));

        return redirect()->route('agenda.ejecutiva.detalle',['id' => $dia,'id2' => $mes,'id3' => $anho])->with('success_message', '[Evento actualizado correctamente.]');
    }

    public static function calendar_month($month)
    {
        $mes = $month;
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
                $datanew['evento'] = Evento::where("fecha", $datafecha)
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
