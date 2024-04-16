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

use App\Models\EmpleadosModel;
use App\Models\AreasModel;


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
            $consumos = DB::table('compracomb as s')
                     
            ->where('s.idcompracomb', $id2)
            ->select('s.idcompracomb','s.estadocompracomb')
            ->first();

        return view('combustibles.detalleparcial.index2',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idcompracomb'=>$id2,
        'estado'=>$estado,
        'consumos'=>$consumos,
        'compras'=>$compras]);
    }

    public function index3(){

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
            $consumos = DB::table('compracomb as s')
                     
            ->where('s.idcompracomb', $id2)
            ->select('s.idcompracomb','s.estadocompracomb')
            ->first();

        return view('combustibles.detalleparcial.index3',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idcompracomb'=>$id2,
        'estado'=>$estado,
        'consumos'=>$consumos,
        'compras'=>$compras]);
    }

    public function index4(){

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
            $consumos = DB::table('compracomb as s')
                     
            ->where('s.idcompracomb', $id2)
            ->select('s.idcompracomb','s.estadocompracomb')
            ->first();

        return view('combustibles.detalleparcial.index4',
        ['prodserv'=>$prodserv,
        'productos'=>$productos,
        'valor_total2'=>$valor_total2,
        'idcompracomb'=>$id2,
        'estado'=>$estado,
        'consumos'=>$consumos,
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

    public function show($idcompracomb){
        
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        $id3 = $personalArea->idarea;

        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');


        // tomar en cuenta $compra = CompraModel::find($id2);
        $prodserv = DB::table('detallecompracomb as d')
                        ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
                        ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')
                        ->join('partidacomb as par', 'par.idpartidacomb', '=', 'ps.idpartidacomb')

                        ->select('d.iddetallecompracomb', 'c.idcompracomb','ps.nombreprodcomb',
                        'ps.detalleprodcomb','par.codigopartida',
                        'd.cantidad','d.subtotal','d.precio')

                        -> where('d.idcompracomb','=', $idcompracomb)

                        -> orderBy('d.iddetallecompracomb', 'asc')
                        -> get();

        $datos = DB::table('areas as a')
        ->join('compracomb as c', 'c.idarea', '=', 'a.idarea')
        -> where('c.idcompracomb', $idcompracomb)
        ->select('a.nombrearea')
        ->first();
        $valor_total = $prodserv->sum('subtotal');



        $compras = DB::table('compracomb as c')
     ->join('proveedor as p', 'p.idproveedor', 'c.idproveedor')
     ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', 'c.idcatprogramaticacomb')
     ->join('programacomb as prog', 'prog.idprogramacomb', 'c.idprogramacomb')
     ->join('areas as a', 'a.idarea', 'c.idarea')

        ->select('c.idcompracomb','c.controlinterno','c.estado1',
        'prog.nombreprograma',
        'c.objeto', 'c.justificacion', 'c.preventivo',
        'p.nombreproveedor','p.representanteproveedor',
        'p.cedulaproveedor','p.nitciproveedor','p.telefonoproveedor',
        'cat.codcatprogramatica',

        'c.preventivo','c.numcompra')
        ->where('c.idcompracomb','=', $idcompracomb)
        ->first();
         // dd($compras->idarea);


       $encargado = DB::table('encargados as e')
          ->join('areas as a', 'a.idarea', '=', 'e.idarea')
          ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
        -> where('a.idarea', $id3)
        ->select('emp.nombres','emp.ap_pat','emp.ap_mat','e.abrev')
        ->first();
        //dd($encargado->nombres);



        return view('combustibles.detalleparcial.print',[

            'prodserv' => $prodserv,
            'valor_total' => $valor_total,
            'compras' => $compras,
            'datos' => $datos,
            'encargado' => $encargado
         ]);
    


} catch (Exception $ex) {
    \Log::error("Orden Error: {$ex->getMessage()}");
    return redirect()->route('combustibles.detalleparcial.index')->with('message', $ex->getMessage());
} finally {
    ini_restore('memory_limit');
    ini_restore('max_execution_time');
}
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
