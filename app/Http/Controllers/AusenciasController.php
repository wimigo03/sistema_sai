<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAusenciasRequest;
use App\Models\AsistenciaModel;
use App\Models\EmpleadoLicenciasModel;
use App\Models\EmpleadoPermisoModel;
use App\Models\EmpleadosModel;
use App\Models\HistorialAsistenciasCambios;
use App\Models\HorarioModel;
use App\Models\LicenciasRipModel;
use App\Models\PermisoModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class AusenciasController extends Controller
{

    public function index(Request $request)
    {


        if ($request->ajax()) {

            $data = RegistroAsistencia::with(['empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
            }])->whereNotIn('estado', [0, 1])
                ->with('asistencia')
                ->get();


            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->asistencia->fecha ? Carbon::parse($row->asistencia->fecha)->format('Y-m-d') : '-';
                })
                ->addColumn('nombres_apellidos', function ($row) {
                    $nomb = $row->empleado->nombres ?? '-';
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $nomb . ' ' . $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('estado', function ($row) {
                    if ($row->estado == 0) {
                        return 'FALTA';
                    } else if ($row->estado == 2) {
                        return 'FALTA';
                    } else {
                        return 'Marcado'; // You can customize this message as needed
                    }
                })
                ->addColumn('opciones', function ($row) {
                    $url = route('regularizar.ausencia', ['id' => $row->id]);

                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Ausencia" href="' . $url . '">
                    <i class="fa-solid fa-2xl fa fa-clock" aria-hidden="true"></i>
                            </a>';
                })

                ->rawColumns(['opciones'])

                ->make(true);
        }

        return view('asistencias.regularizar.index');
    }




    public function regularizar($id)
    {
        $añoMesActual = Carbon::now()->format('Y-m');
        $permisoID =  $this->obtenerOCrearPermiso($añoMesActual);

        $año = Carbon::now()->format('Y');
        $licencia =  $this->obtenerOCrearLicencia($año);
        $licenciaID = $licencia->id;
        $registroAsistencia = RegistroAsistencia::with([
            'empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat', 'tipo');
            },
            'horario',
            'asistencia'
        ])->find($id);
        //dd($registroAsistencia);
        if ($registroAsistencia->horario->tipo == 0) {
            $opciones = explode(',', $registroAsistencia->observ);

            $permisos = EmpleadoPermisoModel::where('fecha_solicitud', $registroAsistencia->fecha)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->where('hora_retorno', '>', $registroAsistencia->horario->hora_final)
                ->get();
            $permisTotal = EmpleadoPermisoModel::where('permiso_id', $permisoID->id)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->orderBy('fecha_solicitud', 'desc')
                ->get();
            $sumaPermisos = EmpleadoPermisoModel::where('permiso_id', $permisoID->id)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->sum('horas_utilizadas');

            $licencia  = EmpleadoLicenciasModel::where('fecha_solicitud',  $registroAsistencia->fecha)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->get();
            $licenciaTotal = EmpleadoLicenciasModel::where('licencia_id', $licenciaID)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->orderBy('fecha_solicitud', 'desc')
                ->get();

            $sumaLicencias = EmpleadoLicenciasModel::where('licencia_id',  $licenciaID)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->sum('dias_utilizados');
            // $tiempoTexto = $this->convertirHorasMinutosATexto($sumaPermisos);
            // dd($permiso);
            return view('asistencias.regularizar.manual', compact('opciones','licenciaTotal', 'sumaLicencias', 'licencia', 'permisTotal', 'sumaPermisos', 'permisoID', 'permisos', 'registroAsistencia'));
        } else if ($registroAsistencia->horario->tipo == 1) {


            $opciones = explode(',', $registroAsistencia->observ);


            $permisos = EmpleadoPermisoModel::where('fecha_solicitud', $registroAsistencia->fecha)->where('empleado_id', $registroAsistencia->empleado_id)
                ->where('hora_retorno', '>', [$registroAsistencia->horario->hora_salida, $registroAsistencia->horario->hora_final])
                ->get();
            $permisTotal = EmpleadoPermisoModel::where('permiso_id', $permisoID->id)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->orderBy('fecha_solicitud', 'desc')
                ->get();
            // dd($permisos);

            $sumaPermisos = EmpleadoPermisoModel::where('permiso_id', $permisoID->id)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->sum('horas_utilizadas');

            $licencia  = EmpleadoLicenciasModel::where('fecha_solicitud',  $registroAsistencia->fecha)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->get();
            $licenciaTotal = EmpleadoLicenciasModel::where('licencia_id', $licenciaID)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->orderBy('fecha_solicitud', 'desc')
                ->get();
            $sumaLicencias = EmpleadoLicenciasModel::where('licencia_id',  $licenciaID)
                ->where('empleado_id', $registroAsistencia->empleado_id)
                ->sum('dias_utilizados');
            // $tiempoTexto = $this->convertirHorasMinutosATexto($sumaPermisos);
            //dd($sumaLicencias);

            return view('asistencias.regularizar.manual', compact('opciones','licenciaTotal', 'sumaLicencias', 'licencia', 'permisTotal', 'sumaPermisos', 'permisoID', 'permisos', 'registroAsistencia'));
        }

        // Asegúrate de que $data no sea nulo antes de pasar los datos a la vista
        if (!$registroAsistencia) {
            abort(404); // o maneja de alguna manera el caso en que no se encuentre el registro
        }
    }

    public function crear($fecha, $id)
    {
        try {
            $añoMesActual = Carbon::now()->format('Y-m');
            $permisoID =  $this->obtenerOCrearPermiso($añoMesActual);


            $empleado = EmpleadosModel::select('idemp', 'nombres', 'ap_pat', 'ap_mat')
                ->where('idemp', $id)
                ->first();
            // Si la fecha es anterior a hoy
            if (Carbon::parse($fecha)->isAfter(Carbon::now())) {
                $horario = $empleado->horarios()->where('estado', 1)->first();
            } else {
                $horario = HorarioModel::whereHas('registrosAsistencia', function ($query) use ($fecha) {
                    $query->where('fecha', $fecha);
                })->select('id', 'tipo', 'Nombre', 'hora_inicio', 'hora_final', 'hora_entrada', 'hora_salida')->first();
            }


            $vistaselectedMonth = Carbon::parse($fecha)->format('Y-m');
            $f2 = Carbon::parse($fecha);
            $f = $f2->isoFormat('dddd D [de] MMMM');


            if (!$horario) {
                return redirect()->route('horarios.fechas', compact('vistaselectedMonth'))->with('error', 'Seleccione un Horario. NO HAY HORARIO ACTIVO O PROGRAMADO para el día ' . $f);
                //return view('asistencias.horarios.fechas',compact('vistaselectedMonth'))->with('error', 'Seleccione un Horario. NO HAY HORARIO ACTIVO O PROGRAMADO');
            }
            $horarioId = $horario->id;

            // $permiso = EmpleadoPermisoModel::where('fecha_solicitud', '2023-12-15')->where('empleado_id', 1)->where('hora_retorno', '>', '12:30:00')->first();

            $asistencia = AsistenciaModel::where('fecha', $fecha)->select('id')->first();
            if (!$asistencia) {
                $asistencia = $this->CrearAsistencia($fecha);
            }

            $registroAsistencia = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                ->where('asistencia_id', $asistencia->id)->first();

            if (!$registroAsistencia) {
                $registroAsistencia = new RegistroAsistencia();
                $registroAsistencia->empleado_id = $empleado->idemp;
                $registroAsistencia->horario_id = $horarioId;
                $registroAsistencia->fecha = $fecha;
                $registroAsistencia->estado = 0;
                $registroAsistencia->asistencia_id = $asistencia->id;
                $registroAsistencia->save();
            }
            $id = $registroAsistencia->id;



            return redirect()->route('regularizar.ausencia', ['id' =>  $id])->with('success', 'Regularizado correctamente la asistencia del día: ' . $fecha);
        } catch (\Exception $e) {
            // Catch any exception that may occur and return an error message
            abort(404); // o maneja de alguna manera el caso en que no se encuentre el registro
        }
    }

    public function regularizar2(Request $request)
    {
        // Definir $selectedMonth fuera del bloque if para que esté disponible en ambos casos
        // Asignar un valor predeterminado a $selectedMonth
        // $vistaselectedMonth = Carbon::now()->format('Y-m');


        if ($request->ajax()) {
            $id = $request->input('id');
            $empleado = EmpleadosModel::where('idemp', $id)->select('idemp', 'nombres', 'ap_pat', 'ap_mat')->first();
            $id = $empleado->idemp;
            // Obtener la fecha seleccionada desde el input de tipo month
            $selectedMonth = $request->input('selected_month');
            $formattedDate = $selectedMonth . '-01'; // Añade el primer día del mes



            // Verificar si no se proporcionó una fecha seleccionada y usar el mes actual
            if (!$selectedMonth) {
                $selectedMonth = Carbon::now()->format('Y-m');
                $formattedDate = $selectedMonth . '-01'; // Añade el primer día del mes
            }
            $firstDay = Carbon::createFromFormat('Y-m-d', $formattedDate)->startOfMonth();
            $lastDay = Carbon::createFromFormat('Y-m-d', $formattedDate)->endOfMonth();



            // Obtener todos los días del mes actual organizados por semanas
            $weeksInMonth = $this->getWeeksInMonth($firstDay, $lastDay, $selectedMonth);

            // Transformar los datos en un formato compatible con DataTables
            $data = $this->transformDataForDataTables($weeksInMonth, $selectedMonth, $id);

            return DataTables::of($data)->make(true);
        }

        return redirect()->route('agregar.regulacion', ['id' => 'id'])->with('success', 'Regularizado correctamente la asistencia del día: ');
    }

    private function getWeeksInMonth($start, $end, $selectedMonth)
    {
        $weeks = [];
        $currentWeek = [];

        // Calcular el número de días a agregar del mes anterior
        $daysToAdd = $start->dayOfWeek === Carbon::SUNDAY ? 6 : $start->dayOfWeek - 1;

        // Agregar días del mes anterior si la primera semana no comienza en lunes
        for ($i = $daysToAdd; $i > 0; $i--) {
            $currentWeek[] = $start->copy()->subDay($i);
        }

        while ($start <= $end) {
            $currentWeek[] = $start->copy();

            if ($start->dayOfWeek == Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth()->format('D')) {
                $weeks[] = $currentWeek;
                $currentWeek = [];
            }

            $start->addDay();
        }

        // Agregar días del mes posterior si la última semana no está completa
        $remainingDays = 7 - count($currentWeek);
        for ($i = 0; $i <= $remainingDays; $i++) {
            $currentWeek[] = $start->copy()->addDay($i);
        }

        // Agregar la última semana si es necesario
        if (!empty($currentWeek)) {
            $weeks[] = $currentWeek;
        }

        return $weeks;
    }


    private function transformDataForDataTables($weeksInMonth, $selectedMonth, $id)
    {
        $data = [];

        // Obtener todos los datos del mes de una vez
        $allData = $this->getDataForMonth($weeksInMonth[0][0], end($weeksInMonth[count($weeksInMonth) - 1]), $id);


        foreach ($weeksInMonth as $week) {
            $rowData = [];
            $rowData[] = $week[0] ? $week[0]->weekOfYear : null; // Agregar la columna de semana

            foreach ($week as $day) {
                // Aquí puedes agregar la información adicional que desees mostrar en la celda
                $cellData = [
                    'day' => $day ? $day->format('d') : null,
                    'additional_info' => $this->getDataForDate($day, $allData),
                    'date' => $day ? $day->format('Y-m-d') : null,
                    'actual' => $day && Carbon::parse($day)->format('m') == Carbon::parse($selectedMonth)->format('m') ? true : false,
                    'empleado_id' => $id
                    // Agrega más información según sea necesario
                ];
                $rowData[] = $cellData;
            }

            // Llenar con nulos para completar la última semana
            while (count($rowData) < 7) {
                $rowData[] = null;
            }

            $data[] = $rowData;
        }

        return $data;
    }

    private function getDataForDate($date, $allData)
    {
        // Filtrar los datos correspondientes a la fecha
        $filteredData = $allData->where('fecha', $date->toDateString());

        // Puedes procesar $filteredData según tus necesidades y devolver la información deseada
        return $filteredData;
    }


    private function getDataForMonth($start, $end, $employeeId)
    {
        // Realizar una sola consulta para obtener todos los datos del mes para un empleado específico
        return RegistroAsistencia::where('empleado_id', $employeeId)
            ->whereBetween('fecha', [$start->toDateString(), $end->toDateString()])
            ->select('id', 'fecha', 'estado', 'observ')
            ->get();
    }

    public function update(UpdateAusenciasRequest $request, $id)
    {
        try {
            $request->validated();

            //Encuentro el registro

            $registro = RegistroAsistencia::where('id', $id)->first();

            if (Auth::check()) {
                $usuario_creacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
            }
            //busco historial
            $id = $registro->id;
            $fecha  = request('fecha');

            // Guarda los datos anteriores en el historial

            $historial = HistorialAsistenciasCambios::where('registro_asistencia_id', $id)->first();

            if (!$historial) {
                $historial = new HistorialAsistenciasCambios;
                $historial->registro_asistencia_id = $registro->id;
                $historial->usuario_mod = Auth::user()->name;
                $historial->empleado_id = $registro->empleado_id;
                $historial->datos_anteriores = json_encode($registro->toArray());
                $historial->save();
            } else {
                $historial->registro_asistencia_id = $registro->id;
                $historial->usuario_mod = Auth::user()->name;
                $historial->empleado_id = $registro->empleado_id;
                $historial->datos_anteriores = json_encode($registro->toArray());
                $historial->save();
            }

            $registroF = RegistroAsistencia::where('id', $id)->get();

            foreach ($registroF as $registro) {
                $this->verificarMarcado($registro);
                $this->calcularRetraso($registro);
            }

            // Actualiza los datos del registro de asistencia
            $registro->update($request->all());

            foreach ($registroF as $registro) {
                $this->verificarMarcado($registro);

                $this->calcularRetraso($registro);
            }
            $f2 = Carbon::parse($fecha);
            $f = $f2->isoFormat('dddd D [de] MMMM');

            // Puedes redirigir a la vista de detalles o a donde desees
            // Puedes redirigir a la vista de detalles o a donde desees
            return redirect()->route('agregar.regulacion', ['id' => $registro->empleado_id])->with('success', 'Regularizado correctamente la asistencia del dia : ' . $f);
        } catch (\Exception $e) {
            // Manejo de errores aquí
            return back()->withError('Error al actualizar el registro: ' . $e->getMessage());
        }
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

    private function CrearAsistencia($fecha)
    {
        // Verificar si el mes es posterior al mes actual
        if (Carbon::now()->format('Y-m-d') < $fecha) {
            // Si es posterior, obtener o crear el permiso del mes actual
            $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id')->first();
            if (!$asistenciaActual) {
                $asistenciaActual = AsistenciaModel::create(['fecha' => $fecha, 'descrip' => "Activo", 'estado' => '0']);
            }

            return $asistenciaActual;
        }

        // Si no es posterior, obtener o crear el permiso del mes proporcionado
        $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id')->first();

        if (!$asistenciaActual) {
            $asistenciaActual = AsistenciaModel::create([
                'fecha' => $fecha,
                'descrip' => 'Personal',
                'estado' => '1'
            ]);
        }



        return $asistenciaActual;
    }

    private function obtenerOCrearPermiso($añoMes)
    {
        // Verificar si el mes es posterior al mes actual
        if (Carbon::now()->format('Y-m') < $añoMes) {
            // Si es posterior, obtener o crear el permiso del mes actual
            $permisoActual = PermisoModel::where('mes', Carbon::now()->format('Y-m'))->first();

            if (!$permisoActual) {
                $permisoActual = PermisoModel::create(['mes' => Carbon::now()->format('Y-m'), 'horas_permitidas' => 120]);
            }

            return $permisoActual;
        }

        // Si no es posterior, obtener o crear el permiso del mes proporcionado
        $permiso = PermisoModel::where('mes', $añoMes)->first();

        if (!$permiso) {
            $permiso = PermisoModel::create(['mes' => $añoMes, 'horas_permitidas' => 120]);
        }

        return $permiso;
    }

    function convertirHorasMinutosATexto($horas_permitidas)
    {
        $horas = floor($horas_permitidas / 60);
        $minutos = $horas_permitidas % 60;

        // Genera una representación textual
        $texto = '';

        if ($horas > 0) {
            $texto .= $horas . ' hora' . ($horas > 1 ? 's' : '') . ' ';
        }

        if ($minutos > 0) {
            $texto .= $minutos . ' minuto' . ($minutos > 1 ? 's' : '');
        }

        return $texto;
    }

    private function obtenerOCrearLicencia($añoActual)
    {
        $licencia = LicenciasRipModel::where('licencia', $añoActual)->first();

        if (!$licencia) {
            $licencia = LicenciasRipModel::create(['licencia' => $añoActual, 'dias_permitidos' => 48]);
        }
        return $licencia;
    }
}
