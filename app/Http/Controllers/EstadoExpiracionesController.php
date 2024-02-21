<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\MovimientosPtModel;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class EstadoExpiracionesController extends Controller
{
    /**


     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentDate = now();


        $personashoy = EmpleadosModel::whereDay('expinduccion', $currentDate->day)
            ->whereMonth('expinduccion', $currentDate->month)
            ->where('tipo', 1)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'expinduccion']);

        $cumplenAnioshoy = count($personashoy);

        $expdecjuradahoy = EmpleadosModel::whereDay('natalicio', $currentDate->day)
            ->whereMonth('natalicio', $currentDate->month)
            ->where('tipo', 1)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'expdecjurada']);
        $cumplenexpdecjuradahoy = count($expdecjuradahoy);
        $rejaphoy = EmpleadosModel::whereDay('rejap', $currentDate->day)
            ->whereMonth('rejap', $currentDate->month)
            ->where('tipo', 1)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'rejap']);
        $cumplenrejaphoy = count($rejaphoy);
        $expsippasehoy = EmpleadosModel::whereDay('expsippase', $currentDate->day)
            ->whereMonth('expsippase', $currentDate->month)
            ->where('tipo', 1)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'expsippase']);
        $cumplenexpsippasehoy = count($expsippasehoy);
        $exppoaihoy = EmpleadosModel::whereDay('exppoai', $currentDate->day)
            ->whereMonth('exppoai', $currentDate->month)
            ->where('tipo', 1)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'exppoai']);
        $cumplenexppoaihoy = count($exppoaihoy);
        $expprogvacacionhoy = EmpleadosModel::whereDay('expprogvacacion', $currentDate->day)
            ->whereMonth('expprogvacacion', $currentDate->month)
            ->where('tipo', 1)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'expprogvacacion']);
        $cumplenexpprogvacacionhoy = count($expprogvacacionhoy);
        $expsippase2hoy = EmpleadosModel::whereDay('expsippase', $currentDate->day)
            ->whereMonth('expsippase', $currentDate->month)
            ->where('tipo', 2)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'expsippase']);
        $cumplenexpsippase2hoy = count($expsippase2hoy);
        $rejaphoy2 = EmpleadosModel::whereDay('rejap', $currentDate->day)
            ->whereMonth('rejap', $currentDate->month)
            ->where('tipo', 2)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'rejap']);
        $cumplenrejaphoy2 = count($rejaphoy2);
        $personashoy2 = EmpleadosModel::whereDay('expinduccion', $currentDate->day)
            ->whereMonth('expinduccion', $currentDate->month)
            ->where('tipo', 2)
            ->get(['nombres', 'ap_pat', 'ap_mat', 'expinduccion','idarea']);

        $cumplenAnioshoy2 = count($personashoy2);
 
        //return view('cumpleanios.index', compact('cumplenAnios'));
        return view(
            'asistencias.estado-expiraciones.index',
            compact(
                'personashoy',
                'cumplenAnioshoy',
                'expdecjuradahoy',
                'cumplenrejaphoy',
                'cumplenexpdecjuradahoy',
                'expsippasehoy',
                'cumplenexpsippasehoy',
                'exppoaihoy',
                'cumplenexppoaihoy',
                'expprogvacacionhoy',
                'cumplenexpprogvacacionhoy',
                'expsippase2hoy',
                'cumplenexpsippase2hoy',
                'rejaphoy',
                'rejaphoy2',
                'cumplenrejaphoy2',
                'personashoy2',
                'cumplenAnioshoy2'
            )
        );
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
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {


        $currentDate = now();



        if ($id >= 1 && $id <= 9) {
            $columnName = '';  // Variable para almacenar el nombre de la columna dinámicamente

            switch ($id) {
                case 1:
                    $columnName = 'expinduccion';
                    $descripcion  = 'Inducción Personal';

                    break;
                case 2:
                    $columnName = 'expdecjurada';
                    $descripcion  = 'Declaracion Jurada';

                    break;
                case 3:
                    $columnName = 'rejap';
                    $descripcion  = 'Certificado REJAP';
                    break;
                case 4:
                    $columnName = 'expsippase';
                    $descripcion  = 'Certificado SIPPASE';
                    break;
                case 5:
                    $columnName = 'exppoai';
                    $descripcion  = 'POAI';
                    break;
                case 6:
                    $columnName = 'expprogvacacion';
                    $descripcion  = 'Programacion de Vacaciones';
                    break;
                case 7:
                    $columnName = 'rejap';
                    $descripcion  = 'Certificado REJAP';
                    break;
                case 8:
                    $columnName = 'expsippase';
                    $descripcion  = 'Certificado SIPPASE';

                    break;
                case 9:
                    $columnName = 'expinduccion';
                    $descripcion  = 'Exp. Inducción';

                    break;
                default:
                    // Manejo de error o acción por defecto si el $id no coincide con ninguno de los casos anteriores
                    break;
            }
            $tipo = $descripcion;

            $personasmes = EmpleadosModel::whereMonth($columnName, $currentDate->month)
            ->where('tipo', ($id <= 6) ? 1 : 2)
            ->with('empleadosareas') // Cargar la relación de área
            ->get(['idemp', 'nombres', 'ap_pat', 'ap_mat', $columnName, 'idarea']);
        
        $personasmes = $personasmes->map(function ($item) use ($columnName) {
            return [
                'idemp' => $item['idemp'],
                'nombre_completo' => $item['nombres'] . ' ' . $item['ap_pat'] . ' ' . $item['ap_mat'],
                'fecha' => $item[$columnName],
                'ColumnaPersonalizada' => Carbon::parse($item[$columnName])->diffForHumans(),
                'nombre_area' => $item['empleadosareas']->nombrearea // Agregar el nombre del área
            ];
        });

            if ($request->ajax()) {
                return DataTables::of($personasmes)
                    ->toJson();
            }

            if ($request->ajax()) {

                return DataTables::of($personasmes)
                    // Asignar a la variable personasmes y convertir a JSON
                    ->toJson();
            }
            // Pasar a la vista
            return view('asistencias.estado-expiraciones.lista', compact('id', 'personasmes', 'descripcion'));
        } else {
            return abort(404);
        }
    }


    public function expira()
    {



        return view('asistencias.estado-expiraciones.lista2');
    }

    public function planta()
    {

        $fecha30DiasFuturos = now()->addDays(30)->toDateString();
        $areasExcluidas = [33, 34];
        $data = EmpleadosModel::where('tipo', 1)
            ->whereNotIn('idarea', $areasExcluidas)

            ->get([
                'idemp',
                'nombres',
                'ap_pat',
                'ap_mat',
                'expinduccion',
                'expdecjurada',
                'expsippase',
                'rejap',
                'exppoai',
                'expprogvacacion'
            ]);
        return DataTables::of($data)
            ->addColumn('id', function ($row) {
                return $row->idemp;
            })
            ->addColumn('nomb_aps', function ($row) {
                $nomb = $row->nombres ?? '';
                $ap_pat = $row->ap_pat ?? '';
                $ap_mat = $row->ap_mat ?? '';
                return $nomb . ' ' . $ap_pat . ' ' . $ap_mat;
            })
            ->addColumn('expinduccion', function ($row) {
                if (empty($row->expinduccion)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->expinduccion);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('expdecjurada', function ($row) {
                if (empty($row->expdecjurada)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->expdecjurada);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('expsippase', function ($row) {
                if (empty($row->expsippase)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->expsippase);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('rejap', function ($row) {

                if (empty($row->rejap)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->rejap);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('exppoai', function ($row) {
                if (empty($row->exppoai)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->exppoai);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('expprogvacacion', function ($row) {
                if (empty($row->expprogvacacion)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->expprogvacacion);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })

            ->addColumn('actions', function ($row) {
                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horarios Asignados" href="' . route('planta.editar', $row->idemp) . '">
                <i class="fa-solid fa-2xl fa-edit text-warning"></i>
                
            </a>';
            })->rawColumns(['actions', 'expprogvacacion', 'exppoai', 'rejap', 'expsippase', 'expdecjurada', 'expinduccion'])->make(true);
    }
    public function contrato()
    {
        $areasExcluidas = [33, 34];

        $fecha30DiasFuturos = now()->addDays(30)->toDateString();

        $data = EmpleadosModel::whereNotIn('idarea', $areasExcluidas)
            ->where('tipo', 2)
            ->get([
                'idemp',
                'nombres',
                'ap_pat',
                'ap_mat',

                'expsippase',
                'rejap',
                'expinduccion',

            ]);
        return DataTables::of($data)
            ->addColumn('idemp', function ($row) {
                return $row->idemp;
            })
            ->addColumn('nomb_aps', function ($row) {
                $nomb = $row->nombres ?? '';
                $ap_pat = $row->ap_pat ?? '';
                $ap_mat = $row->ap_mat ?? '';
                return $nomb . ' ' . $ap_pat . ' ' . $ap_mat;
            })

            ->addColumn('expsippase', function ($row) {
                if (empty($row->expsippase)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->expsippase);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('rejap', function ($row) {

                if (empty($row->rejap)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->rejap);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })
            ->addColumn('expinduccion', function ($row) {

                if (empty($row->rejap)) {
                    return '<span style="color: black;">NO TIENE</span>';
                }
                $carbonDate = Carbon::parse($row->rejap);

                return $carbonDate->isPast()
                    ? '<span style="color: red;">' . $carbonDate->diffForHumans() . '</span>'
                    : ($carbonDate->isFuture()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : $carbonDate->diffForHumans());
            })


            ->addColumn('actions', function ($row) {
                return '<a href="' . route('contrato.editar', ['id' => $row->idemp]) . '" class="btn btn-outline-info btn-sm">Editar</a>';
            })->rawColumns(['actions', 'expprogvacacion', 'exppoai', 'rejap', 'expsippase', 'expdecjurada', 'expinduccion'])->make(true);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notificacion  $notificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
