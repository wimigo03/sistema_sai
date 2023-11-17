<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoLicenciasModel;
use App\Models\EmpleadoPermisoModel;
use App\Models\EmpleadosModel;
use App\Models\LicenciasRipModel;
use App\Models\PermisoModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class LicenciasPersonalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    private function obtenerOCrearLicencia($añoActual)
    {
        $licencia = LicenciasRipModel::where('licencia', $añoActual)->first();

        if (!$licencia) {
            $licencia = LicenciasRipModel::create(['licencia' => $añoActual, 'dias_permitidos' => 48]);
        }
        return $licencia;
    }

    public function index(Request $request)
    {
        $añoActual = Carbon::now()->format('Y-m');
        $año = Carbon::now()->format('Y');
        $licencia =  $this->obtenerOCrearLicencia($año);
        return view('permisos.licencias.index', compact('licencia', 'añoActual'));
    }
    public function getID(Request $request)
    {
        $fecha = Carbon::now()->format($request->input('fecha'));
        $this->obtenerOCrearLicencia($fecha);
        $id =  LicenciasRipModel::where('licencia', $fecha)->first()->id;

        return response()->json([
            'id' => $id,
        ]);
    }

    public function getEmpleados(Request $request)
    {
        $licencia_id = $request->input('licencia_id');
        $licencia = LicenciasRipModel::find($licencia_id);

        $empleados = EmpleadosModel::where('tipo', 1)
            ->select(['idemp', 'nombres', 'ap_mat', 'ap_pat'])
            ->withCount(['licencias as suma_dias_utilizados' => function ($query) use ($licencia) {
                $query
                    ->where('licencias.id', $licencia->id)
                    ->select(DB::raw('sum(dias_utilizados)'));
            }])
            ->get();
        $licenciaId = $licencia->id;

        return Datatables::of($empleados)
            ->addColumn('details_url', function ($empleado) use ($licenciaId) {
                return route('licenciaspersonales.detalle', ['id' => $empleado->idemp, 'licencia_id' => $licenciaId]);
            })
            ->addColumn('total_dias_disponibles', function ($empleado) use ($licencia) {
                $suma_dias_utilizados = $empleado->suma_dias_utilizados;
                $dias_permitidos = $licencia->dias_permitidos;
                if ($suma_dias_utilizados) {

                    $dias_disponible = $dias_permitidos - $suma_dias_utilizados;
                    if ($dias_disponible == 0) {
                        return '<span style="color: red;">No Disponibles</span>';
                    }

                    $diaTexto = $this->convertirATexto($dias_disponible);
                    return '<span style="color: blue;">' . $diaTexto . '</span>';
                } else {


                    $diaTexto = $this->convertirATexto($dias_permitidos);

                    // Mostrará "2 horas 15 minutos" para 135 minutos

                    return $diaTexto;
                }
            })
            ->addColumn('btn2', function ($empleado) use ($licenciaId) {
                return '<a href="' . route('licenciaspersonales.nuevo', ['id' => $empleado->idemp, 'licencia_id' => $licenciaId]) . ' " class="tts:left tts-slideIn tts-custom" aria-label="Registrar Solicitud Licencia Personal ">
                            <i class="fa fa-lg fa-plus text-success"></i> &nbsp;
                        </a>' . '<a class="tts:left tts-slideIn tts-custom" aria-label="Ver Todos los Registros" href="' . route('listar.licencias', ['id' => $empleado->idemp]) . '">
                        &nbsp;<i class="fa-sharp fa-solid fa-list"></i></i>
                        </a>';
            })
            ->rawColumns(['btn2', 'total_dias_disponibles'])
            ->make(true);
    }

    public function listarLicencias($id)
    {
        $empleado = EmpleadosModel::with(['licencias'])->where('idemp', $id)->select('nombres', 'ap_pat', 'ap_mat', 'idemp')->firstOrFail();
        $licencias = $empleado->licencias;
        if (request()->ajax()) {
            return DataTables::of($licencias)
                ->addColumn('dias_utilizados', function ($licencia) {
                    $dias_utilizados = $licencia->pivot->dias_utilizados;
                    if ($dias_utilizados) {
                        if ($dias_utilizados == 0) {
                            return '<span style="color: red;">No Disponibles</span>';
                        }

                        $diaTexto = $this->convertirATexto($dias_utilizados);
                        return '<span style="color: blue;">' . $diaTexto . '</span>';
                    }
                })


                ->rawColumns(['dias_utilizados'])
                ->make(true);
        }
        return view('permisos.licencias.show', compact('empleado', 'licencias'));
    }

    //$permisos = DB::table('empleados_permisos');
    public function detalle($id, $licencia_id)
    {
        $licencia = EmpleadoLicenciasModel::where('empleado_id', $id)
            ->where('licencia_id', $licencia_id)
            ->get();

        return Datatables::of($licencia)

            ->addColumn('dias_utilizados', function ($licencia) {
                $dias_utilizados = $licencia->dias_utilizados;
                if ($dias_utilizados) {


                    if ($dias_utilizados == 0) {
                        return '<span style="color: red;">No Disponibles</span>';
                    }

                    $diaTexto = $this->convertirATexto($dias_utilizados);
                    return '<span style="color: blue;">' . $diaTexto . '</span>';
                }
            })
            ->addColumn('opciones', function ($licencia) use ($id) {

                return '<a class="tts:left tts-slideIn tts-custom" aria-label="Ver Todos los Registros" href="' . route('editar.licencia', ['id' => $licencia->id]) . '">
                &nbsp;<i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                </a>';
            })
            ->rawColumns(['dias_utilizados', 'opciones'])
            ->make(true);
    }


    public function nuevo($id, $licencia_id)
    {
        $empleado = EmpleadosModel::find($id);
        $licencia = LicenciasRipModel::find($licencia_id);
        return view('permisos.licencias.create', compact('empleado', 'licencia'));
    }

    public function editarLicencias($id)  {
        $licencia = EmpleadoLicenciasModel::with('empleado', 'licencia')->find($id);

         // Verificar si el permiso existe
         if (!$licencia) {
            // Puedes manejar la situación en la que el permiso no existe, por ejemplo, redirigir o mostrar un error.
            // Aquí simplemente redirijo a alguna ruta, puedes ajustarlo según tus necesidades.
            return redirect()->route('ruta.de.error');
        }

        return view('permisos.licencias.edit', compact('licencia'));
    }

    public function actualizarLicencias(Request $request, $id) {
        $request->validate([
            'empleado_id' => 'required',
            'licencia_id' => 'required',
            'asunto' => 'required',
            'fecha_solicitud' => 'required|date',
            'duracion' => 'required|numeric',
        ]);
        try {
            // Obtén los valores del formulario
            $empleadoId = $request->input('empleado_id');
            $licenciaId = $request->input('licencia_id');
            $diasSolicitados = $request->input('duracion');
            $fechaCompleta = $request->input('fecha_solicitud'); // Reemplaza esto con tu fecha completa en el formato 'Y-m-d'

            if ($diasSolicitados == 0) {
                return redirect()->back()->with('error', 'No se pudo registrar la licencia. Seleccione ');
            }
           
            
          

            $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fechaCompleta);
            $fechaAño = $fechaCarbon->format('Y');

            $licencia = LicenciasRipModel::find($licenciaId);
            $fechaCarbon2 = Carbon::createFromFormat('Y', $licencia->licencia);
            $año = $fechaCarbon2->format('Y');

            if ($fechaAño === $año) {
                // Busca al empleado con el permiso específico
                $empleadolicencia = EmpleadosModel::where('idemp', $empleadoId)
                    ->with(['licencias' => function ($query) use ($licenciaId) {
                        $query->where('licencias.id', $licenciaId); // Filtra por el ID del permiso deseado
                    }])
                    ->select('idemp')
                    ->first();

                // Supongamos que ya tienes el modelo $empleadopermiso
                if ($empleadolicencia) {
                    $licencia = $empleadolicencia->licencias->first();

                    if ($licencia) {

                        $diasPermitidas = $licencia->dias_permitidos;
                        $totalDiasUtilizadas = $empleadolicencia->licencias->sum('pivot.dias_utilizados');
                        $suma = $totalDiasUtilizadas + $diasSolicitados;

                        if ($diasPermitidas >= $suma) {
                            $licenciaPersonal = EmpleadoLicenciasModel::where('fecha_solicitud', $fechaCompleta)
                            ->where('empleado_id', $empleadoId)
                            ->first();
                            // Asigna los valores del formulario a la instancia
                            
                            $licenciaPersonal->asunto = $request->input('asunto');
                            $licenciaPersonal->fecha_solicitud = $request->input('fecha_solicitud');
                            $licenciaPersonal->dias_utilizados = $diasSolicitados;
                            if (Auth::check()) {
                                $licenciaPersonal->usuario_modificacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
                            }
                            // Guarda el registro en la base de datos
                            $licenciaPersonal->save();
                            // Redirecciona a la vista de éxito o a donde desees
                            return redirect()->route('licenciaspersonales.index')->with('success', 'Permiso Modificado Exitosamente.');
                        } else {
                            return redirect()->back()->with('error', 'No se pudo actualizar el registro de Licencia: ' . 'Limite  Excedido a ' . $s = $this->convertirATexto($suma));
                        }
                    }
                } else {
                    // Manejar el caso en el que no se encuentra el empleado
                    return redirect()->back()->with('error', 'No se pudo crear el permiso: ');
                }
            } else {
                return redirect()->back()->with('error', 'La Fecha de Solicitud No corresponde al Mes ' . $año . ' No se pudo registrar el permiso: ');
            }
        } catch (\Exception $e) {


            // Captura cualquier excepción que pueda ocurrir y muestra un mensaje de error
            return redirect()->back()->with('error', 'No se pudo actualizar el registro de Licencia:  '.$licencia.''.$fechaAño.'  '.$licenciaId .'  '.$empleadoId. $e->getMessage());
        }
   
        
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
            'licencia_id' => 'required',
            'asunto' => 'required',
            'fecha_solicitud' => 'required|date',
            'duracion' => 'required|numeric',
        ]);

        try {
            // Obtén los valores del formulario
            $empleadoId = $request->input('empleado_id');
            $licenciaId = $request->input('licencia_id');
            $diasSolicitados = $request->input('duracion');
            $fechaCompleta = $request->input('fecha_solicitud'); // Reemplaza esto con tu fecha completa en el formato 'Y-m-d'

            if ($diasSolicitados == 0) {
                return redirect()->back()->with('error', 'No se pudo registrar la licencia');
            }
            $EmpLic = EmpleadoLicenciasModel::where('fecha_solicitud', $fechaCompleta)
                ->where('empleado_id', $empleadoId)
                ->first();
            if ($EmpLic) {
                return redirect()->back()->with('error', 'Ya registró su licencia hoy: ' . $fechaCompleta);
            }

            $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fechaCompleta);
            $fechaAño = $fechaCarbon->format('Y');

            $licencia = LicenciasRipModel::find($licenciaId);
            $fechaCarbon2 = Carbon::createFromFormat('Y', $licencia->licencia);
            $año = $fechaCarbon2->format('Y');

            if ($fechaAño === $año) {
                // Busca al empleado con el permiso específico
                $empleadolicencia = EmpleadosModel::where('idemp', $empleadoId)
                    ->with(['licencias' => function ($query) use ($licenciaId) {
                        $query->where('licencias.id', $licenciaId); // Filtra por el ID del permiso deseado
                    }])
                    ->select('idemp')
                    ->first();

                // Supongamos que ya tienes el modelo $empleadopermiso
                if ($empleadolicencia) {
                    $licencia = $empleadolicencia->licencias->first();

                    if ($licencia) {

                        $diasPermitidas = $licencia->dias_permitidos;
                        $totalDiasUtilizadas = $empleadolicencia->licencias->sum('pivot.dias_utilizados');
                        $suma = $totalDiasUtilizadas + $diasSolicitados;

                        if ($diasPermitidas >= $suma) {
                            $licenciaPersonal = new EmpleadoLicenciasModel();
                            // Asigna los valores del formulario a la instancia
                            $licenciaPersonal->empleado_id = $empleadoId;
                            $licenciaPersonal->licencia_id = $licenciaId;
                            $licenciaPersonal->asunto = $request->input('asunto');
                            $licenciaPersonal->fecha_solicitud = $request->input('fecha_solicitud');
                            $licenciaPersonal->dias_utilizados = $diasSolicitados;
                            // Guarda el registro en la base de datos
                            $licenciaPersonal->save();
                            // Redirecciona a la vista de éxito o a donde desees
                            return redirect()->route('licenciaspersonales.index')->with('success', 'Permiso registrado exitosamente.');
                        } else {
                            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . 'Limite  Excedido a ' . $s = $this->convertirATexto($suma));
                        }
                    } else {

                        $licenciaPersonal = new EmpleadoLicenciasModel();
                        // Asigna los valores del formulario a la instancia
                        $licenciaPersonal->empleado_id = $empleadoId;
                        $licenciaPersonal->licencia_id = $licenciaId;
                        $licenciaPersonal->asunto = $request->input('asunto');

                        $licenciaPersonal->fecha_solicitud = $request->input('fecha_solicitud');
                        $licenciaPersonal->dias_utilizados = $diasSolicitados;
                        // Guarda el registro en la base de datos
                        $licenciaPersonal->save();
                        // Redirecciona a la vista de éxito o a donde desees
                        return redirect()->route('licenciaspersonales.index')->with('success', 'Permiso creado exitosamente.');
                    }
                } else {
                    // Manejar el caso en el que no se encuentra el empleado
                    return redirect()->back()->with('error', 'No se pudo crear el permiso: ');
                }
            } else {
                return redirect()->back()->with('error', 'La Fecha de Solicitud No corresponde al Mes ' . $año . ' No se pudo registrar el permiso: ');
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
    public function destroy(PermisoModel $permisosPersonalesModel)
    {
        //
    }

    function convertirATexto($horas_permitidas)
    {
        $dias = floor($horas_permitidas / 24);
        $minutos = $horas_permitidas % 24;

        // Genera una representación textual
        $texto = '';

        if ($dias > 0) {
            $texto .= $dias . ' día' . ($dias > 1 ? 's' : '') . ' ';
        }

        if ($minutos > 0) {

            $minutos = floor($minutos / 12);
            $texto .= $minutos . ' mediodia' . ($minutos > 1 ? 's' : '');
        }

        return $texto;
    }
}
