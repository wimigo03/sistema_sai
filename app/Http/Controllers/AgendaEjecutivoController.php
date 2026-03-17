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
        return view('agenda-ejecutiva.calendario', compact('data', 'mes', 'mespanish'));
    }

    public function index_month($month)
    {
        $data = $this->calendar_month($month);
        $mes = $data['month'];
        $mespanish = $this->spanish_month($mes);
        $mes = $data['month'];
        return view('agenda-ejecutiva.calendario', compact('data', 'mes', 'mespanish'));
    }

    public function details($dia, $mes, $anio)
    {
        $mess = $this->getmesnumero($mes);
        $myDate = $anio . '/' . $mess . '/' . $dia;
        $date = Carbon::createFromFormat('Y/m/d', $myDate)->format('Y-m-d');
        $eventos = Evento::where('fecha', $date)->orderby('horaini', 'asc')->get();
        $fecha2 = Carbon::parse($date);
        $fechaliteral = ucfirst($fecha2->dayName) . ' ' . $fecha2->day . ' ' . 'de' . ' ' . $fecha2->monthName . ' ' . 'del' . ' ' . $fecha2->year;
        return view('agenda-ejecutiva.evento', compact('eventos', 'date', 'fechaliteral'));
    }

    public function show($id)
    {
        $evento = Evento::find($id);
        $fecha = Carbon::parse($evento->fecha);
        $fechaliteral = ucfirst($fecha->dayName) . ' ' . $fecha->day . ' ' . 'de' . ' ' . $fecha->monthName . ' ' . 'del' . ' ' . $fecha->year;
        return view('agenda-ejecutiva.show', compact('evento', 'fechaliteral'));
    }

    public function form($fecha)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $personal = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($personal->idemp)->empleadosareas;
        return view('agenda-ejecutiva.form', compact('fecha', 'personal'));
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
        $mes_literal = \IntlDateFormatter::create('es_ES', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE, 'UTC', \IntlDateFormatter::GREGORIAN, 'MMMM')->format($timestamp);
        $mes = ucfirst($mes_literal);
        $anho = date("Y", strtotime($request->fecha));

        return redirect()->route('agenda.ejecutiva.detalle', ['id' => $dia, 'id2' => $mes, 'id3' => $anho])->with('success_message', '[Evento creado correctamente.]');
    }

    public function details2($fecha)
    {
        $eventos = Evento::where('fecha', $fecha)->orderby('horaini', 'desc')->get();
        $fecha2 = Carbon::parse($fecha);
        $fechaliteral = $fecha2->dayName . ' ' . $fecha2->day . ' ' . 'de' . ' ' . $fecha2->monthName . ' ' . 'del' . ' ' . $fecha2->year;
        $pdf = PDF::loadView('agenda-ejecutiva.pdf-evento', compact(['eventos', 'fecha', 'fechaliteral']));
        $pdf->setPaper('LETTER', 'landscape');
        return $pdf->stream();
    }

    public function editar($id)
    {
        $evento = Evento::find($id);
        return view('agenda-ejecutiva.actualizar', compact('evento'));
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
        $mes_literal = \IntlDateFormatter::create('es_ES', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE, 'UTC', \IntlDateFormatter::GREGORIAN, 'MMMM')->format($timestamp);
        $mes = ucfirst($mes_literal);
        $anho = date("Y", strtotime($request->fecha));

        return redirect()->route('agenda.ejecutiva.detalle', ['id' => $dia, 'id2' => $mes, 'id3' => $anho])->with('success_message', '[Evento actualizado correctamente.]');
    }

    public static function calendar_month($month)
    {
        $mes = $month;

        // Primer y último día del mes
        $firstDayOfMonth = date("Y-m-01", strtotime($mes));
        $lastDayOfMonth  = date("Y-m-t", strtotime($mes));

        // INICIO del calendario visual: lunes de la semana donde cae el día 1
        $startTimestamp = strtotime($firstDayOfMonth);
        $dayOfWeekStart = (int)date("N", $startTimestamp); // 1=lunes, 7=domingo
        $daysBack = $dayOfWeekStart - 1;
        $startTimestamp = $startTimestamp - ($daysBack * 86400);
        $dateini = date("Y-m-d", $startTimestamp);

        // FIN del calendario visual: domingo de la semana donde cae el último día
        $endTimestamp = strtotime($lastDayOfMonth);
        $dayOfWeekEnd = (int)date("N", $endTimestamp); // 1=lunes, 7=domingo
        $daysForward = 7 - $dayOfWeekEnd;
        $endTimestamp = $endTimestamp + ($daysForward * 86400);
        $dateend = date("Y-m-d", $endTimestamp);

        // Cantidad real de semanas visibles
        $totalDays = ((strtotime($dateend) - strtotime($dateini)) / 86400) + 1;
        $semana = (int)($totalDays / 7);

        $datafecha = $dateini;
        $calendario = array();

        for ($iweek = 1; $iweek <= $semana; $iweek++) {
            $weekdata = [];

            for ($iday = 0; $iday < 7; $iday++) {
                $datanew = [];
                $datanew['mes'] = date("M", strtotime($datafecha));
                $datanew['dia'] = date("d", strtotime($datafecha));
                $datanew['fecha'] = $datafecha;
                $datanew['evento'] = Evento::where("fecha", $datafecha)
                    ->orderBy('horaini', 'desc')
                    ->get();

                $weekdata[] = $datanew;

                // avanzar al siguiente día DESPUÉS de guardar el actual
                $datafecha = date("Y-m-d", strtotime($datafecha . " +1 day"));
            }

            $dataweek = [];
            $dataweek['semana'] = $iweek;
            $dataweek['datos'] = $weekdata;

            $calendario[] = $dataweek;
        }

        $nextmonth = date("Y-M", strtotime($mes . " +1 month"));
        $lastmonth = date("Y-M", strtotime($mes . " -1 month"));
        $monthName = date("M", strtotime($mes));
        $yearmonth = date("Y", strtotime($mes));

        return array(
            'next' => $nextmonth,
            'month' => $monthName,
            'year' => $yearmonth,
            'last' => $lastmonth,
            'calendar' => $calendario,
        );
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
        } elseif ($month == "Nov") {
            $mes = "Noviembre";
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
