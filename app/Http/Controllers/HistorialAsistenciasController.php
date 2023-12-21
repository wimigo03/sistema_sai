<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaModel;
use App\Models\EmpleadosModel;
use App\Models\HistorialAsistenciasCambios;
use App\Models\LectorDactilarModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class HistorialAsistenciasController extends Controller
{




    public function index(Request $request)
    {
        if ($request->ajax()) {
            $historial = HistorialAsistenciasCambios::orderBy('created_at', 'desc')->get();


            $historial->transform(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->diffForHumans();
                $item->datos_anteriores = json_decode(html_entity_decode($item->datos_anteriores), true);
                // Agregar el botón con el ID
                $item->enlace_html = '<a href="' . route('restaurar-datos.restore', ['id' => $item->id]) . '"> <i class="fa-solid fa-2x fa-trash-can-arrow-up"></i></a>';

                $empleado = EmpleadosModel::where('idemp', $item->empleado_id)->select('nombres', 'ap_pat', 'ap_mat')->first();
                $item->nombre_empleado = $empleado ? $empleado->nombres : 'Desconocido';
                $item->apellidos_empleado = $empleado ? $empleado->ap_pat : '';
                $item->apellidos_empleado2 = $empleado ? $empleado->ap_mat : '';

                return $item;
            });
            return Datatables::of($historial)
                ->addColumn('boton_html', function ($row) {
                    return $row->enlace_html;
                })
                ->addColumn('nombre_empleado', function ($row) {
                    return $row->nombre_empleado . ' ' . $row->apellidos_empleado . ' ' . $row->apellidos_empleado2;
                })
                ->rawColumns(['boton_html'])
                ->toJson();
        }


        return view('asistencias.regularizar.historial');
    }

    public function personalHistorial(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $empleado = EmpleadosModel::where('idemp', $id)->select('idemp')->first();
            $id = $empleado->idemp;
            $selectedMonth = $request->input('selected_month');
            $historial =    HistorialAsistenciasCambios::whereHas('registroAsistencia', function ($query) use ($selectedMonth, $id) {
                $query->where('fecha', 'like', $selectedMonth . '%')
                    ->where('empleado_id', $id);
            })->get();





            $historial->transform(function ($item) {
                $item->created_at_formatted = Carbon::parse($item->created_at)->diffForHumans();
                $item->datos_anteriores = json_decode(html_entity_decode($item->datos_anteriores), true);
                // Agregar el botón con el ID
                $item->enlace_html = '<a href="' . route('restaurar-datos.restore', ['id' => $item->id]) . '"> <i class="fa-solid fa-2x fa-trash-can-arrow-up"></i></a>';

                $empleado = EmpleadosModel::where('idemp', $item->empleado_id)->select('nombres', 'ap_pat', 'ap_mat')->first();
                $item->nombre_empleado = $empleado ? $empleado->nombres : 'Desconocido';
                $item->apellidos_empleado = $empleado ? $empleado->ap_pat : '';
                $item->apellidos_empleado2 = $empleado ? $empleado->ap_mat : '';

                return $item;
            });
            return Datatables::of($historial)
                ->addColumn('boton_html', function ($row) {
                    return $row->enlace_html;
                })
                ->addColumn('nombre_empleado', function ($row) {
                    $nombreCompleto = implode('<br>', [
                        $row->nombre_empleado,
                        $row->apellidos_empleado,
                        $row->apellidos_empleado2,
                    ]);

                    return $nombreCompleto;
                })


                ->rawColumns(['boton_html', 'nombre_empleado'])
                ->toJson();
        }


        return view('asistencias.regularizar.historial');
    }
    public function verHistorial($id)
    {
        $historial = HistorialAsistenciasCambios::where('registro_asistencia_id', $id)->get();

        // Puedes pasar los datos del historial a una vista
        return view('historial.ver', compact('historial'));
    }



    public function restore($id)
    {
        // Obtén el historial por su ID
        $historial = HistorialAsistenciasCambios::find($id);

        if (!$historial) {
            abort(404); // o maneja de alguna manera el caso en que no se encuentre el registro
        }

        // Obtén los datos anteriores almacenados en formato JSON y decódificarlos
        $datosAnterioresJson = $historial->datos_anteriores;
        $datosAnterioresArray = json_decode($datosAnterioresJson, true);

        // Ahora, $datosAnterioresArray contiene los valores originales como un array asociativo
        // Puedes utilizar estos valores según tus necesidades
        $registro = RegistroAsistencia::find($datosAnterioresArray['id'])->select('fecha')->first();

        // Por ejemplo, podrías restaurar los datos en el modelo original
        // Supongamos que el modelo original es Usuario y el ID del usuario está en $datosAnterioresArray['usuario_id']
        RegistroAsistencia::find($datosAnterioresArray['id'])->update($datosAnterioresArray);
        // Elimina el historial restaurado
        $historial->empleado_id;
        $historial->registro_asistencia_id;
        $f2 = Carbon::parse($registro->fecha);
        $f = $f2->isoFormat('dddd D [de] MMMM');


        $registros2 = RegistroAsistencia::where('id', $historial->registro_asistencia_id)->get();

        foreach ($registros2 as $reg) {
            $this->verificarMarcado($reg);
            $this->calcularRetraso($reg);
        }


        $historial->delete();
        return redirect()->route('agregar.regulacion', ['id' =>  $historial->empleado_id])->with('success', 'Se restauro con éxito el Registro de Asistencia  del personal del día ' . $f);

        //  return view('asistencias.registros.fechas', compact('vistaselectedMonth', 'empleado'));
        //return view('asistencias.registros.fechas', compact('vistaselectedMonth', 'empleado'))->with('success', );
    }

    private function verificarMarcado(RegistroAsistencia $registro)
    {
        if ($registro->horario->tipo == 1) {
            if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 1;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->tipo = 1;
                $registro->estado = 2;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->tipo = 1;
                $registro->estado = 2;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 0;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 2;
                $registro->tipo = 1;
                $registro->save();
            }
        }
        if ($registro->horario->tipo == 0) {
            if (
                $registro->registro_final && $registro->registro_inicio
            ) {
                $registro->tipo = 0;
                $registro->estado = 1;
                $registro->save();
            } else if (!$registro->registro_final && $registro->registro_inicio) {
                $registro->estado = 2;
                $registro->tipo = 0;
                $registro->save();
            } else if ($registro->registro_final && !$registro->registro_inicio) {
                $registro->estado = 2;
                $registro->tipo = 0;
                $registro->save();
            } else {
                $registro->estado = 0;
                $registro->tipo = 0;
                $registro->save();
            }
        }
    }

    private function calcularRetraso(RegistroAsistencia $registro)
    {
        if ($registro->horario->tipo == 1) {

            $horaEntrada = Carbon::parse($registro->horario->hora_entrada);
            $horaInicio = Carbon::parse($registro->horario->hora_inicio);
            $excepcion = Carbon::parse($registro->horario->excepcion);

            if ($registro->registro_inicio && !$registro->registro_entrada) {

                $horaexcepcion = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaInicio = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaInicio);
                $horaEntradaReal = Carbon::parse($registro->registro_inicio);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso1 = $retraso;
                    $registro->minutos_retraso = $retraso;;

                    $registro->save();
                } else {
                    $registro->retraso1 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            } else if ($registro->registro_entrada && $registro->registro_inicio) {

                $horaexcepcion1 = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaInicio = $horaexcepcion1->format('H:i:s');

                $horaexcepcion2 = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaEntrada = $horaexcepcion2->format('H:i:s');

                $horaEntradaProgramada1 = Carbon::parse($horaInicio);
                $horaEntradaProgramada2 = Carbon::parse($horaEntrada);

                $horaEntradaReal1 = Carbon::parse($registro->registro_inicio);
                $horaEntradaReal2 = Carbon::parse($registro->registro_entrada);

                if ($horaEntradaReal1->greaterThan($horaEntradaProgramada1) || $horaEntradaReal2->greaterThan($horaEntradaProgramada2)) {

                    $retraso1 = $horaEntradaReal1->diffInMinutes($horaEntradaProgramada1);
                    $retraso2 = $horaEntradaReal2->diffInMinutes($horaEntradaProgramada2);
                    $registro->retraso1 = $retraso1;
                    $registro->retraso2 = $retraso2;
                    $registro->minutos_retraso = $retraso1 + $retraso2;
                    $registro->save();
                }
                //cuando se regulariza ambos
                else if (
                    $horaEntradaReal1->lessThanOrEqualTo($horaEntradaProgramada1) &&
                    $horaEntradaReal2->lessThanOrEqualTo($horaEntradaProgramada2)
                ) {
                    $registro->retraso1 = 0;
                    $registro->retraso2 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            } else if ($registro->registro_entrada && !$registro->registro_inicio) {

                $horaexcepcion = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaEntrada = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaEntrada);
                $horaEntradaReal = Carbon::parse($registro->registro_entrada);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso2 = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso2 = $retraso2;
                    $registro->minutos_retraso = $retraso2;
                    $registro->save();
                } else {
                    $registro->retraso2 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            }
        } else if ($registro->horario->tipo == 0) {


            $horaInicio = Carbon::parse($registro->horario->hora_inicio);
            $excepcion = Carbon::parse($registro->horario->excepcion);
            if ($registro->registro_inicio) {

                $horaexcepcion = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaInicio = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaInicio);
                $horaEntradaReal = Carbon::parse($registro->registro_inicio);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso1 = $retraso;
                    $registro->minutos_retraso = $retraso;;

                    $registro->save();
                } else {
                    $registro->retraso1 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            }
        }
    }
}
