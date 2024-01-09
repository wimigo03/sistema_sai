<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\CompraModel;
use App\Models\TemporalModel;
use App\Models\IngresoModel;
use App\Models\DetalleIngresoModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use NumerosEnLetras;

use DataTables;

class CompraController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $compras = DB::table('compra as c')
                ->join('proveedores as p', 'p.idproveedor', '=', 'c.idproveedor')
                ->join('catprogramatica as cat', 'cat.idcatprogramatica', '=', 'c.idcatprogramatica')
                ->join('programa as prog', 'prog.idprograma', '=', 'c.idprograma')
                ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                ->where('c.estadocompra', 1)
                ->select('c.estadocompra', 'c.idcompra', 'c.estado1', 'c.estado2', 'c.estado3', 'a.nombrearea', 'c.objeto', 'c.justificacion', 'p.nombreproveedor', 'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica', 'prog.nombreprograma')
                ->orderBy('c.idcompra', 'asc');
            //->get();

            return Datatables::of($compras)
                ->addIndexColumn()
                ->addColumn('btn', 'compras.pedido.btn')
                ->addColumn('btn2', 'compras.pedido.btn2')
                ->rawColumns(['btn', 'btn2'])
                ->make(true);
        }
        return view('compras.pedido.index');
    }



    public function index2(Request $request)
    {

        if ($request->ajax()) {
            $compras = DB::table('compra as c')
                ->join('proveedores as p', 'p.idproveedor', '=', 'c.idproveedor')
                ->join('catprogramatica as cat', 'cat.idcatprogramatica', '=', 'c.idcatprogramatica')
                ->join('programa as prog', 'prog.idprograma', '=', 'c.idprograma')
                ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                ->where('c.estadocompra', 2)
                ->select('c.estadocompra', 'c.idcompra', 'c.estado1', 'c.estado2', 'c.estado3', 'a.nombrearea', 'c.objeto', 'c.justificacion', 'p.nombreproveedor', 'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica', 'prog.nombreprograma')
                ->orderBy('c.idcompra', 'asc');
            //->get();

            return Datatables::of($compras)
                ->addIndexColumn()
                ->addColumn('btn', 'compras.pedido.btn')
                ->addColumn('btn2', 'compras.pedido.btn2')
                //->addColumn('btn3', 'compras.pedido.btn3')

                ->addColumn('btn3', function ($compras) {

                    if ($compras->estado3 == 1) {
                        return view('compras.pedido.btn3', compact('compras'));
                    }
                    if ($compras->estado3 == 2) {
                        return 'Enviado';
                    }
                })


                ->rawColumns(['btn', 'btn2'])
                ->make(true);
        }
        return view('compras.pedido.index2');
    }




    public function create()
    {
        $proveedores = DB::table('proveedores')->where('estadoproveedor', 1)->pluck('nombreproveedor', 'idproveedor');
        $areas = DB::table('areas')->where('estadoarea', 1)->pluck('nombrearea', 'idarea');
        $catprogramaticas = DB::table('catprogramatica')
            ->select(DB::raw("concat(codcatprogramatica,' : ',nombrecatprogramatica) as programatica"), 'idcatprogramatica')
            ->where('estadocatprogramatica', 1)
            ->pluck('programatica', 'idcatprogramatica');
        $programas = DB::table('programa')->where('estadoprograma', 1)->pluck('nombreprograma', 'idprograma');
        return view('compras.pedido.create', compact('proveedores', 'areas', 'catprogramaticas', 'programas'));
    }

    public function store(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $compras = new CompraModel();
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->preventivo = $request->input('preventivo');
        $compras->tipo = $request->input('tipo');
        $compras->numcompra = $request->input('numcompra');
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idarea = $request->input('idarea');
        $compras->idcatprogramatica = $request->input('idcatprogramatica');
        $compras->idprograma = $request->input('idprograma');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idusuario = $id;
        $compras->estadocompra = 1;
        $compras->estado1 = 1;
        $compras->estado2 = 1;
        $compras->estado3 = 1;
        if ($compras->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('compras.pedido.index');
    }

    public function show($id)
    {
    }

    public function edit($idcomp)
    { //dd($idcomp);
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalModel::find($id);
        if (is_null($detalle)) {
            $detalle = new TemporalModel;
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcomp;
            $detalle->save();
        } else {
            $detalle->idtemporal = $id;
            $detalle->idusuario = $id;
            $detalle->idcompra = $idcomp;
            $detalle->update();
        }
        //return Redirect::to('compras/detalle');
        return redirect()->route('compras.detalle.index');
    }

    public function editar($idcompra)
    {
        $compras = CompraModel::find($idcompra);
        $proveedores = DB::table('proveedores')->get();
        $areas = DB::table('areas')->get();
        $catprogramaticas = DB::table('catprogramatica')->get();
        $programas = DB::table('programa')->get();
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        return view('compras.pedido.editar', compact('id', 'compras', 'proveedores', 'areas', 'catprogramaticas', 'programas'));
    }

    public function update(Request $request)
    {//dd($request->all());
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        $compras = CompraModel::find($request->idcompra);
        $compras->objeto = $request->input('objeto');
        $compras->justificacion = $request->input('justificacion');
        $compras->preventivo = $request->input('preventivo');
        $compras->tipo = $request->input('tipo');
        $compras->numcompra = $request->input('numcompra');
        $compras->controlinterno = $request->input('controlinterno');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idarea = $request->input('idarea');
        $compras->idcatprogramatica = $request->input('idcatprogramatica');
        $compras->idprograma = $request->input('idprograma');
        $compras->idproveedor = $request->input('idproveedor');
        $compras->idusuario = $id;
        if ($compras->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('compras.pedido.index');
    }

    public function destroy($id)
    {
    }

    public function enviar($id)
    {
        $today = Carbon::today();
        // $fecha=new date();
        $compras = CompraModel::find($id);
        $idcompra = $compras->idcompra;
        //dd($today);
        $ingresoalmacen = new IngresoModel;
        $ingresoalmacen->idcompra = $idcompra;
        $ingresoalmacen->fechaingreso = $today;
        $ingresoalmacen->estadoingreso = 1;

        $ingresoalmacen->save();


        $prodserv = DB::table('detallecompra as d')
            ->join('prodserv as ps', 'ps.idprodserv', '=', 'd.idprodserv')
            ->join('compra as c', 'c.idcompra', '=', 'd.idcompra')
            ->select('d.iddetallecompra', 'c.idcompra', 'ps.nombreprodserv', 'ps.idprodserv', 'd.cantidad', 'd.subtotal', 'd.precio')
            ->where('d.idcompra', $idcompra)
            ->orderBy('d.iddetallecompra', 'desc')
            ->get();


        //dd($prodserv);

        foreach ($prodserv as $items) {

            $detalleingreso = new DetalleIngresoModel;
            //$detalleingreso->idcompra = $idcompra;
            $detalleingreso->idprodserv = $items->idprodserv;
            $detalleingreso->idingreso =  $ingresoalmacen->idingreso;
            $detalleingreso->ingresos = $items->cantidad;
            $detalleingreso->salidas = 0;
            $detalleingreso->saldo = $items->cantidad;

            $detalleingreso->save();
        }

        $compras->estado3 = 2;
        $compras->save();

        return redirect()->route('compras.pedido.index');
    }
}
