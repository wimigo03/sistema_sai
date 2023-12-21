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
        $dactilar = HuellasDigitalesModel::select(['id', 'empleado_id', 'created_at', 'usuario_creac'])
            ->with(['empleado' => function ($query) {
                $query->select('idemp', 'nombres', 'ap_pat', 'ap_mat');
            }])
            ->orderBy('created_at', 'desc') // Ordenar por created_at en orden descendente
            ->get();



        if ($request->ajax()) {
            return DataTables::of($dactilar)
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
                    return '<a class="tts:left tts-slideIn tts-custom" aria-label="Eliminar Huella Dactilar" href="#" data-toggle="modal" data-target="#confirmarEliminarModal" data-nombre="' . $dactilar->empleado->nombres . '" data-id="'. $dactilar->id .'">
                    <span class="badge badge-danger"> ELIMINAR</span>  
                </a>
                ';
                })
                ->rawColumns(['created', 'actions'])
                ->make(true);
        }

        return view('asistencias.control.index');
    }

    public function destroy($id)
    {
        // Eliminar el horario
        $dactilar = HuellasDigitalesModel::find($id);
        $dactilar->delete();

        // Redireccionar a la lista de horarios con un mensaje de éxito
        return redirect()->route('lectordactilar.index')->with('success', 'El la huella Dactilar ha sido eliminada correctamente.');
    }
}
