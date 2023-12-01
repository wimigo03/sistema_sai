<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;

use App\Models\Almacen\ValeModel;
use App\Models\Almacen\Temporal2Model;
use App\Models\Almacen\Ingreso\IngresoModel;


use App\Models\Almacen\DetalleValeModel;


use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use NumerosEnLetras;
use PDF;



class DetalleValeController extends Controller
{
    public function index(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;

        $prodserv = DB::table('detallevale as d')

                        ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso')
                        ->join('vale as v', 'v.idvale', '=', 'd.idvale')

                        ->select('d.iddetallevale', 'v.idvale','ing.nombrecatprogmai','ing.cantidadsalida' ,
                        'ing.nombrepartida',
                        'd.cantidadsol',
                        'd.subtotalsol','d.preciosol')

                        ->where('d.idvale', $id2)
                        ->orderBy('d.iddetallevale', 'desc')
                        ->get();

        $productos = DB::table('ingreso')
                        ->where('estadocompracomb',2)
                        ->select(DB::raw("concat(
                        ' Codigo : ',codigoprodcomb,
                        ' // Nombre : ',nombreproducto,
                        ' // Proyecto: ',nombrecatprogmai,
                        ' // Programa: ',nombreprograma,
                        ' // Disponible: ',cantidadsalida, '  Litros '
                        
                        
                        ) as prodservicio"),'idingreso')
                        ->pluck('prodservicio','idingreso');

        $valor_total2 = $prodserv->sum('subtotalsol');


        $vales = DB::table('vale as v')

        ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
        ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

        ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select('v.idvale','v.estadotemp','v.aproxgas', 

               'a.nombrearea',

               'u.codigoconsumo','u.placaconsumo','u.marcaconsumo',

            'lo.nombrelocalidad','lo.distancialocalidad','v.estado2')
            ->where('v.idvale', '=', $id2)
            ->first();

        return view('almacenes.detalle.index',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idvale'=>$id2,
      
        'vales'=>$vales]);
    }

    public function index2(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;

        $prodserv = DB::table('detallevale as d')

                        ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso')
                        ->join('vale as v', 'v.idvale', '=', 'd.idvale')

                        ->select('d.iddetallevale', 'v.idvale','ing.nombrecatprogmai','ing.cantidadsalida' ,
                        'ing.nombrepartida',
                        'd.cantidadsol',
                        'd.subtotalsol','d.preciosol')

                        ->where('d.idvale', $id2)
                        ->orderBy('d.iddetallevale', 'desc')
                        ->get();

        $productos = DB::table('ingreso')
                        ->where('estadocompracomb',2)
                        ->select(DB::raw("concat(
                        ' Codigo : ',codigoprodcomb,
                        ' // Nombre : ',nombreproducto,
                        ' // Proyecto: ',nombrecatprogmai,
                        ' // Programa: ',nombreprograma,
                        ' // Disponible: ',cantidadsalida, '  Litros '
                        
                        
                        ) as prodservicio"),'idingreso')
                        ->pluck('prodservicio','idingreso');

        $valor_total2 = $prodserv->sum('subtotalsol');


        $vales = DB::table('vale as v')

        ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
        ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

        ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select('v.idvale','v.estado1','v.aproxgas', 

               'a.nombrearea',

               'u.codigoconsumo','u.placaconsumo','u.marcaconsumo',

            'lo.nombrelocalidad','lo.distancialocalidad')
            ->where('v.idvale', '=', $id2)
            ->first();

        return view('almacenes.detalle.index2',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idvale'=>$id2,
      
        'vales'=>$vales]);
    }

    public function index3(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;

        $prodserv = DB::table('detallevale as d')

                        ->join('ingreso as ing', 'ing.idingreso', '=', 'd.idingreso')
                        ->join('vale as v', 'v.idvale', '=', 'd.idvale')

                        ->select('d.iddetallevale', 'v.idvale','ing.nombrecatprogmai','ing.cantidadsalida' ,
                        'ing.nombrepartida',
                        'd.cantidadsol',
                        'd.subtotalsol','d.preciosol')

                        ->where('d.idvale', $id2)
                        ->orderBy('d.iddetallevale', 'desc')
                        ->get();

        $productos = DB::table('ingreso')
                        ->where('estadocompracomb',2)
                        ->select(DB::raw("concat(
                        ' Codigo : ',codigoprodcomb,
                        ' // Nombre : ',nombreproducto,
                        ' // Proyecto: ',nombrecatprogmai,
                        ' // Programa: ',nombreprograma,
                        ' // Disponible: ',cantidadsalida, '  Litros '
                        
                        
                        ) as prodservicio"),'idingreso')
                        ->pluck('prodservicio','idingreso');

        $valor_total2 = $prodserv->sum('subtotalsol');


        $vales = DB::table('vale as v')

        ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
        ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

        ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select('v.idvale','v.estado1','v.aproxgas', 

               'a.nombrearea',

               'u.codigoconsumo','u.placaconsumo','u.marcaconsumo',

            'lo.nombrelocalidad','lo.distancialocalidad')
            ->where('v.idvale', '=', $id2)
            ->first();

        return view('almacenes.detalle.index3',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idvale'=>$id2,
      
        'vales'=>$vales]);
    }

    public function store (Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        
        $id2 = $detalle->idvale;

        $prod = $request->get('almacen');

        $almacen = IngresoModel::find($prod);
        $precio = $almacen->precio;
        
        $Cantidadsalida = $almacen->cantidadsalida;

        $cantidad = $request->get('cantidad');

// de la cantidad solicitada restamos la cantidad entrante

$SubTotalsol = $cantidad*$precio;
$SubTotalsolresu = number_format($SubTotalsol, 3, '.', '');


         $Cero = $cantidad-$cantidad;
         $Cantidadsalidados = $Cantidadsalida;
        $Cantidadrest = $Cantidadsalida-$cantidad;
        $SubTotalres = $Cantidadrest*$precio;
        $SubTotalresul = number_format($SubTotalres, 3, '.', '');
        // $cantidadrestaNoNegativa = $Cantidadrest < 0 ? 0 : $Cantidadrest;



        $detalle = new DetalleValeModel;
        $detalle->idingreso = $request->get('almacen');
        $detalle->idvale = $id2;
        $detalle->cantidadsol = $request->get('cantidad');
        $detalle->preciosol = $precio;
        $detalle->subtotalsol = $SubTotalsolresu;

        $detalle->cantidadresta = $Cantidadrest;
        $detalle->sudtotalresta = $SubTotalresul;

        $detalle->devolucionresta = 0;
        $detalle->subtotaldevolucion = 0;

        $detallito = DB::table('detallevale as d')

                            ->join('ingreso as ing', 'ing.idingreso', 'd.idingreso')
                            ->join('vale as v', 'v.idvale', 'd.idvale')

                            ->select('d.iddetallevale','v.idvale','ing.nombreproducto',
                            'd.cantidadsol','d.subtotalsol','d.preciosol')

                            -> where('d.idingreso', $prod)

                            -> where('d.idvale', $id2)->get(); 

        if($detallito->isEmpty()){


            if ($Cantidadrest >= 0) {
               
                $detalle->save();

           
            
                $progrmi = ValeModel::find($id2);
                $progrmi -> estadotemp=2;
                $progrmi->save();  

                $request->session()->flash('message', 'Registro Agregado',);
            } else {
                
                $request->session()->flash('message', 'La cantidad debe ser menor o igual que: '.$Cantidadsalidados.' Litros'  );
            }       
            // $request->session()->flash('message', 'Registro Agregado',);
        }else{
          $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('almacenes.detalle.index');
    }

   
    public function solicitud($id)    
    {        
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
                $detalle = DetalleValeModel::find($id);
                $detalle = DB::table('detallevale as d')
                ->select(


        'd.idvale',
        'd.idingreso' , //de forma automatica del que tiene acceso

        'd.cantidadsol' ,  //de forma automatica del que tiene acceso
        'd.preciosol' ,  //el lugar de ida

          //via
        'd.subtotalsol',
        'd.cantidadresta'
                        )
        ->where('d.iddetallevale', $id)
                
        ->first();
    
        $Idvale = $detalle->idvale;
      
        $Idingreso = $detalle->idingreso;

      
        $vales = DB::table('vale as v')
        ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
        ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

        ->join('areas as a', 'a.idarea', '=', 'v.idarea')
        ->select('v.idvale','v.marcaconsumo','v.placaconsumo','v.kilometrajeactualconsumo','v.kiloanterior',
        'v.detallesouconsumo','a.nombrearea','v.usuarionombre')
        ->where('v.idvale', '=', $Idvale)
        ->first();
     
        $ingresos = DB::table('ingreso as ing')
        ->select('ing.idingreso','ing.nombreprograma',
        'ing.codigocatprogramai'
        // 'ing.kilometrajeactualconsumo','ing.kiloanterior',
        // 'ing.detallesouconsumo','ing.nombrearea'
        
        )
        ->where('ing.idingreso', '=', $Idingreso)
        ->first();




    
            $pdf = PDF::loadView('almacenes.detalle.pdf-solicitud', 
            compact(['detalle', 'vales','ingresos']));
    
            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();

        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('almacenes.detalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    
    
    }
    public function show()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;
        // tomar en cuenta $compra = CompraModel::find($id2);

        $prodserv = DB::table('detallecompracomb as d')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
            ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')
            ->join('partidacomb as par', 'par.idpartidacomb', '=', 'ps.idpartidacomb')

            ->select('d.iddetallecompracomb', 'c.idcompracomb', 'ps.nombreprodcomb',
             'ps.detalleprodcomb', 'par.codigopartida',
              'd.cantidad', 'd.subtotal', 'd.precio')
            ->where('d.idcompracomb', '=', $id2)
            ->orderBy('d.iddetallecompracomb', 'asc')
            ->paginate(7);

        $datos = DB::table('areas as a')
        ->join('compracomb as c', 'c.idarea', 'a.idarea')
        ->where('c.idcompracomb', $id2)->get();
        $valor_total = $prodserv->sum('subtotal');


        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', 'c.idproveedor')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', 'c.idcatprogramaticacomb')
            ->join('programacomb as prog', 'prog.idprogramacomb', 'c.idprogramacomb')
            ->join('areas as a', 'a.idarea', 'c.idarea')
            ->select('c.idcompracomb', 'a.nombrearea', 'c.objeto', 'c.justificacion', 'c.preventivo', 'p.nombreproveedor', 'p.representante', 'p.cedula', 'p.nitci', 'p.telefonoproveedor', 'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica', 'prog.nombreprogramacomb')
            ->where('c.idcompracomb', '=', $id2)
            ->first();
        //dd($id2);
        return view('almacenes.detalle.print', 
        compact('prodserv', 'valor_total', 'compras'));
    }

    public function editar($iddetallevale)
    {
        $detalles = DetalleValeModel::find($iddetallevale);
 

        return view('almacenes/detalle/editar',compact('detalles'));
    }

    public function update(Request $request )
  {
    
         $detalle = DetalleValeModel::find($request->iddetallevale);

         //cantidad de devolucion
         $cantidadtres = $request->get('cantidad');
         $cantidad = $cantidadtres;
     //la cantidad que solicito
         $CANtidaDsol = $detalle->cantidadsol;
         $SUdtoalsol = $detalle->subtotalsol;

         //el id del ingreso
          $Idingreso = $detalle->idingreso;
          $IdVale = $detalle->idvale;
          $PReciosOL = $detalle->preciosol;
     // sol 20 del 15  igual 5
          $Cantidadsobra = $CANtidaDsol-$cantidad;


          $SUdtotaldev = $cantidad*$PReciosOL;
          // para detalle vale subtotaldevolucion
          $Cantidaddev = number_format($SUdtotaldev, 5, '.', '');


          $almacen = IngresoModel::find($Idingreso);
          //pide la cantidad actual de almacen
          $Cantidadsalida = $almacen->cantidadsalida;
          $Cantidadsalidasuma = $Cantidadsalida+$Cantidadsobra;

          $SubTotalsol = $Cantidadsalidasuma*$PReciosOL;
          $SubTotalsolresu = number_format($SubTotalsol, 5, '.', '');

         
         


       if ($CANtidaDsol > $cantidad) {


        $detalle->cantidadsol = $request->get('cantidad');
        $detalle->subtotalsol = $Cantidaddev;

        $detalle->devolucionresta = $CANtidaDsol;
        $detalle->subtotaldevolucion = $SUdtoalsol;
            $detalle->save();
            $almacend = IngresoModel::find($Idingreso);
 
         

            $almacend->cantidadsalida = $Cantidadsalidasuma;
            $almacend->subtotalsalida = $SubTotalsolresu;
            $almacend->save();

            $almacendes = ValeModel::find($IdVale);
            $almacendes->estado1 = 3;
            $almacendes->estado2 = 2;
            $almacendes->save();

            $request->session()->flash('message', 'Registro Agregado uno la cantidad era menor');
            return redirect()->route('almacenes.detalle.index3');
            
        
    } else {

        if ($CANtidaDsol == $cantidad) {


           
            $almacendes = ValeModel::find($IdVale);
            $almacendes->estado1 = 3;
            $almacendes->estado2 = 2;
            $almacendes->save();
        $request->session()->flash('message', 'la cantida era igual  que la solicitada corregido' );
        return redirect()->route('almacenes.detalle.index3');
    } else {
        $request->session()->flash('message', 'La cantidad debe ser menor o igual que: la cantidad solicitada  corregido'  );
        return redirect()->route('almacenes.detalle.index2');
    }
     
    return redirect()->route('almacenes.detalle.index2');
}
}  


    public function delete($id){
        $detalle = DetalleValeModel::find($id);
        $detalle->delete();

        return redirect()->route('almacenes.detalle.index2');
    }
    public function aprovar($id)
    {

        $detalle = DetalleValeModel::find($id);

        $Idvale = $detalle->idvale;
        $Idingreso = $detalle->idingreso;


          // del detalle obtenermos la cantidad , el subtotal y el precio
          $Cantidadsol = $detalle->cantidadsol;
          $Preciosol = $detalle->preciosol;
       
          

          $ingresoss = IngresoModel::find($Idingreso);
          $Cantidadsali = $ingresoss->cantidadsalida;
       

          $Cantidadrestal = $Cantidadsali-$Cantidadsol;
          $SubTosol = $Cantidadrestal*$Preciosol;
          //convertir a 3 decimales
          $SubTosolaprox = number_format($SubTosol, 3, '.', '');


            //buscamos el id del ingreso y lo modificamos
            $ingreso = IngresoModel::find($Idingreso);
            $ingreso->cantidadsalida = $Cantidadrestal;
            $ingreso->subtotalsalida = $SubTosolaprox;

            $ingreso->save();

              //buscamos el id del ingreso y lo modificamos
              $detallenuevo = DetalleValeModel::find($id);
              $detallenuevo->cantidadresta = $Cantidadrestal;
              $detallenuevo->sudtotalresta = $SubTosolaprox;
  
              $detallenuevo->save();
 //buscamos el id del vale y lo modificamos
       

            $vales = ValeModel::find($Idvale);
            $vales->estadovale = 2;
            $vales->estado1 = 2;
            $vales->save();

        return redirect()->route('almacenes.detalle.index2');

      
    }
 
}
