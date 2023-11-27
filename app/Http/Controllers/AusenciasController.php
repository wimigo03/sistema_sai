<?php

namespace App\Http\Controllers;

use App\Models\HistorialAsistenciasCambios;
use App\Models\HorarioModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class AusenciasController extends Controller
{
    
    public function index(Request $request)
    {
        $registros = RegistroAsistencia::all(); // Asumiendo que quieres obtener los resultados

        foreach ($registros as $registro) {
            $this->verificarMarcado($registro);
        }
        if ($request->ajax()) {



            $data = RegistroAsistencia::with(['empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
            }])
            ->whereNotIn('estado', [0, 1])
            ->with('asistencia')
            ->get();
            



            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->asistencia->fecha ? Carbon::parse($row->asistencia->fecha)->format('Y-m-d') : '-';
                })
                ->addColumn('nombres_apellidos', function ($row) {
                    $nomb = $row->empleado->nombres ?? '-';
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $nomb . ' ' . $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('estado', function ($row) {
                    if ($row->estado == 0) {
                        return 'FALTA';
                    } else if ($row->estado == 2) {
                        return 'No marco Salida';
                    } else if ($row->estado == 4) {
                        return 'Regularizar Registro de la mañana';
                    } else if ($row->estado == 3) {
                        return 'Regularizar Registro de la tarde';
                    } else if ($row->estado == 5) {
                        return 'Regularizar Registro de Mañana y Tarde';
                    } else {
                        return '-'; // You can customize this message as needed
                    }
                })
                ->addColumn('opciones', function ($row) {
                    $url = route('regularizar.ausencia', ['id' => $row->id]);

                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Ausencia" href="' . $url . '">
                                <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                            </a>';
                })




                ->rawColumns(['opciones'])

                ->make(true);
        }

        return view('asistencias.regularizar.index');
    }

    public function faltas(Request $request)
    {
        $registros = RegistroAsistencia::all(); // Asumiendo que quieres obtener los resultados

        foreach ($registros as $registro) {
            $this->verificarMarcado($registro);
        }
        if ($request->ajax()) {



            $data = RegistroAsistencia::with(['empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
            }])
            ->whereNotIn('estado', [0, 1])
            ->with('asistencia')
            ->get();
            



            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->asistencia->fecha ? Carbon::parse($row->asistencia->fecha)->format('Y-m-d') : '-';
                })
                ->addColumn('nombres_apellidos', function ($row) {
                    $nomb = $row->empleado->nombres ?? '-';
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $nomb . ' ' . $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('estado', function ($row) {
                    if ($row->estado == 0) {
                        return 'FALTA';
                    } else if ($row->estado == 2) {
                        return 'No marco Salida';
                    } else if ($row->estado == 4) {
                        return 'Regularizar Registro de la mañana';
                    } else if ($row->estado == 3) {
                        return 'Regularizar Registro de la tarde';
                    } else if ($row->estado == 5) {
                        return 'Regularizar Registro de Mañana y Tarde';
                    } else {
                        return '-'; // You can customize this message as needed
                    }
                })
                ->addColumn('opciones', function ($row) {
                    $url = route('regularizar.ausencia', ['id' => $row->id]);

                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Ausencia" href="' . $url . '">
                                <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                            </a>';
                })




                ->rawColumns(['opciones'])

                ->make(true);
        }

        return view('asistencias.regularizar.index');
    }


    public function regularizar($id)
    {
        $registroAsistencia = RegistroAsistencia::with([
            'empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
            },
            'horario',
            'asistencia'
        ])->find($id);

        // Asegúrate de que $data no sea nulo antes de pasar los datos a la vista
        if (!$registroAsistencia) {
            abort(404); // o maneja de alguna manera el caso en que no se encuentre el registro
        }
       
        return view('asistencias.regularizar.manual', compact('registroAsistencia'));

     }
   

 
  
 

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'registro_inicio' => 'required',
                'registro_final' => 'required',
                // Añade reglas adicionales según tus necesidades
            ]);
            $registro = RegistroAsistencia::find($id);
    
            // Guarda los datos anteriores en el historial
            HistorialAsistenciasCambios::create([
                'registro_asistencia_id' => $registro->id,
                'datos_anteriores' => json_encode($registro->toArray()),
            ]);
    
            // Actualiza los datos del registro de asistencia
            $registro->update($request->all());
            $this->verificarMarcado($registro);
 
            // Puedes redirigir a la vista de detalles o a donde desees
           return redirect()->route('ausencias.index');
        } catch (\Exception $e) {
            // Manejo de errores aquí
            return back()->withError('Error al actualizar el registro: ' . $e->getMessage());
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
                $registro->observ = 'Dia Trabajado Regularizado';
                $registro->tipo = 0;
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
                $registro->observ = 'Dia Trabajado Regularizado';
                $registro->tipo = 0;
                $registro->save();
            } else if (!$registro->registro_final && $registro->registro_inicio) {
                $registro->estado = 3;
                $registro->save();
            } else if ($registro->registro_final && !$registro->registro_inicio) {
                $registro->estado = 4;
                $registro->save();
            } else {
                $registro->estado = 0;
                $registro->save();
            }
        }
    }
    
}
