<?php

namespace App\Http\Controllers;

use App\Models\EmpleadosModel;
use App\Models\RegistroAsistencia;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class RetrasoController extends Controller
{
    public function indejx(Request $request)
    {
        $fechaHoy = Carbon::now()->format('Y-m');

        if ($request->ajax()) {

            $filtro = $request->input('filtro', 'fechaHoy');
            $filtro = Carbon::parse($filtro);

            $mesAnio = $filtro->format('Y-m');

            $data = RegistroAsistencia::with('empleado')->where('minutos_retraso', '>', 0)
                ->where('fecha', 'like', $mesAnio . '%');

            $fechaHoy = Carbon::now()->toDateString();


            // Aplicar el filtro de fecha según el valor seleccionado
            $filtro = $request->input('filtro');
            $filtro = Carbon::parse($filtro)->format('Y-m-d');

            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->fecha ?: '-';
                })
                ->addColumn('nombres', function ($row) {
                    return $row->empleado->nombres ?? '-';
                })
                ->addColumn('apellidos', function ($row) {
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('minutos', function ($row) {
                    return $row->minutos_retraso ?? '-';
                })
                ->make(true);
        }
        $filtro = $request->input('filtro', 'actual');

        return view('asistencias.retrasos.index', compact('filtro', 'fechaHoy'));
    }





    public function index()
    {
        $fechaInicio = '2024-01-01';
        $fechaFin = '2024-02-29';
        $arregloEmpleados =  EmpleadosModel::pluck('idemp')->toArray();
        $registrosPorEmpleado = [];

        foreach ($arregloEmpleados as $empleado_id) {
            $registrosPorEmpleado[$empleado_id] = $this->mostrarRegistrosPorEmpleado($empleado_id,  $fechaInicio,  $fechaFin);
        }



        return view('asistencias.retrasos.indeFx', compact('registrosPorEmpleado'));
    }

    public function mostrarRegistrosPorEmpleado($empleado_id,$fechaInicio,  $fechaFin)
    {
      

        // Generar un arreglo de fechas dentro del rango deseado
        $fechas = [];
        $fechaActual = Carbon::parse($fechaInicio);
        $fechaFinCarbon = Carbon::parse($fechaFin);
        while ($fechaActual->lte($fechaFinCarbon)) {
            $fechas[] = $fechaActual->toDateString();
            $fechaActual->addDay();
        }

        // Obtener los registros de asistencia para las fechas dentro del rango
        $data = RegistroAsistencia::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->where('empleado_id', $empleado_id)
            ->get();



        // Combinar los registros con las fechas, rellenando los días sin registros con valores nulos
        $registros = [];
        foreach ($fechas as $fecha) {
            $reg = $data->where('fecha', $fecha)->first();

            if ($reg) {
                $nom = $reg->empleado->nombres ?? '-';
                $ap_pat = $reg->empleado->ap_pat ?? '-';
                $ap_mat = $reg->empleado->ap_mat ?? '-';
                $nombreEmpleado = implode("", [$nom, $ap_pat, $ap_mat]);

                $nombreEmpleado = $nom . '\n' . $ap_pat . '\n' . $ap_mat;
                $hi = $reg->horario->hora_inicio ? Carbon::parse($reg->horario->hora_inicio)->format('H:i') : '-';

                $hf = $reg->horario->hora_final ? Carbon::parse($reg->horario->hora_final)->format('H:i') : '-';

                $hs = $reg->horario->hora_salida ? Carbon::parse($reg->horario->hora_salida)->format('H:i') : '-';
                $he = $reg->horario->hora_entrada ? Carbon::parse($reg->horario->hora_entrada)->format('H:i') : '-';
                $hn = $reg->horario->Nombre;
                $ht = $reg->horario->tipo;

                $est = $reg->estado;
                $ovb = $reg->observ;


                // Ajusta el nombre de la relación según corresponda en tu modelo
                $reg->ht = $ht;
                $reg->hs = $hs;
                $reg->he = $he;
                $reg->hi = $hi;
                $reg->hf = $hf;
                $reg->hn = $hn;
                $reg->est =  $est;
                $reg->ovb =  $ovb;



                $reg->nombre_empleado = $nombreEmpleado;
                $registros[] = $reg;
            } else {
                // Si no hay registro para esta fecha, agregar un objeto con valores nulos

                $registros[] = (object) [
                    'id' => null,
                    'fecha' => $fecha,
                    'minutos_retraso' => null,
                    'registro_inicio' => null,
                    'registro_salida' => null,
                    'registro_entrada' => null,
                    'registro_final' => null,
                    'nombre_empleado' => null,
                    'hi' => null,
                    'hf' => null,
                    'he' => null,
                    'hs' => null,
                    'hn' => null,
                    'est' => null,
                    'ovb' => null,
                    'ht' => null

                    // Agregar más propiedades según tus necesidades
                ];
            }
        }
        return $registros;
    }
}
