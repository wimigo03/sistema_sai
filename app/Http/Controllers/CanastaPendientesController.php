<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Afiliado;
use App\Models\Entrega;
use App\Models\TemporalEntrega;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use PDF;
use Yajra\Datatables\Datatables;
class CanastaPendientesController extends Controller
{

  public function index(){
   /* $temporal = TemporalEntrega::get();
    if(count($temporal) > 0){
      foreach($temporal as $data){
        $temporal = TemporalEntrega::find($data->id_e_temp);
        $temporal->delete();
      }
    }*/
    $entrega_temp = TemporalEntrega::get();
    return view('discapacidad.pendientes.index',compact('entrega_temp'));
  }



  public function search(Request $request){
    try {
	        ini_set('memory_limit','-1');
          ini_set('max_execution_time','-1');
	 
	  $inicio = '01/01/' . $request->anho;
    $final = '31/12/' . $request->anho;
    $periodo = $request->periodo;
    switch ($periodo) {
      case "1":
        $mes_1 = 'ENERO';
        $mes_2 = 'FEBRERO';
        $mes_3 = 'MARZO';
        break;
      case "2":
        $mes_1 = 'ABRIL';
        $mes_2 = 'MAYO';
        $mes_3 = 'JUNIO';
        break;
      case "3":
        $mes_1 = 'JULIO';
        $mes_2 = 'AGOSTO';
        $mes_3 = 'SEPTIEMBRE';
        break;
      case "4":
        $mes_1 = 'OCTUBRE';
        $mes_2 = 'NOVIEMBRE';
        $mes_3 = 'DICIEMBRE';
        break;
    }
    $pendientes = Afiliado::get();
    $temporal = TemporalEntrega::get();
    if(count($temporal) > 0){
      foreach($temporal as $data){
        $temporal = TemporalEntrega::find($data->id_e_temp);
        $temporal->delete();
      }
    }
    $num = 0;
    foreach($pendientes as $pendiente){
      $entrega_search = Entrega::query()
                        ->byPendiente($pendiente->codigo)
                        ->byMes1($mes_1)
                        ->byMes2($mes_2)
                        ->byMes3($mes_3)
                        ->byFechas($inicio,$final)
                        ->get();
      if(count($entrega_search) == 0){
        $afiliado = new TemporalEntrega();
        $afiliado->id_e_temp = $num;
        $afiliado->id_ent = $pendiente->codigo;
        $afiliado->save();
        $num++;
      }
    }
    $entrega_temp = TemporalEntrega::get();
    return view('discapacidad.pendientes.index',compact('entrega_temp'));
	
       
    } catch (Exception $ex) {
	   Log::error("Error al generar: {$ex->getMessage()}");
        
	
       
    } finally {
	
        ini_restore('memory_limit');
        ini_restore('max_execution_time');
       
    }
  }

 /* public function search(Request $request){
    $inicio = '01/01/' . $request->anho;
    $final = '31/12/' . $request->anho;
    $periodo = $request->periodo;
    switch ($periodo) {
      case "1":
        $mes_1 = 'ENERO';
        $mes_2 = 'FEBRERO';
        $mes_3 = 'MARZO';
        break;
      case "2":
        $mes_1 = 'ABRIL';
        $mes_2 = 'MAYO';
        $mes_3 = 'JUNIO';
        break;
      case "3":
        $mes_1 = 'JULIO';
        $mes_2 = 'AGOSTO';
        $mes_3 = 'SEPTIEMBRE';
        break;
      case "4":
        $mes_1 = 'OCTUBRE';
        $mes_2 = 'NOVIEMBRE';
        $mes_3 = 'DICIEMBRE';
        break;
    }
    $pendientes = Afiliado::get();
    $temporal = TemporalEntrega::get();
    if(count($temporal) > 0){
      foreach($temporal as $data){
        $temporal = TemporalEntrega::find($data->id_e_temp);
        $temporal->delete();
      }
    }
    $num = 0;
    foreach($pendientes as $pendiente){
      $entrega_search = Entrega::query()
                        ->byPendiente($pendiente->codigo)
                        ->byMes1($mes_1)
                        ->byMes2($mes_2)
                        ->byMes3($mes_3)
                        ->byFechas($inicio,$final)
                        ->get();
      if(count($entrega_search) == 0){
        $afiliado = new TemporalEntrega();
        $afiliado->id_e_temp = $num;
        $afiliado->id_ent = $pendiente->codigo;
        $afiliado->save();
        $num++;
      }
    }
    $entrega_temp = TemporalEntrega::get();
    return view('discapacidad.pendientes.index',compact('entrega_temp'));
  }*/







  public function searchdetalle(Request $request){
    $entrega_temp = TemporalEntrega::query()
                                ->byNroCarnet($request->nro_carnet)
                                ->byNombres($request->nombres)
                                ->byApellidos($request->apellidos)
                                ->byEdad($request->edad)
                                ->byBarrio($request->barrio)
                                ->byCarnetDiscapacitado($request->carnet_disc)
                                ->orderBy('id_ent','desc')
                                ->get();
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