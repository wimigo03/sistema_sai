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
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = RegistroAsistencia::with('empleado')->where('estado', 0);
            $data = $data->get();

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
