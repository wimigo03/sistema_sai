<?php

namespace App\Http\Controllers;

use App\Models\MovimientosContModel;
use App\Models\MovimientosPtModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
 
class MovimientosPlantaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = MovimientosPtModel::with('empleado');
 
            $data = $data->get();

            return DataTables::of($data)

                ->addColumn('fecha', function ($row) {
                    return $row->fechamovpt ? Carbon::parse($row->fechamovpt)->format('Y-m-d') : '-';
                })
                ->addColumn('nombres_apellidos', function ($row) {
                    $nomb = $row->empleado->nombres ?? '-';
                    $ap_pat = $row->empleado->ap_pat ?? ' ';
                    $ap_mat = $row->empleado->ap_mat ?? ' ';
                    return $nomb . ' ' . $ap_pat . ' ' . $ap_mat;
                })
                ->addColumn('motivo', function ($row) {
                    return $row->motivopt;
                })
                ->addColumn('areactual', function ($row) {
                    return $row->nombreareaactualpt;
                })
                ->addColumn('cargoactual', function ($row) {
                    return $row->cargoactualpt;
                })
                ->addColumn('nombrecargoactualpt', function ($row) {
                    return $row->nombrecargoactualpt;
                })
            
         
                
                
                ->rawColumns(['opciones'])

                ->make(true);
        }

        return view('rechumanos.planta.movimientos.index');
    }
}
