<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;


use App\Models\Compra\CompraCombModel;
use App\Models\Compra\ProdCombModel;
use App\Models\Compra\DetalleCompraCombModel;

use App\Models\TemporalModel;

use App\Models\DocOrdenModel;


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


use App\Models\Almacen\Ingreso\IngresoModel;
use App\Models\Almacen\Ingreso\BorrarModel;
use App\Models\Almacen\Ingreso\NotaIngresoModel;


use App\Models\Compra\ProveedorModel;
use App\Models\Compra\PartidaCombModel;

use App\Models\Compra\CatProgModel;
use App\Models\Compra\ProgramaCombModel;

use App\Models\Almacen\Comprobante\ComingresoModel;
use App\Models\Almacen\Comprobante\DetalleComingresoModel;

class DetalleCompraCombController extends Controller
{
    public function index()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prodserv = DB::table('detallecompracomb as d')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
            ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')
            ->join('umedidacomb as un', 'un.idmedida', '=', 'ps.idmedidacomb')
            ->select(
                'd.iddetallecompracomb',
                'd.idcompracomb',
                'un.nombremedida',
                'c.idcompracomb',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )

            ->where('d.idcompracomb', $id2)
            ->orderBy('d.iddetallecompracomb', 'asc')
            ->get();

        $productos = DB::table('prodcomb')
            ->where('estadoprodcomb', 1)
            ->select(DB::raw("concat(codigoprodcomb,' // ',nombreprodcomb,' // PRECIO BS. ',precioprodcomb)
             as prodservicio"), 'idprodcomb')
            ->pluck('prodservicio', 'idprodcomb');

        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->where('c.idcompracomb', $id2)
            ->select(
                'c.idcompracomb',
                'c.estado1',
                'c.estadocompracomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();

        $valor_total3 = $prodserv->sum('cantidad');
        $valor_total2 = $prodserv->sum('subtotal');

        $CalAdosDecimdos = number_format($valor_total3, 2, '.', '');
        $CalAdosDecim = number_format($valor_total2, 2, '.', '');

        $ordencompra = DB::table('ordencompracomb as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor')
            ->where('o.compra_idcompra', '=', $id2)->first();

        $prodservdos = DB::table('detallecompracomb as d')
            ->select(
                'd.iddetallecompracomb',
                'd.idcompracomb',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )

            ->where('d.idcompracomb', '=', $id2)->first();


        $resultado = $prodservdos;
        $estado = 1;
        if (is_null($resultado)) {
            $estado = 0;
        }

        return view('combustibles.detalle.index', [
            'prodserv' => $prodserv,
            'productos' => $productos,
            'CalAdosDecimdos' => $CalAdosDecimdos,
            'CalAdosDecim' => $CalAdosDecim,
            'idcompracomb' => $id2,
            'estado' => $estado,
            'compras' => $compras
        ]);
    }

    public function index2()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prodserv = DB::table('detallecompracomb as d')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
            ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')
            ->join('umedidacomb as un', 'un.idmedida', '=', 'ps.idmedidacomb')
            ->select(
                'd.iddetallecompracomb',
                'd.idcompracomb',
                'un.nombremedida',
                'c.idcompracomb',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )

            ->where('d.idcompracomb', $id2)
            ->orderBy('d.iddetallecompracomb', 'asc')
            ->get();

        $valor_total3 = $prodserv->sum('cantidad');
        $valor_total2 = $prodserv->sum('subtotal');

        $CalAdosDecimdos = number_format($valor_total3, 2, '.', '');
        $CalAdosDecim = number_format($valor_total2, 2, '.', '');

        $productos = DB::table('prodcomb')
            ->where('estadoprodcomb', 1)
            ->select(DB::raw("concat(codigoprodcomb,' // ',nombreprodcomb,' // PRECIO BS. ',precioprodcomb)
             as prodservicio"), 'idprodcomb')
            ->pluck('prodservicio', 'idprodcomb');

        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->where('c.idcompracomb', $id2)
            ->select(
                'c.idcompracomb',
                'c.estado1',
                'c.estadocompracomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();

        $ordencompra = DB::table('ordencompracomb as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor')
            ->where('o.compra_idcompra', '=', $id2)->first();
        $resultado = $ordencompra;
        $estado = 1;
        if (is_null($resultado)) {
            $estado = 0;
        }

        return view('combustibles.detalle.index2', [
            'prodserv' => $prodserv,
            'productos' => $productos,
            'CalAdosDecimdos' => $CalAdosDecimdos,
            'CalAdosDecim' => $CalAdosDecim,
            'idcompracomb' => $id2,
            'estado' => $estado,
            'compras' => $compras
        ]);
    }

    public function index3()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prodserv = DB::table('detallecompracomb as d')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
            ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')
            ->join('umedidacomb as un', 'un.idmedida', '=', 'ps.idmedidacomb')
            ->select(
                'd.iddetallecompracomb',
                'd.idcompracomb',
                'un.nombremedida',
                'c.idcompracomb',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )

            ->where('d.idcompracomb', $id2)
            ->orderBy('d.iddetallecompracomb', 'asc')
            ->get();

        $productos = DB::table('prodcomb')
            ->where('estadoprodcomb', 1)
            ->select(DB::raw("concat(codigoprodcomb,' // ',nombreprodcomb,' // PRECIO BS. ',precioprodcomb)
             as prodservicio"), 'idprodcomb')
            ->pluck('prodservicio', 'idprodcomb');

        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->where('c.idcompracomb', $id2)
            ->select(
                'c.idcompracomb',
                'c.estado1',
                'c.estadocompracomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();
        $valor_total3 = $prodserv->sum('cantidad');
        $valor_total2 = $prodserv->sum('subtotal');

        $CalAdosDecimdos = number_format($valor_total3, 2, '.', '');
        $CalAdosDecim = number_format($valor_total2, 2, '.', '');

        $ordencompra = DB::table('ordencompracomb as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor')
            ->where('o.compra_idcompra', '=', $id2)->first();
        $resultado = $ordencompra;
        $estado = 1;
        if (is_null($resultado)) {
            $estado = 0;
        }

        return view('combustibles.detalle.index3', [
            'prodserv' => $prodserv,
            'productos' => $productos,
            'CalAdosDecimdos' => $CalAdosDecimdos,
            'CalAdosDecim' => $CalAdosDecim,
            'idcompracomb' => $id2,
            'estado' => $estado,
            'compras' => $compras
        ]);
    }

    public function index5()
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prodserv = DB::table('detallecompracomb as d')
            ->join('prodcomb as ps', 'ps.idprodcomb', '=', 'd.idprodcomb')
            ->join('compracomb as c', 'c.idcompracomb', '=', 'd.idcompracomb')
            ->join('umedidacomb as un', 'un.idmedida', '=', 'ps.idmedidacomb')
            ->select(
                'd.iddetallecompracomb',
                'd.idcompracomb',
                'un.nombremedida',
                'c.idcompracomb',
                'ps.detalleprodcomb',
                'ps.nombreprodcomb',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )

            ->where('d.idcompracomb', $id2)
            ->orderBy('d.iddetallecompracomb', 'asc')
            ->get();

        $productos = DB::table('prodcomb')
            ->where('estadoprodcomb', 1)
            ->select(DB::raw("concat(codigoprodcomb,' // ',nombreprodcomb,' // PRECIO BS. ',precioprodcomb)
             as prodservicio"), 'idprodcomb')
            ->pluck('prodservicio', 'idprodcomb');

        $compras = DB::table('compracomb as c')
            ->join('proveedor as p', 'p.idproveedor', '=', 'c.idproveedor')
            ->where('c.idcompracomb', $id2)
            ->select(
                'c.idcompracomb',
                'c.estado1',
                'c.estadocompracomb',
                'p.idproveedor',
                'p.nombreproveedor'
            )
            ->first();
        $valor_total3 = $prodserv->sum('cantidad');
        $valor_total2 = $prodserv->sum('subtotal');

        $CalAdosDecimdos = number_format($valor_total3, 2, '.', '');
        $CalAdosDecim = number_format($valor_total2, 2, '.', '');

        $ordencompra = DB::table('ordencompracomb as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor')
            ->where('o.compra_idcompra', '=', $id2)->first();
        $resultado = $ordencompra;
        $estado = 1;
        if (is_null($resultado)) {
            $estado = 0;
        }

        return view('combustibles.detalle.index5', [
            'prodserv' => $prodserv,
            'productos' => $productos,
            'CalAdosDecimdos' => $CalAdosDecimdos,
            'CalAdosDecim' => $CalAdosDecim,
            'idcompracomb' => $id2,
            'estado' => $estado,
            'compras' => $compras
        ]);
    }

    public function store(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        $id2 = $detalle->idcompra;

        $prod = $request->get('producto');
        $producto = ProdCombModel::find($prod);
        $precio = $producto->precioprodcomb;
        $cantidad = $request->get('cantidad');

        $detalle = new DetalleCompraCombModel;
        $detalle->idprodcomb = $request->get('producto');
        $detalle->idcompracomb = $id2;
        $detalle->cantidad = $request->get('cantidad');
        $detalle->precio = $precio;
        $detalle->subtotal = $precio * $cantidad;




        $detallito = DB::table('detallecompracomb as d')

            ->join('prodcomb as ps', 'ps.idprodcomb', 'd.idprodcomb')
            ->join('compracomb as c', 'c.idcompracomb', 'd.idcompracomb')

            ->select('d.iddetallecompracomb', 'c.idcompracomb', 'ps.nombreprodcomb', 'd.cantidad', 'd.subtotal', 'd.precio')
            ->orwhere('d.idprodcomb', $prod)
            ->where('d.idcompracomb', $id2)->get();

        if ($detallito->isEmpty()) {
            $detalle->save();
            $request->session()->flash('message', 'Registro Agregado');
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('combustibles.detalle.index');
    }

    public function aprovar($id)
    {
        $compras = CompraCombModel::find($id);
        $compras->estadocompracomb = 2;

        $fechasolACT = Carbon::now();
        $hora = $fechasolACT->toTimeString();

        $compras->fechaaprob = $fechasolACT;
        $compras->horaaprob = $hora;
        $compras->save();
        return redirect()->route('detalle.index5');
    }
    //estadorechazado
    public function rechazar($id)
    {
        $compras = CompraCombModel::find($id);
        $compras->estadocompracomb = 10;
        $fechasolACT = Carbon::now();

        $hora = $fechasolACT->toTimeString();
        $compras->fechaaprob = $fechasolACT;
        $compras->horaaprob = $hora;
        $compras->save();
        return redirect()->route('detalle.index3');
    }


    public function almacen($idcompracomb)
    {

        //idcompracomb es el id de la compracomb
        $compracomb = CompraCombModel::find($idcompracomb);

        if ($compracomb) {
            $detalleconcompra = $compracomb->comprasdetallecomb;
            foreach ($detalleconcompra as $detalle) {

                $iddeTallCompra = $detalle->iddetallecompracomb;
                $idCompra = $detalle->idcompracomb;
                $idProducto = $detalle->idprodcomb;

                $CanTidad = $detalle->cantidad;
                $PreCios = $detalle->precio;


                //solo producto
                $producto = ProdCombModel::find($idProducto);
                $nombreprodser = $producto->nombreprodcomb;
                $CodiGprodser = $producto->codigoprodcomb;
                $idPartida = $producto->idpartidacomb;

                $partidai = PartidaCombModel::find($idPartida);
                $cdpart = $partidai->codigopartida;
                $nmbpart = $partidai->nombrepartida;

                //solo compra
                $compra = CompraCombModel::find($idCompra);
                $idCat = $compra->idcatprogramaticacomb;
                $idPro = $compra->idprogramacomb;
                $idProov = $compra->idproveedor;
                $idEstadoCompra = $compra->estadocompracomb;
                $NumeroCompra = $compra->numcompra;
                $PreventiCompra = $compra->preventivo;
                $IdareaCompra = $compra->idarea;

                //solo catprogramatica
                $catprogrami = CatProgModel::find($idCat);
                $cdcatprogm = $catprogrami->codcatprogramatica;
                $nmbcatprog = $catprogrami->nombrecatprogramatica;



                //solo programa
                $progrmi = ProgramaCombModel::find($idPro);
                $nomvpog = $progrmi->nombreprograma;

                //solo proveedores
                $proveedori = ProveedorModel::find($idProov);
                $nmbprveri = $proveedori->nombreproveedor;



                $ingreso = new IngresoModel();

                $ingreso->cantidad = $CanTidad;

                $ingreso->subtotal = $CanTidad * $PreCios;
                $ingreso->precio = $PreCios;

                $ingreso->cantidadsalida = $CanTidad;
                $ingreso->subtotalsalida = $CanTidad * $PreCios;


                $ingreso->codigocatprogramai = $cdcatprogm;
                $ingreso->nombrecatprogmai = $nmbcatprog;


                $ingreso->idcompracomb = $idCompra;
                $ingreso->iddetallecompracomb = $iddeTallCompra;

                $ingreso->idprodcomb = $idProducto;
                $ingreso->nombreproducto = $nombreprodser;
                $ingreso->codigoprodcomb = $CodiGprodser;


                $ingreso->idpartidacomb = $idPartida;
                $ingreso->codigopartida = $cdpart;
                $ingreso->nombrepartida = $nmbpart;

                $ingreso->idcatprogramaticacomb = $idCat;

                $ingreso->idprogramacomb = $idPro;
                $ingreso->nombreprograma = $nomvpog;

                $ingreso->idproveedor = $idProov;
                $ingreso->nombreproveedor = $nmbprveri;

                $ingreso->estadoingreso = 1;
                $ingreso->estadocompracomb = $idEstadoCompra;
                $ingreso->estado1 = 1;
                $ingreso->estado2 = 1;
                $ingreso->save();

                $obtenerId = $ingreso->idingreso;

                $notaingreso = new NotaIngresoModel();
                $notaingreso->numcompra = $NumeroCompra;
                $notaingreso->numsolicitud = $PreventiCompra;
                $notaingreso->codigoproducto = $CodiGprodser;
                $notaingreso->nombreproducto = $nombreprodser;
                $notaingreso->ingreso = $CanTidad;
                $notaingreso->precio = $PreCios;
                $notaingreso->subtotal = $CanTidad * $PreCios;
                $notaingreso->num_comprobante = 10;
                $notaingreso->factura_comprobante = 11;
                $notaingreso->nombreprobeedor = $nmbprveri;
                $notaingreso->idingreso = $obtenerId;
                $notaingreso->idarea = $IdareaCompra;
                $notaingreso->idproveedor = $idProov;
                $notaingreso->fechaentra = Carbon::now();
                $notaingreso->save();

                $comprass = CompraCombModel::find($idcompracomb);
                $comprass->estadocompracomb = 5;
                $comprass->save();

                session()->flash('message', 'Registro Enviado a almacen');
            }
        } else {
            session()->flash('message', 'no hay nada');
        }

        return redirect()->route('detalle.index2');
    }

    public function show()
    {
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
            ->select('d.iddetallecompra', 'c.idcompra', 'ps.nombreprodserv', 'ps.detalleprodcomb', 'par.codigopartida', 'u.nombreumedida', 'd.cantidad', 'd.subtotal', 'd.precio')
            ->where('d.idcompra', '=', $id2)
            ->orderBy('d.iddetallecompra', 'asc')
            ->paginate(7);

        $datos = DB::table('areas as a')->join('compra as c', 'c.idarea', 'a.idarea')->where('c.idcompra', $id2)->get();
        $valor_total = $prodserv->sum('subtotal');


        $compras = DB::table('compra as c')
            ->join('proveedores as p', 'p.idproveedor', 'c.idproveedor')
            ->join('catprogramatica as cat', 'cat.idcatprogramatica', 'c.idcatprogramatica')
            ->join('programa as prog', 'prog.idprograma', 'c.idprograma')
            ->join('areas as a', 'a.idarea', 'c.idarea')
            ->select('c.idcompra', 'a.nombrearea', 'c.objeto', 'c.justificacion', 'c.preventivo', 'p.nombreproveedor', 'p.representante', 'p.cedula', 'p.nitci', 'p.telefonoproveedor', 'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica', 'prog.nombreprograma')
            ->where('c.idcompra', '=', $id2)
            ->first();
        //dd($id2);
        return view('compras.detalle.print', compact('prodserv', 'valor_total', 'compras'));
    }

    public function invitacion($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $ordencompra = DB::table('ordencompra as o')
                ->select(
                    'o.numinforme',
                    'o.fechaorden',
                    'o.nombrecompra',
                    'o.solicitante',
                    'o.modalidadcontratacion',
                    'o.precioreferencial',
                    'o.proveedor',
                    'o.representante',
                    'o.cedula',
                    'o.nitci',
                    'o.telefono',
                    'o.approgramatica',
                    'o.partida',
                    'o.actividad',
                    'o.nordencompra',
                    'o.npreventivo',
                    'o.hojaruta',
                    'o.numcontrolinterno',
                    'o.plazoentrega',
                    'o.fechainicio',
                    'o.fechaconclusion',
                    'o.fechainvitacion',
                    'o.fechaaceptacion',
                    'o.codciteinvitacion',
                    'o.horapresentacion',
                    'o.cedulaaceptacion',
                    'o.numnotaadjudicacion',
                    'o.fechainiciosolproc',
                    'o.controlinter',
                    'o.autoridadsolicitante'
                )
                ->where('o.compra_idcompra', $id)
                ->first();

            $ordendoc = DB::table('ordencompra as o')
                ->join('ordendoc as od', 'od.idorden', '=', 'o.idorden')
                ->join('docorden as doc', 'doc.iddoc', '=', 'od.iddoc')
                ->select('doc.nombredoc')
                ->where('o.compra_idcompra', $id)
                ->get();

            $fechaInvitacion = $ordencompra->fechainvitacion;
            $fechaInvitacion = Carbon::parse($fechaInvitacion)->isoFormat('D \d\e MMMM \d\e\l Y');
            $fechaAceptacion = $ordencompra->fechaaceptacion;
            $fechaAceptacion = Carbon::parse($fechaAceptacion)->isoFormat('D \d\e MMMM');
            $responsables = DB::table('responsables')->first();

            $pdf = PDF::loadView('compras.detalle.pdf-invitacion', compact(['ordencompra', 'ordendoc', 'responsables', 'fechaInvitacion', 'fechaAceptacion']));
            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('compras.detalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }

        // return view('compras.detalle.invitacion',['ordencompra'=>$ordencompra,'ordendoc'=>$ordendoc,'responsables'=>$responsables,'fechaInvitacion'=>$fechaInvitacion,'fechaAceptacion'=>$fechaAceptacion]);
    }

    public function aceptacion($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $ordencompra = DB::table('ordencompra as o')
                ->select(
                    'o.numinforme',
                    'o.fechaorden',
                    'o.nombrecompra',
                    'o.solicitante',
                    'o.modalidadcontratacion',
                    'o.precioreferencial',
                    'o.proveedor',
                    'o.representante',
                    'o.cedula',
                    'o.nitci',
                    'o.telefono',
                    'o.approgramatica',
                    'o.partida',
                    'o.actividad',
                    'o.nordencompra',
                    'o.npreventivo',
                    'o.hojaruta',
                    'o.numcontrolinterno',
                    'o.plazoentrega',
                    'o.fechainicio',
                    'o.fechaconclusion',
                    'o.fechainvitacion',
                    'o.fechaaceptacion',
                    'o.codciteinvitacion',
                    'o.horapresentacion',
                    'o.cedulaaceptacion',
                    'o.numnotaadjudicacion',
                    'o.fechainiciosolproc',
                    'o.controlinter',
                    'o.autoridadsolicitante'
                )
                ->where('o.compra_idcompra', $id)
                ->first();

            $ordendoc = DB::table('ordencompra as o')
                ->join('ordendoc as od', 'od.idorden', 'o.idorden')
                ->join('docorden as doc', 'doc.iddoc', 'od.iddoc')
                ->select('doc.nombredoc')
                ->where('o.compra_idcompra', $id)
                ->get();

            $fechaInvitacion = $ordencompra->fechainvitacion;
            $fechaInvitacion = Carbon::parse($fechaInvitacion)->isoFormat('D \d\e MMMM \d\e\l Y');
            $fechaAceptacion = $ordencompra->fechaaceptacion;
            $fechaAceptacion = Carbon::parse($fechaAceptacion)->isoFormat('D \d\e MMMM \d\e\l Y');
            $responsables = DB::table('responsables')->first();

            $pdf = PDF::loadView(
                'compras.detalle.pdf-aceptacion',
                compact(['ordencompra', 'ordendoc', 'responsables', 'fechaInvitacion', 'fechaAceptacion'])
            );
            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('compras.detalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }

        //return view('compras.detalle.aceptacion',['ordencompra'=>$ordencompra,'ordendoc'=>$ordendoc,'responsables'=>$responsables,'fechaInvitacion'=>$fechaInvitacion,'fechaAceptacion'=>$fechaAceptacion]);
    }

    public function cotizacion($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $ordencompra = DB::table('ordencompra as o')
                ->select(
                    'o.numinforme',
                    'o.fechaorden',
                    'o.nombrecompra',
                    'o.solicitante',
                    'o.modalidadcontratacion',
                    'o.precioreferencial',
                    'o.proveedor',
                    'o.representante',
                    'o.cedula',
                    'o.nitci',
                    'o.telefono',
                    'o.approgramatica',
                    'o.partida',
                    'o.actividad',
                    'o.nordencompra',
                    'o.npreventivo',
                    'o.hojaruta',
                    'o.numcontrolinterno',
                    'o.plazoentrega',
                    'o.fechainicio',
                    'o.fechaconclusion',
                    'o.fechainvitacion',
                    'o.fechaaceptacion',
                    'o.codciteinvitacion',
                    'o.horapresentacion',
                    'o.cedulaaceptacion',
                    'o.numnotaadjudicacion',
                    'o.fechainiciosolproc',
                    'o.controlinter',
                    'o.autoridadsolicitante',
                    'o.memorandum1',
                    'o.memorandum2',
                    'o.comision1',
                    'o.comision2',
                    'o.informe1',
                    'o.informe2'
                )
                ->where('o.compra_idcompra', $id)
                ->first();

            $ordendoc = DB::table('ordencompra as o')
                ->join('ordendoc as od', 'od.idorden', '=', 'o.idorden')
                ->join('docorden as doc', 'doc.iddoc', '=', 'od.iddoc')
                ->select(
                    'doc.nombredoc',
                    'doc.dato1',
                    'doc.dato2',
                    'doc.dato3',
                    'doc.dato4',
                    'doc.original',
                    'doc.fotocopia'
                )
                ->where('o.compra_idcompra', $id)
                ->get();

            $fechaInvitacion = $ordencompra->fechainvitacion;
            $fechaInvitacion = Carbon::parse($fechaInvitacion)->isoFormat('D \d\e MMMM \d\e\l Y');
            $fechaAceptacion = $ordencompra->fechaaceptacion;
            $fechaAceptacion = Carbon::parse($fechaAceptacion)->isoFormat('D \d\e MMMM \d\e\l Y');
            $responsables = DB::table('responsables')->first();
            $fechaorden = $ordencompra->fechaorden;
            $fechaorden = Carbon::parse($fechaorden)->isoFormat('dddd D \d\e MMMM \d\e\l Y');

            $dateinvitacion = Carbon::parse($ordencompra->fechainvitacion)->format('d-m-Y');
            $dateaceptacion = Carbon::parse($ordencompra->fechaaceptacion)->format('d-m-Y');


            $prodserv = DB::table('detallecompra as d')
                ->join('prodserv as ps', 'ps.idprodserv', 'd.idprodserv')
                ->join('compra as c', 'c.idcompra', 'd.idcompra')
                ->join('partida as par', 'par.idpartida', 'ps.partida_idpartida')
                ->join('umedida as u', 'u.idumedida', 'ps.umedida_idumedida')
                ->select(
                    'd.iddetallecompra',
                    'c.idcompra',
                    'ps.nombreprodserv',
                    'ps.detalleprodserv',
                    'par.codigopartida',
                    'u.nombreumedida',
                    'd.cantidad',
                    'd.subtotal',
                    'd.precio'
                )
                ->where('d.idcompra', $id)->get();


            $valor_total = $prodserv->sum('subtotal');
            $valor_total2 = NumerosEnLetras::convertir($valor_total, 'Bolivianos', true);

            $valor_total3 = number_format($valor_total, 2, ',', '.');

            $pdf = PDF::loadView(
                'compras.detalle.pdf-cotizacion',
                compact([
                    'valor_total2', 'prodserv', 'valor_total', 'ordencompra',
                    'ordendoc', 'responsables', 'fechaInvitacion', 'fechaAceptacion',
                    'fechaorden', 'valor_total3', 'dateinvitacion', 'dateaceptacion'
                ])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('compras.detalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function adjudicacion($id)
    {
        $ordencompra = DB::table('ordencompra as o')
            ->select(
                'o.numinforme',
                'o.fechaorden',
                'o.nombrecompra',
                'o.solicitante',
                'o.modalidadcontratacion',
                'o.precioreferencial',
                'o.proveedor',
                'o.representante',
                'o.cedula',
                'o.nitci',
                'o.telefono',
                'o.approgramatica',
                'o.partida',
                'o.actividad',
                'o.nordencompra',
                'o.npreventivo',
                'o.hojaruta',
                'o.numcontrolinterno',
                'o.plazoentrega',
                'o.fechainicio',
                'o.fechaconclusion',
                'o.fechainvitacion',
                'o.fechaaceptacion',
                'o.codciteinvitacion',
                'o.horapresentacion',
                'o.cedulaaceptacion',
                'o.numnotaadjudicacion',
                'o.fechainiciosolproc',
                'o.controlinter',
                'o.autoridadsolicitante'
            )
            ->where('o.compra_idcompra', $id)->first();

        $ordendoc = DB::table('ordencompra as o')
            ->join('ordendoc as od', 'od.idorden', 'o.idorden')
            ->join('docorden as doc', 'doc.iddoc', 'od.iddoc')
            ->select('doc.nombredoc')
            ->where('o.compra_idcompra', $id)->get();

        $fechaInvitacion = $ordencompra->fechainvitacion;
        $fechaInvitacion = Carbon::parse($fechaInvitacion)->isoFormat('D \d\e MMMM \d\e\l Y');
        $fechaAceptacion = $ordencompra->fechaaceptacion;
        $fechaAceptacion = Carbon::parse($fechaAceptacion)->isoFormat('D \d\e MMMM \d\e\l Y');
        $responsables = DB::table('responsables')->first();
        $fechaorden = $ordencompra->fechaorden;
        $fechaorden = Carbon::parse($fechaorden)->isoFormat('D \d\e MMMM \d\e\l Y');
        $fechainiciosolici = $ordencompra->fechainiciosolproc;
        $fechainiciosolici = Carbon::parse($fechainiciosolici)->isoFormat('D \d\e MMMM');
        // tomar en cuenta $compra = CompraModel::find($id2);
        $prodserv = DB::table('detallecompra as d')
            ->join('prodserv as ps', 'ps.idprodserv', '=', 'd.idprodserv')
            ->join('compra as c', 'c.idcompra', '=', 'd.idcompra')
            ->join('partida as par', 'par.idpartida', '=', 'ps.partida_idpartida')
            ->join('umedida as u', 'u.idumedida', '=', 'ps.umedida_idumedida')
            ->select('d.iddetallecompra', 'c.idcompra', 'ps.nombreprodserv', 'ps.detalleprodserv', 'par.codigopartida', 'u.nombreumedida', 'd.cantidad', 'd.subtotal', 'd.precio')
            ->where('d.idcompra', '=', $id)->get();

        $valor_total = $prodserv->sum('subtotal');
        $responsables = DB::table('responsables')->first();

        return view('compras.detalle.adjudicacion', [
            'responsables' => $responsables,
            'prodserv' => $prodserv,
            'valor_total' => $valor_total,
            'fechainiciosolici' => $fechainiciosolici,
            'ordencompra' => $ordencompra,
            'ordendoc' => $ordendoc,
            'responsables' => $responsables,
            'fechaInvitacion' => $fechaInvitacion,
            'fechaAceptacion' => $fechaAceptacion,
            'fechaorden' => $fechaorden
        ]);
    }

    public function orden($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');

            $ordencompra = DB::table('ordencompra as o')
                ->select(
                    'o.numinforme',
                    'o.fechaorden',
                    'o.nombrecompra',
                    'o.solicitante',
                    'o.modalidadcontratacion',
                    'o.precioreferencial',
                    'o.proveedor',
                    'o.representante',
                    'o.cedula',
                    'o.nitci',
                    'o.telefono',
                    'o.approgramatica',
                    'o.partida',
                    'o.actividad',
                    'o.nordencompra',
                    'o.npreventivo',
                    'o.hojaruta',
                    'o.numcontrolinterno',
                    'o.plazoentrega',
                    'o.fechainicio',
                    'o.fechaconclusion',
                    'o.fechainvitacion',
                    'o.fechaaceptacion',
                    'o.codciteinvitacion',
                    'o.horapresentacion',
                    'o.cedulaaceptacion',
                    'o.numnotaadjudicacion',
                    'o.fechainiciosolproc',
                    'o.controlinter',
                    'o.autoridadsolicitante'
                )
                ->where('o.compra_idcompra', '=', $id)->first();



            $ordendoc = DB::table('ordencompra as o')

                ->join('ordendoc as od', 'od.idorden', '=', 'o.idorden')
                ->join('docorden as doc', 'doc.iddoc', '=', 'od.iddoc')

                ->select('doc.nombredoc')
                ->where('o.compra_idcompra', '=', $id)->get();



            $fechaInvitacion = $ordencompra->fechainvitacion;
            $fechaInvitacion = Carbon::parse($fechaInvitacion)->isoFormat('D \d\e MMMM \d\e\l Y');
            $fechaAceptacion = $ordencompra->fechaaceptacion;
            $fechaAceptacion = Carbon::parse($fechaAceptacion)->isoFormat('D \d\e MMMM \d\e\l Y');

            $responsables = DB::table('responsables')->first();

            $fechaorden = $ordencompra->fechaorden;
            $fechaorden = Carbon::parse($fechaorden)->isoFormat('D \d\e MMMM \d\e\l Y');
            $fechainiciosolici = $ordencompra->fechainiciosolproc;
            $fechainiciosolici = Carbon::parse($fechainiciosolici)->isoFormat('D \d\e MMMM');


            $prodserv = DB::table('detallecompra as d')
                ->join('prodserv as ps', 'ps.idprodserv', '=', 'd.idprodserv')
                ->join('compra as c', 'c.idcompra', '=', 'd.idcompra')

                ->join('partida as par', 'par.idpartida', '=', 'ps.partida_idpartida')
                ->join('umedida as u', 'u.idumedida', '=', 'ps.umedida_idumedida')

                ->select(
                    'd.iddetallecompra',
                    'c.idcompra',
                    'ps.nombreprodserv',
                    'ps.detalleprodserv',
                    'par.codigopartida',
                    'u.nombreumedida',
                    'd.cantidad',
                    'd.subtotal',
                    'd.precio'
                )
                ->where('d.idcompra', '=', $id)->get();

            $valor_total = $prodserv->sum('subtotal');
            $valor_total2 = NumerosEnLetras::convertir($valor_total, 'Bolivianos', true);

            //$pdf = PDF::loadView('compras.detalle.pdf-orden', compact(['valor_total2', 'responsables', 'prodserv', 'valor_total', 'fechainiciosolici', 'ordencompra', 'ordendoc', 'responsables', 'fechaInvitacion', 'fechaAceptacion', 'fechaorden']));
            //$pdf->setPaper('LETTER', 'portrait'); //landscape
            //return $pdf->stream();

            return view('compras.detalle.orden', [
                'valor_total2' => $valor_total2,
                'responsables' => $responsables,
                'prodserv' => $prodserv,
                'valor_total' => $valor_total,
                'fechainiciosolici' => $fechainiciosolici,
                'ordencompra' => $ordencompra,
                'ordendoc' => $ordendoc,
                'responsables' => $responsables,
                'fechaInvitacion' => $fechaInvitacion,
                'fechaAceptacion' => $fechaAceptacion,
                'fechaorden' => $fechaorden
            ]);
        } catch (Exception $ex) {
            \Log::error("Orden Error: {$ex->getMessage()}");
            return redirect()->route('compras.detalle.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function crearOrdenxxx($id)
    {
        $compras = DB::table('compra as c')
            ->join('proveedores as p', 'p.idproveedor', 'c.idproveedor')
            ->join('catprogramatica as cat', 'cat.idcatprogramatica', 'c.idcatprogramatica')
            ->join('programa as prog', 'prog.idprograma', 'c.idprograma')
            ->join('areas as a', 'a.idarea', 'c.idarea')

            ->select(
                'c.idcompra',
                'a.nombrearea',
                'c.objeto',
                'c.justificacion',
                'c.preventivo',
                'p.nombreproveedor',
                'p.representante',
                'p.cedula',
                'p.nitci',
                'p.telefonoproveedor',
                'c.preventivo',
                'c.numcompra',
                'cat.codcatprogramatica',
                'prog.nombreprograma'
            )
            ->where('c.idcompra', '=', $id)
            ->first();

        $prodserv = DB::table('detallecompra as d')
            ->join('prodserv as ps', 'ps.idprodserv', 'd.idprodserv')
            ->join('compra as c', 'c.idcompra', 'd.idcompra')
            ->select('d.iddetallecompra', 'c.idcompra', 'ps.nombreprodserv', 'd.cantidad', 'd.subtotal', 'd.precio')
            ->where('d.idcompra', $id)->get();

        $subtotal = $prodserv->sum('subtotal');

        return view(
            'compras.detalle.principal',
            [
                'compras' => $compras,
                'subtotal' => $subtotal,
                'idcompra' => $id
            ]
        );
    }

    public function crearorden(Request $request)
    {
        $id = $request->idcompra;
        $ordencompra = DB::table('ordencompra as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor')
            ->where('o.compra_idcompra', $id)->first();
        $resultado = $ordencompra;

        $fecha_orden = substr($request->fechaOden, 6, 4) . '-' . substr($request->fechaOden, 3, 2) . '-' . substr($request->fechaOden, 0, 2);
        $fecha_inicio = substr($request->fechainicio, 6, 4) . '-' . substr($request->fechainicio, 3, 2) . '-' . substr($request->fechainicio, 0, 2);
        $fecha_conclusion = substr($request->fechaconclusion, 6, 4) . '-' . substr($request->fechaconclusion, 3, 2) . '-' . substr($request->fechaconclusion, 0, 2);
        $fecha_invitacion = substr($request->fechainvitacion, 6, 4) . '-' . substr($request->fechainvitacion, 3, 2) . '-' . substr($request->fechainvitacion, 0, 2);
        $fecha_aceptacion = substr($request->fechaaceptacion, 6, 4) . '-' . substr($request->fechaaceptacion, 3, 2) . '-' . substr($request->fechaaceptacion, 0, 2);
        $fecha_iniciosoli = substr($request->fechainiciosoli, 6, 4) . '-' . substr($request->fechainiciosoli, 3, 2) . '-' . substr($request->fechainiciosoli, 0, 2);
        if (is_null($resultado)) {
            $ordencompra = new OrdenCompraModel();
            $ordencompra->numinforme = $request->input('informe');
            $ordencompra->fechaorden = $fecha_orden;
            $ordencompra->nombrecompra = $request->input('objeto');
            $ordencompra->solicitante = $request->input('solicitante');
            $ordencompra->modalidadcontratacion = $request->input('modalidad');
            $ordencompra->precioreferencial = $request->input('subtotal');
            $ordencompra->proveedor = $request->input('proveedor');
            $ordencompra->representante = $request->input('representante');
            $ordencompra->cedula = $request->input('cedula');
            $ordencompra->nitci = $request->input('nit');
            $ordencompra->telefono = $request->input('telefono');
            $ordencompra->approgramatica = $request->input('apertura');
            $ordencompra->partida = $request->input('partida');
            $ordencompra->actividad = $request->input('actitividad');
            $ordencompra->nordencompra = $request->input('orden');
            $ordencompra->npreventivo = $request->input('preventivo');
            $ordencompra->hojaruta = $request->input('ruta');
            $ordencompra->numcontrolinterno = $request->input('cinterno');
            $ordencompra->plazoentrega = $request->input('entrega');
            $ordencompra->fechainicio = $fecha_inicio;
            $ordencompra->fechaconclusion = $fecha_conclusion;
            $ordencompra->fechainvitacion = $fecha_invitacion;
            $ordencompra->fechaaceptacion = $fecha_aceptacion;
            $ordencompra->codciteinvitacion = $request->input('codigocite');
            $ordencompra->horapresentacion = $request->input('horapresentacion');
            $ordencompra->cedulaaceptacion = $request->input('cedulaaceptacion');
            $ordencompra->numnotaadjudicacion = $request->input('notaadjudicacion');
            $ordencompra->fechainiciosolproc = $fecha_iniciosoli;
            $ordencompra->controlinter = $request->input('controlinterno');
            $ordencompra->autoridadsolicitante = $request->input('solicitante');
            $ordencompra->compra_idcompra = $id;
            $ordencompra->memorandum1 = $request->input('memorandum1');
            $ordencompra->memorandum2 = $request->input('memorandum2');
            $ordencompra->comision1 = $request->input('comision1');
            $ordencompra->comision2 = $request->input('comision2');
            $ordencompra->informe1 = $request->input('informe1');
            $ordencompra->informe2 = $request->input('informe2');
            $ordencompra->save();
        }

        $ordencompra = DB::table('ordencompra as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor', 'o.fechaorden')
            ->where('o.compra_idcompra', $id)->get();

        $ordendoc = DB::table('ordencompra as o')
            ->join('ordendoc as od', 'od.idorden', 'o.idorden')
            ->join('docorden as doc', 'doc.iddoc', 'od.iddoc')
            ->select('doc.nombredoc')
            ->where('o.compra_idcompra', $id)->get();

        $docorden = DB::table('docorden as doc')
            ->select('doc.nombredoc', 'doc.iddoc')
            ->where('doc.estadodoc', 1)->get();

        return view('compras.detalle.principalorden', compact('ordencompra', 'id', 'ordendoc', 'docorden'));
    }

    public function crearOrdendoc(Request $request)
    {
        $id = $request->idcompra;
        $ordencompra = DB::table('ordencompra as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor', 'o.fechaorden')
            ->where('o.compra_idcompra', '=', $id)->get();

        $docorden = DB::table('docorden as doc')
            ->select('doc.nombredoc', 'doc.iddoc')
            ->where('doc.estadodoc', '=', 1)->get();

        $ordencompra2 = DB::table('ordencompra as o')
            ->select('o.idorden', 'o.nombrecompra', 'o.solicitante', 'o.proveedor', 'o.fechaorden')
            ->where('o.compra_idcompra', '=', $id)->first();

        $idordencompra = $ordencompra2->idorden;
        $ordendoccreate = new OrdenDocModel;
        $ordendoccreate->iddoc = $request->input('iddoc');
        $ordendoccreate->idorden = $idordencompra;
        $ordendoccreate->save();

        $ordendoc = DB::table('ordencompra as o')
            ->join('ordendoc as od', 'od.idorden', '=', 'o.idorden')
            ->join('docorden as doc', 'doc.iddoc', '=', 'od.iddoc')
            ->select('doc.nombredoc')
            ->where('o.compra_idcompra', '=', $id)->get();

        return back();
    }

    public function crearOrdendocxx($id)
    {
        $ordencompra = DB::table('ordencompra as o')
            ->select('o.nombrecompra', 'o.solicitante', 'o.proveedor', 'o.fechaorden')
            ->where('o.compra_idcompra', '=', $id)->get();

        $ordencompra2 = DB::table('ordencompra as o')
            ->select('o.idorden', 'o.nombrecompra', 'o.solicitante', 'o.proveedor', 'o.fechaorden')
            ->where('o.compra_idcompra', '=', $id)->first();

        $idordencompra = $ordencompra2->idorden;
        $ordendoc = DB::table('ordencompra as o')
            ->join('ordendoc as od', 'od.idorden', '=', 'o.idorden')
            ->join('docorden as doc', 'doc.iddoc', '=', 'od.iddoc')
            ->select('od.idordendoc', 'doc.nombredoc')
            ->where('o.compra_idcompra', '=', $id)->get();

        $docorden = DB::table('docorden as doc')
            ->select('doc.nombredoc', 'doc.iddoc')
            ->where('doc.estadodoc', '=', 1)->get();

        return view(
            'compras/detalle/principalorden',
            compact('ordencompra', 'id', 'ordendoc', 'docorden', 'idordencompra')
        );
    }

    public function edit($id)
    {
        //edit
    }

    public function update(Request $request, $id)
    {
        //update
    }

    public function create()
    {
        //create
    }

    public function destroy($id)
    {
        $detalle = DetalleCompraModel::find($id);
        $detalle->delete();

        return redirect('compras/detalle');
    }

    public function delete($id)
    {
        $detalle = DetalleCompraModel::find($id);
        $detalle->delete();

        return redirect()->route('compras.detalle.index');
    }

    public function destroyed2($id)
    {
        $ordendoc = OrdenDocModel::find($id);
        $ordendoc->delete();

        return back();
    }

    public function almacendos($idcompracomb)
    {

        //idcompracomb es el id de la compracomb

        $compracomb = CompraCombModel::find($idcompracomb);
        //solo compra
        $compra = CompraCombModel::find($idcompracomb);

        $IdareaCompra = $compra->idarea;
        $idProov = $compra->idproveedor;
        $idPro = $compra->iddea;
        $idCat = $compra->idcatprogramaticacomb;
        $IdCompra = $compra->idcompracomb;

        $iduno = $compra->iddirigidoa;
        $iddos = $compra->idviaa;
        $Idtres = $compra->iddepartede;


        $NumeroCompra = $compra->numcompra;
        $PreventiCompra = $compra->preventivo;
        $Numerocontrolin = $compra->controlinterno;

        $fechasoli = $compra->fechasoli;
        $horasoli = $compra->horasoli;
        $gestionsoli = $compra->gestionsoli;

        $justificacion = $compra->justificacion;
        $objeto = $compra->objeto;

        $tipo = $compra->tipo;
        $oficinade = $compra->oficinade;
        $comingreso = new ComingresoModel();
        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();

        $comingreso->fechaingreso = $fechasolACT;
        $comingreso->horaingreso = $hora;
        $comingreso->gestion = $gesti;


        $comingreso->fechasolicitud = $fechasoli;
        $comingreso->horasolicitud = $horasoli;
        $comingreso->gestionsolicitud = $gestionsoli;

        $comingreso->numcompra = $NumeroCompra;
        $comingreso->numsolicitud = $Numerocontrolin;
        $comingreso->numpreventivo = $PreventiCompra;
        $comingreso->numfactura = 0;
        $comingreso->detallecomingreso = $justificacion;
        $comingreso->objeto = $objeto;


        $comingreso->idarea = $IdareaCompra;
        $comingreso->idproveedor = $idProov;
        $comingreso->iddea = $idPro;
        $comingreso->idcatprogramaticacomb = $idCat;
        $comingreso->idcompracomb = $IdCompra;
        $comingreso->idtipocomin = 1;  //estado 1 balance inial

        $comingreso->iddirigidoa = $iduno;
        $comingreso->idviaa = $iddos;
        $comingreso->iddepartede = $Idtres;


        $comingreso->estadoingreso = 2;  //Estado 2 aprobado
        $comingreso->estado1 = 1;
        $comingreso->estado2 = 1;

        $comingreso->tipo = $tipo;
        $comingreso->oficinade = $oficinade;

        $comingreso->save();

        $IdcomINGREso = $comingreso->idcomingreso;

        if ($compracomb) {
            $detalleconcompra = $compracomb->comprasdetallecomb;
            foreach ($detalleconcompra as $detalle) {

                $idProducto = $detalle->idprodcomb;
                $CanTidad = $detalle->cantidad;
                $PreCios = $detalle->precio;
                $subtotal = $detalle->subtotal;

                $comprasss = ProdCombModel::find($idProducto);
                $CanTidaddd = $comprasss->cantidadproducto;
                $Stotalproducto = $comprasss->subtotalproducto;
                $CanTidaddde = $CanTidaddd + $CanTidad;
                $Stotalproductodos = $Stotalproducto + $subtotal;
                $cantidaduno = number_format($CanTidaddde, 10, '.', '');
                $cantidaddos = number_format($Stotalproductodos, 10, '.', '');

                $comprasss->cantidadproducto = $cantidaduno;
                $comprasss->subtotalproducto = $cantidaddos;
                $comprasss->save();

                $detalleingreso = new DetalleComingresoModel();

                $detalleingreso->cantidad = $CanTidad;
                $detalleingreso->subtotal = $subtotal;
                $detalleingreso->precio = $PreCios;

                $detalleingreso->cantidadsalida = $CanTidad;
                $detalleingreso->subtotalsalida = $subtotal;

                $detalleingreso->cantidadentrada = 0;
                $detalleingreso->subtotalentrada = 0;

                $detalleingreso->difcantidad = $CanTidad;
                $detalleingreso->subtdifcantidad = $subtotal;

                $detalleingreso->cantidadingreso = 0;
                $detalleingreso->subtotalcantidadingreso = 0;

                $detalleingreso->difcantidadingreso = 0;
                $detalleingreso->subdifcantidadingreso = 0;

                $detalleingreso->idcomingreso = $IdcomINGREso;
                $detalleingreso->idproducto = $idProducto;

                $detalleingreso->estado1 = 1;
                $detalleingreso->estado2 = 1;

                $detalleingreso->save();

                $comprass = CompraCombModel::find($idcompracomb);
                $fechasolACT = Carbon::now();
                $gesti = $fechasolACT->year;
                $hora = $fechasolACT->toTimeString();

                $comprass->fechaalmacen = $fechasolACT;
                $comprass->horaalmacen = $hora;
                $comprass->gestionalmacen = $gesti;

                $comprass->estadocompracomb = 5;
                $comprass->save();

                session()->flash('message', 'Registro Enviado a almacen');
            }
        } else {
            session()->flash('message', 'no hay nada');
        }

        return redirect()->route('detalle.index2');
    }
}
