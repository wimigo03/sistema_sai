<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaModel;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use App\Models\EmpleadosModel;
use App\Models\HorarioModel;
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

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $filtro = $request->input('filtro', 'actual');
            $data = RegistroAsistencia::with('empleado', 'horario');



            // Aplicar el filtro de fecha según el valor seleccionado
            $filtro = $request->input('filtro');

            if ($filtro == 'actual') {
                $data = $data->whereDate('fecha', Carbon::today());
            } elseif ($filtro == 'mensual') {
                $data = $data->whereMonth('fecha', Carbon::now()->month);
            }

            $data = $data->get();
            return DataTables::of($data)
                ->addColumn('fecha', function ($row) {
                    return $row->fecha ? Carbon::parse($row->fecha)->format('Y-m-d') : '-';

                    // return $row->fecha ? Carbon::parse($row->fecha)->format('l j F Y') : '-';
                })


                ->addColumn('horario', function ($row) {
                    $nombre = $row->horario->Nombre;
                    $final = $row->horario->hora_final ? Carbon::parse($row->horario->hora_final)->format('H:i') : '-';
                    $inicio = $row->horario->hora_inicio ? Carbon::parse($row->horario->hora_inicio)->format('H:i') : '-';

                    if ($row->horario->tipo == 1) {

                        $salida = $row->horario->hora_salida ? Carbon::parse($row->horario->hora_salida)->format('H:i') : '-';
                        $entrada = $row->horario->hora_entrada ? Carbon::parse($row->horario->hora_entrada)->format('H:i') : '-';
                        $html = '<span>' . $nombre . '</span><br><span>' . $inicio . '-' . $salida . '</span><br><span>' . $entrada . '-' . $final . '</span>';
                    } else if ($row->horario->tipo == 0) {

                        $html = '<span>' . $nombre . '</span><br><span>' . $inicio . '</span><br><span>' . $final . '</span>';
                    }
                    return $html;
                })
                ->addColumn('nom_ap', function ($row) {
                    $nom = $row->empleado->nombres;
                    $ap_pat = $row->empleado->ap_pat ?? '-';
                    $ap_mat = $row->empleado->ap_mat ?? '-';
                    return $nom . ' ' . $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('registro_inicio', function ($row) {
                    return $row->registro_inicio ? Carbon::parse($row->registro_inicio)->format('H:i') : '-';
                })
                ->addColumn('registro_entrada', function ($row) {
                    return $row->registro_entrada ? Carbon::parse($row->registro_entrada)->format('H:i') : '-';
                })
                ->addColumn('registro_salida', function ($row) {
                    return $row->registro_salida ? Carbon::parse($row->registro_salida)->format('H:i') : '-';
                })
                ->addColumn('registro_final', function ($row) {
                    return $row->registro_final ? Carbon::parse($row->registro_final)->format('H:i') : '-';
                })
                ->addColumn('minutos_retraso', function ($row) {
                    return $row->minutos_retraso ?? '-';
                })
                ->addColumn('estado', function ($row) {
                    if ($row->estado == 0) {
                        return 'Sin Registro';
                    } else if ($row->estado == 1) {
                        return 'Registrado';
                    } else if ($row->estado == 2) {
                        return 'Pendiente';
                    } else {
                        return '-'; // Puedes personalizar este mensaje según sea necesario
                    }
                })

                ->rawColumns(['horario'])
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


    public function marcadoDactilar(Request $request)
    {
        // Validar los datos del formulario

        $data = $request->json()->all();
        $hora = $data['hora'] ?? null;
        $id = $data['id'] ?? null;
        $pin = $data['pin'] ?? null;
        $fecha = $data['fecha'] ?? null;

        try {

            //verificar dia
            $response = $this->verificarDomingo($fecha);
            if ($response) {
                return $response;
            }


            if (!$pin) {
                $emp = $this->buscarPersonalID($id);
            } else if (!$id) {
                $emp = $this->buscarPersonalPIN($pin);
            }

            // Lógica para buscar el empleado

            if (!$emp) {
                return response()->json(['error' => 'NO CORRESPONDE A NINGÚN PERSONAL ACTIVO.']);
            }

            // Lógica para verificar el horario activo
            $horario = $emp->horarios()->where('estado', 1)->first();


            if (!$horario) {
                // No se encontró un horario válido para la hora actual
                return response()->json(['error' => 'NO SE ENCONTRÓ HORARIO ACTIVO PARA EL PERSONAL']);
            }


            //tiempo Inicio y maximo para entrada y salida
            $fechaObtenida = Carbon::createFromFormat('Y-m-d', $fecha);
            $horaActual = Carbon::parse($hora)->format('H:i:s');
            $horaInicioJornada = Carbon::parse($horario->inicio_jornada);
            $HoraInicioJornada = $horaInicioJornada->format('H:i:s');



            if ($fechaObtenida->dayOfWeek === Carbon::SATURDAY && $horaActual >= $HoraInicioJornada) {
                return response()->json(['info' => 'SÁBADO. DÍA NO LABORAL.']);
            }
            //Marcar fecha de Salida antes de inicio de Jornada en dia Posterior
            $fechaAnterior = $this->obtenerFechaAnteriorSinDomingo($fecha);
            if ($fechaObtenida->dayOfWeek === Carbon::SATURDAY &&  $horaActual <= $HoraInicioJornada) {
                $asistencia = $this->obtenerOCrearAsistencia($fechaAnterior);
            } else {
                $asistencia = $this->obtenerOCrearAsistencia($fecha);
            }

            $horarioID = $horario->id;
            $asistenciaID = $asistencia->id;

            //Buscar Registro con horario activo
            $registro = $emp
                ->registrosAsistencia()
                ->where('asistencia_id', $asistenciaID)
                ->where('horario_id', $horarioID)
                ->first();

            //Buscar Registro con horario programado
            if (!$registro) {

                $horario_ID = RegistroAsistencia::where('asistencia_id', $asistenciaID)
                    ->where('empleado_id', $emp->idemp)
                    ->select('horario_id')
                    ->first();
                if ($horario_ID) {
                    $registro = $emp
                        ->registrosAsistencia()
                        ->where('asistencia_id', $asistenciaID)
                        ->where('horario_id', $horario_ID->horario_id)
                        ->first();
                    $registro->asistencia->fecha == $fecha;
                    if ($horarioID != $horario_ID->horario_id) {
                        $horario = HorarioModel::find($horario_ID->horario_id);
                    }
                }
            }

            //sumar minutos de excepcion a Horario entrada
            $horaInicio = Carbon::parse($horario->hora_inicio);
            $horaEntrada = Carbon::parse($horario->hora_entrada);
            $excepcion = Carbon::parse($horario->excepcion);

            $suma = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
            $suma2 = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);

            $sumaInicioFormateada = $suma->format('H:i:s');
            $sumaEntradaFormateada = $suma2->format('H:i:s');





            // Obtén la fecha y hora actual
            $now = Carbon::parse($fecha);
            // Obtiene la hora de inicio del día en formato h:i:s
            $inicioDelDia = $now->startOfDay()->format('H:i:s');
            // Obtiene la hora de final del día en formato h:i:s
            $finalDelDia = $now->endOfDay()->format('H:i:s');





            if ($horaActual >= $inicioDelDia && ($horaActual <= $HoraInicioJornada && $fechaAnterior)) {


                $horario_ID = RegistroAsistencia::where('fecha', $fechaAnterior)
                    ->where('empleado_id', $emp->idemp)
                    ->select('horario_id')
                    ->first();

                if ($horario_ID) {
                    $registro = $emp
                        ->registrosAsistencia()
                        ->where('empleado_id', $emp->idemp)
                        ->where('fecha', $fechaAnterior)
                        ->where('horario_id', $horario_ID->horario_id)
                        ->first();

                    $registro->asistencia->fecha == $fecha;

                    if ($horarioID != $horario_ID->horario_id) {
                        $horario = HorarioModel::find($horario_ID->horario_id);
                    }
                }

                if (!$registro) {
                    $registro = new RegistroAsistencia();
                    $registro->empleado_id = $emp->idemp;
                    $registro->horario_id = $horario->id;
                    $registro->asistencia_id = $asistencia->id;

                    $registro->registro_final = $horaActual;

                    $registro->fecha = $asistencia->fecha;
                    $registro->tipo = $asistencia->tipo;

                    $registro->save();
                    $this->verificarMarcado($registro);

                    return response()->json(['success' => 'SE GUARDÓ REGISTRO DE SALIDA:']);
                }
                if (!$registro->registro_final) {
                    $registro->registro_final = $horaActual;
                    $registro->save();
                    $this->verificarMarcado($registro);

                    // $this->sumarRetrasos($registroactual);
                    return response()->json(['success' => 'SE GUARDÓ REGISTRO DE SALIDA:']);
                } else {
                    return response()->json(['success' => 'YA EXISTE REGISTRO DE SALIDA.']);
                }
            }





            $horaInicioCarbon = Carbon::parse($horario->hora_inicio);
            $horaSalidaCarbon = Carbon::parse($horario->hora_salida);
            $horaEntradaCarbon = Carbon::parse($horario->hora_entrada);
            $horaFinalCarbon = Carbon::parse($horario->hora_final);


            $horaMinimaInicio = $horaInicioCarbon->subMinutes(45)->format('H:i:s');
            $horaMaximaSalida = $horaSalidaCarbon->addMinutes(45)->format('H:i:s');
            $horaMinimaEntrada = $horaEntradaCarbon->subMinutes(45)->format('H:i:s');
            $horaMaximaFinal = $horaFinalCarbon->addMinutes(45)->format('H:i:s');

            if (!$registro) {
                $asistencia = $this->obtenerOCrearAsistencia($fecha);



                if ($horario->tipo == 1) {

                    //return response()->json(['success' => 'SIN REGISTRO HORARIO TIPO ' . $horario->tipo]);
                    if ($horaActual  >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_inicio = $horaActual;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;
                        $registro->tipo = $asistencia->fecha;

                        $registro->save();

                        $this->calcularRetraso($registro);
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA']);

                        // $this->sumarRetrasos($registroactual);
                    } else if ($horaActual < $horario->hora_salida && $horaActual  > $sumaInicioFormateada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_inicio = $horaActual;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->calcularRetraso($registro);
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA: RETRASO: ' . $registro->minutos_retraso]);
                    } else if ($horaActual < $horario->hora_inicio && $horaActual >= $HoraInicioJornada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_inicio = $horaActual;
                        $registro->retraso1 = 0;
                        $registro->minutos_retraso = 0;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA:']);
                    } else if ($horaActual >= $horario->hora_salida && $horaActual <= $horaMaximaSalida) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_salida = $horaActual;
                        $registro->retraso1 = 0;
                        $registro->minutos_retraso = 0;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE SALIDA:']);
                    } else if ($horaActual < $horario->hora_entrada && $horaActual >= $horaMinimaEntrada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_entrada = $horaActual;
                        $registro->retraso2 = 0;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        // $this->calcularRetraso($registro);
                        // $this->sumarRetrasos($registroactual);
                        $registro->save();
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE SALIDA:']);
                    } else if ($horaActual >= $horario->hora_entrada && $horaActual <= $sumaEntradaFormateada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_entrada = $horaActual;
                        $registro->retraso2 = 0;

                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->calcularRetraso($registro);
                        // $this->sumarRetrasos($registroactual);
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA:']);
                    } else if ($horaActual < $horario->hora_final && $horaActual > $sumaEntradaFormateada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_entrada = $horaActual;

                        $registro->estado = 0;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->calcularRetraso($registro);
                        $this->verificarMarcado($registro);

                        // $this->sumarRetrasos($registroactual);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE SALIDA: RETRASOS' . $registro->retraso1]);
                    } else if ($horaActual >= $horario->hora_final && $horaActual <= $finalDelDia) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_final = $horaActual;

                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->verificarMarcado($registro);


                        // $this->sumarRetrasos($registroactual);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE SALIDA:']);
                    }
                } else if ($horario->tipo == 0) {
                    //return response()->json(['success' => 'SIN REGISTRO HORARIO TIPO :' . $horario->tipo]);
                    if ($horaActual >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_inicio = $horaActual;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA']);

                        $this->calcularRetraso($registro);
                        // $this->sumarRetrasos($registroactual);
                    } else if ($horaActual  < $horario->hora_final && $horaActual  > $sumaInicioFormateada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_inicio = $horaActual;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->calcularRetraso($registro);
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA. RETRASO: ' . $registro->retraso1]);
                    } else if ($horaActual < $horario->hora_inicio && $horaActual >= $HoraInicioJornada) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_inicio = $horaActual;
                        $registro->retraso1 = 0;
                        $registro->minutos_retraso = 0;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;

                        $registro->save();
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE ENTRADA. RETRASO: ' . $registro->retraso1]);
                    } else if ($horaActual >= $horario->hora_final && $horaActual <= $finalDelDia) {
                        $registro = new RegistroAsistencia();
                        $registro->empleado_id = $emp->idemp;
                        $registro->horario_id = $horario->id;
                        $registro->registro_final = $horaActual;
                        $registro->asistencia_id = $asistencia->id;
                        $registro->fecha = $asistencia->fecha;


                        $registro->estado = 0;
                        $registro->save();
                        $this->verificarMarcado($registro);
                        return response()->json(['success' => 'SE CREÓ REGISTRO DE SALIDA.']);

                        // $this->sumarRetrasos($registroactual);
                    }
                }
            } else if ($registro->asistencia->id == $asistenciaID) {

                if ($horario->tipo == 1) {

                    //return response()->json(['success' => 'CON REGISTRO HORARIO TIPO' . $horario->tipo]);
                    if ($horaActual  >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                        if (!$horario->hora_inicio) {
                            $registro->registro_inicio = $horaActual;
                            $registro->save();

                            $this->calcularRetraso($registro);
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }


                        // $this->sumarRetrasos($registroactual);
                    } else if ($horaActual  < $horario->hora_salida && $horaActual  > $sumaInicioFormateada) {

                        if (!$registro->registro_inicio) {
                            $registro->registro_inicio = $horaActual;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA: RETRASOS :' . $registro->minutos_retraso]);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual < $horario->hora_inicio && $horaActual >= $HoraInicioJornada) {

                        if (!$registro->registro_inicio) {
                            $registro->registro_inicio = $horaActual;
                            $registro->retraso1 = 0;
                            $registro->minutos_retraso = 0;
                            $registro->save();
                            $this->verificarMarcado($registro);
                            Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                            return redirect()->back();
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual >= $horario->hora_salida && $horaActual <= $horaMaximaSalida) {

                        if (!$registro->registro_salida) {
                            $registro->registro_salida = $horaActual;
                            $registro->estado = 0;

                            //  $this->sumarRetrasos($registroactual);
                            $registro->save();
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE SALIDA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE SALIDA.']);
                        }
                    } else if ($horaActual < $horario->hora_entrada && $horaActual >= $horaMinimaEntrada) {

                        if (!$registro->registro_entrada) {
                            $registro->registro_entrada = $horaActual;
                            $registro->retraso2 = 0;
                            // $this->calcularRetraso($registro);
                            // $this->sumarRetrasos($registroactual);
                            $registro->save();
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE SALIDA.']);
                        }
                    } else if ($horaActual >= $horario->hora_entrada && $horaActual <= $sumaEntradaFormateada) {

                        if (!$registro->registro_entrada) {
                            $registro->registro_entrada = $horaActual;
                            $registro->retraso2 = 0;
                            $registro->estado = 0;
                            $this->calcularRetraso($registro);
                            $this->verificarMarcado($registro);
                            // $this->sumarRetrasos($registroactual);
                            $registro->save();
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual < $horario->hora_final && $horaActual > $sumaEntradaFormateada) {

                        if (!$registro->registro_entrada) {
                            $registro->registro_entrada = $horaActual;

                            $registro->estado = 0;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarMarcado($registro);
                            // $this->sumarRetrasos($registroactual);

                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual >= $horario->hora_final && $horaActual <= $finalDelDia) {
                        if (!$registro->registro_final) {
                            $registro->registro_final = $horaActual;
                            $registro->estado = 0;
                            $registro->save();
                            $this->verificarMarcado($registro);

                            // $this->sumarRetrasos($registroactual);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE SALIDA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE SALIDA.']);
                        }
                    }
                } else if ($horario->tipo == 0) {
                    //return response()->json(['success' => 'CON REGISTRO HORARIO TIPO :' . $horario->tipo]);

                    if ($horaActual  >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                        if (!$registro->registro_inicio) {
                            $registro->registro_inicio = $horaActual;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);

                            // $this->sumarRetrasos($registroactual);
                            return redirect()->back();
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual  < $horario->hora_final && $horaActual  > $sumaInicioFormateada) {
                        if (!$registro->registro_inicio) {
                            $registro->registro_inicio = $horaActual;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual < $horario->hora_inicio && $horaActual >= $HoraInicioJornada) {
                        if (!$registro->registro_inicio) {
                            $registro->registro_inicio = $horaActual;
                            $registro->retraso1 = 0;
                            $registro->minutos_retraso = 0;
                            $registro->save();
                            $this->verificarMarcado($registro);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE ENTRADA:']);
                            return redirect()->back();
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE ENTRADA.']);
                        }
                    } else if ($horaActual >= $horario->hora_final && $horaActual <= $finalDelDia) {
                        if (!$registro->registro_final) {
                            $registro->registro_final = $horaActual;
                            $registro->estado = 0;
                            $registro->save();
                            $this->verificarMarcado($registro);
                            // $this->sumarRetrasos($registroactual);
                            return response()->json(['success' => 'SE GUARDÓ REGISTRO DE SALIDA:']);
                            return redirect()->back();
                        } else {
                            return response()->json(['info' => 'YA EXISTE REGISTRO DE SALIDA.']);
                        }
                    }
                }
            }




            // Si todo está bien, puedes devolver un mensaje de éxito si es necesario
            return response()->json(['success' => 'NO INICIO LA JORNADA']);
        } catch (\Exception $e) {
            return response()->json(['error' => "Error interno del servidor."]);
        }
    }



    function obtenerFechaAnteriorSinDomingo($fechaString)
    {
        // Obtén la fecha y hora actual
        $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fechaString);
        // Obtén la fecha anterior restando un día
        $fechaAnterior = $fechaCarbon->subDays(1);

        // Verifica si la fecha anterior es un domingo
        if ($fechaAnterior->dayOfWeek === Carbon::SUNDAY) {
            return $fechaAnterior == null;
        }

        // Formatea la fecha en el formato deseado
        return $fechaAnterior->format('Y-m-d');
    }

    private function obtenerOCrearAsistencia($fecha)
    {
        // Verificar si el mes es posterior al mes actual
        if (Carbon::now()->format('Y-m-d') < $fecha) {
            // Si es posterior, obtener o crear el permiso del mes actual
            $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id', 'fecha')->first();
            if (!$asistenciaActual) {
                $asistenciaActual = AsistenciaModel::create(['fecha' => $fecha, 'descrip' => "Activo", 'estado' => '0']);
            }

            return $asistenciaActual;
        }

        // Si no es posterior, obtener o crear el permiso del mes proporcionado
        $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id', 'fecha')->first();

        if (!$asistenciaActual) {
            $asistenciaActual = AsistenciaModel::create([
                'fecha' => $fecha,
                'descrip' => 'Activo',
                'estado' => '0'
            ]);
        }

        return $asistenciaActual;
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
                    $registro->save();
                } else {
                    $registro->retraso1 = 0;
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
            } else if ($registro->registro_entrada && $registro->registro_inicio) {

                $horaexcepcion = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaEntrada = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaEntrada);
                $horaEntradaReal = Carbon::parse($registro->registro_entrada);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso2 = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso2 = $retraso2;
                    $registro->minutos_retraso = $registro->retraso2 + $registro->retraso1;
                    $registro->save();
                } else {
                    $registro->retraso2 = 0;
                    $registro->save();
                    $registro->minutos_retraso = $registro->retraso2 + $registro->retraso1;
                    $registro->save();
                }
            }
        }
        if ($registro->horario->tipo == 0) {

            $horaEntrada = Carbon::parse($registro->horario->hora_entrada);
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

    private function sumarRetrasos(RegistroAsistencia $registro)
    {


        if ($registro->estado == 1) {
            $emp_id = $registro->empleado_id;
            $sumaRetraso = RegistroAsistencia::whereDate('created_at', Carbon::today())
                ->where('empleado_id', $emp_id)
                ->where('estado', 1)
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

    public function verificarDomingo($fecha)
    {
        $fechaObtenida = Carbon::createFromFormat('Y-m-d', $fecha);


        if ($fechaObtenida->dayOfWeek === Carbon::SUNDAY) {
            return response()->json(['error' => 'DOMINGO. DÍA NO LABORAL.']);
        }
    }
    public function buscarPersonalPIN($pin)
    {

        $areasExcluidas = [33, 34];
        $emp = EmpleadosModel::where('pin', $pin)
            ->whereNotIn('idarea', $areasExcluidas)

            ->first();
        return $emp;
    }


    public function buscarPersonalID($id)
    {

        $areasExcluidas = [33, 34];
        $emp = EmpleadosModel::where('idemp', $id)
            ->whereNotIn('idarea', $areasExcluidas)
            ->first();

        return $emp;
    }
}
