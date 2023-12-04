<?php

namespace App\Http\Controllers;

use App\Models\AreasModel;
use App\Models\DescuentoModel;
use App\Models\ReporteModel;
use App\Models\EmpleadosModel;
use App\Models\FileModel;
use App\Models\HorarioModel;
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
use Illuminate\Support\Facades\Log;

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



            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query

                    ->where('estado', '=', 1)
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
            })
                ->where('idarea', $area_id)
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

            $query = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($empleado_id, $fechaInicio, $fechaFinal) {
                $query
                    ->where('empleado_id', $empleado_id)
                    ->where('estado', '=', 1)
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
            });


            $totalRecords = $query->count();

            $query->skip($request->input('start'))
                ->take($request->input('length'));

            $empleados = $query->get();

            $empleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                    ->where('estado', '=', 1)
                    ->sum('minutos_retraso');

                $observacion = $this->calculateObservation($suma_retrasos);

                $empleadosData[] = [
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
                'data' => $empleadosData,
            ];

            return response()->json($data);
        }
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
            ->whereBetween('created_at', [$fechaI, $fechaF])
            ->where('estado', '=', 1)
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

    public function allGetReporte(Request $request)
    {
        if ($request->ajax()) {

            $fechaInicio = $request->input('fecha_inicio2');
            $fechaFinal = $request->input('fecha_final2');



            $areasExcluidas = [33, 34]; // Lista de IDs de áreas que deseas excluir

            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query
                    ->where('estado', '=', 1)
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal]);
            })
                ->whereNotIn('idarea', $areasExcluidas)
                ->select('idemp', 'nombres', 'ap_mat', 'ap_pat')
                ->get();




            $totalRecords = $empleados->count();

            $areaempleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('created_at', [$fechaInicio, $fechaFinal])
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

            return response()->json($data);
        }

        // For non-AJAX requests, return the view

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
 

            $empleado_id = request('empleadoId');
            $fechaInicio = request('fechaInicio');
            $fechaFinal = request('fechaFinal');
            // $empleadoDatos = EmpleadosModel::where('idemp', $empleado_id)->select('nombres','ap_pat','ap_mat','ci')->with('empleadosareas')->first();
            $empleadoDatos =  EmpleadosModel::where('idemp', $empleado_id)->with('empleadosareas')->first();

            
       
            $query = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($empleado_id, $fechaInicio, $fechaFinal) {
                $query
                    ->where('empleado_id', $empleado_id)
                    ->where('estado', '=', 1)
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
            });


            $totalRecords = $query->count();

            $query->skip($request->input('start'))
                ->take($request->input('length'));

            $empleados = $query->get();

            $empleadosData = [];

            foreach ($empleados as $empleado) {
                $suma_retrasos = RegistroAsistencia::where('empleado_id', $empleado->idemp)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
                    ->where('estado', '=', 1)
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
            ->where('estado', '=', 1)
            ->get();

            $data = [
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $empleadosData,
                 
            ];




 
            $pdf = PDF::loadView('asistencias.reportes.reporte-personal-pdf', compact(['retrasos','empleadoDatos','data','fechaInicio', 'fechaFinal']));
            $pdf->setPaper('LETTER', 'landscape');
           return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function areaprevisualizarPdf(Request $request)
    {
        try {
 

            $area_id= request('area_id');
            $fechaInicio = request('fechaInicio');
            $fechaFinal = request('fechaFinal');
 

            $areasDatos =  AreasModel::where('idarea', $area_id)->first();

            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query

                    ->where('estado', '=', 1)
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
            })
                ->where('idarea', $area_id)
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
   




 
            $pdf = PDF::loadView('asistencias.reportes.reporte-area-pdf', compact(['areasDatos','data','fechaInicio', 'fechaFinal']));
            $pdf->setPaper('LETTER', 'landscape');
           return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  
    public function   generalReportePdf(Request $request)
    {
        try {
 

    
            $fechaInicio = request('fechaInicio');
            $fechaFinal = request('fechaFinal');
 
 

            $empleados = EmpleadosModel::whereHas('registrosAsistencia', function ($query) use ($fechaInicio, $fechaFinal) {
                $query

                    ->where('estado', '=', 1)
                    ->where('minutos_retraso', '>', 0)
                    ->whereBetween('created_at', [$fechaInicio, $fechaFinal]);
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
   




 
            $pdf = PDF::loadView('asistencias.reportes.reporte-general-pdf', compact(['data','fechaInicio', 'fechaFinal']));
            $pdf->setPaper('LETTER', 'landscape');
           return $pdf->stream();
        } catch (\Exception $e) {

            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
