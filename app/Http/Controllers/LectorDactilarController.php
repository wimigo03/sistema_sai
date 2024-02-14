<?php

namespace App\Http\Controllers;

use App\Models\HuellasDigitalesModel;
use App\Models\LectorDactilarModel;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\RegistroAsistencia;

class LectorDactilarController extends Controller
{
    public function index(Request $request)
    {
        //
        $dactilar = HuellasDigitalesModel::select(['id', 'fid', 'empleado_id', 'created_at', 'usuario_creac'])
            ->with(['empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
            }])
            ->orderBy('created_at', 'desc') // Ordenar por created_at en orden descendente
            ->get();



        if ($request->ajax()) {
            return DataTables::of($dactilar)
                ->addColumn('fecha', function ($dactilar) {
                    return Carbon::parse($dactilar->created_at)->format('Y-m-d');
                })
                ->addColumn('created', function ($dactilar) {
                    $carbonDate = Carbon::parse($dactilar->created_at);

                    return $carbonDate->isToday()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : '<span style="color: black;">' . $carbonDate->diffForHumans() . '</span>';
                })
                ->addColumn('nombres', function ($row) {
                    $nom = $row->empleado->nombres;
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $nom . ' ' . $ap_pat . ' ' . $ap_mat;
                })


                ->addColumn('actions', function ($dactilar) {
                    // return '<button class="btn btn-danger btn-sm" href="' . route('descuentos.edit', $dactilar->id) . '">Eliminar</button>';
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Eliminar Huella Dactilar" href="#" data-toggle="modal" data-target="#confirmarEliminarModal" data-nombre="' . $dactilar->empleado->nombres . '" data-id="' . $dactilar->id . '">
                    <span class="badge badge-danger"> ELIMINAR</span>  
                </a>
                ';
                })
                ->rawColumns(['created', 'actions'])
                ->make(true);
        }

        return view('asistencias.control.index');
    }

    public function lector(Request $request)
    {
        //
        $lector = LectorDactilarModel::select(['id', 'serial_lector', 'model_lector', 'descrip', 'estado', 'updated_at', 'created_at'])
            ->orderBy('created_at', 'desc') // Ordenar por created_at en orden descendente
            ->get();



        if ($request->ajax()) {
            return DataTables::of($lector)
                ->addColumn('model_lector', function ($row) {
                    $nom = $row->model_lector;

                    return $nom;
                })
                ->addColumn('descrip', function ($row) {
                    $nom = $row->descrip;

                    return $nom;
                })
                ->addColumn('fecha', function ($lector) {
                    return Carbon::parse($lector->created_at)->format('Y-m-d');
                })
                ->addColumn('created', function ($lector) {
                    $carbonDate = Carbon::parse($lector->created_at);

                    return $carbonDate->isToday()
                        ? '<span style="color: green;">' . $carbonDate->diffForHumans() . '</span>'
                        : '<span style="color: black;">' . $carbonDate->diffForHumans() . '</span>';
                })
              

                ->addColumn('actions', function ($lector) {
                    // return '<button class="btn btn-danger btn-sm" href="' . route('descuentos.edit', $dactilar->id) . '">Eliminar</button>';
               
                $estado = ($lector->estado);
                if ($estado == 1) {
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Desactivar Lector Dactilar" href="#" data-toggle="modal" data-target="#confirmarEliminarModal" data-estado="' . $lector->estado . '"data-nombre="'  . $lector->model_lector . '" data-id="' . $lector->id . '">
                    <span class="badge badge-success"> ACTIVO</span>  
                </a>';
                } else {

                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Desactivar Lector Dactilar" href="#" data-toggle="modal" data-target="#confirmarEliminarModal" data-estado="' . $lector->estado . '" data-nombre="' . $lector->model_lector . '" data-id="' . $lector->id . '">
                    <span class="badge badge-danger"> INACTIVO</span>  
                </a>';
                }
                })
                ->rawColumns(['created', 'estado','actions'])
                ->make(true);
        }

        return view('asistencias.lectorDactilar.index');
    }


    public function destroy($id)
    {
        // Eliminar el horario
        $dactilar = HuellasDigitalesModel::find($id);
        $dactilar->delete();

        // Obtener todos los registros restantes
        $remainingRecords = HuellasDigitalesModel::orderBy('created_at', 'desc')->get();

        // Recorrer los registros y asignar nuevos valores a la columna fid
        foreach ($remainingRecords as $index => $record) {
            $record->fid = $index + 1;
            $record->save(); // Guardar cada registro individualmente
        }

        // Redireccionar a la lista de horarios con un mensaje de éxito
        return redirect()->route('lectordactilar.index')->with('success', 'La huella Dactilar ha sido eliminada correctamente.');
    }

    
    public function updateEstado($id)
    {
        // Find the device
        $dispositivo = LectorDactilarModel::where('id',$id)->first();
    
        // Check if the device exists
        if ($dispositivo) {
            // Toggle the estado value between 0 and 1
            $dispositivo->estado = $dispositivo->estado == 0 ? 1 : 0;
    
            // Save the changes
            $dispositivo->save();
    
            // Redirect to the list of devices with a success message
            return redirect()->route('lector.index')->with('success', 'Estado actualizado exitosamente.');
        } else {
            // Device not found, redirect with an error message or handle the error as needed
            return redirect()->route('lector.index')->with('error', 'Dispositivo no encontrado.');
        }
    }
    
}
