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
        if ($request->ajax()) {
            $filtro = $request->input('filtro', 'actual');

            $data = RegistroAsistencia::with('empleado')->where('minutos_retraso','>',0);
            $filtro = $request->input('filtro');
            if ($filtro == 'actual') {
                $data = $data->whereDate('fecha', Carbon::today());
            } elseif ($filtro == 'mensual') {
                $data = $data->whereMonth('fecha', Carbon::now()->month);
            }
            $data = $data->get();

            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d'): '-';
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

        return view('asistencias.retrasos.index',compact('filtro'));
    }
}
