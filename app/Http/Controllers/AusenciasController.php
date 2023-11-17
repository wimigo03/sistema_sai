<?php

namespace App\Http\Controllers;

use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class AusenciasController extends Controller
{
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
            }
            else if (
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
            }else if (
                $registro->registro_inicio &&
                !$registro->registro_salida &&
                !$registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            }else if (
                !$registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            }
            else if (
                $registro->registro_inicio &&
                $registro->registro_salida &&
                !$registro->registro_entrada &&
                $registro->registro_final
            ) {
                $registro->estado = 3;
                $registro->save();
            }
            else if (
                !$registro->registro_inicio &&
                !$registro->registro_salida &&
                $registro->registro_entrada &&
                !$registro->registro_final
            ) {
                $registro->estado = 5;
                $registro->save();
            }else if (
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
            }  else if ($registro->registro_final && !$registro->registro_inicio) {
                $registro->estado = 5;
                $registro->save();
            } else {
                $registro->estado = 0;
                $registro->save();
            }
        }
    }
    public function index(Request $request)
    {
        $registros = RegistroAsistencia::all(); // Asumiendo que quieres obtener los resultados

        foreach ($registros as $registro) {
            $this->verificarMarcado($registro);
        }
        if ($request->ajax()) {

           

            $data = RegistroAsistencia::with('empleado')->where('estado','<>',1)->get();



            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '-';
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
                    }else if ($row->estado == 5) {
                        return 'Regularizar Registro de Mañana y Tarde';
                    } else {
                        return '-'; // You can customize this message as needed
                    }
                })
                ->addColumn('opciones', function ($row) {
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Regularizar Ausencia" href="#" data-toggle="modal" data-target="#miModal" data-id="' . $row->id . '">
                                <i class="fa-solid fa-2xl fa-square-pen text-warning"></i>
                            </a>';
                })


                ->rawColumns(['opciones'])

                ->make(true);
        }

        return view('asistencias.ausencias.index');
    }
}
