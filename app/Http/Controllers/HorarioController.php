<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\HoraEmpleadoRequest;
use App\Models\AsistenciaModel;
use App\Models\EmpleadosModel;
use App\Models\HorarioModel;
use App\Models\HuellasDigitalesModel;
use App\Models\RegistroAsistencia;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class HorarioController extends Controller
{

    //App\Models\HorarioModel::whereHas('registrosAsistencia', function ($query) {$query->whereBetween('created_at',  ['2023-11-01','2023-11-30' ]);})->get();

    //App\Models\RegistroAsistencia::whereBetween('created_at', ['2023-11-01','2023-11-30' ])->with('empleado')->select()->get();


    public function index(Request $request)
    {
        //
        $horarioActivo = HorarioModel::where('estado', 1)->first();
        if ($request->ajax()) {
            $horarios = HorarioModel::select(['id', 'Nombre', 'hora_final', 'hora_inicio', 'hora_entrada', 'hora_salida', 'excepcion', 'estado'])
                ->withCount('empleados')->get();


            return DataTables::of($horarios)
                ->addColumn('mañana', function ($horario) {
                    if (!$horario->hora_salida) {
                        return Carbon::parse($horario->hora_inicio)->format('H:i');
                    } else {
                        $horaI = Carbon::parse($horario->hora_inicio)->format('H:i');
                        $horaS = Carbon::parse($horario->hora_salida)->format('H:i');
                        return $horaI . ' - ' . $horaS;
                    }
                })
                ->addColumn('tarde', function ($horario) {
                    if (!$horario->hora_salida) {
                        return Carbon::parse($horario->hora_final)->format('H:i');
                    } else {
                        $horaE = Carbon::parse($horario->hora_entrada)->format('H:i');
                        $horaF = Carbon::parse($horario->hora_final)->format('H:i');
                        return $horaE . ' - ' . $horaF;
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
                        $html .= '<a class="tts:left tts-slideIn tts-custom" aria-label="Desactivar Horario" href="#" onclick="confirmUpdateState(this)"><span class="badge badge-success">Activado</span></a>';
                    } else if ($horario->estado == 0) {
                        $html .= '<a class="tts:left tts-slideIn tts-custom" aria-label="Activar Horario"  href="#" onclick="confirmUpdateState(this)"><span class="badge badge-danger">Desactivado</span></a>';
                    } else {
                        $html .= '<a class="tts:left tts-slideIn tts-custom" aria-label="Horario sin Asignar" href="#" onclick="confirmUpdateState(this)"><span class="badge badge-secondary">Sin Asignar</span></a>';
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
        if ($request->hora_entrada && $request->hora_salida) {
            $horario->tipo = 1;
        }
        $horario->save();


        if ($request->has('asignado')) {
            $horario->estado = 1;
            $horario->save();
            HorarioModel::where('id', '<>', $horario->id)->where('estado', '=', 1)->update(['estado' => 0]);

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

        // Obtener el nombre del usuario actual
        $nombreUsuario = Auth::user()->name; // Ajusta según la estructura de tu tabla de usuarios

        // Actualizar el valor del estado según la lógica deseada
        if ($horario->estado == 0) {
            $horario->update([
                'estado' => 1,
                'usuario_modificacion' => $nombreUsuario
            ]);

            return redirect()->route('horarios.index')->with('success', 'Estado de horario actualizado a activo por ' . $nombreUsuario . '.');
        } else if ($horario->estado == 1) {
            $horario->update([
                'estado' => 0,
                'usuario_modificacion' => $nombreUsuario
            ]);

            return redirect()->route('horarios.index')->with('pendiente', 'Estado de horario actualizado a inactivo por ' . $nombreUsuario . '.');
        } else {
            Session::flash('error', 'No se asignó el horario.');
            return redirect()->back();
            // return redirect()->route('horarios.index')->with('error', 'El empleado no tiene asignado a ningún horario.');
        }
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

            // Actualizar estado de los horarios asignados al empleado
            $empleado->horarios()
                ->whereIn('horarios.id', $request->horarios)
                ->update(['horarios.estado' => 1]);

            // Actualizar estado de los horarios no asignados a ningún empleado

            HorarioModel::whereNotIn('id', $request->horarios)
                ->where(function ($query) {
                    $query->whereDoesntHave('empleados')->orWhereHas('empleados', function ($query) {
                        $query->where('empleados.idemp', '=', null);
                    });
                })
                ->update(['estado' => 2]);


            return redirect()->route('empleadoasistencias.index')->with('success', 'Horarios de Empleado Activados');
        } catch (\Exception $e) {
            // Captura cualquier excepción que pueda ocurrir y muestra un mensaje de error
            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . $e->getMessage());
        }
    }


    public function pinguardar(Request $request, EmpleadosModel $empleado)
    {
        $request->validate([]);
        $pin = $request->input('pin');

        try {
            if ($pin) {
                $emp = EmpleadosModel::where('pin', $pin)
                    ->first();
                if ($emp) {
                    return redirect()->back()->with('error', 'No se pudo crear el PIN');
                }
                $empleado->pin = $pin;
                $empleado->save();
                return redirect()->route('empleadoasistencias.index')->with('success', 'PIN de Empleado creado exitosamente');
            }




            return redirect()->route('empleadoasistencias.index');
        } catch (\Exception $e) {
            // Captura cualquier excepción que pueda ocurrir y muestra un mensaje de error
            return redirect()->back()->with('error', 'No se pudo crear el permiso: ' . $e->getMessage());
        }
    }




    public function cambio(EmpleadosModel $empleado)
    {
        $horarios = HorarioModel::all()->pluck('Nombre', 'id');
        $horariosCompletos = HorarioModel::all(['id', 'Nombre', 'hora_inicio', 'hora_final', 'hora_entrada', 'hora_salida', 'estado']);

      
        $cantidadHuellas = HuellasDigitalesModel::where('empleado_id', $empleado->idemp)
    ->count();
        if ($empleado) {
            return view('asistencias.horarios.cambio', compact('cantidadHuellas','empleado', 'horarios', 'horariosCompletos'));
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

        $fecha = Carbon::now()->format('Y-m-d');
        $asistencia = AsistenciaModel::where('fecha', $fecha)->select('id')->first();
        $request->validated();

        $horario->Nombre = $request->input('nombre');
        $horario->hora_entrada = $request->input('hora_entrada');
        $horario->hora_inicio = $request->input('hora_inicio');
        $horario->hora_final = $request->input('hora_final');

        $horario->hora_entrada = $request->input('hora_entrada');
        $horario->hora_salida = $request->input('hora_salida');
        $horario->excepcion = $request->input('excepcion');
        $horario->inicio_jornada = $request->input('inicio_jornada');
        if ($request->input('hora_inicio') && $request->input('hora_entrada')) {
            $horario->tipo = 1;
        } else {
            # code...
            $horario->tipo = 0;
        }

        if (Auth::check()) {
            $horario->usuario_modificacion = Auth::user()->name; // Obtener el nombre del usuario actualmente autenticado
        }

        // Guardar el nuevo horario en la base de datos
        $horario->save();


        if ($request->has('asignado')) {
            $horario->estado = 1;
            $horario->save();
            HorarioModel::where('id', '<>', $horario->id)->update(['estado' => 2]);

            $empleados = EmpleadosModel::all();

            foreach ($empleados as $empleado) {
                $empleado->horarios()->sync([$horario->id]);
            }

            //$this->CrearAsistencia($fecha);



            // if ($asistencia) {
            //     $asistencia->update(['estado' => 0,'descrip'=>'Activo']);
            //    $this->actualizarRegistro($asistencia);
            // }


        } else {
            $horario->empleados()->detach();
            $horario->estado = 2;
            $horario->save();
        }


        return redirect()->route('horarios.index')->with('success', 'Horario modificado exitosamente.');
    }








    public function fechas(Request $request)
    {
        // Definir $selectedMonth fuera del bloque if para que esté disponible en ambos casos
        // Asignar un valor predeterminado a $selectedMonth
        $vistaselectedMonth = Carbon::now()->format('Y-m');


        if ($request->ajax()) {
            // Obtener la fecha seleccionada desde el input de tipo month
            $selectedMonth = $request->input('selected_month');
            $formattedDate = $selectedMonth . '-01'; // Añade el primer día del mes



            // Verificar si no se proporcionó una fecha seleccionada y usar el mes actual
            if (!$selectedMonth) {
                $selectedMonth = Carbon::now()->format('Y-m');
                $formattedDate = $selectedMonth . '-01'; // Añade el primer día del mes
            }
            $firstDay = Carbon::createFromFormat('Y-m-d', $formattedDate)->startOfMonth();
            $lastDay = Carbon::createFromFormat('Y-m-d', $formattedDate)->endOfMonth();



            // Obtener todos los días del mes actual organizados por semanas
            $weeksInMonth = $this->getWeeksInMonth($firstDay, $lastDay, $selectedMonth);

            // Transformar los datos en un formato compatible con DataTables
            $data = $this->transformDataForDataTables($weeksInMonth, $selectedMonth);

            return DataTables::of($data)->make(true);
        }

        return view('asistencias.horarios.fechas', compact('vistaselectedMonth'));
    }



    private function getWeeksInMonth($start, $end, $selectedMonth)
    {
        $weeks = [];
        $currentWeek = [];

        // Calcular el número de días a agregar del mes anterior
        $daysToAdd = $start->dayOfWeek === Carbon::SUNDAY ? 6 : $start->dayOfWeek - 1;

        // Agregar días del mes anterior si la primera semana no comienza en lunes
        for ($i = $daysToAdd; $i > 0; $i--) {
            $currentWeek[] = $start->copy()->subDay($i);
        }

        while ($start <= $end) {
            $currentWeek[] = $start->copy();

            if ($start->dayOfWeek == Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth()->format('D')) {
                $weeks[] = $currentWeek;
                $currentWeek = [];
            }

            $start->addDay();
        }

        // Agregar días del mes posterior si la última semana no está completa
        $remainingDays = 7 - count($currentWeek);
        for ($i = 0; $i <= $remainingDays; $i++) {
            $currentWeek[] = $start->copy()->addDay($i);
        }

        // Agregar la última semana si es necesario
        if (!empty($currentWeek)) {
            $weeks[] = $currentWeek;
        }

        return $weeks;
    }


    private function transformDataForDataTables($weeksInMonth, $selectedMonth)
    {
        $data = [];

        // Obtener todos los datos del mes de una vez
        $allData = $this->getDataForMonth($weeksInMonth[0][0], end($weeksInMonth[count($weeksInMonth) - 1]));
        $allData2 = $this->getDataHorariosForMonth($weeksInMonth[0][0], end($weeksInMonth[count($weeksInMonth) - 1]));


        foreach ($weeksInMonth as $week) {
            $rowData = [];
            $rowData[] = $week[0] ? $week[0]->weekOfYear : null; // Agregar la columna de semana

            foreach ($week as $day) {
                // Aquí puedes agregar la información adicional que desees mostrar en la celda
                $cellData = [
                    'day' => $day ? $day->format('d') : null,
                    'additional_info' => $this->getDataForDate($day, $allData),
                    'date' => $day ? $day->format('Y-m-d') : null,
                    'actual' => $day && Carbon::parse($day)->format('m') == Carbon::parse($selectedMonth)->format('m') ? true : false,
                    'horario' => $this->getDataForDate2($day, $allData)
                    // Agrega más información según sea necesario
                ];
                $rowData[] = $cellData;
            }

            // Llenar con nulos para completar la última semana
            while (count($rowData) < 7) {
                $rowData[] = null;
            }

            $data[] = $rowData;
        }

        return $data;
    }

    private function getDataForDate($date, $allData)
    {
        // Filtrar los datos correspondientes a la fecha
        $filteredData = $allData->where('fecha', $date->toDateString());

        // Puedes procesar $filteredData según tus necesidades y devolver la información deseada
        return $filteredData;
    }

    private function getDataForDate2($date, $allData2)
    {
        // Filtrar los datos correspondientes a la fecha
        $filteredData = $allData2->where('fecha', $date->toDateString());

        // Puedes procesar $filteredData según tus necesidades y devolver la información deseada
        return $filteredData;
    }
    private function getDataForMonth($start, $end)
    {
        // Realizar una sola consulta para obtener todos los datos del mes
        return AsistenciaModel::whereBetween('fecha', [$start->toDateString(), $end->toDateString()])
            ->with('horarios')->get();
    }
    private function getDataHorariosForMonth($start, $end)
    {
        // Realizar una sola consulta para obtener todos los datos del mes

        return HorarioModel::whereHas('registrosAsistencia', function ($query) use ($start, $end) {
            $query->whereBetween('fecha', [$start, $end]);
        })->select('tipo', 'Nombre', 'hora_inicio', 'hora_final', 'hora_entrada', 'hora_salida')
            ->get();
    }















    public function destroy(HorarioModel $horario)
    {
        // Eliminar el horario
        $horario->delete();

        // Redireccionar a la lista de horarios con un mensaje de éxito
        return redirect()->route('horarios.index')->with('success', 'El horario ha sido eliminado correctamente.');
    }
}
