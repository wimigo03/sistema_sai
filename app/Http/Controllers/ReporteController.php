<?php

namespace App\Http\Controllers;

use App\Models\DescuentoModel;
use App\Models\ReporteModel;
use App\Models\EmpleadosModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


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
        //

        return view('asistencias.reportes.create');
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
                    ->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$request->fecha_inicio, $request->fecha_final]);
            })->get();


            //$empleados = EmpleadosModel::all();

            foreach ($empleados as $empleado) {

                // Obtener la suma de retrasos diarios del empleado para el rango de fechas
                // Convertir timestamps a DATE
                $suma_retrasos = RetrasosEmpleado::where('empleado_id', $empleado->idemp)
                    ->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$request->fecha_inicio, $request->fecha_final])
                    ->sum('minutos_diario');
                $observacion = '';

                // Buscar el descuento correspondiente en la tabla "descuentos"
                 $descuento = DescuentoModel::where('retraso_max', '>=', $suma_retrasos)->orderBy('retraso_max', 'asc')->first();

                if ($descuento) {
                    $observacion = $descuento->descripcion;
                }else{
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
    public function getReporte(Request $request)
    {
        if ($request->ajax()) {
            
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFinal = $request->input('fecha_final');

            $query = EmpleadosModel::whereHas('retrasos', function ($query) use ($fechaInicio, $fechaFinal) {
                $query->where('minutos_diario', '>=', 0)
                    ->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$fechaInicio, $fechaFinal]);
            });

            $totalRecords = $query->count();

            $query->skip($request->input('start'))
                ->take($request->input('length'));

            $empleados = $query->get();

            $empleadosData = [];
            foreach ($empleados as $empleado) {
                $suma_retrasos = RetrasosEmpleado::where('empleado_id', $empleado->idemp)
                    ->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$fechaInicio, $fechaFinal])
                    ->sum('minutos_diario');

                $observacion = '';

                $descuento = DescuentoModel::where('retraso_max', '>=', $suma_retrasos)->orderBy('retraso_max', 'asc')->first();

                if ($descuento) {
                    $observacion = $descuento->descripcion;
                }else{
                    $descuento = DescuentoModel::where('retraso_max', '<=', $suma_retrasos)->orderBy('retraso_max', 'desc')->first();

                    $observacion = $descuento->descripcion;
                }

                $empleadosData[] = [
                    'empleado' => $empleado->nombres,
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
        $empleadosReportes = $reporte->empleados()->with('empleado')->get();
        if (request()->ajax()) {
            return DataTables::of($empleadosReportes)
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
        return view('asistencias.reportes.show', compact('reporte', 'empleadosReportes'));
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