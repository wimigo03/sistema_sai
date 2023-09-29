<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\CompraModel;
use App\Models\TemporalModel;
use App\Models\IngresoAlmacenModel;
use App\Models\DetalleIngresoModel;
use App\Models\TemporalAlmacenModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use DataTables;




class AlmacenController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $compras = DB::table('ingreso as i')

                ->join('compra as c', 'c.idcompra', '=', 'i.idcompra')
                ->join('proveedores as p', 'p.idproveedor', '=', 'c.idproveedor')
                ->join('catprogramatica as cat', 'cat.idcatprogramatica', '=', 'c.idcatprogramatica')
                ->join('programa as prog', 'prog.idprograma', '=', 'c.idprograma')
                ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                //->where('c.estadocompra',1)
                ->select('i.idingreso', 'c.estadocompra', 'c.idcompra', 'c.estado1', 'c.estado2', 'c.estado3', 'a.nombrearea', 'c.objeto', 'c.justificacion', 'p.nombreproveedor', 'c.preventivo', 'c.numcompra', 'cat.codcatprogramatica', 'prog.nombreprograma')
                ->orderBy('c.idcompra', 'asc');
            //->get();

            return Datatables::of($compras)
                ->addIndexColumn()

                ->addColumn('btn2', 'almacen.btn2')
                ->rawColumns(['btn2'])
                ->make(true);
        }

        return view('almacen.index');
    }

    public function temporal($idingreso)
    { //dd($idcomp);
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $detalle = TemporalAlmacenModel::find($id);
        if (is_null($detalle)) {
            $detalle = new TemporalAlmacenModel;
            $detalle->idtemporalalmacen = $id;
            $detalle->idusuario = $id;
            $detalle->idingreso = $idingreso;
            $detalle->save();
        } else {
            $detalle->idtemporalalmacen = $id;
            $detalle->idusuario = $id;
            $detalle->idingreso = $idingreso;
            $detalle->update();
        }

        //dd($idingreso);
        //return Redirect::to('compras/detalle');
        // return redirect()->route('compras.detalle.index');
    }



    public function detalle($idingreso)
    {
       // $personal = User::find(Auth::user()->id);
        //$id = $personal->id;
       // $detalle = TemporalAlmacenModel::find($id);
        //$id2 = $detalle->idingreso;
        $prodserv = DB::table('detalleingreso as d')
            ->join('ingreso as i', 'i.idingreso', '=', 'd.idingreso')
            ->join('compra as c', 'c.idcompra', '=', 'i.idcompra')
            ->join('prodserv as ps', 'ps.idprodserv', '=', 'd.idprodserv')
            ->select('d.iddetalleingreso', 'c.idcompra', 'ps.nombreprodserv', 'd.ingresos', 'd.salidas', 'd.saldo')
            ->where('i.idingreso', $idingreso)
            ->orderBy('d.iddetalleingreso', 'desc')
            ->get();


    // dd($prodserv);

        return view('almacen.detalle', ['prodserv' => $prodserv]);
    }
}
