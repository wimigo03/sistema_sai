<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use App\Models\EmpleadosModel;
use App\Models\RegistroAsistencia;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;
use DateTime;



use Illuminate\Support\Facades\Session;



class RegistroAsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function calcularRetraso(RegistroAsistencia $registro)
    {
        if ($registro->horario) {
            $horaEntradaProgramada = Carbon::parse($registro->horario->excepcion);
            $horaEntradaReal = Carbon::parse($registro->registro_entrada);


            if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {
                $minutosRetraso = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
            } else {
                $minutosRetraso = 0;
            }

            // Actualizar el campo "minutos_retraso" en el registro de asistencia
            $registro->minutos_retraso = $minutosRetraso;
            $registro->save();
        }
    }

    private function sumarRetrasos(RegistroAsistencia $registro)
    {

        $emp_id = $registro->empleado_id;

        $sumaRetraso = RegistroAsistencia::whereDate('created_at', Carbon::today())
            ->where('empleado_id', $emp_id)
            ->sum('minutos_retraso');

        $retraso_emp = RetrasosEmpleado::whereDate('created_at', Carbon::today())
            ->where('empleado_id', $emp_id)->first();
        if ($retraso_emp) {

            $retraso_emp->empleado_id = $emp_id;

            $retraso_emp->minutos_diario = $sumaRetraso;
            $retraso_emp->save();
        } else {
            $retraso_emp =  new RetrasosEmpleado();

            $retraso_emp->empleado_id = $emp_id;
            $retraso_emp->minutos_diario = $sumaRetraso;
            $retraso_emp->save();
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $filtro = $request->input('filtro', 'actual');
            $data = RegistroAsistencia::with('empleado', 'horario');

            // Aplicar el filtro de fecha según el valor seleccionado
            $filtro = $request->input('filtro');
            if ($filtro == 'actual') {
                $data = $data->whereDate('created_at', Carbon::today());
            } elseif ($filtro == 'mensual') {
                $data = $data->whereMonth('created_at', Carbon::now()->month);
            }

            $data = $data->get();
            return DataTables::of($data)
                ->addColumn('fecha', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '-';
                })
                ->addColumn('horario', function ($row) {
                    return $row->horario->Nombre ?? '-';
                })
                ->addColumn('nom_ap', function ($row) {
                    $nom = $row->empleado->nombres;
                    $ap_pat = $row->empleado->ap_pat ?? '-';
                    $ap_mat = $row->empleado->ap_mat ?? '-';
                    return $nom . ' ' . $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('registro_entrada', function ($row) {
                    return $row->registro_entrada ? Carbon::parse($row->registro_entrada)->format('H:i') : '-';
                })
                ->addColumn('registro_salida', function ($row) {
                    return $row->registro_salida ? Carbon::parse($row->registro_salida)->format('H:i') : '-';
                })
                ->addColumn('minutos_retraso', function ($row) {
                    return $row->minutos_retraso ?? 'vacio';
                })
                ->rawColumns(['registro_entrada', 'registro_salida'])
                ->make(true);
        }

        // Pasar el valor del filtro a la vista
        $filtro = $request->input('filtro', 'actual');
        return view('asistencias.registros.index', compact('filtro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('asistencias.registros.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'pin' => 'required_without:id', // El PIN o el ID son obligatorios, pero no ambos
            'id' => 'required_without:pin',
            'fecha' => 'required',
            'hora' => 'required|date_format:H:i:s',
        ]);

        // Obtener el PIN enviado en el formulario

        $pin = $request->input('pin');
        $id = $request->input('id');
        if (!empty($pin)) {
            $emp = EmpleadosModel::where('pin', $pin)->first();
        }

        if (empty($emp) && !empty($id)) {
            $emp = EmpleadosModel::find($id);
        }

        $horaActual = $request->input('hora');

        $horaActualCarbon = Carbon::parse($horaActual);
        $horaMinima = $horaActualCarbon->subMinutes(20)->format('H:i:s');
        $horaMaxima = $horaActualCarbon->addMinutes(20)->format('H:i:s');
        // Buscar al empleado por su PIN
        $emp = EmpleadosModel::where('pin', $pin)->first();

        // Si el empleado existe, busca el horario activo del empleado
        if ($emp) {

            $horario = $emp->horarios()
                ->where('hora_entrada', '<=', $horaMaxima)
                ->where('hora_salida', '>=', $horaMinima)
                ->where('estado', 1)->first();
            $horariosAsignados = $emp->horarios()
                ->where('estado', 1)->pluck('Nombre')->implode(' - ');

            $horariosCount = $emp->horarios()
                ->where('estado', 1)->count();

            if ($horario) {
                $horarioId = $horario->id;


                $registro = $emp->registrosAsistencia()
                    ->whereDate('created_at', Carbon::today())
                    ->where('horario_id', $horarioId)
                    ->first();


                // Si el registro existe, busca el fecha del registro
                // Continúa con el registro de asistencia utilizando el $horarioId
                if ($registro) {
                    if ($horaActual >= $horario->hora_salida && $horaActual <= $horaMaxima) {
                        if (!$registro->registro_salida) {
                            $registro->registro_salida = $horaActual;
                            $registro->save();

                            $this->sumarRetrasos($registro);

                            Session::flash('success', 'Registro de salida guardado exitosamente.' . $registro->minutos_retraso . ' Registro de salida .' . $registro->fecha . ' Horario:' . $registro->horario->Nombre . '  Horarios asignados: ' . $horariosAsignados);
                            return redirect()->back();
                        } else {
                            Session::flash('error', 'El empleado ' . $registro->empleado->nombres . ' ya registró su salida .' . $registro->registro_salida . ' Horario:' . $registro->horario->Nombre . '  Horarios asignados: ' . $horariosAsignados);
                            return redirect()->back();
                        }
                    } else if (!$registro->registro_entrada) {
                        $registro->registro_entrada = $horaActual;
                        $registro->save();
                        $this->calcularRetraso($registro);
                        $this->sumarRetrasos($registro);

                        Session::flash('success', 'El empleado: ' . $registro->empleado->nombres . ' registró su entrada en el HORARIO: ' . $horario->Nombre);
                        return redirect()->back();
                    } else {
                        Session::flash('error', 'El empleado: ' . $registro->empleado->nombres . ' ya registró su entrada en el HORARIO: ' . $horario->Nombre);
                        return redirect()->back();
                    }
                } else {
                    if (!$registro) {
                        $registroactual = new RegistroAsistencia();
                        $registroactual->empleado_id = $emp->idemp;
                        $registroactual->horario_id = $horarioId;


                        if ($horaActual <= $horario->hora_entrada && $horaActual <= $horario->excepcion) {

                            $registroactual->registro_entrada = $horaActual;
                            $this->calcularRetraso($registroactual);
                            $this->sumarRetrasos($registroactual);
                            Session::flash('success', 'Registro de entrada guardado exitosamente. Registro de entrada sin retrasos. ' . $horaActual .  ' HORARIO: ' . $horario->Nombre . ' Horarios asignados: ' . $horariosAsignados);
                        } else if ($horaActual <= $horario->hora_salida && $horaActual > $horario->excepcion) {

                            $registroactual->registro_entrada = $horaActual;
                            $this->calcularRetraso($registroactual);
                            $this->sumarRetrasos($registroactual);
                            Session::flash('success', 'Registro de asistencia guardado exitosamente. Registro de entrada con retrasos. ' . $horaActual . ' HORARIO: ' . $horario->Nombre .  ' Horarios asignados: ' . $horariosAsignados);
                        } else if ($horaActual >= $horario->hora_salida && $horaActual > $horario->excepcion) {

                            $registroactual->registro_salida = $horaActual;
                            $this->sumarRetrasos($registroactual);
                            Session::flash('success', ' Registro de salida guardado exitosamente.');
                        }

                        $registroactual->save();
                        return redirect()->back();
                    }
                    return redirect()->back();
                    Session::flash('error', 'El empleado no está en horario de registro.' . $horaActual  . 'Horarios asignados: ' . $horariosAsignados);
                }
            } else {
                if ($horariosCount > 0) {
                    // No se encontró un horario válido para la hora actual
                    Session::flash('error', 'El empleado no está en horario de Registro - Horarios asignados: ' . $horariosAsignados);
                    return redirect()->back();
                }
                //No se encontró un horario asignado
                Session::flash('error', 'NO SE ENCONTRO HORARIO ASIGNADO: ' . $horariosCount);
                return redirect()->back();
            }
        } else {
            // Si el PIN no corresponde a ningún empleado, mostrar un mensaje de error
            Session::flash('error', 'El PIN ingresado no corresponde a ningún empleado.');
            return redirect()->back();
        }
    }


    public function marcadoDactilar(Request $request)
    {
        try {
            $data = $request->json()->all();
            $horaActual = $data['hora'];
            $empleadoId = $data['id'];
 
            $emp = EmpleadosModel::where('idemp', $empleadoId)->first();

            $horaActualCarbon = Carbon::parse($horaActual);
            $horaMinima = $horaActualCarbon->subMinutes(20)->format('H:i:s');
            $horaMaxima = $horaActualCarbon->addMinutes(20)->format('H:i:s');

            if (!$emp) {
                return response()->json(['error' => 'El ID no corresponde a ningún empleado.', 'data' => ['Empleado' => $empleadoId]]);
            }

            $horario = $emp->horarios()
                ->where('hora_entrada', '<=', $horaMaxima)
                ->where('hora_salida', '>=', $horaMinima)
                ->where('estado', 1)
                ->first();

            $horariosAsignados = $emp->horarios()
                ->where('estado', 1)
                ->pluck('Nombre')
                ->implode(' - ');

            $horariosCount = $emp->horarios()
                ->where('estado', 1)
                ->count();

            if (!$horario) {
                if ($horariosCount > 0) {
                    return response()->json(['error' => 'El empleado no está en horario de Registro.', 'data' => ['horarios_asignados' => $horariosAsignados]]);
                } else {
                    return response()->json(['error' => 'No se encontró un horario asignado']);
                }
            }

            $horarioId = $horario->id;
            $registro = $emp->registrosAsistencia()
                ->whereDate('created_at', Carbon::today())
                ->where('horario_id', $horarioId)
                ->first();

            if (!$registro) {
                $registroactual = new RegistroAsistencia();
                $registroactual->empleado_id = $emp->idemp;
                $registroactual->horario_id = $horarioId;

                if ($horaActual <= $horario->hora_entrada && $horaActual <= $horario->excepcion) {
                    $registroactual->registro_entrada = $horaActual;

                    $this->calcularRetraso($registroactual);
                    $this->sumarRetrasos($registroactual);
                    $message = 'Registro de entrada guardado exitosamente. Registro de entrada sin retrasos.';
                } else if ($horaActual <= $horario->hora_salida && $horaActual > $horario->excepcion) {
                    $registroactual->registro_entrada = $horaActual;

                    $this->calcularRetraso($registroactual);
                    $this->sumarRetrasos($registroactual);
                    $message = 'Registro de asistencia guardado exitosamente. Registro de entrada con retrasos.';
                } else if ($horaActual >= $horario->hora_salida && $horaActual > $horario->excepcion) {
                    $registroactual->registro_salida = $horaActual;
                    
                    
                    $this->sumarRetrasos($registroactual);
                    $data = ['Empleado' => $emp->nombres];
                    $message = 'Registro de salida guardado exitosamente.';
                }

                $registroactual->save();

                $responseData = [
                    'message' => $message,
                    'data' => [
                        'registro_entrada' => $registroactual->registro_entrada ?? null,
                        'horario' => $horario->Nombre,
                        'horarios_asignados' => $horariosAsignados,
                    ],
                ];

                if (isset($data)) {
                    $responseData['data'] += $data;
                }

                return response()->json($responseData);
            } else {
                if ($horaActual >= $horario->hora_salida && $horaActual <= $horaMaxima) {
                    if (!$registro->registro_salida) {
                        $registro->registro_salida = $horaActual;
                        $registro->save();

                        $this->sumarRetrasos($registro);
                        return response()->json(['message' => 'Registro de salida guardado exitosamente.', 'data' => [
                            'minutos_retraso' => $registro->minutos_retraso,
                            'fecha' => $registro->fecha,
                            'horario' => $registro->horario->Nombre,
                            'horarios_asignados' => $horariosAsignados,
                        ]]);
                    } else {
                        return response()->json(['error' => 'El empleado ya registró su salida.', 'data' => [
                            'registro_salida' => $registro->registro_salida,
                            'horario' => $registro->horario->Nombre,
                            'horarios_asignados' => $horariosAsignados,
                        ]]);
                    }
                } elseif (!$registro->registro_entrada) {
                    $registro->registro_entrada = $horaActual;
                    $registro->save();
                    $this->calcularRetraso($registro);
                    $this->sumarRetrasos($registro);
                    return response()->json(['message' => 'El empleado registró su entrada en el HORARIO: ' . $horario->Nombre]);
                } else {
                    return response()->json(['error' => 'El empleado ya registró su entrada en el HORARIO: ' . $horario->Nombre]);
                }
            }
        } catch (\Exception $e) {
            // Captura y maneja la excepción
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}
