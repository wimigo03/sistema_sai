<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoPermisoModel;
use App\Models\EmpleadosModel;
use App\Models\PermisoModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermisosPersonalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private function obtenerFechaEnMayusculas()
    {
        $fechaCarbon = Carbon::now();
        $fechaEnEspañol = $fechaCarbon->locale('es')->isoFormat('MMMM YYYY');
        return mb_strtoupper($fechaEnEspañol, 'UTF-8');
    }

    private function obtenerOCrearPermiso($fechaEnMayusculas)
    {
        $permiso = PermisoModel::where('permiso', $fechaEnMayusculas)->first();

        if (!$permiso) {
            $permiso = PermisoModel::create(['permiso' => $fechaEnMayusculas, 'horas_permitidas' => 120]);
        }

        return $permiso;
    }

    public function index(Request $request)
    {

        $fechaEnMayusculas = $this->obtenerFechaEnMayusculas();
        $this->obtenerOCrearPermiso($fechaEnMayusculas);
        $añoActual = Carbon::now()->year;
        // Obtén la lista de permisos filtrando por el año actual y ordénalos de manera descendente por ID
        // Obtén la lista de permisos filtrando por el año actual en la columna 'permiso' y ordénalos de manera descendente por ID
        $permisos = PermisoModel::where('permiso', 'like', '%' . $añoActual . '%')
            ->orderBy('id', 'desc')
            ->get();

        return view('permisos.personales.index', compact('permisos'));
    }

    public function getEmpleados(Request $request)
    {
        $permiso_id = $request->input('permiso_id');
        $permiso = PermisoModel::find($permiso_id);

        $empleados = EmpleadosModel::where('tipo', 1)
            ->select(['idemp', 'nombres', 'ap_mat', 'ap_pat'])
            ->withCount(['permisos as suma_horas_utilizadas' => function ($query) use ($permiso) {
                $query
                    ->where('permisos.id', $permiso->id)
                    ->select(DB::raw('sum(horas_utilizadas)'));
            }])
            ->get();
        $permisoId = $permiso->id;

        return Datatables::of($empleados)
            ->addColumn('details_url', function ($empleado) use ($permisoId) {
                return route('permisospersonales.detalle', ['id' => $empleado->idemp, 'permiso_id' => $permisoId]);
            })
            ->addColumn('total_horas_disponibles', function ($empleado) use ($permiso) {
                $suma_horas_utilizadas = $empleado->suma_horas_utilizadas;
                $horas_permitidas = $permiso->horas_permitidas;
                if ($suma_horas_utilizadas) {

                    $tiempo_disponible = $horas_permitidas - $suma_horas_utilizadas;
                    return $tiempo_disponible;
                } else {
                    return $horas_permitidas;
                }
            })
            ->addColumn('btn2', function ($empleado) use ($permisoId) {
                return '<a href="' . route('permisospersonales.nuevo', ['id' => $empleado->idemp, 'permiso_id' => $permisoId]) . ' " class="tts:left tts-slideIn tts-custom" aria-label="Crear Nuevo Reporte">
                            <i class="fa fa-lg fa-plus text-success"></i>
                        </a>';
            })
            ->rawColumns(['btn2'])
            ->make(true);
    }

    //$permisos = DB::table('empleados_permisos');
    public function detalle($id, $permiso_id)
    {
        $permisos = EmpleadoPermisoModel::where('empleado_id', $id)
            ->where('permiso_id', $permiso_id)
            ->get();

        return Datatables::of($permisos)
            ->make(true);
    }

    public function nuevo($id, $permiso_id)
    {
        $empleado = EmpleadosModel::find($id);
        $permiso = PermisoModel::find($permiso_id);
        return view('permisos.personales.create', compact('empleado', 'permiso'));
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

            // Busca al empleado con el permiso específico
            $empleadopermiso = EmpleadosModel::where('idemp', $empleadoId)
                ->with(['permisos' => function ($query) use ($permisoId) {
                    $query->where('permisos.id', $permisoId); // Filtra por el ID del permiso deseado
                }])
                ->first();

            // Supongamos que ya tienes el modelo $empleadopermiso
            if ($empleadopermiso) {
                $permiso = $empleadopermiso->permisos->first();
                if ($permiso) {

                    $horasPermitidas = $permiso->horas_permitidas;
                    $totalHorasUtilizadas = $empleadopermiso->permisos->sum('pivot.horas_utilizadas');
                    $suma = $totalHorasUtilizadas + $horasSolicitadas;

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
                        // Guarda el registro en la base de datos
                        $permisoPersonal->save();
                        // Redirecciona a la vista de éxito o a donde desees
                        return redirect()->route('permisospersonales.index')->with('success', 'Permiso creado exitosamente.' . 'horas Permitidas' . $horasPermitidas . 'sumaActual' . $suma . 'acumulado' . $totalHorasUtilizadas);
                    } else {
                        return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . $totalHorasUtilizadas . 'Limite  Excedido a' . $suma);
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
                    // Guarda el registro en la base de datos
                    $permisoPersonal->save();
                    // Redirecciona a la vista de éxito o a donde desees
                    return redirect()->route('permisospersonales.index')->with('success', 'Permiso creado exitosamente.');
                }
            } else {
                // Manejar el caso en el que no se encuentra el empleado
                return redirect()->back()->with('error', 'No se pudo crear el permiso: ');
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
}
