<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Afiliado;
//use App\Models\Entrega;
use App\Models\ActivosActual;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use PDF;
//use Yajra\Datatables\Datatables;
class ActivosVsiafController extends Controller
{

  public function index(){
    $activos = ActivosActual::orderBy('id','desc')->paginate(10);
    return view('activosVsiaf.index',compact('activos'));
  }

  public function search(Request $request){
    $activos = ActivosActual::query()
                              ->byUnidad($request->unidad)
                              ->byCodigo($request->codigo)
                              ->byDescripcion($request->descripcion)
                              ->orderBy('id','desc')
                              ->paginate(10);
    return view('activosVsiaf.index',compact('activos'));
  }

  public function searchdetalle(Request $request){
    $entrega_temp = TemporalEntrega::query()
                                ->byNroCarnet($request->nro_carnet)
                                ->byNombres($request->nombres)
                                ->byApellidos($request->apellidos)
                                ->byEdad($request->edad)
                                ->byBarrio($request->barrio)
                                ->byCarnetDiscapacitado($request->carnet_disc)
                                ->orderBy('id_ent','desc')
                                ->paginate(10);
    return view('discapacidad.pendientes.index',compact('entrega_temp'));
  }

  public function searchdetallepdf(Request $request){
    try {
        ini_set('memory_limit','-1');
        ini_set('max_execution_time','-1');
        $entrega_temp = TemporalEntrega::query()
                                    ->byNroCarnet($request->nro_carnet)
                                    ->byNombres($request->nombres)
                                    ->byApellidos($request->apellidos)
                                    ->byEdad($request->edad)
                                    ->byBarrio($request->barrio)
                                    ->byCarnetDiscapacitado($request->carnet_disc)
                                    ->orderBy('id_ent','desc')
                                    ->get();
        $pdf = PDF::loadView('discapacidad.pendientes.pdf',compact(['entrega_temp']));
        $pdf->setPaper('LETTER', 'landscape');
        return $pdf->stream();
    } catch (Exception $ex) {
        \Log::error("Cotizacion Error: {$ex->getMessage()}");
        return redirect()->route('compras.detalle.index')->with('message',$ex->getMessage());
    } finally {
        ini_restore('memory_limit');
        ini_restore('max_execution_time');
    }
  }
}