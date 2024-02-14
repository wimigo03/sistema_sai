<?php

namespace App\Http\Controllers;

use App\Models\RegistroAsistencia;
use App\Models\RetrasosEmpleado;
use App\Models\RetrasosModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class RetrasoController extends Controller
{
    public function index(Request $request)
    {
        $fechaHoy = Carbon::now()->format('Y-m');

        if ($request->ajax()) {
        
            $filtro = $request->input('filtro', 'fechaHoy');
            $filtro = Carbon::parse($filtro);

            $mesAnio = $filtro->format('Y-m');
            
            $data = RegistroAsistencia::with('empleado')->where('minutos_retraso', '>', 0)
            ->where('fecha', 'like', $mesAnio . '%')
            ;
            
            $fechaHoy = Carbon::now()->toDateString();


            // Aplicar el filtro de fecha según el valor seleccionado
            $filtro = $request->input('filtro');
            $filtro = Carbon::parse($filtro)->format('Y-m-d');

            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->fecha ?: '-';
                })
                ->addColumn('nombres', function ($row) {
                    return $row->empleado->nombres ?? '-';
                })
                ->addColumn('apellidos', function ($row) {
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('minutos', function ($row) {
                    return $row->minutos_retraso ?? 'vacio';
                })
                ->make(true);
        }
        $filtro = $request->input('filtro', 'actual');

        return view('asistencias.retrasos.index', compact('filtro','fechaHoy'));
    }
}
