<?php

namespace App\Http\Controllers;

use App\Exports\ReporteAraePorFechasExport;
use App\Exports\ReporteGeneralPorFechasExport;
use App\Exports\ReportePorFechasExport;
use App\Models\AreasModel;
use App\Models\DescuentoModel;
use App\Models\ReporteModel;
use App\Models\EmpleadosModel;
use App\Models\FileModel;
use App\Models\HorarioModel;
use App\Models\NivelModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\RegistroAsistencia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = ReporteModel::all();

            return DataTables::of($data)

                ->addColumn('mes_año', function ($row) {
                    if ($row->fecha_inicio) {
                        $fechaCarbon = Carbon::parse($row->fecha_inicio);
                        $fechaEnEspañol = $fechaCarbon->locale('es')->isoFormat('MMMM YYYY');
                        $fechaEnMayusculas = mb_strtoupper($fechaEnEspañol, 'UTF-8');
                        return $fechaEnMayusculas;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('fecha_inicio', function ($row) {
                    return $row->fecha_inicio ?? '-';
                })
                ->addColumn('fecha_final', function ($row) {
                    return $row->fecha_final ?? '-';
                })
                ->addColumn('actions', function ($row) {
                    return
                        '<a class="tts:left tts-slideIn tts-custom" aria-label="Ver Reporte" href="' . route('reportes.show', $row->id) . '">
                            <button class="btn btn-sm btn-info font-verdana" type="button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('asistencias.reportes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = DB::table('areas')
            ->get();

        $empleados = EmpleadosModel::where('estadoemp1', 1)
            ->where('estadoemp2', 1)
            ->select('idemp', 'nombres', 'ap_mat', 'ap_pat')
            ->get();

        return view('asistencias.reportes.create', compact('empleados', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
        ]);

        try {
            $reporte = new ReporteModel;
            $reporte->fill($request->all());
            $reporte->save();

            $empleados = EmpleadosModel::whereHas('retrasos', function ($query) use ($request) {
                $query->where('minutos_diario', '>', 0)
                    ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_final]);
            })->get();


            //$empleados = EmpleadosModel::all();

            foreach ($empleados as $empleado) {

                // Obtener la suma de retrasos diarios del empleado para el rango de fechas
                // Convertir timestamps a DATE
                $suma_retrasos = RetrasosEmpleado::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_final])
                    ->sum('minutos_diario');
                $observacion = '';

                // Buscar el descuento correspondiente en la tabla "descuentos"
                $descuento = DescuentoModel::where('retraso_max', '>=', $suma_retrasos)->orderBy('retraso_max', 'asc')->first();

                if ($descuento) {
                    $observacion = $descuento->descripcion;
                } else {
                    $descuento = DescuentoModel::where('retraso_max', '<=', $suma_retrasos)->orderBy('retraso_max', 'desc')->first();

                    $observacion = $descuento->descripcion;
                }


                $reporte->empleados()->attach($empleado, [
                    'total_retrasos' => $suma_retrasos,
                    'observaciones' => $observacion,
                ]);
            }
            return response()->json(['success' => 'Datos guardados con éxito']);
        } catch (\Exception $e) {
            // Catch any exception that may occur and return an error message
            return response()->json(['error' => 'Error al guardar datos']);
        }
    }


    public function areaGetReporte(Request $request)
    {
        if ($request->ajax()) {

            $fechaInicio = $request->input('fecha_inicio2');
            $fechaFinal = $request->input('fecha_final2');
            $area_id = $request->input('area_id');

            $data = $this->areaConsulta($request, $area_id, $fechaInicio, $fechaFinal);



            return response()->json($data);
        }

        // For non-AJAX requests, return the view

    }


    public function personalgetReporte(Request $request)
    {
        if ($request->ajax()) {
            $empleado_id = $request->input('empleado');
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFinal = $request->input('fecha_final');

            $data = $this->personalConsulta($request, $empleado_id, $fechaInicio, $fechaFinal);


            return response()->json($data);
        }
    }

    public function asistenciapersonalreportes(Request $request)
    {
        //  if ($request->ajax()) {
        $empleado_id = $request->input('empleado');

        // Asegúrate de que las fechas se están parseando correctamente
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFinal = $request->input('fecha_final');

        $registros = $this->registropPersonalConsulta($empleado_id, $fechaInicio, $fechaFinal);

        return DataTables::of($registros)
            ->addColumn('fecha', function ($item) {
                return $item['fecha'];
            })
            ->addColumn('horario', function ($row) {
                $nombre = $row->horario->Nombre ?: '';
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
                    return 'Falta';
                } else if ($row->estado == 1) {
                    return 'Registrado';
                } else if ($row->estado == 2) {
                    return 'Falta';
                } else if ($row->estado == 3) {
                    # code...

                    return 'Marcado Biometrico'; // Puedes personalizar este mensaje según sea necesario
                } else {
                    return '-';
                }
            })
            ->rawColumns(['horario'])
            ->make(true);
        // }
    }
    private function calculateObservation($suma_retrasos)
    {
        $observacion = '';

        $descuento = DescuentoModel::where('retraso_max', '>=', $suma_retrasos)->orderBy('retraso_max', 'asc')->first();

        if ($descuento) {
            $observacion = $descuento->descripcion;
        } else {
            $descuento = DescuentoModel::where('retraso_max', '<=', $suma_retrasos)->orderBy('retraso_max', 'desc')->first();
            $observacion = $descuento->descripcion;
        }

        return $observacion;
    }

    public function detalle($id, $fechaI, $fechaF)
    {
        $retrasos = RegistroAsistencia::where('empleado_id', $id)
            ->whereBetween('fecha', [$fechaI, $fechaF])
            ->whereNotIn('estado', [0, 2])
            ->where('minutos_retraso', '>', 0)
            ->get();
        return Datatables::of($retrasos)
            ->addColumn('fecha', function ($row) {
                return $row->fecha ?: '-';
            })
            ->addColumn('horario', function ($row) {
                $horario = $row->horario->Nombre;
                return $horario;
            })

            ->make(true);
    }



    public function visualizar(Request $request)
    {
        $empleado_id = $request->input('empleado');

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFinal = $request->input('fecha_final');
        $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->first();


        return view('asistencias.reportes.reporte-personal', compact('empleadoDatos', 'empleado_id', 'fechaInicio', 'fechaFinal'));
    }
    public function visualizar2(Request $request)
    {
        $area_id = $request->input('area_id');
        $fechaInicio = $request->input('fecha_inicio2');
        $fechaFinal = $request->input('fecha_final2');

        return view('asistencias.reportes.reporte-area', compact('area_id', 'fechaInicio', 'fechaFinal'));
    }
    public function visualizar3(Request $request)
    {

        $fechaInicio = $request->input('fecha_inicio3');
        $fechaFinal = $request->input('fecha_final3');

        return view('asistencias.reportes.reporte-general', compact('fechaInicio', 'fechaFinal'));
    }


    public function registro(Request $request)
    {

        $empleado_id = $request->input('empleado2');
        $fechaInicio = $request->input('fecha_inicio4');
        $fechaFinal = $request->input('fecha_final4');
        $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->first();

               // Generar un arreglo de fechas dentro del rango deseado
               $fechas = [];
               $fechaActual = Carbon::parse($fechaInicio);
               $fechaFinCarbon = Carbon::parse($fechaFinal);
               while ($fechaActual->lte($fechaFinCarbon)) {
                   $fechas[] = $fechaActual->toDateString();
                   $fechaActual->addDay();
               }
       
               // Obtener los registros de asistencia para las fechas dentro del rango
               $data = RegistroAsistencia::whereBetween('fecha', [$fechaInicio, $fechaFinal])
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
       
                       $nombreEmpleado = $nom . ' ' . $ap_pat . ' ' . $ap_mat;
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
                           'est' => 4,
                           'ovb' => null,
                           'ht' => null
       
                           // Agregar más propiedades según tus necesidades
                       ];
                   }
               }

        return view('asistencias.reportes.reporte-asistencia-personal', compact('registros','empleadoDatos', 'empleado_id', 'fechaInicio', 'fechaFinal'));
    }

    public function personalConsulta($request, $id, $fechaI, $fechaF)
    {
        // Después de recibir los parámetros, no es necesario asignarlos a nuevas variables.
        // Puedes utilizar directamente $id, $fechaI, y $fechaF.
        $empleadoId = $request->input('empleadoId');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFinal = $request->input('fechaFinal');

        $query = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($id, $fechaI, $fechaF) {
            $query
                ->where('empleado_id', $id)
                ->where('estado', [1,3]) // Puedes omitir el '=', ya que es el valor predeterminado.
                ->where('minutos_retraso', '>', 0)
                ->whereBetween('fecha', [$fechaI, $fechaF])
                ->orderBy('fecha', 'asc'); // o 'desc' para ordenar en orden descendente
        });

        $totalRecords = $query->count();
        $empleados = $query->get();
        $empleadosData = [];

        foreach ($empleados as $empleado) {
            // Utiliza el método sum directamente en la relación registrosAsistencia.
            $suma_retrasos = $empleado->registrosAsistencia()
                ->whereBetween('fecha', [$fechaI, $fechaF])
                ->where('estado', [1,3]) // Puedes omitir el '=', ya que es el valor predeterminado.
                ->orderBy('fecha', 'asc') // o 'desc' para ordenar en orden descendente
                ->sum('minutos_retraso');

            $observacion = $this->calculateObservation($suma_retrasos);

            $empleadosData[] = [


                'details_url' => route('reportespersonales.detalle', ['id' => $empleado->idemp, 'fecha_i' => $fechaI, 'fecha_f' => $fechaF]),
                'idemp' => $empleado->idemp,
                'empleado' => "{$empleado->nombres} {$empleado->ap_pat} {$empleado->ap_mat}",
                'total_retrasos' => $suma_retrasos,
                'observaciones' => $observacion,

            ];
        }

        $data = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $empleadosData,
        ];
        return $data;
    }


    public function areaConsulta(Request $request, $id, $fechaI, $fechaF)
    {
        $area_id = $id;
        $fechaInicio = $fechaI;
        $fechaFinal = $fechaF;

        $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query)
        use ($fechaInicio, $fechaFinal) {
            $query
                ->where('estado', '=', [1,3])
                ->where('minutos_retraso', '>', 0)
                ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
        })->where('idarea', $area_id)
            ->select('idemp', 'nombres', 'ap_mat', 'ap_pat')
            ->get();



        $totalRecords = $empleados->count();

        $areaempleadosData = [];

        foreach ($empleados as $empleado) {
            $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                ->where('estado', '=', [1,3])
                ->sum('minutos_retraso');

            $observacion = $this->calculateObservation($suma_retrasos);

            $areaempleadosData[] = [
                'details_url' => (function ($empleado) use ($fechaInicio, $fechaFinal) {
                    return route('reportespersonales.detalle', ['id' => $empleado->idemp, 'fecha_i' => $fechaInicio, 'fecha_f' => $fechaFinal]);
                })($empleado),
                'idemp' => $empleado->idemp,
                'empleado' => $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat,
                'total_retrasos' => $suma_retrasos,
                'observaciones' => $observacion,
            ];
        }

        $data = [
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $areaempleadosData,
        ];
        return $data;
    }


    public function allGetReporte(Request $request)
    {
        if ($request->ajax()) {

            $fechaInicio = $request->input('fecha_inicio3');
            $fechaFinal = $request->input('fecha_final3');
            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query
                    ->where('estado', '=', [1,3])
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
            })

                ->select('idemp', 'nombres', 'ap_mat', 'ap_pat')
                ->get();


            $totalRecords = $empleados->count();

            $areaempleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                    ->sum('minutos_retraso');

                $observacion = $this->calculateObservation($suma_retrasos);

                $areaempleadosData[] = [
                    'details_url' => (function ($empleado) use ($fechaInicio, $fechaFinal) {
                        return route('reportespersonales.detalle', ['id' => $empleado->idemp, 'fecha_i' => $fechaInicio, 'fecha_f' => $fechaFinal]);
                    })($empleado),
                    'idemp' => $empleado->idemp,
                    'empleado' => $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat,
                    'total_retrasos' => $suma_retrasos,
                    'observaciones' => $observacion,
                ];
            }

            $data = [
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $areaempleadosData,
            ];

            return response()->json($data);
        }
        // For non-AJAX requests, return the view
    }

    public function registropPersonalConsulta($id, $fechaI, $fechaF)
    {

        $empleado_id = $id;

        $fechaInicio = $fechaI;
        $fechaFinal = $fechaF;
        $fechaInicio = Carbon::parse($fechaInicio);
        $fechaFinal = Carbon::parse($fechaFinal);

        $registros = RegistroAsistencia::with('horario')->with(['empleado' => function ($query) {
            $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
        }])
            ->where('empleado_id', $empleado_id)
            ->whereBetween('fecha', [$fechaI, $fechaF])
            ->orderBy('fecha', 'asc') // o 'desc' para ordenar en orden descendente
            ->get();

        return $registros;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReporteModel  $reporteModel
     * @return \Illuminate\Http\Response
     */
    public function show(ReporteModel $reporte)
    {
        $reportes = $reporte->empleados()->with('empleado')->get();
        if (request()->ajax()) {
            return DataTables::of($reportes)
                ->addColumn('empleado', function ($row) {
                    return  $row->empleado->nombres ?? '-';
                })
                ->addColumn('apellidos', function ($row) {
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('total_retrasos', function ($row) {
                    return $row->pivot->total_retrasos;
                })
                ->addColumn('observaciones', function ($row) {
                    return $row->pivot->observaciones;
                })
                ->toJson();


            $currentDate = now();
        }
        return view('asistencias.reportes.show', compact('reporte', 'reportes'));
    }



    public function previsualizarPdf(Request $request)
    {
        try {
            $userID = Auth::user()->idemp;
            $datoUsuario = EmpleadosModel::where('idemp', $userID)
                ->select('nombres', 'ap_pat', 'ap_mat')
                ->first();
            
            $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;


            $empleado_id = request('empleadoId');
            $fechaInicio = request('fechaInicio');
            $fechaFinal = request('fechaFinal');
            // $empleadoDatos = EmpleadosModel::where('idemp', $empleado_id)->select('nombres','ap_pat','ap_mat','ci')->with('empleadosareas')->first();
            $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->first();



            $query = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($empleado_id, $fechaInicio, $fechaFinal) {
                $query
                    ->where('empleado_id', $empleado_id)
                    ->where('estado', '=', [1,3])
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
            });


            $totalRecords = $query->count();

            $query->skip($request->input('start'))
                ->take($request->input('length'));

            $empleados = $query->get();

            $empleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                    ->where('estado', '=', [1,3])
                    ->sum('minutos_retraso');

                $observacion = $this->calculateObservation($suma_retrasos);


                $empleadosData[] = [

                    'idemp' => $empleado->idemp,
                    'empleado' => $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat,
                    'total_retrasos' => $suma_retrasos,
                    'observaciones' => $observacion,
                ];
            }
            $retrasos = RegistroAsistencia::where('empleado_id', $empleado_id)
                ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                ->where('minutos_retraso', '>', 0)

                ->where('estado', '=', [1,3])
                ->get();

            $data = [
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $empleadosData,

            ];

            $pdf = PDF::loadView('asistencias.reportes.reporte-personal-pdf', compact(['retrasos', 'empleadoDatos', 'data', 'fechaInicio', 'fechaFinal','nombreCompleto']));
            $pdf->setPaper('LETTER', 'Portrait');
            return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function areaprevisualizarPdf(Request $request)
    {
        try {

            $userID = Auth::user()->idemp;
            $datoUsuario = EmpleadosModel::where('idemp', $userID)
                ->select('nombres', 'ap_pat', 'ap_mat')
                ->first();
            
            $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;
            $area_id = request('area_id');
            $fechaInicio = request('fechaInicio');
            $fechaFinal = request('fechaFinal');

            $areasDatos =  AreasModel::where('idarea', $area_id)->first();
          
            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query

                    ->where('estado', '=', [1,3])
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
            })
                ->where('idarea', $area_id)
                ->select('idemp', 'nombres', 'ap_mat', 'ap_pat', 'ci')
                ->get();



            $totalRecords = $empleados->count();

            $areaempleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                    ->sum('minutos_retraso');

                $observacion = $this->calculateObservation($suma_retrasos);

                $areaempleadosData[] = [
                    'empleado' => $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat,
                    'ci' => $empleado->ci,
                    'total_retrasos' => $suma_retrasos,
                    'observaciones' => $observacion,
                ];
            }

            $data = [
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $areaempleadosData,
            ];






            $pdf = PDF::loadView('asistencias.reportes.reporte-area-pdf', compact(['nombreCompleto','areasDatos', 'data', 'fechaInicio', 'fechaFinal']));
            $pdf->setPaper('LETTER', 'Portrait');
            return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function generalReportePdf(Request $request)
    {
        try {

            $userID = Auth::user()->idemp;
            $datoUsuario = EmpleadosModel::where('idemp', $userID)
                ->select('nombres', 'ap_pat', 'ap_mat')
                ->first();
            
            $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;
            // $empleadoId = $request->input('empleadoId');
            $fechaInicio = $request->input('fechaInicio');
            $fechaFinal = $request->input('fechaFinal');

            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query

                    ->where('estado', '=', [1,3])
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
            })

                ->select('idemp', 'nombres', 'ap_mat', 'ap_pat')
                ->get();



            $totalRecords = $empleados->count();

            $areaempleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                    ->sum('minutos_retraso');

                $observacion = $this->calculateObservation($suma_retrasos);

                $areaempleadosData[] = [
                    'empleado' => $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat,
                    'total_retrasos' => $suma_retrasos,
                    'observaciones' => $observacion,
                ];
            }

            $data = [
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $areaempleadosData,
            ];





            $pdf = PDF::loadView('asistencias.reportes.reporte-general-pdf', compact(['data', 'fechaInicio', 'fechaFinal','nombreCompleto']));
            $pdf->setPaper('LETTER', 'Portrait');
            return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function asistenciaPdf(Request $request)
    {

        try {

            $userID = Auth::user()->idemp;
            $datoUsuario = EmpleadosModel::where('idemp', $userID)
                ->select('nombres', 'ap_pat', 'ap_mat')
                ->first();
            
            $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;


            $empleado_id = request('empleadoId');
            $fechaInicio = request('fechaInicio');
            $fechaFinal = request('fechaFinal');
            $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->first();
            $fechas = [];
            $fechaActual = Carbon::parse($fechaInicio);
            $fechaFinCarbon = Carbon::parse($fechaFinal);
            while ($fechaActual->lte($fechaFinCarbon)) {
                $fechas[] = $fechaActual->toDateString();
                $fechaActual->addDay();
            }
    
            // Obtener los registros de asistencia para las fechas dentro del rango
            $data = RegistroAsistencia::whereBetween('fecha', [$fechaInicio, $fechaFinal])
                ->where('empleado_id', 1)
                ->get();
    
    
    
            // Combinar los registros con las fechas, rellenando los días sin registros con valores nulos
            $registros = [];
            foreach ($fechas as $fecha) {
                $reg = $data->where('fecha', $fecha)->first();
    
                if ($reg) {
                     $nom = $reg->empleado->nombres ?? ' ';
                    $ap_pat = $reg->empleado->ap_pat ?? ' ';
                    $ap_mat = $reg->empleado->ap_mat ?? ' ';
                      $ap =  $ap_pat. ' '.   $ap_mat ;
                    $hi = $reg->horario->hora_inicio ? Carbon::parse($reg->horario->hora_inicio)->format('H:i') : '-';
    
                    $hf = $reg->horario->hora_final ? Carbon::parse($reg->horario->hora_final)->format('H:i') : '-';
    
                    $hs = $reg->horario->hora_salida ? Carbon::parse($reg->horario->hora_salida)->format('H:i') : '-';
                    $he = $reg->horario->hora_entrada ? Carbon::parse($reg->horario->hora_entrada)->format('H:i') : '-';
                    $hn = $reg->horario->Nombre;
                    $ht = $reg->horario->tipo;
                    $est = $reg->estado;
                    $ovb = $reg->observ;
    
    
                    // Ajusta el nombre de la relación según corresponda en tu modelo
                    $reg->ht= $ht;
                    $reg->hs = $hs;
                    $reg->he = $he;
                    $reg->hi = $hi;
                    $reg->hf = $hf;
                    $reg->hn = $hn;
                    $reg->est =  $est;
                    $reg->ovb =  $ovb;
                    $reg->ap = $ap;
    
    
    
                    $reg->nombre_empleado = $nom;
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
                        'ht' => null,
                        'est' => null,
                        'est' => null,
                        'ovb' => null,
                        'ap' => null,

                        // Agregar más propiedades según tus necesidades
                    ];
                }
            }

            $pdf = PDF::loadView('asistencias.reportes.pdf-reporte-personal-asistencias', compact(['registros', 'empleadoDatos',   'fechaInicio', 'fechaFinal','nombreCompleto']));
            $pdf->setPaper('LETTER', 'portrait');
            $pdf->getDomPDF()->getOptions()->setDefaultFont('Calibri');

            return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function generarExcelReporte(Request $request)
    {
        $userID = Auth::user()->idemp;
        $datoUsuario = EmpleadosModel::where('idemp', $userID)
            ->select('nombres', 'ap_pat', 'ap_mat')
            ->first();
        
        $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;
        $empleado_id = request('empleadoId');
        $fechaInicio = request('fechaInicio');
        $fechaFinal = request('fechaFinal');

        $data = $this->personalConsulta($request, $empleado_id, $fechaInicio, $fechaFinal);
        $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->select('nombres', 'ap_pat', 'ap_mat', 'idarea', 'ci')->first();


        $view =  view('asistencias.reportes.reporte-personal-excel', compact(['empleadoDatos', 'data', 'fechaInicio', 'fechaFinal']));

        // Asegúrate de tener un modelo que represente tus datos
        $fileName = 'reporte_por_fechas.xlsx';
        return Excel::download(new ReportePorFechasExport($view), $fileName);
    }
    
    public function generarExcelAreaReporte(Request $request)
    {

        $userID = Auth::user()->idemp;
        $datoUsuario = EmpleadosModel::where('idemp', $userID)
            ->select('nombres', 'ap_pat', 'ap_mat')
            ->first();
        
        $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;
        $area_id = request('area_id');
        $fechaInicio = request('fechaInicio');
        $fechaFinal = request('fechaFinal');

        $data = $this->areaConsulta($request, $area_id, $fechaInicio, $fechaFinal);
        $areasDatos =  AreasModel::where('idarea', $area_id)->first();


        $view =  view('asistencias.reportes.reporte-area-excel', compact(['areasDatos', 'data', 'fechaInicio', 'fechaFinal','nombreCompleto']));

        // Asegúrate de tener un modelo que represente tus datos
        $fileName = 'reporte_area_por_fechas.xlsx';
        return Excel::download(new ReporteAraePorFechasExport($view), $fileName);
    }

    public function ExcelGeneralReporte(Request $request)
    {

      
        $userID = Auth::user()->idemp;
        $datoUsuario = EmpleadosModel::where('idemp', $userID)
            ->select('nombres', 'ap_pat', 'ap_mat')
            ->first();
        
        $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;
        $fechaInicio = request('fechaInicio');
        $fechaFinal = request('fechaFinal');


        $fechaInicio = $request->input('fechaInicio');
        $fechaFinal = $request->input('fechaFinal');

        $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
            $query

                ->where('estado', '=', [1,3])
                ->where('minutos_retraso', '>', 0)
                ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
        })

            ->select('idemp', 'nombres', 'ap_mat', 'ap_pat')
            ->get();



        $totalRecords = $empleados->count();

        $areaempleadosData = [];

        foreach ($empleados as $empleado) {
            $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                ->sum('minutos_retraso');

            $observacion = $this->calculateObservation($suma_retrasos);

            $areaempleadosData[] = [
                'empleado' => $empleado->nombres,
                'total_retrasos' => $suma_retrasos,
                'observaciones' => $observacion,
            ];
        }

        $data = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $areaempleadosData,
        ];



        $view =  view('asistencias.reportes.reporte-general-excel', compact(['data', 'fechaInicio', 'fechaFinal','nombreCompleto']));

        // Asegúrate de tener un modelo que represente tus datos
        $fileName = 'reporte_general_por_fechas.xlsx';
        return Excel::download(new     ReporteGeneralPorFechasExport($view), $fileName);
    }
    public function excelRegistroReporte(Request $request)
    {

              $userID = Auth::user()->idemp;
            $datoUsuario = EmpleadosModel::where('idemp', $userID)
                ->select('nombres', 'ap_pat', 'ap_mat')
                ->first();
            
            $nombreCompleto = $datoUsuario->nombres . ' ' . $datoUsuario->ap_pat . ' ' . $datoUsuario->ap_mat;

        $empleado_id = request('empleadoId');
        $fechaInicio = request('fechaInicio');
        $fechaFinal = request('fechaFinal');
        $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->first();

        $registros = $this->registropPersonalConsulta($empleado_id, $fechaInicio, $fechaFinal);


        $view =  view('asistencias.reportes.excel-reporte-personal-asistencias', compact(['nombreCompleto','registros', 'empleadoDatos',   'fechaInicio', 'fechaFinal']));

        // Asegúrate de tener un modelo que represente tus datos
        $fileName = 'reporte_por_fechas.xlsx';
        return Excel::download(new ReportePorFechasExport($view), $fileName);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReporteModel  $reporteModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ReporteModel $reporteModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReporteModel  $reporteModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReporteModel $reporteModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReporteModel  $reporteModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReporteModel $reporteModel)
    {
        //
    }
}
