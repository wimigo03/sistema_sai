<?php

namespace App\Http\Controllers;

use App\Models\EmpleadosModel;
use App\Models\RegistroAsistencia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class EmpleadoAsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {


            $data = EmpleadosModel::with(['registrosAsistencia', 'horarios' => function ($query) {
                $query->where('estado', 1); // Filtrar los horarios con estado activo (estado = 1)
            }])->select(['idemp', 'nombres', 'ap_pat', 'ap_mat']);

            $data = $data->get();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return $row->idemp;
                })
                ->addColumn('nombres', function ($row) {
                    return $row->nombres;
                })
                ->addColumn('apellidos', function ($row) {
                    $ap_pat = $row->ap_pat ?? '-';
                    $ap_mat = $row->ap_mat ?? '-';
                    return $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('horario', function ($row) {

                    if ($row->horarios->count() > 0) {
                        $horariosAsignados = $row->horarios->pluck('Nombre')->implode(' - ');
                        return $horariosAsignados;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('actions', function ($row) {
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Ver Registros de Asistencia" href="' . route('empleadoasistencias.show', ['id' => $row->idemp]) . '">
                                <button class="btn btn-sm btn-success font-verdana" type="button"><i class="fa-solid fa-list" aria-hidden="true"></i>
                                </button>
                            </a>' . '       ' . '<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horarios Asignados" href="' . route('horarios.cambio', $row->idemp) . '">
                            <button class="btn btn-sm btn-info font-verdana" type="button"><i class="fa-regular fa-clock"></i>
                            </button>
                        </a>';
                })->rawColumns(['actions'])
                ->toJson();
        }

        return view('asistencias.empleados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
        $empleado = EmpleadosModel::with(['registrosAsistencia'])->where('idemp', $id)->firstOrFail();
        $registros = $empleado->registrosAsistencia;

        if (request()->ajax()) {
            return DataTables::of($registros)
                ->addColumn('fecha', function ($registro) {
                    return $registro->created_at ? Carbon::parse($registro->created_at)->format('Y-m-d') : '-';
                })
                ->addColumn('horario', function ($registro) {
                    return $registro->horario->Nombre ?? '-';
                })
                ->addColumn('hora_entrada', function ($registro) {
                    return $registro->registro_entrada ?? '';
                })
                ->addColumn('hora_salida', function ($registro) {
                    return $registro->registro_salida ?? '-';
                })
                ->addColumn('minutos_retraso', function ($registro) {
                    return $registro->minutos_retraso ?? '-';
                })
                ->toJson();
        }

        return view('asistencias.empleados.show', compact('empleado', 'registros'));
    }
}
