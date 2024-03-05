<?php

namespace App\Http\Controllers\sereges;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sereges\AlbergueModel;
use App\Models\sereges\UserAlbergueModel;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\sereges\SeregesModel;
use App\Models\sereges\FotoRegistroModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Canasta\Dea;
use Carbon\Carbon;

class SeregesController extends Controller
{
////////ingresa al modulo albergue ///////
    public function index()
    {


        return view('sereges.albergue_index')->with(['albergue'=> AlbergueModel::where('estado', '=', 1)->paginate(15),'deas'=>Dea::pluck('descripcion','id')]);

    }
/////////crea albergue ///////
    public function create(Request $request)
    {
            $tipo='';
            if ($request->tipo == 1) {
            $tipo='ALBERGUE';
            } else if( $request->tipo == 2) {
                $tipo='HOGAR';
            };

           $albergue = new AlbergueModel();
           $albergue->nombre = $request->nombre;
           $albergue->dea_id = $request->dea;
           $albergue->tipo = $request->tipo;
           $albergue->nombre_tipo = $tipo;
           $albergue->estado = 1;
           $albergue->save();

        return redirect()->route('sereges.albergue_index')->with($request->session()->flash('message', 'Registro Procesado'));

    }
///////////actualiza albergue /////////////
    public function update(Request $request,  $idalbergue)
    {
        $tipo='';
        if ($request->tipo == 1) {
        $tipo='ALBERGUE';
        } else if( $request->tipo == 2) {
            $tipo='HOGAR';
        };
        $albergue = AlbergueModel::find($idalbergue);
        $albergue->nombre = $request->nombre;
        $albergue->dea_id = $request->dea;
        $albergue->tipo = $request->tipo;
        $albergue->nombre_tipo = $tipo;
        $albergue->estado = 1;
        $albergue->save();

     return redirect()->route('sereges.albergue_index')->with($request->session()->flash('message', 'Registro Procesado'));
    }

////// ingresa al modulo registro /////

   public function registro_index()
   {
    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $albergue=UserAlbergueModel::where('id_user', '=', $id)->first();
    $albergue2 = AlbergueModel::where('id', '=',$albergue->id_albergue)->first();
    //dd( $albergue2->nombre);


       return view('sereges.registro_index')->with(['sereges'=> SeregesModel::where('estado', '=', 1)->where('id_albergue','=',$albergue->id_albergue)->paginate(15),
       'deas'=>Dea::pluck('descripcion','id'),
       'nombre_albergue'=>$albergue2->nombre,
       'nombre_tipo'=>$albergue2->nombre_tipo,
       'tipo'=>$albergue2->tipo]);

   }

/////////// crea registro ////////////
   public function createRegistro(Request $request)
   {
             ////datos de usuario logueado//
         $personal = User::find(Auth::user()->id);
         $id = $personal->id;
         $albergue=UserAlbergueModel::where('id_user', '=', $id)->first();
         //dd( $albergue->id_albergue);
             /////////////////////////////

             ///calculando la edad segun fecha de nacimiento//
        $date = Carbon::createFromDate($request->fnacimiento)->age;


            // dd($date);

          $registro = new SeregesModel();
          $registro->id_albergue = $albergue->id_albergue;
          $registro->ncodigo = $request->ncodigo;
          $registro->nurej = $request->nurej;
          $registro->cud = $request->cud;
          $registro->nombres = $request->nombres;
          $registro->apellidos = $request->apellidos;
          $registro->nacionalidad = $request->nacionalidad;
          $registro->edad = $date;
          $registro->sexo = $request->sexo;
          $registro->fnacimiento = $request->fnacimiento;
          $registro->fingreso = $request->fingreso;

          $registro->estado = 1;
          $registro->save();

       return redirect()->route('sereges.registro_index')->with($request->session()->flash('message', 'Registro Procesado'));

   }
///////////actualiza registro ///////////
   public function updateRegistro(Request $request,$idregistro)
   {
             ////datos de usuario logueado//
         $personal = User::find(Auth::user()->id);
         $id = $personal->id;
         $albergue=UserAlbergueModel::where('id_user', '=', $id)->first();
         //dd( $albergue->id_albergue);
             /////////////////////////////

             ///calculando la edad segun fecha de nacimiento//
        $date = Carbon::createFromDate($request->fnacimiento)->age;


            // dd($date);
            $registro = SeregesModel::find($idregistro);
          //$registro = new SeregesModel();
          $registro->id_albergue = $albergue->id_albergue;
          $registro->ncodigo = $request->ncodigo;
          $registro->nurej = $request->nurej;
          $registro->cud = $request->cud;
          $registro->nombres = $request->nombres;
          $registro->apellidos = $request->apellidos;
          $registro->nacionalidad = $request->nacionalidad;
          $registro->edad = $date;
          $registro->sexo = $request->sexo;
          $registro->fnacimiento = $request->fnacimiento;
          $registro->fingreso = $request->fingreso;

          $registro->estado = 1;
          $registro->save();

         return redirect()->route('sereges.registro_index')->with($request->session()->flash('message', 'Registro Procesado'));

   }
////////ingresa al modulo de fotografias/////
   public function foto_index($idregistro)
   {
   // $foto= FotoRegistroModel::all();
   $registro = SeregesModel::find($idregistro);
       return view('sereges.foto_index')->with([
       'deas'=>Dea::pluck('descripcion','id'),
       'idregistro'=>($idregistro),
       'registro'=> $registro,
       'foto'=> FotoRegistroModel::where('id_sereges', '=', $idregistro)
       ->where('tipo', '=', 1)
       ->paginate(15)]);

   }


////////////cargar fotografia //////////////////
   public function insertarFoto(Request $request,$idregistro)
   {




       if ($request->hasFile("documento")) {
           $file = $request->file("documento");
           $file_name = $file->getClientOriginalName();
           $nombre = "archivo_" . time() . "." . $file->guessExtension();

           $ruta = public_path("/sereges/fotos/" . $nombre);

           if ($file->guessExtension() == "jpg") {
               copy($file, $ruta);
           } else {
               return back()->with(["error" => "File not available!"]);
           }
       }


       $date = Carbon::now();
       //dd($idregistro);
       //$nombre2='hola';
       $archivos = new FotoRegistroModel();
       $archivos->detalle = $request->input('nombre');
       $archivos->id_sereges = $idregistro;
       $archivos->ruta = $nombre;
       $archivos->fecha = $date;
       $archivos->estado = 1;
       $archivos->tipo = 1;


       $archivos->save();

       return redirect()->route('sereges.foto_index',$idregistro)->with($request->session()->flash('message', 'Registro Procesado'));
      // return redirect()->action('App\Http\Controllers\sereges\SeregesController@foto_index');

   }


   public function ingreso_index($idregistro)
   {
   // $foto= FotoRegistroModel::all();
   $registro = SeregesModel::find($idregistro);
       return view('sereges.ingreso_index')->with([
       'deas'=>Dea::pluck('descripcion','id'),
       'idregistro'=>($idregistro),
       'registro'=> $registro,
       'foto'=> FotoRegistroModel::where('id_sereges', '=', $idregistro)
       ->where('tipo', '=', 2)
       ->paginate(15)]);

   }


   ////////////cargar pdf ingreso //////////////////
   public function insertarpdfingreso(Request $request,$idregistro)
   {




       if ($request->hasFile("documento")) {
           $file = $request->file("documento");
           $file_name = $file->getClientOriginalName();
           $nombre = "archivo_" . time() . "." . $file->guessExtension();

           $ruta = public_path("/sereges/documentos/" . $nombre);

           if ($file->guessExtension() == "pdf") {
               copy($file, $ruta);
           } else {
               return back()->with(["error" => "File not available!"]);
           }
       }


       $date = Carbon::now();
       //dd($idregistro);
       //$nombre2='hola';
       $archivos = new FotoRegistroModel();
       $archivos->detalle = $request->input('nombre');
       $archivos->id_sereges = $idregistro;
       $archivos->ruta = $nombre;
       $archivos->fecha = $date;
       $archivos->estado = 1;
       $archivos->tipo = 2;


       $archivos->save();

       return redirect()->route('sereges.ingreso_index',$idregistro)->with($request->session()->flash('message', 'Registro Procesado'));
      // return redirect()->action('App\Http\Controllers\sereges\SeregesController@foto_index');

   }


}
