<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpleadosModel;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Facebook;
use App\Models\FacePubli;
use App\Models\NivelModel;
use App\Models\PersonalFace;


use DB;
use PDF;


use App\Models\AreasModel;

class FacebookController extends Controller
{

    public function index()
    {

        //$this->copiardistritos();
        //$deas = Dea::pluck('nombre','id');
       // $estados = Distrito::ESTADOS;
        $facebook = Facebook::orderBy('id', 'desc')->paginate(10);
        return view('facebook.index', compact('facebook'));
    }

    public function create(Request $request)
    {


           $facebook = new Facebook();
           $facebook->fecha = $request->fecha;
           $facebook->publicacion = $request->publicacion;

           $facebook->save();

        return redirect()->route('facebook.index')->with($request->session()->flash('message', 'Registro Procesado'));

    }

    public function editar($id)

    {

        //$barrio = Barrio::find($id);
        //$distritos = Distrito::select('nombre','id')->where('dea_id',Auth::user()->dea->id)->get();
        //$tipos = Barrio::TIPOS;
        $facepubli1 = FacePubli::select('id_area')->where('id_facebook','=',$id)->pluck('id_area','id_area');
        $facepubli2 = FacePubli::All()->where('id_facebook','=',$id);

        //$areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
        $niveles = NivelModel::ALL()->pluck('nombrenivel','nombrenivel');

        if ($facepubli1->isEmpty()) {
            $areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
       } else {

            $areas = DB::table('areas')
            ->whereIn('idarea', $facepubli2->pluck('id_area'))
            //->select('idarea', 'nombrearea')
            ->pluck('nombrearea','nombrearea');
       }


       // dd($areas);
       // $facepubli = FacePubli::orderBy('id', 'desc')->paginate(10);

        $facepubli = FacePubli::where('id_facebook','=',$id)
         ->paginate(10);
        $estado1=0;
        if ($facepubli->isEmpty()) {
            $estado1=1;

          }


        $idfacebook=$id;
//dd($idd);
        return view('facebook.index2', compact('facepubli','idfacebook','areas','niveles','estado1'));
    }

    public function deshabilitar(Request $request,$id){

        $facepubli1 = FacePubli::select('id_area')->where('id_facebook','=',$id)->pluck('id_area','id_area');
        $facepubli2 = FacePubli::All()->where('id_facebook','=',$id);
        $idfacebook=$id;
        //$areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
        if ($facepubli1->isEmpty()) {
            $areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
       } else {

            $areas = DB::table('areas')
            ->whereIn('idarea', $facepubli2->pluck('id_area'))
            //->select('idarea', 'nombrearea')
            ->pluck('nombrearea','nombrearea');
       }

        $niveles = NivelModel::ALL()->pluck('nombrenivel','nombrenivel');
        $facePubli2 = FacePubli::find($id);
        $facePubli2->compartido = $request->compartido;
        $facePubli2->megusta = $request->megusta;
        $facePubli2->like = $request->like;

        $facePubli2->save();
        $facepubli = FacePubli::where('id_facebook','=',$id)
        ->paginate(10);
       $estado1=0;
       if ($facepubli->isEmpty()) {
           $estado1=1;
            }
        //return view('facebook.index2', compact('facepubli'));
        return back();


    }

    public function search(Request $request,$id)
    {
        $facepubli1 = FacePubli::select('id_area')->where('id_facebook','=',$id)->pluck('id_area','id_area');
        $facepubli2 = FacePubli::All()->where('id_facebook','=',$id);


        $idfacebook=$id;
        //$areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
        $niveles = NivelModel::ALL()->pluck('nombrenivel','nombrenivel');

        if ($facepubli1->isEmpty()) {
            $areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
       } else {

            $areas = DB::table('areas')
            ->whereIn('idarea', $facepubli2->pluck('id_area'))
            //->select('idarea', 'nombrearea')
            ->pluck('nombrearea','nombrearea');
       }

        $facepubli = FacePubli::query()

                            ->byNombre($request->nombre)
                            ->byAp($request->ap)
                            ->byAm($request->am)
                            ->byArea($request->area)
                            ->byNivel($request->nivell)
                            ->where('id_facebook','=',$id)
                            ->orderBy('id', 'desc')
                            ->paginate(10);
                            //dd($request->barrio);
        $estado1=0;
        //if ($facepubli->isEmpty()) {
          //  $estado1=1;
             //}
         return view('facebook.index2', compact('facepubli','idfacebook','areas','niveles','estado1'));
    }



    public function agregarEmpleados(Request $request,$id)
    {

        $facepubli1 = FacePubli::select('id_area')->where('id_facebook','=',$id)->pluck('id_area','id_area');
        $facepubli2 = FacePubli::All()->where('id_facebook','=',$id);

                        $empleados = DB::table('personalface as e')
                        ->join('areas as a', 'a.idarea', '=', 'e.idArea')
                        ->join('niveles as n', 'a.idnivel', '=', 'n.idnivel')
                        ->select('a.idarea', 'e.id','n.idnivel')
                        //-> where('d.idcompra','=', $id2)
                        //-> orderBy('e.idemp', 'desc')
                        ->get();
                        //dd($empleados);
                                        foreach ($empleados as $data){

                                        $datos=([

                                            'id_empleado'=>$data->id,
                                            'id_area'=>$data->idarea,
                                            'id_nivel'=>$data->idnivel,
                                            'id_facebook'=>$id,
                                            'compartido'=>2,
                                            'megusta'=>2,
                                            'like'=>2
                                                ]

                                                );
                                        $facePubli=FacePubli::CREATE($datos);
                                        }



                                        //$areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
                                        if ($facepubli1->isEmpty()) {
                                            $areas = AreasModel::ALL()->pluck('nombrearea','nombrearea');
                                       } else {

                                            $areas = DB::table('areas')
                                            ->whereIn('idarea', $facepubli2->pluck('id_area'))
                                            //->select('idarea', 'nombrearea')
                                            ->pluck('nombrearea','nombrearea');
                                       }
                                        $niveles = NivelModel::ALL()->pluck('nombrenivel','nombrenivel');



                                       // dd($areas);
                                       $facepubli = FacePubli::where('id_facebook','=',$id)
                                        ->paginate(10);
                                        $estado1=0;
                                        if ($facepubli->isEmpty()) {
                                            $estado1=1;

                                          }


                                $idfacebook=$id;
                                //dd($idd);
                                        return view('facebook.index2', compact('facepubli','idfacebook','areas','niveles','estado1'));

    }


}
