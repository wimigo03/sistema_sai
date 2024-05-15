<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Empleado;
use App\Models\Area;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use DataTables;
use PDF;

use App\Models\Transporte\UnidaddConsumoModel;
use App\Models\Transporte\DoUconsumoModel;


class UnidaddConsumoController extends Controller
{
    public function index(Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {

        $consumos = DB::table('unidadconsumo as u')

                        ->join('tipomovilidad as t', 't.idtipomovilidad', '=', 'u.idtipomovilidad')
                        ->join('programacomb as prog', 'prog.idprogramacomb', '=', 'u.idprogramacomb')

                        ->join('areas as a', 'a.idarea', '=', 'u.idarea')
                        ->where('u.estadoconsumo',1)
                        ->select('u.idunidadconsumo','u.nombreuconsumo','u.codigoconsumo','u.desconsumo',
                        'u.colorconsumo','u.marcaconsumo','u.modeloconsumo',
                        'u.placaconsumo','u.kilometrajeinicialconsumo','u.documento',

                        't.nombremovilidad','a.nombrearea','prog.nombreprograma'

                        )->orderBy('u.idunidadconsumo', 'desc');

                        return Datatables::of($consumos)
                        ->addIndexColumn()
                        ->addColumn('btn', 'transportes.uconsumo.btn')
                        ->addColumn('btn2', 'transportes.uconsumo.btn2')
                        ->rawColumns(['btn','btn2'])
                        ->make(true);

                    }
$personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;
            return view('transportes.uconsumo.index',
            ['idd'=>$personalArea]);

    }

    public function index2(Request $request){


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

        if ($request->ajax()) {

        $consumos = DB::table('unidadconsumo as u')

                        ->join('tipomovilidad as t', 't.idtipomovilidad', '=', 'u.idtipomovilidad')
                        ->join('programacomb as prog', 'prog.idprogramacomb', '=', 'u.idprogramacomb')

                        ->join('areas as a', 'a.idarea', '=', 'u.idarea')


                        ->where('u.estadoconsumo',2)
                        ->select('u.idunidadconsumo','u.nombreuconsumo','u.codigoconsumo','u.fechasalida',
                        'u.colorconsumo','u.marcaconsumo','u.modeloconsumo',
                        'u.placaconsumo','u.fecharetorno',

                        't.nombremovilidad','a.nombrearea','prog.nombreprograma'

                        )->orderBy('u.idunidadconsumo', 'asc');

                        return Datatables::of($consumos)
                        ->addIndexColumn()
                        ->addColumn('btn3', 'transportes.uconsumo.btn3')

                        ->rawColumns(['btn3'])
                        ->make(true);

                    }

                    $personal = User::find(Auth::user()->id);
                    $id = $personal->id;
                    $userdate = User::find($id)->usuariosempleados;
                    $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

            return view('transportes.uconsumo.index2', ['idd' => $personalArea]);

    }




    public function create(){



        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;


         $areas = DB::table('areas')
         ->where('estadoarea',1)
         ->pluck('nombrearea','idarea');


         $tipos = DB::table('tipomovilidad')
         ->where('estadomovilidad',1)
         ->pluck('nombremovilidad','idtipomovilidad');



         $programas = DB::table('programacomb')
         ->where('estadoprograma',1)
         ->pluck('nombreprograma','idprogramacomb');



         return view('transportes.uconsumo.create',
         compact('areas','tipos',
         'programas','personalArea'));



    }

    public function store(Request $request){

        try{
            ini_set('memory_limit','-1');
           ini_set('max_execution_time','-1');
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;


        if ($request->hasFile("documento")) {
            $file = $request->file("documento");

            $file_name = $file->getClientOriginalName();
            $nombre = "img_" . time() . "." . $file->guessExtension();

            $ruta = public_path("/Imagenes/" . $personalArea->nombrearea . '/' . $nombre);

            if (in_array($file->guessExtension(), ['jpg', 'jpeg', 'png', 'gif','WEBP'])) {
                copy($file, $ruta);
            } else {
                return back()->with(["error" => "File not available!"]);
            }
        }


        $consumos = new UnidaddConsumoModel();
        $consumos->codigoconsumo = $request->input('codigoc');
        $consumos->nombreuconsumo = $request->input('nombreuconsumo');
        $consumos->desconsumo = $request->input('desconsumo');

        $consumos->colorconsumo = $request->input('colorc');

        $consumos->marcaconsumo = $request->input('marcac');
        $consumos->modeloconsumo = $request->input('modeloc');
        $consumos->placaconsumo = $request->input('placac');
        $consumos->kilometrajeinicialconsumo = $request->input('klminicialc');

        $consumos->idarea = $personalArea->idarea;
        $consumos->idtipomovilidad = $request->input('idtipomovilidad');
        $consumos->idprogramacomb = $request->input('idprograma');
        $consumos->idusuario = $personal->id;
        $consumos->estadoconsumo = 1;

        $consumos->kilometrajefinalconsumo = $request->input('klmfinal');
        $consumos->gasporklm = $request->input('gasklm');

        $consumos->documento = $personalArea->nombrearea . '/' . $nombre;


        $consumos->save();

        return redirect()->action('App\Http\Controllers\Transporte\UnidaddConsumoController@index');

        } catch (\Throwable $th){
         return '[ERROR_500]';
        }finally{
        ini_restore('memory_limit');
        ini_restore('max_execution_time');
         }
    }


    public function editar($idunidadconsumo){
        $consumos = UnidaddConsumoModel::find($idunidadconsumo);

        $tipos = DB::table('tipomovilidad')->get();

        $areas = DB::table('areas')->get();
        $programas = DB::table('programacomb')->get();



        $personal = User::find(Auth::user()->id);
        $id = $personal->id;

        return view('transportes.uconsumo.editar',
        ["id" => $id,

        "consumos" => $consumos,
        "tipos" => $tipos,
        "areas" => $areas,
        "programas" => $programas]);
    }

    public function update(Request $request){

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;


        $consumos = UnidaddConsumoModel::find($request->idunidadconsumo);

        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = "img_" . time() . "." . $file->guessExtension();

                $ruta = public_path("/Imagenes/" . $personalArea->nombrearea . '/' . $nombre);

                if (in_array($file->guessExtension(), ['jpg', 'jpeg', 'png', 'gif','WEBP'])) {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }

        $consumos->codigoconsumo = $request->input('codigoc');

        $consumos->nombreuconsumo = $request->input('nombreuconsumo');

        $consumos->desconsumo = $request->input('desconsumo');
        $consumos->colorconsumo = $request->input('colorc');
        $consumos->marcaconsumo = $request->input('marcac');
        $consumos->modeloconsumo = $request->input('modeloc');
        $consumos->placaconsumo = $request->input('placac');
        $consumos->kilometrajeinicialconsumo = $request->input('klminicialc');

        $consumos->gasporklm = $request->input('gasklm');
        $consumos->kilometrajefinalconsumo = $request->input('klmfinal');

        $consumos->idarea = $personalArea->idarea;
        $consumos->idtipomovilidad = $request->input('idtipomovilidad');
        $consumos->idprogramacomb = $request->input('idprograma');
        $consumos->idusuario =$personal->id;
        $consumos->documento = $personalArea->nombrearea . '/' . $nombre;

        $consumos->save();
    } else {

        $consumos->codigoconsumo = $request->input('codigoc');

        $consumos->nombreuconsumo = $request->input('nombreuconsumo');

        $consumos->desconsumo = $request->input('desconsumo');
        $consumos->colorconsumo = $request->input('colorc');
        $consumos->marcaconsumo = $request->input('marcac');
        $consumos->modeloconsumo = $request->input('modeloc');
        $consumos->placaconsumo = $request->input('placac');
        $consumos->kilometrajeinicialconsumo = $request->input('klminicialc');

        $consumos->gasporklm = $request->input('gasklm');
        $consumos->kilometrajefinalconsumo = $request->input('klmfinal');

        $consumos->idarea = $personalArea->idarea;
        $consumos->idtipomovilidad = $request->input('idtipomovilidad');
        $consumos->idprogramacomb = $request->input('idprograma');
        $consumos->idusuario =$personal->id;
        $consumos->save();

    }

    return redirect()->action('App\Http\Controllers\Transporte\UnidaddConsumoController@index');
}






// primero es el boton btn2 de ahi manda el id de unidadconsumo
// luego es la funcion del controlador  que lo manda aqui editardoc que recibe el id
    public function editardoc($idunidadconsumo){

        // crea un nuevo modelo y selecciona las relaciones y tablas
        $docuconsumo = DB::table('docuconsumo as d')

        ->join('unidadconsumo as u', 'u.idunidadconsumo', '=', 'd.idunidadconsumo')

        ->select('d.nombredocumento','d.iddocuconsumo','d.documento')

        // ya le da el id de unidadconsumo a docunidadconsumo con el where
        -> where('d.idunidadconsumo','=', $idunidadconsumo)
        ->get();

        //  retorna la vista o el index
         return view('transportes.uconsumo.docuconsumo',
        //  manda la variable docuconsumo que es el nuevo modelo y el id de unidadconsumo
         ['docuconsumo' => $docuconsumo,
         'idunidadconsumo' => $idunidadconsumo]);}



        //  createdoc es el boton para crear un nuevo documento
public function createdoc($idunidadconsumo){

             return view('transportes.uconsumo.createdocuconsumo',
              ['idunidadconsumo' => $idunidadconsumo]);}



public function insertar(Request $request){

    $personal = User::find(Auth::user()->id);
    $id = $personal->id;
    $userdate = User::find($id)->usuariosempleados;
    $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

   $idunidadconsumo=$request->input('consumo');

   if($request->hasFile("documento")){
    $file=$request->file("documento");
    $file_name = $file->getClientOriginalName();
    $nombre = "pdf_".time().".".$file->guessExtension();

    $ruta = public_path("/Archivos/" . $personalArea->nombrearea . '/' . $nombre);

    if($file->guessExtension() == "pdf"){
        copy($file, $ruta);
    }else{
        return back()->with(["error" => "File not available!"]);

    }
}
   $docuconsumo = new DoUconsumoModel();
   $docuconsumo -> nombredocumento = $request->input('nombredocumento');
   $docuconsumo -> documento = $personalArea->nombrearea . '/' . $nombre;
   $docuconsumo -> idunidadconsumo =$idunidadconsumo;
   $docuconsumo -> estadodocuconsumo = 1;


   $docuconsumo->save();


   return redirect()->action('App\Http\Controllers\Transporte\UnidadConsumoController@editardoc',
    [$idunidadconsumo]);
}


public function aprovar($id)
{
    $detalle = UnidaddConsumoModel::find($id);
    $detalle->estadoconsumo = 1;
    $detalle->save();
    return redirect()->route('transportes.uconsumo.index2');
}
}

