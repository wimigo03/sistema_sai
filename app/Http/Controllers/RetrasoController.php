<?php

namespace App\Http\Controllers;

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
            $data = RetrasosEmpleado::with('empleado')->where('minutos_diario','>',0);
            
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
                    return $row->minutos_diario ?? 'vacio';
                })
                ->make(true);
        }

        return view('asistencias.retrasos.index');
    }
}
