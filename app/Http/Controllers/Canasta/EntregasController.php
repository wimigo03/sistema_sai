<?php

namespace App\Http\Controllers\Canasta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CanastaEntregasModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use PDF;


class EntregasController extends Controller
{
    public function index(){
        //$gestiones = CanastaPeriodosModel::select('gestion')->groupBy('gestion')->pluck('gestion','gestion');
        //$meses = CanastaPeriodosModel::select('mes')->groupBy('mes')->pluck('mes','mes');
        //$estados = CanastaPeriodosModel::ESTADOS;
        $entregas = CanastaEntregasModel::query()
                                        ->orderBy('idEntrega', 'desc')
                                        ->paginate(10);
        return view('canasta.entregas.index', compact('entregas'));
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
