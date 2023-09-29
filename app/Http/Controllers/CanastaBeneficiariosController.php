<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Afiliado;
//use App\Models\Entrega;
use App\Models\CanastaBeneficiariosModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use PDF;


class CanastaBeneficiariosController extends Controller
{
    public function index()
    {
       // $data2 = CanastaBeneficiariosModel::orderBy('idUsuario', 'desc')->paginate(10);
       // $data = CanastaBeneficiariosModel::all();
       // $data = DB::connection('mysql_canasta')->table('datos')->get();
        //$data = DB::connection('mysql_canasta')->table("datos as d")
       // ->select('d.id')
      // ->get();
       // $canasta = DB::table('usuarios')->get();
       // $canasta = CanastaBeneficiariosModel::orderBy('idBarrio', 'desc')->paginate(10);
       // dd($data);
      $data22 = DB::connection('mysql_canasta')->table("barrios as b")
      ->select('b.barrio','b.idBarrio')
      //->distinct()
      ->get();
      //dd($data22);
      $data = CanastaBeneficiariosModel::query()
     // ->where('estado', 'B')
      ->orderBy('idUsuario', 'desc')
      ->paginate(10);
      //$data2=1000;
      return view('canasta.index', compact('data','data22'));
       //return view("canasta.index", ["data" => $data]);
    }


    public function search(Request $request)
    {


        $data = CanastaBeneficiariosModel::query()
            ->bynombres($request->nombres)
            ->byap($request->ap)
            ->byam($request->am)
            ->bydireccion($request->direccion)
            ->bydistrito($request->distrito)
            ->bybarrio($request->barrio)
            ->orderBy('idUsuario', 'desc')
            ->paginate(10);
            return view('canasta.index', compact('data'));
        //return view('activosVsiaf.index', compact('activos'));
    }


}
