<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TemporalModel;

use App\Models\DocOrdenModel;

use App\Models\Compra\CompraCombModel;
use App\Models\Compra\ProdCombModel;
use App\Models\Compra\DetalleCompraCombModel;

use App\Models\OrdenCompraModel;
use App\Models\OrdenDocModel;
use App\Models\ResponsablesModel;



use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use NumerosEnLetras;
use PDF;



class DetalleCompraCombController2 extends Controller
{
    public function index(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prodserv = DB::table('detallecompracomb as d')

                        ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
                        ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')

                        ->select('d.iddetallecompracomb', 'c.idcompracomb','ps.nombreprodcomb','d.cantidad',
                        'd.subtotal','d.precio')

                        ->where('d.idcompracomb', $id2)
                        ->orderBy('d.iddetallecompracomb', 'desc')
                        ->get();


        $productos = DB::table('prodcomb')
                        ->where('estadoprodcomb',1)
                        ->select(DB::raw("concat(codigoprodcomb,' // ',nombreprodcomb,' // ',detalleprodcomb,' 
                        // PRECIO BS. ',precioprodcomb) as prodservicio"),'idprodcomb')
                        ->pluck('prodservicio','idprodcomb');

        $valor_total2 = $prodserv->sum('subtotal');

        $ordencompra = DB::table('ordencompracomb as o')
                            ->select('o.nombrecompra','o.solicitante','o.proveedor')
                            -> where('o.compra_idcompra','=', $id2)->first();
        $resultado = $ordencompra;

        $estado = 1;

        if(is_null($resultado)){
            $estado = 0;
        }

        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', 'c.idproveedor')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', 'c.idcatprogramaticacomb')
            ->join('programacomb as prog', 'prog.idprogramacomb', 'c.idprogramacomb')
            ->join('areas as a', 'a.idarea', 'c.idarea')

            ->select('c.idcompracomb','c.estado1', 'a.nombrearea', 'c.objeto',
             'c.justificacion', 'c.preventivo', 'p.nombreproveedor',
              'p.representanteproveedor', 'p.cedulaproveedor', 'p.nitciproveedor', 'p.telefonoproveedor',
               'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica',
                'prog.nombreprograma')
            ->where('c.idcompracomb', '=', $id2)
            ->first();

        return view('combustibles.detalleparcial.index',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idcompracomb'=>$id2,
        'estado'=>$estado,
        'compras'=>$compras]);
    }

    public function index2(){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prodserv = DB::table('detallecompracomb as d')

                        ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
                        ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')

                        ->select('d.iddetallecompracomb', 'c.idcompracomb','ps.nombreprodcomb','d.cantidad',
                        'd.subtotal','d.precio')

                        ->where('d.idcompracomb', $id2)
                        ->orderBy('d.iddetallecompracomb', 'desc')
                        ->get();


        $productos = DB::table('prodcomb')
                        ->where('estadoprodcomb',1)
                        ->select(DB::raw("concat(codigoprodcomb,' // ',nombreprodcomb,' // ',detalleprodcomb,' 
                        // PRECIO BS. ',precioprodcomb) as prodservicio"),'idprodcomb')
                        ->pluck('prodservicio','idprodcomb');

        $valor_total2 = $prodserv->sum('subtotal');

        $ordencompra = DB::table('ordencompracomb as o')
                            ->select('o.nombrecompra','o.solicitante','o.proveedor')
                            -> where('o.compra_idcompra','=', $id2)->first();
        $resultado = $ordencompra;

        $estado = 1;

        if(is_null($resultado)){
            $estado = 0;
        }

        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', 'c.idproveedor')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', 'c.idcatprogramaticacomb')
            ->join('programacomb as prog', 'prog.idprogramacomb', 'c.idprogramacomb')
            ->join('areas as a', 'a.idarea', 'c.idarea')

            ->select('c.idcompracomb','c.estado1', 'a.nombrearea', 'c.objeto',
             'c.justificacion', 'c.preventivo', 'p.nombreproveedor',
              'p.representanteproveedor', 'p.cedulaproveedor', 'p.nitciproveedor', 'p.telefonoproveedor',
               'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica',
                'prog.nombreprograma')
            ->where('c.idcompracomb', '=', $id2)
            ->first();

        return view('combustibles.detalleparcial.index2',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idcompracomb'=>$id2,
        'estado'=>$estado,
        'compras'=>$compras]);
    }

    public function store (Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $detalle = TemporalModel::find($id);
        
        $id2 = $detalle->idcompra;
//accede a la tabla producto servicio
        $prod = $request->get('producto');
        $producto = ProdCombModel::find($prod);
        //del id del producto crea una variable precio para sacar el precio del producto
        $precio = $producto->precioprodcomb;

//requiere la cantidad para detalle compra
        $cantidad = $request->get('cantidad');


        $detalle = new DetalleCompraCombModel;

        $detalle->idprodcomb = $request->get('producto');
        $detalle->idcompracomb = $id2;
        $detalle->cantidad = $request->get('cantidad');
//la variable precio lo trae aqui
        $detalle->precio = $precio;
        //la cantidad del detalle lo multi x cantidad
        $detalle->subtotal = $precio * $cantidad;

        // para productos obtendremos el nombre y la partida
        $detallito = DB::table('detallecompracomb as d')

                            ->join('prodcomb as ps', 'ps.idprodcomb', 'd.idprodcomb')
                            ->join('compracomb as c', 'c.idcompracomb', 'd.idcompracomb')

                            ->select('d.iddetallecompracomb', 'c.idcompracomb','ps.nombreprodcomb',

                            'd.cantidad','d.subtotal','d.precio')
                            -> orwhere('d.idprodcomb', $prod)
                            -> where('d.idcompracomb', $id2)->get();

        if($detallito->isEmpty()){
            $detalle->save();     
            
            $request->session()->flash('message', 'Registro Agregado');
        }else{
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('combustibles.detalleparcial.index');
    }

    public function show(){
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        // tomar en cuenta $compra = CompraModel::find($id2);
        $prodserv = DB::table('detallecompra as d')
                        ->join('prodserv as ps', 'ps.idprodserv', '=', 'd.idprodserv')
                        ->join('compra as c', 'c.idcompra', '=', 'd.idcompra')
                        ->join('partida as par', 'par.idpartida', '=', 'ps.partida_idpartida')
                        ->join('umedida as u', 'u.idumedida', '=', 'ps.umedida_idumedida')

                        ->select('d.iddetallecompra', 'c.idcompra','ps.nombreprodserv',
                        'ps.detalleprodserv','par.codigopartida','u.nombreumedida',
                        'd.cantidad','d.subtotal','d.precio')

                        -> where('d.idcompra','=', $id2)

                        -> orderBy('d.iddetallecompra', 'asc')
                        -> get();

        $datos = DB::table('areas as a')->join('compra as c', 'c.idarea', '=', 'a.idarea')
        -> where('c.idcompra', $id2)
        ->select('a.nombrearea')
        ->first();
        $valor_total = $prodserv->sum('subtotal');



        $compras = DB::table('compra as c')
        ->join('proveedores as p', 'p.idproveedor', 'c.idproveedor')
        ->join('catprogramatica as cat', 'cat.idcatprogramatica', 'c.idcatprogramatica')
        ->join('programa as prog', 'prog.idprograma', 'c.idprograma')
        ->join('areas as a', 'a.idarea', 'c.idarea')

        ->select('c.idcompra','c.controlinterno','c.estado1','a.idarea','a.nombrearea',
        'c.objeto', 'c.justificacion', 'c.preventivo','p.nombreproveedor','p.representante',
        'p.cedula','p.nitci','p.telefonoproveedor','c.preventivo','c.numcompra','cat.codcatprogramatica',
        'prog.nombreprograma')
        ->where('c.idcompra','=', $id2)
        ->first();
         // dd($compras->idarea);


       $encargado = DB::table('encargados as e')
          ->join('areas as a', 'a.idarea', '=', 'e.idarea')
          ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
        -> where('a.idarea', $compras->idarea)
        ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
        ->first();
        //dd($encargado->nombres);



        return view('compras.detalleparcial.print',
        compact('prodserv','valor_total','compras','datos','encargado'));
    }


    
    public function delete($id){

        $detalle = DetalleCompraCombModel::find($id);
        $detalle->delete();
        return redirect()->route('combustibles.detalleparcial.index');
    }

    public function destroyed2($id){
        $ordendoc = OrdenDocModel::find($id);
        $ordendoc->delete();
        return back();
    }
}
