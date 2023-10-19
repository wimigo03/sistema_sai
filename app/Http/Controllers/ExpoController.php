<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedidaModel;
use App\Models\RubroModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;


class ExpoController extends Controller
{

    public function index()
    {



        return view('expochaco.index');
    }


    public function rubro()
    {
        $rubros = DB::table('rubro as r')
            //->join('remitente as re', 're.id_remitente', '=', 'r.id_remitente')
            // ->join('areas as a', 'a.idarea', '=', 'd.idarea')
            ->select('r.idrubro', 'r.nombrerubro')
            //->where('d.idarea', $personalArea->idarea)
            //->where('d.estadoderiv1', 1)

            ->get();


        return view('expochaco/rubro', ["rubros" => $rubros]);
    }
}
