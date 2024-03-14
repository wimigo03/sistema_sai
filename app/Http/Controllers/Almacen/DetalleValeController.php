<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Models\Almacen\Comprobante\ComingresoModel;
use App\Models\Almacen\Comprobante\DetalleComingresoModel;
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

use Carbon\Carbon;
use NumerosEnLetras;
use PDF;


use App\Models\Almacen\Comprobante\ComegresoModel;
use App\Models\Almacen\Comprobante\DetallecomegresoModel;
use App\Models\Transporte\UnidaddConsumoModel;
use App\Models\Compra\ProdCombModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Canasta\Dea;
class DetalleValeController extends Controller
{
    public function index()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;

        $detalless = ValeModel::find($id2);
        $id6 = $detalless->idcomingreso;
        $id7 = $detalless->idpartidacomb;

        $prodserv = DB::table('detallevale as d')


            ->join('vale as v', 'v.idvale', '=', 'd.idvale')
            ->join('detallecomingreso as det', 'det.iddetallecomingreso', '=', 'd.iddetallecomingreso')
            ->join('prodcomb as pro', 'pro.idprodcomb', '=', 'det.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'pro.idmedidacomb')
            ->select(
                'd.iddetallevale',
                'v.idvale',
                'd.cantidadsol',
                'd.subtotalsol',
                'd.preciosol',
                'pro.nombreprodcomb',
                'pro.detalleprodcomb',
                'u.nombremedida'
            )

            ->where('d.idvale', $id2)
            ->orderBy('d.iddetallevale', 'desc')
            ->get();

        $detallecomingresos = DB::table('detallecomingreso as deta')
            ->join('prodcomb as pro', 'pro.idprodcomb', '=', 'deta.idproducto')
            ->join('partidacomb as pa', 'pa.idpartidacomb', '=', 'pro.idpartidacomb')
            ->join('comingreso as comin', 'comin.idcomingreso', '=', 'deta.idcomingreso')

            ->where('deta.idcomingreso', $id6)
            ->where('pro.idpartidacomb', $id7)
            ->select(DB::raw("concat(
                            ' Codigo : ',pro.detalleprodcomb,
                            ' // Nombre : ',pro.nombreprodcomb,
                            ' // Cantidad : ',deta.difcantidad
                        
                        ) as detalleingreso"), 'iddetallecomingreso')
            ->pluck('detalleingreso', 'iddetallecomingreso');

        $valor_total2 = $prodserv->sum('cantidadsol');
        $valor_total3 = $prodserv->sum('subtotalsol');

        $CalAdosDecim = number_format($valor_total2, 2, '.', '');
        $CalAdosDecimdos = number_format($valor_total3, 2, '.', '');

        $vales = DB::table('vale as v')

            ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
            ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

            ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select(
                'v.idvale',
                'v.estadotemp',
                'v.aproxgas',

                'a.nombrearea',

                'u.codigoconsumo',
                'u.placaconsumo',
                'u.marcaconsumo',

                'lo.nombrelocalidad',
                'lo.distancialocalidad',
                'v.estado2',
                'v.idcomingreso'
            )
            ->where('v.idvale', '=', $id2)
            ->first();



        $comingresos = DB::table('comingreso as comin')
            ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
            ->where('comin.idcomingreso', '=', $id6)
            ->select('comin.idcomingreso', 'cat.codcatprogramatica', 'cat.nombrecatprogramatica')
            ->first();
        $id4 = $comingresos->codcatprogramatica;
        $id5 = $comingresos->nombrecatprogramatica;
        return view('almacenes.detalle.index',
            [
                'prodserv' => $prodserv,
                'comingresos' => $comingresos,
                'detallecomingresos' => $detallecomingresos,
                'valor_total2' => $valor_total2,
                'CalAdosDecim' => $CalAdosDecim,
                'CalAdosDecimdos' => $CalAdosDecimdos,
                'idvale' => $id2,
                'id4' => $id4,
                'id5' => $id5,
                'id6' => $id6,
                'vales' => $vales
            ]
        );
    }

    public function index2()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;
        $detalless = ValeModel::find($id2);
        $id6 = $detalless->idcomingreso;
        $prodserv = DB::table('detallevale as d')


            ->join('vale as v', 'v.idvale', '=', 'd.idvale')
            ->join('detallecomingreso as det', 'det.iddetallecomingreso', '=', 'd.iddetallecomingreso')
            ->join('prodcomb as pro', 'pro.idprodcomb', '=', 'det.idproducto')
            ->join('umedidacomb as u', 'u.idmedida', '=', 'pro.idmedidacomb')
            ->select(
                'd.iddetallevale',
                'v.idvale',
                'u.nombremedida',

                'd.cantidadsol',
                'd.subtotalsol',
                'd.preciosol',
                'pro.nombreprodcomb',
                'pro.detalleprodcomb'
            )

            ->where('d.idvale', $id2)
            ->orderBy('d.iddetallevale', 'desc')
            ->get();

        $valor_total2 = $prodserv->sum('cantidadsol');
        $valor_total3 = $prodserv->sum('subtotalsol');

        $CalAdosDecim = number_format($valor_total2, 2, '.', '');
        $CalAdosDecimdos = number_format($valor_total3, 2, '.', '');

        $detallecomingresos = DB::table('detallecomingreso as deta')
            ->join('prodcomb as pro', 'pro.idprodcomb', '=', 'deta.idproducto')
            ->join('comingreso as comin', 'comin.idcomingreso', '=', 'deta.idcomingreso')

            ->where('deta.idcomingreso', $id6)
            ->select(DB::raw("concat(
                            ' Codigo : ',pro.detalleprodcomb,
                            ' // Nombre : ',pro.nombreprodcomb,
                            ' // Cantidad : ',deta.cantidad
                        
                        ) as detalleingreso"), 'iddetallecomingreso')
            ->pluck('detalleingreso', 'iddetallecomingreso');




        $vales = DB::table('vale as v')

            ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
            ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

            ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select(
                'v.idvale',
                'v.estado1',
                'v.aproxgas',

                'a.nombrearea',

                'u.codigoconsumo',
                'u.placaconsumo',
                'u.marcaconsumo',

                'lo.nombrelocalidad',
                'lo.distancialocalidad'
            )
            ->where('v.idvale', '=', $id2)
            ->first();

        return view(
            'almacenes.detalle.index2',
            [
                'prodserv' => $prodserv,
                'detallecomingresos' => $detallecomingresos,
                'valor_total2' => $valor_total2,
                'idvale' => $id2,
                'CalAdosDecim' => $CalAdosDecim,
                'CalAdosDecimdos' => $CalAdosDecimdos,
                'vales' => $vales
            ]
        );
    }

    public function index3()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        $id2 = $detalle->idvale;

        $prodserv = DB::table('detallevale as d')

            ->join('iddetallecomingreso as ing', 'ing.iddetallecomingreso', '=', 'd.iddetallecomingreso')
            ->join('vale as v', 'v.idvale', '=', 'd.idvale')

            ->select(
                'd.iddetallevale',
                'v.idvale',
                'ing.cantidadsalida',
                'd.cantidadsol',
                'd.subtotalsol',
                'd.preciosol'
            )

            ->where('d.idvale', $id2)
            ->orderBy('d.iddetallevale', 'desc')
            ->get();

        $productos = DB::table('ingreso')
            ->where('estadocompracomb', 2)
            ->select(DB::raw("concat(
                        ' Codigo : ',codigoprodcomb,
                        ' // Nombre : ',nombreproducto,
                        ' // Proyecto: ',nombrecatprogmai,
                        ' // Programa: ',nombreprograma,
                        ' // Disponible: ',cantidadsalida, '  Litros '
                        
                        
                        ) as prodservicio"), 'idingreso')
            ->pluck('prodservicio', 'idingreso');

        $valor_total2 = $prodserv->sum('subtotalsol');


        $vales = DB::table('vale as v')

            ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
            ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')

            ->join('areas as a', 'a.idarea', '=', 'v.idarea')

            ->select(
                'v.idvale',
                'v.estado1',
                'v.aproxgas',

                'a.nombrearea',

                'u.codigoconsumo',
                'u.placaconsumo',
                'u.marcaconsumo',

                'lo.nombrelocalidad',
                'lo.distancialocalidad'
            )
            ->where('v.idvale', '=', $id2)
            ->first();

        return view(
            'almacenes.detalle.index3',
            [
                'prodserv' => $prodserv,
                'productos' => $productos,
                'valor_total2' => $valor_total2,
                'idvale' => $id2,

                'vales' => $vales
            ]
        );
    }

    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);

        $id2 = $detalle->idvale;
        $producto = $request->get('producto');

        $almacen = DetalleComingresoModel::find($producto);
        $precio = $almacen->precio;

        $Cantidaddetallecomin = $almacen->cantidad;
        $Cantidadentrada = $almacen->cantidadentrada;

        $cantidadd = $request->get('cantidad');
        $cantidad = number_format($cantidadd, 10, '.', '');

        $cantidaddiferencia = $cantidad + $Cantidadentrada;  //viendo si hay combustible

        $cantidadtotal = $Cantidaddetallecomin - $Cantidadentrada;  //haciendo una resta si queda combustible

        // de la cantidad solicitada restamos la cantidad entrante

        $SubTotalsol = $cantidad * $precio;
        $SubTotalsolresu = number_format($SubTotalsol, 10, '.', '');  //subtotal 
        $Cantidadsalidados = $cantidadtotal;

        $Cantidadrest = $Cantidaddetallecomin - $cantidaddiferencia;  //viendo si queda combustible

        // $cantidadrestaNoNegativa = $Cantidadrest < 0 ? 0 : $Cantidadrest;

        $detalle = new DetalleValeModel;
        $detalle->iddetallecomingreso = $request->get('producto');
        $detalle->idvale = $id2;
        $detalle->cantidadsol = $cantidad;
        $detalle->preciosol = $precio;
        $detalle->subtotalsol = $SubTotalsolresu;

        $detalle->cantidadresta = 0;
        $detalle->sudtotalresta = 0;

        $detalle->devolucionresta = 0;
        $detalle->subtotaldevolucion = 0;

        $detallito = DB::table('detallevale as d')

            ->join('detallecomingreso as ing', 'ing.iddetallecomingreso', 'd.iddetallecomingreso')
            ->join('vale as v', 'v.idvale', 'd.idvale')

            ->select(
                'd.iddetallevale',
                'v.idvale',
                'd.cantidadsol',
                'd.subtotalsol',
                'd.preciosol'
            )

            ->where('d.iddetallecomingreso', $producto)

            ->where('d.idvale', $id2)->get();

        if ($detallito->isEmpty()) {
            if ($Cantidadrest >= 0) {

                $detalle->save();
                $progrmi = ValeModel::find($id2);
                $progrmi->estadotemp = 2;
                $progrmi->estadovale = 3;
                $progrmi->save();

                $request->session()->flash('message', 'Registro Agregado',);
            } else {

                $request->session()->flash('message', 'La cantidad debe ser menor o igual que: ' . $Cantidadsalidados . ' Litros');
            }
            // $request->session()->flash('message', 'Registro Agregado',);
        } else {
            $request->session()->flash('message', 'El Item Ya existe en la Planilla');
        }
        return redirect()->route('adetalle.index');
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
                    'd.iddetallecomingreso', //de forma automatica del que tiene acceso

                    'd.cantidadsol',  //de forma automatica del que tiene acceso
                    'd.preciosol',  //el lugar de ida

                    //via
                    'd.subtotalsol',
                    'd.cantidadresta'
                )
                ->where('d.iddetallevale', $id)

                ->first();

            $Idvale = $detalle->idvale;

            $Idingreso = $detalle->iddetallecomingreso;
            $cantidadsolici = $detalle->cantidadsol;
            $Cantidaddev = number_format($cantidadsolici, 2, '.', '');
            $vales = DB::table('vale as v')
                ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'v.idunidad')
                ->join('localidad as lo', 'lo.idlocalidad', '=', 'v.idlocalidad')
                ->join('comingreso as comin', 'comin.idcomingreso', '=', 'v.idcomingreso')
                ->join('catprogramaticacomb as cat', 'cat.idcatprogramaticacomb', '=', 'comin.idcatprogramaticacomb')
                ->join('areas as a', 'a.idarea', '=', 'v.idarea')
                ->select(
                    'v.idvale',
                    'v.marcaconsumo',
                    'v.placaconsumo',
                    'v.kilometrajeactualconsumo',
                    'v.kiloanterior',
                    'v.detallesouconsumo',
                    'a.nombrearea',
                    'v.usuarionombre',
                    'cat.codcatprogramatica',
                    'cat.nombrecatprogramatica'
                )
                ->where('v.idvale', '=', $Idvale)
                ->first();

            $detallecomingresos = DB::table('detallecomingreso as det')
                ->select(
                    'det.iddetallecomingreso',
                    'det.difcantidad'
                    // 'ing.kilometrajeactualconsumo','ing.kiloanterior',
                    // 'ing.detallesouconsumo','ing.nombrearea'

                )
                ->where('det.iddetallecomingreso', '=', $Idingreso)
                ->first();

            $cantidadsolicidos = $detallecomingresos->difcantidad;
            $Cantidaddevdos = number_format($cantidadsolicidos, 2, '.', '');

            // $ingresos = DB::table('ingreso as ing')
            // ->select('ing.idingreso','ing.nombreprograma',
            // 'ing.codigocatprogramai'


            // )
            // ->where('ing.idingreso', '=', $Idingreso)
            // ->first();


            $pdf = PDF::loadView(
                'almacenes.detalle.pdf-solicitud',
                compact(['detalle', 'vales', 'detallecomingresos', 'Cantidaddev', 'Cantidaddevdos'])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('adetalle.index')->with('message', $ex->getMessage());
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

            ->select(
                'd.iddetallecompracomb',
                'c.idcompracomb',
                'ps.nombreprodcomb',
                'ps.detalleprodcomb',
                'par.codigopartida',
                'd.cantidad',
                'd.subtotal',
                'd.precio'
            )
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
        return view(
            'almacenes.detalle.print',
            compact('prodserv', 'valor_total', 'compras')
        );
    }

    public function editar($iddetallevale)
    {
        $detalles = DetalleValeModel::find($iddetallevale);


        return view('almacenes/detalle/editar', compact('detalles'));
    }

    public function update(Request $request)
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
        $Cantidadsobra = $CANtidaDsol - $cantidad;


        $SUdtotaldev = $cantidad * $PReciosOL;
        // para detalle vale subtotaldevolucion
        $Cantidaddev = number_format($SUdtotaldev, 10, '.', '');


        $almacen = IngresoModel::find($Idingreso);
        //pide la cantidad actual de almacen
        $Cantidadsalida = $almacen->cantidadsalida;
        $Cantidadsalidasuma = $Cantidadsalida + $Cantidadsobra;

        $SubTotalsol = $Cantidadsalidasuma * $PReciosOL;
        $SubTotalsolresu = number_format($SubTotalsol, 10, '.', '');





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
            return redirect()->route('adetalle.index3');
        } else {

            if ($CANtidaDsol == $cantidad) {



                $almacendes = ValeModel::find($IdVale);
                $almacendes->estado1 = 3;
                $almacendes->estado2 = 2;
                $almacendes->save();
                $request->session()->flash('message', 'la cantida era igual  que la solicitada corregido');
                return redirect()->route('adetalle.index3');
            } else {
                $request->session()->flash('message', 'La cantidad debe ser menor o igual que: la cantidad solicitada  corregido');
                return redirect()->route('adetalle.index2');
            }

            return redirect()->route('adetalle.index2');
        }
    }


    public function delete($id)
    {
        $detalle = DetalleValeModel::find($id);
        $IDdetal = $detalle->idvale;

        $progrmi = ValeModel::find($IDdetal);
        $progrmi->estadotemp = 1;
        $progrmi->estadovale = 1;
        $progrmi->save();
        $detalle->delete();

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = Temporal2Model::find($id);
        
        if(is_null($detalle)){
        $detalle = new Temporal2Model;
        $detalle->idtemporal2=$id;
        $detalle->idusuario=$id;
        $detalle->idvale=$IDdetal;
        $detalle->save();
        }else{
        $detalle->idtemporal2 = $id;
        $detalle->idusuario = $id;
        $detalle->idvale = $IDdetal;
        $detalle->update();
        }

        return redirect()->route('adetalle.index');
    }
    public function aprovar($id)
    {

        $detalle = DetalleValeModel::find($id);

        $Idvale = $detalle->idvale;
        $Idingreso = $detalle->iddetallecomingreso;


        // del detalle obtenermos la cantidad , el subtotal y el precio
        // fixme:  aqui esta la cantidad solicitada y el subtotal
        $Cantidadsol = $detalle->cantidadsol;
        $sudtotalsol = $detalle->subtotalsol;

        $precioo = $detalle->preciosol;
        $sudtotalsolu = $sudtotalsol;


        $ingresoss = DetalleComingresoModel::find($Idingreso);
        $Cantidaddif = $ingresoss->cantidad;
        $sudtotaldif = $ingresoss->subtotal;

        $Cantidadentrada = $ingresoss->cantidadentrada;
        $sudtotalentrada = $ingresoss->subtotalentrada;

        $Cantidadsalid = $ingresoss->cantidadsalida;
        $sudtotalsalid = $ingresoss->subtotalsalida;

        $Cantidadingreso = $ingresoss->cantidadingreso;
        $sudtotalingreso = $ingresoss->subtotalcantidadingreso;


        $var1 = $Cantidadentrada + $Cantidadsol;
        $var2 = $sudtotalentrada + $sudtotalsol;

        $var11 = number_format($var1, 10, '.', '');
        $var22 = number_format($var2, 10, '.', '');

        $var3 = $Cantidaddif - $var11;
        $var4 = $sudtotaldif - $var22;
        $var33 = number_format($var3, 10, '.', '');
        $var44 = number_format($var4, 10, '.', '');


        $var51 = $Cantidadsalid + $Cantidadingreso;
        $var5 = $var51 - $var11;

        $var61 = $sudtotalsalid + $sudtotalingreso;
        $var6 = $var61 - $var22;

        $var55 = number_format($var5, 10, '.', '');
        $var66 = number_format($var6, 10, '.', '');


        //buscamos el id del ingreso y lo modificamos
        $ingreso = DetalleComingresoModel::find($Idingreso);
        $ingreso->cantidadentrada = $var11;
        $ingreso->subtotalentrada = $var22;

        $ingreso->difcantidad = $var33;
        $ingreso->subtdifcantidad = $var44;

        $ingreso->difcantidadingreso = $var55;
        $ingreso->subdifcantidadingreso = $var66;

        $ingreso->save();

      


        $vales = ValeModel::find($Idvale);
        $vales->estadovale = 2;
        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $hora = $fechasolACT->toTimeString();

        $vales->fechaaprob = $fechasolACT;
        $vales->horaaprob = $hora;
        $vales->gestionvale = $gesti;
        $vales->save();


        $valese = ValeModel::find($Idvale);
        $idcoming = $valese->idcomingreso;


        $idunid = $valese->idunidad;
        $klmant = $valese->kiloanterior;
        $klmfin = $valese->kilometrajeactualconsumo;
        $motivo = $valese->detallesouconsumo;
        $idprogramacombd = $valese->iddea;
        $idpartidacombd = $valese->idpartidacomb;
        $idaread = $valese->idarea;
        $idusuariod = $valese->idusuario;
        $numcompr = $valese->numpreventivo;

        $fechas = $valese->fechasolicitud;
        $horaso = $valese->horasoli;
        $gestionso = $valese->gestionvale;
   

        $unidadconsumos = UnidaddConsumoModel::find($idunid);
        $unidadconsumos->kilometrajeinicialconsumo = $klmant;
        $unidadconsumos->kilometrajefinalconsumo = $klmfin;
        $unidadconsumos->save();


        $comingreso = new ComegresoModel();
     

        $comingreso->fechaegreso = $fechas;
        $comingreso->horaegreso = $horaso;
        $comingreso->gestionegreso = $gestionso;

        $comingreso->idvale = $Idvale;
        $comingreso->idcomingreso = $idcoming;

        $comingreso->idtipocomin = 3;  //id 3 egreso
        $comingreso->idproveedor = 1;

        $comingreso->estadoegreso = 1;
        $comingreso->detallecomegreso = $motivo;

        $comingreso->iddea = $idprogramacombd;
        $comingreso->idpartidacomb = $idpartidacombd;
        $comingreso->idarea = $idaread;
        $comingreso->idusuario = $idusuariod;
        $comingreso->numvale = $Idvale;
        $comingreso->numpreventivo = $numcompr;
        $comingreso->save();
        $idcomegr = $comingreso->idcomegreso;

        $detalleingreso = new DetallecomegresoModel();

        $detalleingreso->iddetallecomingreso = $Idingreso;
        $detalleingreso->iddetallevale = $id;
        $detalleingreso->idcomegreso = $idcomegr;
        $detalleingreso->estadoegreso = 1;

        $detalleingreso->cantidadegreso = $Cantidadsol;
        $detalleingreso->subtotalegreso = $sudtotalsol;

        $detalleingreso->cantidadingreso = $Cantidadsol;
        $detalleingreso->subtotalingreso = $sudtotalsol;
        $detalleingreso->save();

        $Idingresod = $detalleingreso->iddetallecomingreso;
        $Idcat = $detalleingreso->cantidadegreso;
        $Idst = $detalleingreso->subtotalegreso;
        $ingresod = DetalleComingresoModel::find($Idingresod);
        $idpro = $ingresod->idproducto;

        $comprasss = ProdCombModel::find($idpro);
        $CanTidaddd = $comprasss->cantidadproducto;
        $Stotalproducto = $comprasss->subtotalproducto;

        $CanTidaddde = $CanTidaddd + $Idcat;
        $Stotalproductodos = $Stotalproducto + $Idst;
        $varcinco = number_format($CanTidaddde, 10, '.', '');
        $varseis = number_format($Stotalproductodos, 10, '.', '');

        $comprasssn = ProdCombModel::find($idpro);
        $comprasssn->cantidadproducto = $varcinco;
        $comprasssn->subtotalproducto = $varseis;
        $comprasssn->save();

        return redirect()->route('adetalle.index2');
    }
}
