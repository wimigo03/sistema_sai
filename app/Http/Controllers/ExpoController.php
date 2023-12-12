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

    public function createrubro(){



        return view('expochaco.createrubro');

       // return view('expochaco.create');
    }


    public function storerubro(Request $request){



        $newestUser = RubroModel::orderBy('idrubro', 'desc')->first();
        $maxId = $newestUser->idrubro;

        $rubro = new RubroModel();
        $rubro->idrubro = $maxId + 1;

        $rubro->nombrerubro = $request->input('nombrerubro');
        $rubro->estadorubro = 1;




        if($rubro->save()){
            $request->flash('message', 'Registro Procesado');
            return redirect()->action('App\Http\Controllers\ExpoController@rubro');
        }else{
            $request->flash('message', 'Error al Procesar Registro');
        }

    }

}
