<?php

namespace App\Http\Controllers\Almacen\Ingreso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;

use App\Models\Almacen\Ingreso\IngresoModel;
use App\Models\Almacen\Ingreso\ReporteAreaModel;

use App\Models\Almacen\DetalleValeModel;

use App\Models\Almacen\Ingreso\Temporal6Model;
use App\Models\Almacen\Ingreso\Temporal7Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use PDF;
use NumerosEnLetras;
use Hamcrest\TypeSafeDiagnosingMatcher;

use App\Models\Event;
use Carbon\Carbon;
class ReporteAreasController extends Controller
{
    public function index()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal6Model::find($id);

        $id2 = $detalle->idingreso;
        $id3 = $detalle->idarea;
      

       // $prodserv = DB::table('reportarea as rr')


        $prodserv = DB::table('detallevale as d')

        ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso') 
        ->join('vale as va', 'va.idvale', '=', 'd.idvale')

        ->join('areas as a', 'a.idarea', '=', 'va.idarea')


       
        // ->select('rr.idreportarea',
        ->select(
         'ing.nombreprograma', 'ing.nombreproducto',
          'd.cantidadsol', 'd.preciosol', 'd.subtotalsol',
          'va.idarea')
        //->where('ing.estadocompra', 2)

        ->orwhere('va.idarea', $id3 )
        // ->orwhere('va.idarea', $id3 )
        ->where('d.idingreso', $id2)

        ->get();

     

    $ingresos = DB::table('ingreso')
        ->where('estadocompracomb', 2)
        ->select(DB::raw("concat(idingreso,' // ',nombreproducto,' // ',nombreprograma,' // salida LTRS. ',cantidadsalida) as prodservicio"), 'idingreso')
        ->pluck('prodservicio', 'idingreso');
        
   
    $areas = DB::table('areas')
     
    ->where('estadoarea', 1)
    ->select(DB::raw("concat(nombrearea,' // ',idarea) as prodservicios"), 'idarea')
    ->pluck('prodservicios', 'idarea');

    return view('almacenes.reporte.index', 
    ['prodserv' => $prodserv, 
    'ingresos' => $ingresos, 
    'areas' => $areas,
    'id' => $id
]);
}

public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal6Model::find($id);

        $prod = $request->get('ingreso');
        $proddos = $request->get('area');

      
        
        $detallereport = new ReporteAreaModel();
        $detallereport->idingreso = $request->get('ingreso');
        $detallereport->idarea = $request->get('area');
        
        $detallereport->save();
       
        
        if(is_null($detalle)){
            $detalle = new Temporal6Model;
            $detalle->idtemporal6=$id;
            $detalle->idusuario=$id;
            $detalle->idingreso=$prod;
            $detalle->idarea=$proddos;
            $detalle->save();
             $detallereport->save();
        }else{
            $detalle->idtemporal6 = $id;
            $detalle->idusuario = $id;
           $detalle->idingreso = $prod;
           $detalle->idarea=$proddos;
            $detalle->update();
        }

        return redirect()->route('almacenes.reporte.index');
    }


    public function guardartipoarea(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $tipoarea = new TipoAreaModel;
        $tipoarea->idarea = $personalArea->idarea;
        $tipoarea->idtipo = $request->input('tipo');


        $detallito = DB::table('tipoarea as tt')
        ->join('areas as ar', 'ar.idarea', '=', 'tt.idarea')
         ->join('tipoarchivo as t', 't.idtipo', '=', 'tt.idtipo')
         ->select('tt.idtipoarea', 'tt.idtipo', 'tt.idarea', 't.nombretipo')
         ->where('tt.idarea','=', $personalArea->idarea)
         ->where('tt.idtipo', $request->input('tipo'))
         ->get();

//dd($detallito);

        if ($detallito->isEmpty()) {
            $tipoarea->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('archivos2.tipo');
    }

    
    public function delete($idtipoarea)
    {
        $tipoarea =TipoAreaModel::find($idtipoarea);

        $tipoarea->delete();

        return redirect()->route('archivos2.tipo');
    }

    public function solicitud($id)
    {
        $idre=$id;

        $detalle = Temporal6Model::find($idre);

        $id2 = $detalle->idingreso;
        $id3 = $detalle->idarea;

        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $ingresos = DB::table('ingreso as ing')
                ->select(
                    'ing.cantidad',
                    'ing.subtotal',
             
                     'ing.cantidadsalida',
                    // 'ing.subtotalsalida',

                    'ing.codigocatprogramai',
                    'ing.nombrecatprogmai'
                )
                ->where('ing.idingreso', '=', $id2)->first();


            $ingreso = IngresoModel::find($id2);
            $Subtotalsalida=$ingreso -> subtotalsalida;
            $SPrecio=$ingreso -> precio;
            //modificacion aumentando dos columnas
            // $CantitadIngrs=$ingreso -> cantitad;
            // $SubtotalIngreso=$ingreso -> subtotal;
       

                // $Cantidadsalida = $ingresos->cantidadsalida;
                // $Subtotalsalida = $ingresos->subtotalsalida;
            $prodserv = DB::table('detallevale as d')

                ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso') 
                ->join('vale as v', 'v.idvale', '=', 'd.idvale')

                ->join('areas as a', 'a.idarea', '=', 'v.idarea')

                ->select('d.idvale','d.cantidadsol','d.preciosol','d.subtotalsol','d.cantidadresta',
                
                'v.usuarionombre','v.usuariocargo','v.fechaaprob',

                'a.nombrearea',
                
                'ing.precio','ing.subtotalsalida') 

                ->where('d.idingreso', '=', $id2)
                ->where('v.idarea', '=', $id3)
                ->get();

             //    $r_total= $prodserv->preciosol;
             //    $valor_total = $prodserv->sum('cantidadsol');
             //    $valor_total2 = $prodserv->sum('subtotalsol');

               
        
            $valor_total = $prodserv->sum('cantidadsol');
            $valor_total2 = $valor_total* $SPrecio;

            //modificacion para la parte decimal
            $parte_entera = floor($Subtotalsalida); 
            $parte_decimal = ($Subtotalsalida - $parte_entera) * 100;

            $parte_entera_en_letras = NumerosEnLetras::convertir($parte_entera, 'Bolivianos', false);
            $parte_decimal_en_letras = NumerosEnLetras::convertir($parte_decimal, 'Centavos', false);

            $valor_total5 = $parte_entera_en_letras . ' con ' . $parte_decimal_en_letras;

            //fin de la modificacion 

//obeteniendo por unidades centenas y decenas de mil

$parte_entera_formateada = number_format($Subtotalsalida, 0, '', '.');

//$parte_decimaldos = number_format(($Subtotalsalida - floor($Subtotalsalida)), 2, ',', '');
// 0,22 a solo la parte entera 22
$parte_decimaldos = floor($parte_decimal);
$valor_total6 = $parte_entera_formateada . ',' . $parte_decimaldos;



//fin unidades y centenas




             $valor_total3 = NumerosEnLetras::convertir($valor_total2, 'Bolivianos', true);
            // $valor_total5 = NumerosEnLetras::convertir($Subtotalsalida, 'Bolivianos', true);

            return view('almacenes.reporte.pdf-solicitud',[
                                                'valor_total' => $valor_total,
                                                'valor_total2' => $valor_total2,
                                                'valor_total3' => $valor_total3,
                                                'valor_total5' => $valor_total5,
                                                
                                                 
                                                //nueva modificacion
                                                'valor_total6' => $valor_total6,
                                                // 'Cantidadsalida' => $Cantidadsalida,
                                                // 'Subtotalsalida' => $Subtotalsalida,
                                                
                                                //borrar
                                                'parte_entera' => $parte_entera,
                                                'parte_decimal' => $parte_decimal,
                                                'Subtotalsalida' => $Subtotalsalida,
                                                'parte_entera_formateada' => $parte_entera_formateada,
                                                //'parte_decimaldos' => $parte_decimaldos,
                                              
                                       
                                                'prodserv' => $prodserv,
                                                'ingresos' => $ingresos
                                                ]);
        }
        catch (Exception $ex) {
            \Log::error("Orden Error: {$ex->getMessage()}");
            return redirect()->route('almacenes.reporte.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }


    public function index2()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal7Model::find($id);

        $id2 = $detalle->idingreso;
        $id3 = $detalle->fechaini;
        $id4 = $detalle->fechafi;

       // $prodserv = DB::table('reportarea as rr')


       $ingresos = DB::table('ingreso as ing')
       ->select(
           'ing.cantidad',
           'ing.subtotal',
    
           'ing.cantidadsalida',
         'ing.subtotalsalida',

           'ing.codigocatprogramai',
           'ing.nombrecatprogmai'
       )
       ->where('ing.idingreso', '=', $id2)->first();
       
       $ingreso = IngresoModel::find($id2);
    //    $Subtotalsalida=$ingreso -> subtotalsalida;
       $SPrecio=$ingreso -> precio;

       $detalle = DB::table('detallevale as d')
   
                   ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso') 
                   ->join('vale as v', 'v.idvale', '=', 'd.idvale')
   
                   ->join('areas as a', 'a.idarea', '=', 'v.idarea')
   
                   ->select('d.idvale','d.cantidadsol','d.preciosol','d.subtotalsol','d.cantidadresta',
                   
                   'v.usuarionombre','v.usuariocargo','v.estadovale','v.fechaaprob',
   
                   'a.nombrearea',
                   'ing.precio') 
                //    'ing.precio','ing.subtotalsalida') 
   
                   ->where('d.idingreso', '=', $id2)
                   ->whereBetween('v.fechaaprob',[$id3, $id4])
                   ->orderBy('v.fechaaprob', 'asc')
                   ->get();
               
                   $valor_total = $detalle->sum('cantidadsol');
                   $valor_total2 = $valor_total* $SPrecio;
       
                   //modificacion para la parte decimal
                //    $parte_entera = floor($Subtotalsalida); 
                //    $parte_decimal = ($Subtotalsalida - $parte_entera) * 100;
       
                //    $parte_entera_en_letras = NumerosEnLetras::convertir($parte_entera, 'Bolivianos', false);
                //    $parte_decimal_en_letras = NumerosEnLetras::convertir($parte_decimal, 'Centavos', false);
       
                //    $valor_total5 = $parte_entera_en_letras . ' con ' . $parte_decimal_en_letras;
       
               
    //    $parte_entera_formateada = number_format($Subtotalsalida, 0, '', '.');
       
    //    $parte_decimaldos = floor($parte_decimal);
    //    $valor_total6 = $parte_entera_formateada . ',' . $parte_decimaldos;
       
       
  
                    $valor_total3 = NumerosEnLetras::convertir($valor_total2, 'Bolivianos', true);
             
    $ingresoso = DB::table('ingreso')
    ->where('estadocompracomb', 2)
    ->select(DB::raw("concat(idingreso,' // ',nombreproducto,' // ',nombreprograma,' // salida LTRS. ',cantidadsalida) as prodservicio"), 'idingreso')
    ->pluck('prodservicio', 'idingreso');  
           
           return view('almacenes/reporte/index2',
           [
            'valor_total' => $valor_total,
            'valor_total2' => $valor_total2,
            'valor_total3' => $valor_total3,
            // 'valor_total5' => $valor_total5,
            // 'valor_total6' => $valor_total6,
         
            // 'parte_entera' => $parte_entera,
            // 'parte_decimal' => $parte_decimal,
          
            // 'parte_entera_formateada' => $parte_entera_formateada,
          
            'ingresos' => $ingresos,
            'ingresoso' => $ingresoso,
            'detalle'=>$detalle,
        
           'idingreso'=>$id2,
           'id'=>$id
        ]);
           }
           
public function store2(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal7Model::find($id);

        $prod = $request->get('ingreso');
        $prodfi = Carbon::createFromFormat('d/m/Y', $request->input('fechainicio'))->format('Y-m-d');
        $prodffi =Carbon::createFromFormat('d/m/Y', $request->input('fechafin'))->format('Y-m-d');

    
        
        $detallereport = new ReporteAreaModel();
        $detallereport->idingreso = $request->get('ingreso');
        $detallereport->fechainicio = $request->get('fechainicio');
        $detallereport->fechafin = $request->get('fechafin');
        $detallereport->save();
       
        
        if(is_null($detalle)){
            $detalle = new Temporal7Model;
            $detalle->idtemporal7=$id;
            $detalle->idusuario=$id;
            $detalle->idingreso=$prod;
            $detalle->fechaini=$prodfi;
            $detalle->fechafi=$prodffi;
            $detalle->save();
             $detallereport->save();
        }else{
            $detalle->idtemporal7 = $id;
            $detalle->idusuario = $id;
           $detalle->idingreso = $prod;
           $detalle->fechaini=$prodfi;
           $detalle->fechafi=$prodffi;
            $detalle->update();
        }

        return redirect()->route('almacenes.reporte.index2');
    }

    public function solicituddos($id)
    {
        $idre=$id;

        $detalle = Temporal7Model::find($idre);

        $id2 = $detalle->idingreso;
        $id3 = $detalle->fechaini;
        $id4 = $detalle->fechafi;

        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $ingresos = DB::table('ingreso as ing')
                ->select(
                    'ing.cantidad',
                    'ing.subtotal',
             
                     'ing.cantidadsalida',
                    // 'ing.subtotalsalida',

                    'ing.codigocatprogramai',
                    'ing.nombrecatprogmai'
                )
                ->where('ing.idingreso', '=', $id2)->first();


            $ingreso = IngresoModel::find($id2);
            $Subtotalsalida=$ingreso -> subtotalsalida;
            $SPrecio=$ingreso -> precio;
            //modificacion aumentando dos columnas
            // $CantitadIngrs=$ingreso -> cantitad;
            // $SubtotalIngreso=$ingreso -> subtotal;
       

                // $Cantidadsalida = $ingresos->cantidadsalida;
                // $Subtotalsalida = $ingresos->subtotalsalida;
            $prodserv = DB::table('detallevale as d')

                ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso') 
                ->join('vale as v', 'v.idvale', '=', 'd.idvale')

                ->join('areas as a', 'a.idarea', '=', 'v.idarea')

                ->select('d.idvale','d.cantidadsol','d.preciosol','d.subtotalsol','d.cantidadresta',
                
                'v.usuarionombre','v.usuariocargo','v.fechaaprob',

                'a.nombrearea',
                
                'ing.precio','ing.subtotalsalida') 

                ->where('d.idingreso', '=', $id2)
                ->whereBetween('v.fechaaprob',[$id3, $id4])
                ->orderBy('v.fechaaprob', 'asc')
                ->get();

             //    $r_total= $prodserv->preciosol;
             //    $valor_total = $prodserv->sum('cantidadsol');
             //    $valor_total2 = $prodserv->sum('subtotalsol');

               
        
            $valor_total = $prodserv->sum('cantidadsol');
            $valor_total2 = $valor_total* $SPrecio;

            //modificacion para la parte decimal
            $parte_entera = floor($Subtotalsalida); 
            $parte_decimal = ($Subtotalsalida - $parte_entera) * 100;

            $parte_entera_en_letras = NumerosEnLetras::convertir($parte_entera, 'Bolivianos', false);
            $parte_decimal_en_letras = NumerosEnLetras::convertir($parte_decimal, 'Centavos', false);

            $valor_total5 = $parte_entera_en_letras . ' con ' . $parte_decimal_en_letras;

            //fin de la modificacion 

//obeteniendo por unidades centenas y decenas de mil

$parte_entera_formateada = number_format($Subtotalsalida, 0, '', '.');

//$parte_decimaldos = number_format(($Subtotalsalida - floor($Subtotalsalida)), 2, ',', '');
// 0,22 a solo la parte entera 22
$parte_decimaldos = floor($parte_decimal);
$valor_total6 = $parte_entera_formateada . ',' . $parte_decimaldos;



//fin unidades y centenas




             $valor_total3 = NumerosEnLetras::convertir($valor_total2, 'Bolivianos', true);
            // $valor_total5 = NumerosEnLetras::convertir($Subtotalsalida, 'Bolivianos', true);

            return view('almacenes.reporte.pdf-solicituddos',[
                                                'valor_total' => $valor_total,
                                                'valor_total2' => $valor_total2,
                                                'valor_total3' => $valor_total3,
                                                'valor_total5' => $valor_total5,
                                                
                                                 
                                                //nueva modificacion
                                                'valor_total6' => $valor_total6,
                                                // 'Cantidadsalida' => $Cantidadsalida,
                                                // 'Subtotalsalida' => $Subtotalsalida,
                                                
                                                //borrar
                                                'parte_entera' => $parte_entera,
                                                'parte_decimal' => $parte_decimal,
                                                'Subtotalsalida' => $Subtotalsalida,
                                                'parte_entera_formateada' => $parte_entera_formateada,
                                                //'parte_decimaldos' => $parte_decimaldos,
                                              
                                       
                                                'prodserv' => $prodserv,
                                                'ingresos' => $ingresos
                                                ]);
        }
        catch (Exception $ex) {
            \Log::error("Orden Error: {$ex->getMessage()}");
            return redirect()->route('almacenes.reporte.index2')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }


}

