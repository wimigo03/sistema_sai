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




    public function crear($fecha)
    {

        $horarios = HorarioModel::all();

        return view('asistencias.registros.nuevoprog', compact('fecha', 'horarios'));
    }

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
                'descrip' => "Programado",
                'estado' => '1'
            ]);
            $empleados = EmpleadosModel::all();

            $tipo = HorarioModel::find($horarioID)->tipo;

            $id = $asistenciaActual->id;
            foreach ($empleados as $empleado) {
                $empleado->asistencias()->attach([
                    $id => [
                        'created_at' => $fecha,
                        'horario_id' => $horarioID,
                        'asistencia_id' => $id,
                        'fecha' => $fecha,
                        'tipo' => $tipo
                        // Agrega otros campos que necesitas actualizar
                    ],
                ]);
            }
        }


        return redirect()->route('horarios.fechas')->with('success', 'Horario Programado se agrego Exitosamente.');
    }


    public function update(Request $request, AsistenciaModel $asistencia)
    {
        try {
            //code...

            // Validar los datos del formulario
            $request->validate([
                'fecha' => 'required',
                'horario_id' => 'required',
                'descrip' => 'required',
            ]);

            $fecha = $request->input('fecha');
            $horarioID = $request->input('horario_id');

            // Buscar la asistencia existente por su ID
            $id = $asistencia->id;

            // Actualizar los campos necesarios
            $asistencia->update([
                'fecha' => $fecha,
                'descrip' => $request->input('descrip'),
                'estado' => '1'
                // Agrega otros campos que necesitas actualizar
            ]);

            // Actualizar la relación muchos a muchos con los empleados
            $empleados = EmpleadosModel::all();
            $tipo = HorarioModel::find($horarioID)->tipo;


            foreach ($empleados as $empleado) {
                $empleado->asistencias()->syncWithoutDetaching([
                    $id => [

                        'horario_id' => $horarioID,
                        'asistencia_id' => $id,
                        'fecha' => $fecha,
                        'tipo' => $tipo
                        // Agrega otros campos que necesitas actualizar
                    ],
                ]);
            }
            $registros = RegistroAsistencia::where('asistencia_id', $id)->get();
            foreach ($registros as $registro) {
                $this->verificarMarcado($registro);
                $this->calcularRetraso($registro);
            }
      
            return redirect()->route('horarios.fechas')->with('success', 'Asistencia modificada exitosamente.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }





    private function CrearAsistencia($fecha)
    {
        // Verificar si el mes es posterior al mes actual
        if (Carbon::now()->format('Y-m-d') < $fecha) {
            // Si es posterior, obtener o crear el permiso del mes actual
            $asistenciaActual = AsistenciaModel::where('fecha', $fecha)->select('id')->first();
            if (!$asistenciaActual) {
                $asistenciaActual = AsistenciaModel::create(['fecha' => $fecha, 'descrip' => "Programado", 'estado' => '1']);
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

    private function actualizarRegistro($id)
    {
    }




    private function calcularRetraso(RegistroAsistencia $registro)
    {
        if ($registro->horario->tipo == 1) {

            $horaEntrada = Carbon::parse($registro->horario->hora_entrada);
            $horaInicio = Carbon::parse($registro->horario->hora_inicio);
            $excepcion = Carbon::parse($registro->horario->excepcion);

            if ($registro->registro_inicio && !$registro->registro_entrada) {

                $horaexcepcion = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaInicio = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaInicio);
                $horaEntradaReal = Carbon::parse($registro->registro_inicio);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso1 = $retraso;
                    $registro->minutos_retraso = $retraso;;
           
                    $registro->save();
                } else {
                    $registro->retraso1 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            } else if ($registro->registro_entrada && $registro->registro_inicio) {

                $horaexcepcion1 = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaInicio = $horaexcepcion1->format('H:i:s');

                $horaexcepcion2 = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaEntrada = $horaexcepcion2->format('H:i:s');

                $horaEntradaProgramada1 = Carbon::parse($horaInicio);
                $horaEntradaProgramada2 = Carbon::parse($horaEntrada);

                $horaEntradaReal1 = Carbon::parse($registro->registro_inicio);
                $horaEntradaReal2 = Carbon::parse($registro->registro_entrada);

                if ($horaEntradaReal1->greaterThan($horaEntradaProgramada1) || $horaEntradaReal2->greaterThan($horaEntradaProgramada2)) {

                    $retraso1 = $horaEntradaReal1->diffInMinutes($horaEntradaProgramada1);
                    $retraso2 = $horaEntradaReal2->diffInMinutes($horaEntradaProgramada2);
                    $registro->retraso1 = $retraso1;
                    $registro->retraso2 = $retraso2;
                    $registro->minutos_retraso = $retraso1 + $retraso2;
                    $registro->save();
                }
            } else if ($registro->registro_entrada && !$registro->registro_inicio) {

                $horaexcepcion = $horaEntrada->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaEntrada = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaEntrada);
                $horaEntradaReal = Carbon::parse($registro->registro_entrada);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso2 = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso2 = $retraso2;
                    $registro->minutos_retraso = $retraso2;
                    $registro->save();
                } else {
                    $registro->retraso2 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            }
        } else if ($registro->horario->tipo == 0) {

   
            $horaInicio = Carbon::parse($registro->horario->hora_inicio);
            $excepcion = Carbon::parse($registro->horario->excepcion);
            if ($registro->registro_inicio) {

                $horaexcepcion = $horaInicio->addHours($excepcion->hour)->addMinutes($excepcion->minute)->addSeconds($excepcion->second);
                $horaInicio = $horaexcepcion->format('H:i:s');

                $horaEntradaProgramada = Carbon::parse($horaInicio);
                $horaEntradaReal = Carbon::parse($registro->registro_inicio);

                if ($horaEntradaReal->greaterThan($horaEntradaProgramada)) {

                    $retraso = $horaEntradaReal->diffInMinutes($horaEntradaProgramada);
                    $registro->retraso1 = $retraso;
                    $registro->minutos_retraso = $retraso;;
                 
                    $registro->save();
                } else {
                    $registro->retraso1 = 0;
                    $registro->minutos_retraso = 0;
                    $registro->save();
                }
            }
        }
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
