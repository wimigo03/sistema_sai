<?php

namespace App\Http\Controllers\Almacen\Ingreso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\EmpleadosModel;
use App\Models\AreasModel;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use DB;
use DataTables;
use PDF;
use NumerosEnLetras;
use App\Models\Almacen\Ingreso\DetalleValeModel;

//use App\Models\Almacen\Ingreso\IngresoModel;
use App\Models\IngresoModel;
use App\Models\Almacen\Temporal4Model;

use App\Models\DetalleCompraModel;

//use App\Models\Almacen\Ingreso\NotaIngresoModel;
use App\Models\NotaIngresoModel;

use App\Models\Almacen\Ingreso\Temporal6Model;

use Hamcrest\TypeSafeDiagnosingMatcher;


class IngresoController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
   
           $ingresos = DB::table('ingreso as ing')
   
                                       
                           ->join('detallecompracomb as prog', 'prog.iddetallecompracomb', '=', 'ing.iddetallecompracomb')
                           ->where('ing.estadocompracomb',2)
   
                           ->select('ing.idingreso','ing.nombreproducto','ing.cantidad',
                           'ing.subtotal','ing.precio','ing.nombrepartida',
                           'ing.nombrecatprogmai')
                           ->orderBy('ing.idingreso', 'asc');
   
                            return Datatables::of($ingresos)
                            ->addIndexColumn()
                            ->addColumn('btn2', 'almacenes.ingreso.btn2')
                            ->addColumn('btn3', 'almacenes.ingreso.btn3')
                            ->addColumn('btn4', 'almacenes.ingreso.btn4')
                            ->rawColumns(['btn2','btn3','btn4'])
                            ->make(true);
   
                       }     
   
               return view('almacenes.ingreso.index');
       }
     
       public function grafico(){
   
           $ingresos = DB::table('ingreso as ing')
   
   
           ->where('ing.estadocompracomb',2)
           ->get();
   
           return view('almacenes/ingreso/grafico',compact('ingresos'));
       }
    
   
   
       public function detalle($idingreso){
   
           $id2 = $idingreso;
           $detalle = DB::table('detallevale as d')
   
           ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso') 
           ->join('vale as v', 'v.idvale', '=', 'd.idvale')     
           ->select('d.idvale','d.cantidadsol','d.preciosol',
           'd.subtotalsol','d.cantidadresta','d.sudtotalresta','v.idarea','v.usuarionombre','v.usuariocargo',
   
           'ing.cantidadsalida'
           
           ) ->orderBy('d.cantidadresta', 'desc')
           ->where('d.idingreso',$id2)
           
           ->get();
   
        
           
           return view('almacenes/ingreso/detalle',
           ['detalle'=>$detalle,
        
           'idingreso'=>$id2]);
           }
           
           
   
       public function editardoc($idingreso){
          
           // crea un nuevo modelo y selecciona las relaciones y tablas
           // $docuconsumo = DB::table('docuconsumo as d')
           $notaingreso = DB::table('notaingreso as n')
   
           ->join('ingreso as ing', 'ing.idingreso', '=', 'n.idingreso')
   
           ->select('n.numcompra','n.numsolicitud','n.idnotaingreso')
   
           // ya le da el id de unidadconsumo a docunidadconsumo con el where
           -> where('ing.idingreso','=', $idingreso)-> get();
   
           //  retorna la vista o el index
            return view('almacenes.ingreso.docuconsumo', 
           //  manda la variable docuconsumo que es el nuevo modelo y el id de unidadconsumo
            ["notaingreso" => $notaingreso,
            "idingreso" => $idingreso]);}
       
   
            
           //  createdoc es el boton para crear un nuevo documento
   public function createdoc($idingreso){
              
                return view('almacenes.ingreso.createdocuconsumo',
                 ["idingreso" => $idingreso]);}
   
   
   
   public function insertar(Request $request){
   
    
      $idingreso=$request->input('notaingreso');
    
      $ingreso = IngresoModel::find($idingreso);
   
      $nmbpro = $ingreso->nombreproducto;
      $cantidad = $ingreso->cantidad;
      $subtotal = $ingreso->subtotal;
      $precio = $ingreso->precio;
      $nmbprvv = $ingreso->nombreproveedor;
      $codigopartida = $ingreso->codigopartida;
   
    
   
   
      $notaingreso = new NotaIngresoModel();
      $notaingreso -> numcompra = $request->input('numcompra');
      $notaingreso -> numsolicitud = $request->input('numsolicitud');
      $notaingreso -> num_comprobante = $request->input('comprobante');
      $notaingreso -> factura_comprobante = $request->input('factura');
      
      $notaingreso -> nombreproducto = $nmbpro;
      $notaingreso -> ingreso = $cantidad;
      $notaingreso -> subtotal = $subtotal;
      $notaingreso -> precio = $precio;
      $notaingreso -> nombreprobeedor = $nmbprvv;
      $notaingreso -> codigoproducto = $codigopartida;
   
   
      $notaingreso -> idingreso =$idingreso;
     
   
   
      $notaingreso->save();
   
   
      return redirect()
      ->action('App\Http\Controllers\Almacen\Ingreso\IngresoController@editardoc',
       [$idingreso]);
   }
   
   
   public function solicitud($idingreso)
       {
           $id=$idingreso;
           try {
               ini_set('memory_limit', '-1');
               ini_set('max_execution_time', '-1');
   
               $ingresos = DB::table('ingreso as ing')
                   ->select(
                       'ing.cantidad',
                       'ing.subtotal',
                
                       'ing.cantidadsalida',
                       'ing.subtotalsalida',
   
                       'ing.codigocatprogramai',
                       'ing.nombrecatprogmai'
                   )
                   ->where('ing.idingreso', '=', $id)->first();
   
   
               $ingreso = IngresoModel::find($id);
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
                   
                   'v.usuarionombre','v.usuariocargo',
   
                   'a.nombrearea',
                   
                   'ing.precio','ing.subtotalsalida') 
   
                   ->where('d.idingreso', '=', $id)->get();
   
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
   
               return view('almacenes.ingreso.pdf-solicitud',[
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
               return redirect()->route('almacenes.ingreso.index')->with('message', $ex->getMessage());
           } finally {
               ini_restore('memory_limit');
               ini_restore('max_execution_time');
           }
       }
   
   
       public function reporte(){
   
   
       
            $personal = User::find(Auth::user()->id);
            $id = $personal->id;
   
            $detalle = Temporal6Model::find($id);
            $id2 = $detalle->idingreso;
            $id3 = $detalle->idarea;
   
            
         
           $ingresos = DB::table('ingreso')
                           ->where('estadocompracomb',2)
                           ->select(DB::raw("concat(nombreproducto,
       
                           ' // PROGRA. ',nombreprograma,
                           ' // PROVEE. ',nombreproveedor,
                           ' // CAT PROG. ',nombrecatprogmai
                           ) as prodservicio"),'idingreso')
                           ->pluck('prodservicio','idingreso');
   
           $areas = DB::table('areas')
                           ->where('estadoarea',1)
                           ->select(DB::raw("concat(nombrearea,
       
                           ' // IDa. ',idarea
                           ) as prodservicio"),'idarea')
                           ->pluck('prodservicio','idarea');   
       
       
           return view('almacenes.ingreso.reporte',
           ['ingresos'=>$ingresos,
           'areas'=>$areas
       ]);
       }
       
   public function store2 (Request $request){
   
       $personal = User::find(Auth::user()->id);
       $id = $personal->id;
       $detalle = Temporal6Model::find($id);
           
   
       $prod = $request->get('ingreso');
       $almacen = IngresoModel::find($prod);
       $Idingres = $almacen->idingreso;
   
       $prod2 = $request->get('area');
       $almacen2 = AreasModel::find($prod2);
       $Idare = $almacen2->idarea;
   
           if(is_null($detalle)){
   
               $detalle = new Temporal6Model;
               $detalle->idtemporal6=$id;
               $detalle->idusuario=$id;
               $detalle->idingreso = $request->get('ingreso');
               $detalle->idarea = $request->get('area');
               $detalle->save();
           }else{
             
           }
           return redirect()->route('almacenes.ingreso.reporte');
   
   
   }
   
   }
   
   
   
   
