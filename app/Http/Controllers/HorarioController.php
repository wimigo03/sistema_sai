<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\HoraEmpleadoRequest;
use App\Models\EmpleadosModel;
use App\Models\HorarioModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;



class HorarioController extends Controller
{

    public function index(Request $request)
    {
        //
        $horarioActivo = HorarioModel::where('estado', 1)->first();
        if ($request->ajax()) {
            $horarios = HorarioModel::select(['id', 'Nombre', 'hora_final', 'hora_inicio', 'hora_entrada', 'hora_salida', 'excepcion', 'estado'])
                ->withCount('empleados')->get();


            return DataTables::of($horarios)
                ->addColumn('mañana', function ($horario) {
                    if(!$horario->hora_salida){
                        return Carbon::parse($horario->hora_inicio)->format('H:i');
                    }else{
                        $horaI = Carbon::parse($horario->hora_inicio)->format('H:i');
                        $horaS = Carbon::parse($horario->hora_salida)->format('H:i');
                        return $horaI.' - '.$horaS;
                    }
                })
                ->addColumn('tarde', function ($horario) {
                    if(!$horario->hora_salida){
                        return Carbon::parse($horario->hora_final)->format('H:i');
                    }else{
                        $horaE = Carbon::parse($horario->hora_entrada)->format('H:i');
                        $horaF = Carbon::parse($horario->hora_final)->format('H:i');
                        return $horaE.' - '.$horaF;
                    }
                })
                ->addColumn('excepcion', function ($horario) {
                    return Carbon::parse($horario->excepcion)->format('H:i');
                })
                ->addColumn('asignados', function ($horario) {
                    return $horario->empleados_count;
                })
                ->addColumn('estado', function ($horario) {
                    $route = route('horarios.updateEstado', $horario->id);
                    $html = '<form action="' . $route . '" method="POST" style="display: inline">' .
                        csrf_field() .
                        method_field('PUT') .
                        '<span class="font-verdana"></span> ';

                    if ($horario->estado == 1) {
                        $html .= '<a class="text-success" href="#" onclick="submitForm(this)"><span class="badge badge-success">Activado</span></a>';
                    } else if ($horario->estado == 0) {
                        $html .= '<a class="text-danger" href="#" onclick="submitForm(this)"><span class="badge badge-danger">Desactivado</span></a>';
                    } else {
                        $html .= '<a class="text-primary" href="#" onclick="submitForm(this)"><span class="badge badge-secondary">Sin Asignar</span></a>';
                    }

                    $html .= '</form>';

                    return $html;
                })

                ->addColumn('actions', function ($horario) {
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar Horario" href="' . route('horarios.edit', $horario->id) . '">
                                <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                            </a>';
                })
                ->rawColumns(['actions', 'estado'])
                ->make(true);
        }

        return view('asistencias.horarios.index', compact('horarioActivo'));
    }

    public function create()
    {
        //
        return view('asistencias.horarios.create');
    }

    public function store(HoraEmpleadoRequest $request)
    {
        //
        $request->validated();
        $horario = new HorarioModel();

        $horario->Nombre = $request->nombre;
        $horario->hora_entrada = $request->hora_entrada;
        $horario->hora_inicio = $request->hora_inicio;
        $horario->hora_final = $request->hora_final;
        $horario->hora_salida = $request->hora_salida;
        $horario->excepcion = $request->excepcion;
        $horario->usuario_creacion = Auth::user()->name;
        $horario->estado = 0;
        $horario->save();
        if ($horario->hora_entrada && $horario->hora_salida) {
            $horario->tipo = 0;
        }

        if ($request->has('asignado')) {
            $horario->estado = 1;
            $horario->save();
            $empleados = EmpleadosModel::all();

            foreach ($empleados as $empleado) {
                $empleado->horarios()->attach($horario->id);
            }
        }


        return redirect()->route('horarios.index');
    }
    public function updateEstado($id)
    {
        $horario = HorarioModel::findOrFail($id);
        // Actualizar el valor del estado según la lógica deseada
        if ($horario->estado == 0) {
            $horario->estado = 1; // Cambiar de activado a activo
            $horario->save();

            return redirect()->route('horarios.index')->with('success', 'Estado de horario actualizado a activo.');
        } else if ($horario->estado == 1) {
            $horario->estado = 0; // Cambiar de desactivado a pendiente
            $horario->save();

            return redirect()->route('horarios.index')->with('pendiente', 'Estado de horario actualizado a inactivo.');
        } else {
            Session::flash('error', 'No se asigno el horario.');
            return redirect()->back();
            // return redirect()->route('horarios.index')->with('error', 'El empleado no tiene asisgnado a ningún horario.');
        }

        // Guardar los cambios en la base de datos
    }
    public function show(HorarioModel $horario)
    {
        $empleados = $horario->empleados;

        if (request()->ajax()) {
            return DataTables::of($empleados)
                ->addColumn('id', function ($registro) {
                    return $registro->idemp;
                })
                ->addColumn('nombres', function ($registro) {
                    return $registro->nombres ?? 'No se encontró un registro asociado.';
                })
                ->addColumn('apellidos', function ($registro) {
                    $pat = $registro->ap_pat ?? 'No se encontró un registro asociado.';
                    $mat = $registro->ap_mat ?? 'No se encontró un registro asociado.';
                    return $pat . '  ' . $mat;
                })

                ->addColumn('actions', function ($registro) {
                    return
                        '<a class="tts:left tts-slideIn tts-custom" aria-label="Modificar" href="' .
                        route('horarios.cambio', $registro->idemp) . '">
                    <button class="btn btn-sm btn-info font-verdana" type="button">
                    <i class="fa fa-pencil fa-fw"></i>
                    </button>
                    </a>';
                })
                ->rawColumns(['actions'])

                ->toJson();
        }

        return view('asistencias.horarios.show', compact('horario', 'empleados'));
    }

    public function edit(HorarioModel $horario)
    {
        //
        $asignados = $horario->empleados()->count() == EmpleadosModel::count();
        return view('asistencias.horarios.edit', compact('horario', 'asignados'));
    }

    public function guardar(Request $request, EmpleadosModel $empleado)
    {
        $request->validate([
            'horarios' => 'nullable|array',
            'horarios.*' => "integer|exists:horarios,id",
        ]);


        try {
            // Sincronizar los horarios seleccionados desde el formulario
            $empleado->horarios()->sync($request->horarios);
            $empleado->horarios()
                ->whereIn('horarios.id', $request->horarios)
                ->update(['horarios.estado' => 1]);

            return redirect()->route('empleadoasistencias.index')->with('success', 'Horarios de Empleado Activados');
        } catch (\Exception $e) {
            // Captura cualquier excepción que pueda ocurrir y muestra un mensaje de error
            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . $e->getMessage());
        }
    }




    public function cambio(EmpleadosModel $empleado)
    {
        $horarios = HorarioModel::all()->pluck('Nombre', 'id');
        $horariosCompletos = HorarioModel::all(['id', 'Nombre','hora_inicio', 'hora_final','hora_entrada', 'hora_salida', 'estado']);

        if ($empleado) {
            return view('asistencias.horarios.cambio', compact('empleado', 'horarios', 'horariosCompletos'));
        } else {
            // Manejar el caso en el que el empleado no se encuentra en la base de datos
            abort(404); // Otra respuesta apropiada
        }
    }
    //$asignados = $horario->empleados()->count() == EmpleadosModel::count();



    public function updatehora(HorarioModel $horario)
    {
    }

    public function update(HoraEmpleadoRequest $request, HorarioModel $horario)
    {
        
        $request->validated();

        $horario->Nombre = $request->input('nombre');
        $horario->hora_entrada = $request->input('hora_entrada');
        $horario->hora_inicio = $request->input('hora_inicio');
        $horario->hora_final = $request->input('hora_final');
      
        $horario->hora_entrada = $request->input('hora_entrada');
        $horario->hora_salida = $request->input('hora_salida');
        $horario->excepcion = $request->input('excepcion');

        if (Auth::check()) {
            $horario->usuario_modificacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
        }

        // Guardar el nuevo horario en la base de datos
        $horario->save();
        if (!$horario->hora_entrada && !$horario->hora_salida) {
            $horario->tipo = 0;
        }

        if ($request->has('asignado')) {
            $horario->estado = 1;
            $horario->save();
            $empleados = EmpleadosModel::all();
            foreach ($empleados as $empleado) {
                $empleado->horarios()->syncWithoutDetaching([$horario->id]);
            }
        } else {
            $horario->empleados()->detach();
            $horario->estado = 2;
            $horario->save();
        }


        return redirect()->route('horarios.index')->with('success', 'Horario modificado exitosamente.');
    }

    public function destroy(HorarioModel $horario)
    {
        // Eliminar el horario
        $horario->delete();

        // Redireccionar a la lista de horarios con un mensaje de éxito
        return redirect()->route('horarios.index')->with('success', 'El horario ha sido eliminado correctamente.');
    }
}
