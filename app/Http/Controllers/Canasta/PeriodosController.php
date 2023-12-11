<?php

namespace App\Http\Controllers\Canasta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CanastaPeriodosModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use PDF;


class PeriodosController extends Controller
{
    public function index(){
        $gestiones = CanastaPeriodosModel::select('gestion')->groupBy('gestion')->pluck('gestion','gestion');
        $meses = CanastaPeriodosModel::select('mes')->groupBy('mes')->pluck('mes','mes');
        $estados = CanastaPeriodosModel::ESTADOS;
        $periodos = CanastaPeriodosModel::query()
                                        ->orderBy('idPeriodo', 'desc')
                                        ->paginate(10);
        return view('canasta.periodos.index', compact('gestiones','meses','estados','periodos'));
    }

    public function search(Request $request){
        $gestiones = CanastaPeriodosModel::select('gestion')->groupBy('gestion')->pluck('gestion','gestion');
        $meses = CanastaPeriodosModel::select('mes')->groupBy('mes')->pluck('mes','mes');
        $estados = CanastaPeriodosModel::ESTADOS;
        $periodos = CanastaPeriodosModel::query()
                                        ->byPeriodo($request->periodo)
                                        ->byGestion($request->gestion)
                                        ->byMes($request->mes)
                                        ->byNroEntrega($request->nro_entrega)
                                        ->byEstado($request->estado)
                                        ->orderBy('idPeriodo', 'desc')
                                        ->paginate(10);
        return view('canasta.periodos.index', compact('gestiones','meses','estados','periodos'));
    }
}
