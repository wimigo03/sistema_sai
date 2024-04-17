<?php

namespace App\Http\Controllers;

use App\Models\EmpleadosModel;
use App\Models\RegistroAsistencia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Sabberworm\CSS\Property\Selector;

class EmpleadoAsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('asistencias.empleados.index');
    }


    public function planta()
    {
        $areasExcluidas = [33, 34];



        $data = EmpleadosModel::with(['horarios' => function ($query) {
            $query->where('estado', 1); // Filtrar los horarios con estado activo (estado = 1)
        }])->where('tipo', 1)
            ->whereNotIn('idarea', $areasExcluidas)
            ->select(['idemp', 'nombres', 'ap_pat', 'ap_mat']);

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
            ->addColumn('actions1', function ($row) {
                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Datos de Control" href="' . route('horarios.cambio', $row->idemp) . '">
                  <i class="fa-solid fa-2xl fa-bars"></i>
                
            </a>';
            })->addColumn('actions2', function ($row) {
                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regular Asistencia" href="' . route('agregar.regulacion', $row->idemp) . '">

              <i class="fa-solid fa-2xl  fa-calendar-days text-warning"></i>       
      </a>';
            })->addColumn('actions3', function ($row) {
                return ' <a class="tts:left tts-slideIn tts-custom" aria-label="Registros de Asistencia" href="' . route('empleadoasistencias.show', ['id' => $row->idemp]) . '">
                <i class="fa-solid fa-2xl fa-list text-success" aria-hidden="true"></i>
                 
              </a>';
            })
            ->rawColumns(['actions1', 'actions2', 'actions3'])->make(true);
    }
    public function contrato()
    {
        $areasExcluidas = [33, 34];
        $data = EmpleadosModel::with(['horarios' => function ($query) {
            $query->where('estado', 1); // Filtrar los horarios con estado activo (estado = 1)
        }])->where('tipo', 2)
            ->whereNotIn('idarea', $areasExcluidas)
            ->select(['idemp', 'nombres', 'ap_pat', 'ap_mat']);

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
            ->addColumn('actions1', function ($row) {
                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Datos de Control" href="' . route('horarios.cambio', $row->idemp) . '">
                <i class="fa-solid fa-2xl fa-bars"></i>
                
            </a>';
            })->addColumn('actions2', function ($row) {
                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regular Asistencia" href="' . route('agregar.regulacion', $row->idemp) . '">

              <i class="fa-solid fa-2xl  fa-calendar-days text-warning"></i>       
      </a>';
            })->addColumn('actions3', function ($row) {
                return ' <a class="tts:left tts-slideIn tts-custom" aria-label="Ver lista de Registros de Asistencia" href="' . route('empleadoasistencias.show', ['id' => $row->idemp]) . '">
                <i class="fa-solid fa-2xl fa-list text-success" aria-hidden="true"></i>
                 
              </a>';
            })
            ->rawColumns(['actions1', 'actions2', 'actions3'])->make(true);
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


    public function show($id, Request $request)
    {
        //$empleado = EmpleadosModel::findOrFail($id)->select('idemp', 'nombres', 'ap_pat')->first();
        $empleado = EmpleadosModel::where('idemp', $id)->select('idemp', 'nombres', 'ap_pat', 'ap_mat')->first();
        if (!$empleado) {
            abort(404); // o maneja de alguna manera el caso en que no se encuentre el registro
        }
        if ($request->ajax()) {

            $filtro = $request->input('filtro', 'actual');

            $data = RegistroAsistencia::where('empleado_id', $id)
                ->with([
                    'horario' => function ($query) {
                        $query->select('id', 'Nombre', 'hora_inicio', 'hora_entrada', 'hora_salida', 'hora_final', 'tipo'); // Add the columns you want for the 'horario' relationship
                    }
                ])->select('fecha', 'registro_inicio', 'registro_salida', 'registro_entrada', 'registro_final', 'horario_id','estado', 'minutos_retraso', 'observ')
                ->get();
            // Aplicar el filtro de fecha según el valor seleccionado
            $nombre_completo = $empleado->nombres . ' ' . $empleado->ap_pat . ' ' . $empleado->ap_mat;
            $filtro = $request->input('filtro');

            if ($filtro == 'actual') {
                $data = $data->where('fecha', Carbon::today()->format('Y-m-d'));
            } elseif ($filtro == 'mensual') {
                $data = $data->filter(function ($item) {
                    return Carbon::parse($item->fecha)->month == Carbon::now()->month;
                });
           }

             return DataTables::of($data)

                ->addColumn('fecha', function ($registro) {
                    return $registro->fecha ?: '-';
                })
                ->addColumn('nombres', function () use ($nombre_completo) {
                    return $nombre_completo ?: '-';
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
                ->addColumn('estado', function ($row) {
                    if ($row->estado == 0) {
                        return 'Falta';
                    } else if ($row->estado == 1) {
                        return 'Registrado';
                    } else if ($row->estado == 2) {
                        return 'Falta';
                    } else if ($row->estado == 3) {
                        # code...

                        return 'Marcado'; // Puedes personalizar este mensaje según sea necesario
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['horario'])->toJson();
       }
        // Pasar el valor del filtro a la vista
        $filtro = $request->input('filtro', 'actual');
        return view('asistencias.empleados.show', compact('empleado', 'filtro'));
    }


    public function agregarRegulacion($id)
    {
        $empleado = EmpleadosModel::where('idemp', $id)->select('idemp', 'nombres', 'ap_pat', 'ap_mat')->first();
        $vistaselectedMonth = Carbon::now()->format('Y-m');

        return view('asistencias.registros.fechas', compact('vistaselectedMonth', 'empleado'));
    }
}
