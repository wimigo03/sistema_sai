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
    private function verificarmMarcado(RegistroAsistencia $registro)
    {
        if ($registro->horario->tipo == 1) {
            if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 1;
                $registro->save();
            } else {
                $registro->estado = 0;
                $registro->save();
            }
        }
        if ($registro->horario->tipo == 0) {
            if ($registro->registro_final && $registro->registro_inicio) {
                $registro->estado = 1;
                $registro->save();
            } else {
                $registro->estado = 0;
                $registro->save();
            }
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
 
        try {
            $pin = $request->input('pin');
            $id = $request->input('id');
 
            if (!empty($pin)) {
                $emp = EmpleadosModel::where('pin', $pin)->first();
            }
            $hora = $request->input('hora');


            $this->registrar($emp, $hora);
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    private function registrar($emp, $hora)
    {
        if ($emp) {

            $horaActual = Carbon::parse($hora)->format('H:i:s');
            $horario = $emp->horarios()->where('estado', 1)->first();

            if (!$horario) {
                // No se encontró un horario válido para la hora actual
                Session::flash('error', 'NO SE ENCONTRÓ HORARIO DEL EMPLEADO PARA REGISTRO');
                return redirect()->back();
            } else {
                $horarioID = $horario->id;
                $registro = $emp
                    ->registrosAsistencia()
                    ->whereDate('created_at', Carbon::today())
                    ->where('horario_id', $horarioID)
                    ->first();

                if (!$registro) {

                    $horaInicioCarbon = Carbon::parse($horario->hora_inicio); // Parse the input string to a Carbon instance
                    $horaSalidaCarbon = Carbon::parse($horario->hora_salida);
                    $horaEntradaCarbon = Carbon::parse($horario->hora_entrada); // Parse the input string to a Carbon instance
                    $horaFinalCarbon = Carbon::parse($horario->hora_final);

                    $horaMinimaInicio = $horaInicioCarbon->subMinutes(45)->format('H:i:s');
                    $horaMaximaSalida = $horaSalidaCarbon->addMinutes(45)->format('H:i:s');
                    $horaMinimaEntrada = $horaEntradaCarbon->subMinutes(45)->format('H:i:s');
                    $horaMaximaFinal = $horaFinalCarbon->addMinutes(45)->format('H:i:s');

                    $horaInicio = Carbon::parse($horario->hora_inicio);
                    $horaEntrada = Carbon::parse($horario->hora_entrada);
                    $excepcion = Carbon::parse($horario->excepcion);

                    $suma = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                    $suma2 = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                    $sumaInicioFormateada = $suma->format('H:i:s');
                    $sumaEntradaFormateada = $suma2->format('H:i:s');
                    Session::flash('error', 'SE ENCONTRÓ HORARIO: Tipo' . $horario->tipo . ' PARA REGISTRO : ');

                    if ($horario->tipo == 1) {

                        if ($horaActual  >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_inicio = $horaActual;
                            $registro->save();

                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $horaActual  . $horario->Nombre);
                            $this->calcularRetraso($registro);
                            $this->verificarmMarcado($registro);
                            // $this->sumarRetrasos($registroactual);
                        } else if ($horaActual < $horario->hora_salida && $horaActual  > $sumaInicioFormateada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_inicio = $horaActual;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarmMarcado($registro);



                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: RETRASO: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual < $horario->hora_inicio && $horaActual >= $horaMinimaInicio) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_inicio = $horaActual;
                            $registro->retraso1 = 0;
                            $registro->minutos_retraso = 0;
                            $registro->save();
                            $this->verificarmMarcado($registro);


                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual >= $horario->hora_salida && $horaActual <= $horaMaximaSalida) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_salida = $horaActual;
                            $registro->retraso1 = 0;
                            $registro->minutos_retraso = 0;
                            $registro->estado = 0;
                            $registro->save();
                            $this->verificarmMarcado($registro);
                            Session::flash('success', 'SE CREÓ REGISTRO DE SALIDA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual < $horario->hora_entrada && $horaActual >= $horaMinimaEntrada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_entrada = $horaActual;
                            $registro->retraso2 = 0;
                            // $this->calcularRetraso($registro);
                            // $this->sumarRetrasos($registroactual);
                            $registro->save();
                            $this->verificarmMarcado($registro);
                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual >= $horario->hora_entrada && $horaActual <= $sumaEntradaFormateada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_entrada = $horaActual;
                            $registro->retraso2 = 0;
                            $registro->estado = 0;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            // $this->sumarRetrasos($registroactual);
                            $this->verificarmMarcado($registro);
                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual < $horario->hora_final && $horaActual > $sumaEntradaFormateada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_entrada = $horaActual;

                            $registro->estado = 0;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarmMarcado($registro);

                            // $this->sumarRetrasos($registroactual);

                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual >= $horario->hora_final && $horaActual <= $horaMaximaFinal) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_final = $horaActual;

                            $registro->estado = 0;
                            $registro->save();

                            // $this->sumarRetrasos($registroactual);

                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual > $horaMaximaFinal || $horaActual < $horaMinimaInicio) {

                            Session::flash('error', 'FUERA DE HORARIO LABORAL: Tipo :' . $horario->tipo . ' ' . $horario->Nombre);
                            return redirect()->back();
                        }
                        return redirect()->back();
                    }
                    if ($horario->tipo == 0) {

                        if ($horaActual >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_inicio = $horaActual;
                            $registro->save();
                            $this->verificarmMarcado($registro);


                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $horaActual  . $horario->Nombre);
                            $this->calcularRetraso($registro);
                            // $this->sumarRetrasos($registroactual);
                        } else if ($horaActual  < $horario->hora_final && $horaActual  > $sumaInicioFormateada) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_inicio = $horaActual;
                            $registro->save();
                            $this->calcularRetraso($registro);
                            $this->verificarmMarcado($registro);


                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: RETRASO: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual < $horario->hora_inicio && $horaActual >= $horaMinimaInicio) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_inicio = $horaActual;
                            $registro->retraso1 = 0;
                            $registro->minutos_retraso = 0;
                            $registro->save();
                            $this->verificarmMarcado($registro);


                            Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual >= $horario->hora_final && $horaActual <= $horaMaximaFinal) {
                            $registro = new RegistroAsistencia();
                            $registro->empleado_id = $emp->idemp;
                            $registro->horario_id = $horario->id;
                            $registro->registro_final = $horaActual;

                            $registro->estado = 0;
                            $registro->save();
                            $this->verificarmMarcado($registro);

                            // $this->sumarRetrasos($registroactual);
                            Session::flash('success', 'SE CREÓ REGISTRO DE SALIDA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                        } else if ($horaActual > $horaMaximaFinal || $horaActual < $horaMinimaInicio) {
                            Session::flash('error', 'FUERA DE HORARIO LABORAL: Tipo :' . $horario->tipo . ' ' . $horario->Nombre);
                            return redirect()->back();
                        }
                        return redirect()->back();
                    }
                } else {
                    $horaInicio = Carbon::parse($horario->hora_inicio);
                    $horaEntrada = Carbon::parse($horario->hora_entrada);
                    $excepcion = Carbon::parse($horario->excepcion);

                    $suma = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                    $suma2 = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);

                    $sumaInicioFormateada = $suma->format('H:i:s');
                    $sumaEntradaFormateada = $suma2->format('H:i:s');

                    $horaInicioCarbon = Carbon::parse($horario->hora_inicio); // Parse the input string to a Carbon instance
                    $horaSalidaCarbon = Carbon::parse($horario->hora_salida);
                    $horaEntradaCarbon = Carbon::parse($horario->hora_entrada); // Parse the input string to a Carbon instance
                    $horaFinalCarbon = Carbon::parse($horario->hora_final);

                    $horaMinimaInicio = $horaInicioCarbon->subMinutes(45)->format('H:i:s');
                    $horaMaximaSalida = $horaSalidaCarbon->addMinutes(45)->format('H:i:s');
                    $horaMinimaEntrada = $horaEntradaCarbon->subMinutes(45)->format('H:i:s');
                    $horaMaximaFinal = $horaFinalCarbon->addMinutes(45)->format('H:i:s');

                    Session::flash('success', 'SE ENCONTRÓ: ' . $horario->tipo . ' PARA REGISTRO');

                    if ($horario->tipo == 1) {
                        if ($horaActual  >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                            if (!$horario->hora_inicio) {
                                $registro->registro_inicio = $horaActual;
                                $registro->save();

                                Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: ' . $horaActual  . $horario->Nombre);
                                $this->calcularRetraso($registro);
                                $this->verificarmMarcado($registro);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }


                            // $this->sumarRetrasos($registroactual);
                        } else if ($horaActual  < $horario->hora_salida && $horaActual  > $sumaInicioFormateada) {

                            if (!$registro->registro_inicio) {
                                $registro->registro_inicio = $horaActual;
                                $registro->save();
                                $this->calcularRetraso($registro);
                                $this->verificarmMarcado($registro);
                                Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: RETRASO: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual < $horario->hora_inicio && $horaActual >= $horaMinimaInicio) {

                            if (!$registro->registro_inicio) {
                                $registro->registro_inicio = $horaActual;
                                $registro->retraso1 = 0;
                                $registro->minutos_retraso = 0;
                                $registro->save();
                                $this->verificarmMarcado($registro);
                                Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual >= $horario->hora_salida && $horaActual <= $horaMaximaSalida) {

                            if (!$registro->registro_salida) {
                                $registro->registro_salida = $horaActual;
                                $registro->estado = 0;

                                //  $this->sumarRetrasos($registroactual);
                                $registro->save();
                                $this->verificarmMarcado($registro);
                                Session::flash('success', 'SE GUARDÓ REGISTRO DE SALIDA: ' . $horaMaximaSalida . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE SALIDA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual < $horario->hora_entrada && $horaActual >= $horaMinimaEntrada) {

                            if (!$registro->registro_entrada) {
                                $registro->registro_entrada = $horaActual;
                                $registro->retraso2 = 0;
                                // $this->calcularRetraso($registro);
                                // $this->sumarRetrasos($registroactual);
                                $registro->save();
                                $this->verificarmMarcado($registro);
                                Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO:' . $horaMinimaEntrada . '' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual >= $horario->hora_entrada && $horaActual <= $sumaEntradaFormateada) {

                            if (!$registro->registro_entrada) {
                                $registro->registro_entrada = $horaActual;
                                $registro->retraso2 = 0;
                                $registro->estado = 0;
                                $this->calcularRetraso($registro);
                                $this->verificarmMarcado($registro);
                                // $this->sumarRetrasos($registroactual);
                                $registro->save();
                                Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual < $horario->hora_final && $horaActual > $sumaEntradaFormateada) {

                            if (!$registro->registro_entrada) {
                                $registro->registro_entrada = $horaActual;

                                $registro->estado = 0;
                                $registro->save();
                                $this->calcularRetraso($registro);
                                $this->verificarmMarcado($registro);
                                // $this->sumarRetrasos($registroactual);

                                Session::flash('success', 'SE GUARDÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual >= $horario->hora_final && $horaActual <= $horaMaximaFinal) {
                            if (!$registro->registro_final) {
                                $registro->registro_final = $horaActual;
                                $registro->estado = 0;
                                $registro->save();
                                $this->verificarmMarcado($registro);

                                // $this->sumarRetrasos($registroactual);
                                Session::flash('success', 'SE CREÓ REGISTRO DE SALIDA: ' . $horaMaximaFinal . ' ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('error', ' YA EXISTE REGISTRO DE SALIDA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual > $horaMaximaFinal || $horaActual < $horaMinimaInicio) {

                            Session::flash('error', 'FUERA DE HORARIO LABORAL: Tipo :' . $horario->tipo . ' ' . $horario->Nombre);
                            return redirect()->back();
                        }
                        return redirect()->back();
                    } else if ($horario->tipo == 0) {
                        if ($horaActual  >= $horario->hora_inicio && $horaActual  <= $sumaInicioFormateada) {
                            if (!$registro->registro_inicio) {
                                $registro->registro_inicio = $horaActual;
                                $registro->save();
                                Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $horaActual  . $horario->Nombre);
                                $this->calcularRetraso($registro);
                                $this->verificarmMarcado($registro);
                                // $this->sumarRetrasos($registroactual);
                                return redirect()->back();
                            } else {
                                Session::flash('success', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual  < $horario->hora_final && $horaActual  > $sumaInicioFormateada) {
                            if (!$registro->registro_inicio) {
                                $registro->registro_inicio = $horaActual;
                                $registro->save();
                                $this->calcularRetraso($registro);
                                $this->verificarmMarcado($registro);
                                Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: RETRASO: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('success', ' YA EXISTE REGISTRO DE ENTRADA. HORARIO: ' . $horario->Nombre . ': ' . $registro->registro_entrada);
                                return redirect()->back();
                            }
                        } else if ($horaActual < $horario->hora_inicio && $horaActual >= $horaMinimaInicio) {
                            if (!$registro->registro_inicio) {
                                $registro->registro_inicio = $horaActual;
                                $registro->retraso1 = 0;
                                $registro->minutos_retraso = 0;
                                $registro->save();
                                $this->verificarmMarcado($registro);
                                Session::flash('success', 'SE CREÓ REGISTRO DE ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('success', 'YA REGISTRO SU ENTRADA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            }
                        } else if ($horaActual >= $horario->hora_final && $horaActual <= $horaMaximaFinal) {
                            if (!$registro->registro_final) {
                                $registro->registro_final = $horaActual;
                                $registro->estado = 0;
                                $registro->save();
                                $this->verificarmMarcado($registro);
                                // $this->sumarRetrasos($registroactual);
                                Session::flash('success', 'SE CREÓ REGISTRO DE SALIDA: ' . $horaMaximaFinal . ' ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            } else {
                                Session::flash('success', 'YA REGISTRO SU SALIDA: ' . $registro->retraso1 . $horaActual  . $horario->Nombre);
                                return redirect()->back();
                            }
                        } else if ($horaActual > $horaMaximaFinal || $horaActual < $horaMinimaInicio) {

                            Session::flash('error', 'FUERA DE HORARIO LABORAL: Tipo :' . $horario->tipo . ' ' . $horario->Nombre);
                            return redirect()->back();
                        }
                        return redirect()->back();
                    }
                }
            }
        } else {
            Session::flash('error', 'El PIN ingresado no corresponde a ningún empleado.');
            return redirect()->back();
        }
    }

    public function marcadoDactilar(Request $request)
    {



        // Validar los datos del formulario

        $data = $request->json()->all();
        $hora = $data['hora'];
        $empleadoId = $data['id'];

        try {
            //encontrar empleado



            $emp = EmpleadosModel::where('idemp', $empleadoId)
                ->where('estadoemp1', 1)
                ->where('estadoemp2', 1)
                ->first();




            $horaActual = Carbon::parse($hora)->format('H:i:s');
            $horaActualCarbon = Carbon::parse($horaActual); // Parse the input string to a Carbon instance
            $horaActualCarbon2 = Carbon::parse($horaActual);

            $horaMinima = $horaActualCarbon->subMinutes(60)->format('H:i:s');
            $horaMaxima = $horaActualCarbon2->addMinutes(60)->format('H:i:s');

            // Si el empleado existe, busca el horario activo del empleado
            if ($emp) {

                $horario = $emp->horarios()
                    ->select([
                        'horarios.id',
                        'hora_entrada',
                        'hora_salida',
                        'excepcion',
                        'Nombre'
                    ])
                    ->where('hora_entrada', '<=', $horaMaxima)
                    ->where('hora_salida', '>=', $horaMinima)
                    ->where('estado', 1)
                    ->first();

                if (!$horario) {
                    // No se encontró un horario válido para la hora actual
                    return response()->json(['error' =>  "NO SE ENCONTRÓ HORARIO DEL EMPLEADO PARA REGISTRO"]);
                } else {

                    $horarioID = $horario->id;
                    $registro = $emp
                        ->registrosAsistencia()
                        ->whereDate('created_at', Carbon::today())
                        ->where('horario_id', $horarioID)
                        ->first();

                    if (!$registro) {
                        if ($horaActual >= $horario->hora_entrada && $horaActual <= $horario->excepcion) {
                            $registroactual = new RegistroAsistencia();
                            $registroactual->empleado_id = $emp->idemp;
                            $registroactual->horario_id = $horario->id;
                            $registroactual->registro_entrada = $horaActual;
                            $registroactual->save();
                            $message = "SE CREÓ REGISTRO DE ENTRADA: " . $horaActual  . "\n
                            Horario: " . $horario->Nombre;

                            $this->calcularRetraso($registroactual);
                            $this->sumarRetrasos($registroactual);
                        } else if ($horaActual < $horario->hora_salida && $horaActual > $horario->excepcion) {

                            $registroactual = new RegistroAsistencia();
                            $registroactual->empleado_id = $emp->idemp;
                            $registroactual->horario_id = $horario->id;
                            $registroactual->registro_entrada = $horaActual;
                            $registroactual->save();

                            $this->calcularRetraso($registroactual);
                            $this->sumarRetrasos($registroactual);
                            $message = "SE CREÓ REGISTRO DE ENTRADA. \n
                            Retrasos: " . $registroactual->minutos_retraso . "Horario: " . $horario->Nombre;
                        } else if ($horaActual < $horario->hora_entrada) {
                            $registroactual = new RegistroAsistencia();
                            $registroactual->empleado_id = $emp->idemp;
                            $registroactual->horario_id = $horario->id;
                            $registroactual->registro_entrada = $horaActual;
                            $registroactual->minutos_retraso = 0;

                            $this->sumarRetrasos($registroactual);
                            $registroactual->save();
                            $message = "SE CREÓ REGISTRO DE ENTRADA.\n
                            Horario: " . $horario->Nombre;
                        } else if ($horaActual >= $horario->hora_salida) {
                            $registroactual = new RegistroAsistencia();
                            $registroactual->empleado_id = $emp->idemp;
                            $registroactual->horario_id = $horario->id;
                            $registroactual->registro_salida = $horaActual;

                            $registroactual->minutos_retraso = 0;
                            $this->sumarRetrasos($registroactual);
                            $registroactual->save();
                            $message = "SE CREÓ REGISTRO DE SALIDA GUARDADO EXITOSAMENTE.\n 
                            Salida." . $registroactual->registro_salida;
                        }

                        $responseData = [
                            'exito' => $message,
                        ];


                        return response()->json($responseData);
                    } else {
                        //Session::flash('info', "SE ENCONTRÓ REGISTRO PARA HORARIO - : "  . $horario->Nombre);
                        if ($horaActual >= $horario->hora_salida) {

                            if (!$registro->registro_salida) {
                                $registro->registro_salida = $horaActual;
                                $registro->save();
                                $this->sumarRetrasos($registro);
                                return response()->json(['success' => "REGISTRO DE SALIDA GUARDADO EXITOSAMENTE. \n
                                Retrasos" . $registro->minutos_retraso . " Horario :" . $horario->Nombre]);
                            } else {
                                return response()->json(['info' => "YA EXISTE REGISTRO DE SALIDA. \n
                                HORARIO: " . $registro->horario->Nombre . "Salida: " . $registro->registro_entrada]);
                            }
                        } else if ($horaActual < $horario->hora_entrada) {

                            if (!$registro->registro_entrada) {
                                $registro->registro_entrada = $horaActual;
                                $registro->save();
                                $this->calcularRetraso($registro);
                                $this->sumarRetrasos($registro);
                                return response()->json(['success' => "REGISTRO DE ENTRADA GUARDADO EXITOSAMENTE. \n
                                Retrasos: " . $registro->minutos_retraso . "Horario :" . $horario->Nombre]);
                            } else {
                                return response()->json(['info' => "YA EXISTE REGISTRO DE ENTRADA. \n 
                                HORARIO: " . $registro->horario->Nombre . "Entrada: " . $registro->registro_entrada]);
                            }
                        } else if ($horaActual <= $horario->hora_salida && $horaActual > $horario->excepcion) {
                            if (!$registro->registro_entrada) {
                                $registro->registro_entrada = $horaActual;
                                $registro->save();
                                $this->calcularRetraso($registro);
                                $this->sumarRetrasos($registro);

                                return response()->json(['success' => "REGISTRO DE ENTRADA GUARDADO EXITOSAMENTE.\n 
                                Retrasos" . $registro->minutos_retraso . "Horario: " . $horario->Nombre]);
                            } else {
                                return response()->json(['info' => "YA EXISTE REGISTRO DE ENTRADA. \n
                                HORARIO: " . $horario->Nombre . "Entrada: " . $registro->registro_entrada]);
                            }
                        } else if ($horaActual >= $horario->hora_entrada && $horaActual <= $horario->excepcion) {
                            if (!$registro->registro_entrada) {
                                $registro->registro_entrada = $horaActual;
                                $registro->save();
                                $this->calcularRetraso($registro);
                                $this->sumarRetrasos($registro);

                                return response()->json(['success' => "REGISTRO DE ENTRADA GUARDADO EXITOSAMENTE. \n
                                Retrasos: " . $registro->minutos_retraso . " Horario :" . $horario->Nombre]);
                            } else {
                                return response()->json(['info' => " YA EXISTE REGISTRO DE ENTRADA.\n
                                HORARIO: " . $horario->Nombre . "Entrada: " . $registro->registro_entrada]);
                            }
                        }
                    }
                }
            } else {
                // Si el PIN no corresponde a ningún empleado, mostrar un mensaje de error
                return response()->json(['error' => "El ID no corresponde a ningún empleado."]);
            }
        } catch (\Exception $e) {
            // Catch any exception that may occur and return an error message with the exception message
            return response()->json(['error' => "Error interno del servidor" . $e], 500);
        }
    }
}
