<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaModel;
use App\Models\EmpleadosModel;
use App\Models\HorarioModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class AsistenciaController extends Controller
{

    
 
    public function edit($id)
    {

        $asistencia = AsistenciaModel::find($id);
        $horarios = HorarioModel::all();

        return view('asistencias.registros.programar', compact('asistencia', 'horarios'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required',
            'horario_id' => 'required',
            'descrip' => 'required',
        ]);

        $fecha = $request->input('fecha');
        $horarioID = $request->input('horario_id');
        $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id')->first();
        if (!$asistenciaActual) {
            $asistenciaActual = AsistenciaModel::create([
                'fecha' => $fecha,
                'descrip' => "Personal",
                'estado' => '1'
            ]);
        }
        $empleados = EmpleadosModel::all();

        foreach ($empleados as $empleado) {
            $empleado->asistencia()->attach($asistenciaActual->id, [
                'created_at' => $fecha,
                'horario_id' => $horarioID
            ]);
        }

        return redirect()->route('horarios.fechas')->with('success', 'Asistencia modificada exitosamente.');
    }

    public function update(Request $request, AsistenciaModel $asistencia)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required',
            'horario_id' => 'required',
        ]);
        $HiD = $request->input('horario_id');
        $horario = HorarioModel::find($HiD);


        $fecha = $request->input('fecha');
        $desc = $request->input('descrip');


        $asistencia->fecha = $fecha;
        $asistencia->descrip = $desc;
        $asistencia->estado = 1;
        $asistencia->save();

        $empleados = EmpleadosModel::all();

        foreach ($empleados as $empleado) {
            $empleado->asistencia()->attach($asistencia->id, ['horario_id' => $horario->id]); // Ajusta $valorDeHorario según tu lógica
        }

        return redirect()->route('horarios.fechas')->with('success', 'Asistencia modificada exitosamente.');
    }

    public function crear($fecha)
    {

        $horarios = HorarioModel::all();

        return view('asistencias.registros.nuevoprog', compact('fecha', 'horarios'));
    }

    private function CrearAsistencia($fecha)
    {
        // Verificar si el mes es posterior al mes actual
        if (Carbon::now()->format('Y-m-d') < $fecha) {
            // Si es posterior, obtener o crear el permiso del mes actual
            $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id')->first();
            if (!$asistenciaActual) {
                $asistenciaActual = AsistenciaModel::create(['fecha' => $fecha, 'descrip' => "Personal", 'estado' => '1']);
            }

            return $asistenciaActual;
        }

        // Si no es posterior, obtener o crear el permiso del mes proporcionado
        $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id')->first();

        if (!$asistenciaActual) {
            $asistenciaActual = AsistenciaModel::create([
                'fecha' => $fecha,
                'descrip' => 'Personal',
                'estado' => '1'
            ]);
        }

        return $asistenciaActual;
    }
    private function verificarMarcado(RegistroAsistencia $registro)
    {
        if ($registro->horario->tipo == 1) {
            if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 1;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 4;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 4;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 3;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 3;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 3;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 3;
                $registro->save();
            } else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            } else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            }
        }
        if ($registro->horario->tipo == 0) {
            if ($registro->registro_final && $registro->registro_inicio) {
                $registro->estado = 1;
                $registro->save();
            } else if (!$registro->registro_final && $registro->registro_inicio) {
                $registro->estado = 2;
                $registro->save();
            } else if ($registro->registro_final && !$registro->registro_inicio) {
                $registro->estado = 5;
                $registro->save();
            } else {
                $registro->estado = 0;
                $registro->save();
            }
        }
    }
}
           // $fechas = App\Models\AsistenciaModel::with(['empleados' => function ($query) {$query->select('id', 'nombres'); }])->where('id', 32)->select('id')->get();
