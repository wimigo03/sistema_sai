<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\CompraModel;
use App\Models\TemporalModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;


class AlmacenController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
        $compras = DB::table('compra as c')
                        ->join('proveedores as p', 'p.idproveedor', '=', 'c.idproveedor')
                        ->join('catprogramatica as cat', 'cat.idcatprogramatica', '=', 'c.idcatprogramatica')
                        ->join('programa as prog', 'prog.idprograma', '=', 'c.idprograma')
                        ->join('areas as a', 'a.idarea', '=', 'c.idarea')
                        ->where('c.estadocompra',1)
                        ->select('c.estadocompra','c.idcompra','c.estado1','c.estado2','c.estado3','a.nombrearea','c.objeto', 'c.justificacion','p.nombreproveedor','c.preventivo','c.numcompra','cat.codcatprogramatica','prog.nombreprograma')
                        ->orderBy('c.idcompra', 'asc');
                        //->get();

                        return Datatables::of($compras)
                        ->addIndexColumn()
                        ->addColumn('btn', 'compras.pedido.btn')
                        ->addColumn('btn2', 'compras.pedido.btn2')
                        ->rawColumns(['btn','btn2'])
                        ->make(true);

                    }
       return view('compras.pedido.index');
    }




}
