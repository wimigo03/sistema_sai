<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoPermisoModel;
use App\Models\EmpleadosModel;
use App\Models\PermisoModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PermisosPersonalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */






    public function index(Request $request)
    {
        $añoMesActual = Carbon::now()->format('Y-m');
        $permiso =  $this->obtenerOCrearPermiso($añoMesActual);
        return view('permisos.personales.index', compact('permiso', 'añoMesActual'));
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
    public function getID(Request $request)
    {
        $mesAño = $request->input('mesID');


        $permiso =  $this->obtenerOCrearPermiso($mesAño);

        $id =  $permiso->id;
        $fecha = $permiso->mes;

        return response()->json([
            'id' => $id,
            'mes' => $fecha,
        ]);
    }

    public function getEmpleados(Request $request)
    {
        $permiso_id = $request->input('permiso_id');
        $permiso = PermisoModel::find($permiso_id);
        $areasExcluidas = [33, 34];
        $empleados = EmpleadosModel::where('tipo', 1)
            ->whereNotIn('idarea', $areasExcluidas)
            ->select(['idemp', 'nombres', 'ap_mat', 'ap_pat'])
            ->withCount(['permisos as suma_horas_utilizadas' => function ($query) use ($permiso) {
                $query
                    ->where('permisos_mensuales.id', $permiso->id)
                    ->select(DB::raw('sum(horas_utilizadas)'));
            }])
            ->orderBy('idemp') // Ordenar por el campo 'idemp'
            ->get();

        $permisoId = $permiso->id;

        return Datatables::of($empleados)
            ->addColumn('details_url', function ($empleado) use ($permisoId) {
                return route('permisospersonales.detalle', ['id' => $empleado->idemp, 'permiso_id' => $permisoId]);
            })
            ->addColumn('apellidos', function ($empleado) {
                $ap_pat = $empleado->ap_pat ?? '-';
                $ap_mat = $empleado->ap_mat ?? '-';
                return  $ap_pat . ' ' . $ap_mat;
            })
            ->addColumn('total_horas_disponibles', function ($empleado) use ($permiso) {
                $suma_horas_utilizadas = $empleado->suma_horas_utilizadas;
                $horas_permitidas = $permiso->horas_permitidas;
                if ($suma_horas_utilizadas) {

                    $tiempo_disponible = $horas_permitidas - $suma_horas_utilizadas;
                    if ($tiempo_disponible == 0) {
                        return '<span style="color: red;">Sin HORAS disponibles</span>';
                    }

                    $tiempoTexto = $this->convertirHorasMinutosATexto($tiempo_disponible);
                    return '<span style="color: blue;">' . $tiempoTexto . '</span>';
                } else {


                    $tiempoTexto = $this->convertirHorasMinutosATexto($horas_permitidas);

                    // Mostrará "2 horas 15 minutos" para 135 minutos

                    return $tiempoTexto;
                }
            })
            ->addColumn('btn2', function ($empleado) use ($permisoId, $permiso) {
                $suma_horas_utilizadas = $empleado->suma_horas_utilizadas;
                $horas_permitidas = $permiso->horas_permitidas;
                if ($suma_horas_utilizadas == $horas_permitidas) {

                    return  '<a class="tts:left tts-slideIn tts-custom" aria-label="Ver Todos los Registros" href="' . route('listar.permiso', ['id' => $empleado->idemp]) . '">
                &nbsp;<i class="fa-sharp fa-solid fa-list"></i></i>
                </a>';
                } else {

                    return '<a href="' . route('permisospersonales.nuevo', ['id' => $empleado->idemp, 'permiso_id' => $permisoId]) . ' " class="tts:left tts-slideIn tts-custom" aria-label="Registrar Nuevo Permiso Personal ">
                    <i class="fa fa-lg fa-plus text-success"></i> &nbsp;
                </a>' . '<a class="tts:left tts-slideIn tts-custom" aria-label="Ver Todos los Registros" href="' . route('listar.permiso', ['id' => $empleado->idemp]) . '">
                &nbsp;<i class="fa-sharp fa-solid fa-list"></i></i>
                </a>';
                }
            })
            ->rawColumns(['btn2', 'total_horas_disponibles'])
            ->make(true);
    }

    //$permisos = DB::table('empleados_permisos');
    public function detalle($id, $permiso_id)
    {
        $permisos = EmpleadoPermisoModel::where('empleado_id', $id)
            ->where('permiso_id', $permiso_id)
            ->get();

        return Datatables::of($permisos)
            ->addColumn('horas_utilizadas', function ($permiso) {
                $horas_utilizadas = $permiso->horas_utilizadas;
                if ($horas_utilizadas) {
                    if ($horas_utilizadas == 0) {
                        return '<span style="color: red;">SIN HORAS</span>';
                    }

                    $diaTexto = $this->convertirHorasMinutosATexto($horas_utilizadas);
                    return '<span style="color: blue;">' . $diaTexto . '</span>';
                }
            })
            ->addColumn('opciones', function ($permiso) {
                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Registro" href="' . route('editar.permiso', $permiso->id) . '">
                <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
            </a>&nbsp;&nbsp;'
             . '<a class="tts:left tts-slideIn tts-custom" aria-label="Eliminar Huella Dactilar" href="#" data-toggle="modal" data-target="#confirmarEliminarModal" data-nombre="' . $permiso->empleado->nombres .' '.$permiso->empleado->ap_pat.' '.$permiso->empleado->ap_mat. '" data-id="'. $permiso->id .'"><span class="badge badge-danger"> ELIMINAR</span>  </a>'
             ;
            })
            ->rawColumns(['horas_utilizadas', 'opciones'])
            ->make(true);
    }

    public function nuevo($id, $permiso_id)
    {
        $empleado = EmpleadosModel::find($id);
        $permiso = PermisoModel::find($permiso_id);
        return view('permisos.personales.create', compact('empleado', 'permiso'));
    }

    public function editarPermiso(EmpleadoPermisoModel $permiso)
    {
        // Obtener el permiso y la información del empleado asociado al permiso

        // Verificar si el permiso existe
        if (!$permiso) {
            // Puedes manejar la situación en la que el permiso no existe, por ejemplo, redirigir o mostrar un error.
            // Aquí simplemente redirijo a alguna ruta, puedes ajustarlo según tus necesidades.
            abort(404); // o maneja de alguna manera el caso en que no se encuentre el registro
        }

        return view('permisos.personales.edit', compact('permiso'));
    }
    public function listarPermiso($id)
    {
        $empleado = EmpleadosModel::with(['permisos'])->where('idemp', $id)
            ->select('nombres', 'ap_pat', 'ap_mat', 'idemp')
            ->firstOrFail();
        $permisos = $empleado->permisos;

        if (request()->ajax()) {
            return DataTables::of($permisos)
                ->addColumn('mes', function ($permiso) {
                    $fechaCarbon = Carbon::createFromFormat('Y-m', $permiso->mes);
                    $fechaEnEspañol = mb_strtoupper($fechaCarbon->locale('es')->isoFormat('MMMM YYYY'), 'UTF-8');
                    return $fechaEnEspañol ?? '-';
                })

                ->addColumn('horas_utilizadas', function ($permiso) {

                    $diaTexto = $this->convertirHorasMinutosATexto($permiso->pivot->horas_utilizadas);
                    return '<span style="color: blue;">' . $diaTexto . '</span>';
                })

                ->rawColumns(['horas_utilizadas'])
                ->make(true);
        }


        return view('permisos.personales.show', compact('empleado', 'permisos'));
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'empleado_id' => 'required',
            'permiso_id' => 'required',
            'asunto' => 'required',
            'hora_salida_input' => 'required',
            'hora_retorno' => 'required',
            'fecha_solicitud' => 'required|date',
            'duracion' => 'required|numeric',
        ]);

        try {
            // Obtén los valores del formulario
            $empleadoId = $request->input('empleado_id');
            $permisoId = $request->input('permiso_id');
            $horasSolicitadas = $request->input('duracion');
            if ($horasSolicitadas == 0) {
                return redirect()->back()->with('error', 'No se pudo registrar el permiso');
            }


            $fechaCompleta = $request->input('fecha_solicitud'); // Reemplaza esto con tu fecha completa en el formato 'Y-m-d'

            $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fechaCompleta);
            $fechaMes = $fechaCarbon->format('Y-m');

            $permisoMes = PermisoModel::find($permisoId);
            $fechaCarbon2 = Carbon::createFromFormat('Y-m', $permisoMes->mes);
            $mes = $fechaCarbon2->format('Y-m');
            if ($fechaMes === $mes) {
                // Busca al empleado con el permiso específico
                $empleadopermiso = EmpleadosModel::where('idemp', $empleadoId)
                    ->with(['permisos' => function ($query) use ($permisoId) {
                        $query->where('permisos_mensuales.id', $permisoId); // Filtra por el ID del permiso deseado
                    }])
                    ->select('idemp')
                    ->first();
                // Supongamos que ya tienes el modelo $empleadopermiso
                if ($empleadopermiso) {
                    $permiso = $empleadopermiso->permisos->first();

                    if ($permiso) {

                        $horasPermitidas = $permiso->horas_permitidas;
                        $totalHorasUtilizadas = $empleadopermiso->permisos->sum('pivot.horas_utilizadas');
                        $suma = $totalHorasUtilizadas + $horasSolicitadas;
                        $resta = $horasPermitidas - $totalHorasUtilizadas;

                        if ($horasPermitidas >= $suma) {
                            $permisoPersonal = new EmpleadoPermisoModel();
                            // Asigna los valores del formulario a la instancia
                            $permisoPersonal->empleado_id = $empleadoId;
                            $permisoPersonal->permiso_id = $permisoId;
                            $permisoPersonal->asunto = $request->input('asunto');
                            $permisoPersonal->hora_salida = $request->input('hora_salida_input');
                            $permisoPersonal->hora_retorno = $request->input('hora_retorno');
                            $permisoPersonal->fecha_solicitud = $request->input('fecha_solicitud');
                            $permisoPersonal->horas_utilizadas = $horasSolicitadas;
                            if (Auth::check()) {
                                $permisoPersonal->usuario_creacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
                            }
                            // Guarda el registro en la base de datos
                            $permisoPersonal->save();
                            // Redirecciona a la vista de éxito o a donde desees
                            return redirect()->route('permisospersonales.index')->with('success', 'Permiso registrado exitosamente.');
                        } else {
                            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . 'Te quedan ' . $resta . '(minutos)');
                        }
                    } else {

                        $permisoPersonal = new EmpleadoPermisoModel();
                        // Asigna los valores del formulario a la instancia
                        $permisoPersonal->empleado_id = $empleadoId;
                        $permisoPersonal->permiso_id = $permisoId;
                        $permisoPersonal->asunto = $request->input('asunto');
                        $permisoPersonal->hora_salida = $request->input('hora_salida_input');
                        $permisoPersonal->hora_retorno = $request->input('hora_retorno');
                        $permisoPersonal->fecha_solicitud = $request->input('fecha_solicitud');
                        $permisoPersonal->horas_utilizadas = $horasSolicitadas;
                        if (Auth::check()) {
                            $permisoPersonal->usuario_creacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
                        }
                        // Guarda el registro en la base de datos
                        $permisoPersonal->save();
                        // Redirecciona a la vista de éxito o a donde desees
                        return redirect()->route('permisospersonales.index')->with('success', 'Permiso creado exitosamente.');
                    }
                } else {
                    // Manejar el caso en el que no se encuentra el empleado
                    return redirect()->back()->with('error', 'No se pudo crear el permiso: ');
                }
            } else {
                return redirect()->back()->with('error', 'La Fecha de Solicitud No corresponde al Mes ' . $mes . ' No se pudo registrar el permiso: ');
            }
        } catch (\Exception $e) {


            // Captura cualquier excepción que pueda ocurrir y muestra un mensaje de error
            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . $e->getMessage());
        }
    }

    public function actualizarPermiso(Request $request, $id)
    {

        // Validar los datos del formulario, asegúrate de ajustar las reglas de validación según tus necesidades
        $request->validate([
            'empleado_id' => 'required',
            'permiso_id' => 'required',
            'asunto' => 'required',
            'hora_salida_input' => 'required',
            'hora_retorno' => 'required',
            'fecha_solicitud' => 'required|date',
            'duracion' => 'required|numeric',
        ]);
        try {

            $empleadoId = $request->input('empleado_id');
            $permisoId = $request->input('permiso_id');


            $horasSolicitadas = $request->input('duracion');
            if ($horasSolicitadas == 0) {
                return redirect()->back()->with('error', 'No se pudo registrar el permiso');
            }


            $fechaCompleta = $request->input('fecha_solicitud'); // Reemplaza esto con tu fecha completa en el formato 'Y-m-d'

            $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fechaCompleta);
            $fechaMes = $fechaCarbon->format('Y-m');

            $permisoMes = PermisoModel::find($permisoId);
            $fechaCarbon2 = Carbon::createFromFormat('Y-m', $permisoMes->mes);
            $mes = $fechaCarbon2->format('Y-m');
            if ($fechaMes === $mes) {
                // Busca al empleado con el permiso específico
                $empleadopermiso = EmpleadosModel::where('idemp', $empleadoId)
                    ->with(['permisos' => function ($query) use ($permisoId) {
                        $query->where('permisos_mensuales.id',  $permisoId); // Filtra por el ID del permiso deseado
                    }])
                    ->select('idemp')
                    ->first();
                // Supongamos que ya tienes el modelo $empleadopermiso
                if ($empleadopermiso) {
                    $permiso = $empleadopermiso->permisos->first();

                    if ($permiso) {

                        $horasPermitidas = $permiso->horas_permitidas;
                        $totalHorasUtilizadas = $empleadopermiso->permisos->sum('pivot.horas_utilizadas');


                        $limite  = $horasPermitidas - $totalHorasUtilizadas;
                        $permiso = EmpleadoPermisoModel::find($id);
                        $limite2 =  $limite + ($permiso->horas_utilizadas);
                        if ($limite2 >=  $horasSolicitadas) {

                            $permiso->asunto = $request->input('asunto');
                            $permiso->hora_salida = $request->input('hora_salida_input');
                            $permiso->hora_retorno = $request->input('hora_retorno');
                            $permiso->fecha_solicitud = $request->input('fecha_solicitud');
                            $permiso->horas_utilizadas = $horasSolicitadas;

                            if (Auth::check()) {
                                $permiso->usuario_modificacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
                            }
                            // Guarda el registro en la base de datos
                            $permiso->save();
                            // Redirecciona a la vista de éxito o a donde desees
                            return redirect()->route('permisospersonales.index')->with('success',  'Permiso modificado exitosamente.');
                        } else {
                            return redirect()->back()->with('error', 'Limite :' . $limite . '(mins) Minutos Solicitados' . $horasSolicitadas . ' No se pudo crear el permiso: ' . $totalHorasUtilizadas . '(mins) Limite  Excedido a' . '(mins)');
                        }
                    }
                } else {
                    // Manejar el caso en el que no se encuentra el empleado
                    return redirect()->back()->with('error', 'No se pudo crear el permiso: ');
                }
            } else {
                return redirect()->back()->with('error', 'La Fecha de Solicitud No corresponde al Mes ' . $mes . ' No se pudo registrar el permiso: ');
            }
        } catch (\Exception $e) {


            // Captura cualquier excepción que pueda ocurrir y muestra un mensaje de error
            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermisosPersonalesModel  $permisosPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function show(PermisoModel $permisosPersonalesModel)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermisosPersonalesModel  $permisosPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function edit(PermisoModel $permisosPersonalesModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermisosPersonalesModel  $permisosPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PermisoModel $permisosPersonalesModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermisosPersonalesModel  $permisosPersonalesModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // dd($id);
        $permiso = EmpleadoPermisoModel::find($id);
        $permiso->delete();

        // Redireccionar a la lista de horarios con un mensaje de éxito
        return redirect()->route('permisospersonales.index')->with('success', 'El la huella Dactilar ha sido eliminada correctamente.');
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
}
