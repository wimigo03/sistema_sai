<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\Ocupaciones;
use App\Models\Canasta\HistorialMod;
use App\Models\User;
use App\Models\EmpleadosModel;


use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BarriosExcel;
use DB;
use PDF;

class BeneficiariosV2Controller extends Controller
{

     private function copiarbeneficiarios()
    {
         $beneficiarios = DB::connection('mysql_canasta')->table("usuarios")
         //->join('ocupaciones as o', 'o.idOcupacion', '=', 'u.idOcupacion')
        // ->select('o.ocupacion','u.nombres')
        ->where('idUsuario','>',13408)
         ->get();

       //dd($beneficiarios);
        foreach ($beneficiarios as $data){

            $datos=([

                'id'=>$data->idUsuario,
                'nombres'=>$data->nombres,
                'ap'=>$data->ap,
                'am'=>$data->am,
                'ci'=>$data->ci,
                'expedido'=>$data->expedido,
                'fechaNac'=>$data->fechaNac,
                'estadoCivil'=>$data->estadoCivil,
                'sexo'=>$data->sexo,
                'direccion'=>$data->direccion,
                'dirFoto'=>$data->dirFoto,
                'firma'=>$data->firma,
                'obs'=>$data->obs,
                'idOcupacion'=>$data->idOcupacion,
                'idBarrio'=>$data->idBarrio,
                'dea_id'=>1,
                'user_id'=>16,
                'created_att'=>$data->_registrado,
                'updated_att'=>$data->_modificado,
                'idBarrio'=>$data->idBarrio,
                'estado'=>$data->estado
                      ]


                     );
              $beneficiario=Beneficiario::CREATE($datos);
    }

    }


    public function index()
    {
         //$this->copiarbeneficiarios();
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
        $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');
        $estados = Beneficiario::ESTADOS;
        $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
        //->where('dirFoto','=',"../imagenes/fotos/1431100307.jpg")
                            ->orderBy('id', 'desc')
                            ->paginate(10);
                            //dd($barrios);
        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','deas','estados','beneficiarios','barrios'));
    }

    public function search(Request $request)
    {

       //dd($request->barrio);
      // $barrrio='HEROES DEL CHACO';
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
        $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');
        $estados = Beneficiario::ESTADOS;
        $beneficiarios = Beneficiario::query()
                            ->byCodigo($request->codigo)
                            ->byCi($request->ci)
                            ->byNombre($request->nombre)
                            ->byBarrio($request->barrio)
                            ->byAp($request->ap)
                            ->byAm($request->am)
                            ->byDea($request->dea_id)
                            ->byUsuario($request->usuario)
                            ->byEstado($request->estado)
                            ->where('dea_id',Auth::user()->dea->id)
                            ->orderBy('id', 'desc')
                            ->paginate(10);
                            //dd($request->barrio);

        return view('canasta_v2.beneficiario.index', compact('tipos','barrios','deas','estados','beneficiarios'));
    }

    public function create()
    {
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado','=',1)->get();

        return view('canasta_v2.beneficiario.create',compact('barrios','ocupaciones'));
    }


    public function store(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $newestUser = Beneficiario::orderBy('id', 'desc')->first();
        $maxId = $newestUser->id;

                                    $beneficiario = new Beneficiario();
                                    $beneficiario->id = $maxId + 1;
                                    $beneficiario->nombres = $request->nombres;
                                    $beneficiario->ap = $request->ap;
                                    $beneficiario->am = $request->am;
                                    $beneficiario->fechaNac = $request->fnac;
                                    $beneficiario->estadoCivil = $request->estadoCivil;
                                    $beneficiario->sexo = $request->sexo;
                                    $beneficiario->ci = $request->ci;
                                    $beneficiario->expedido = $request->expedido;
                                    $beneficiario->direccion = $request->direccion;
                                    $beneficiario->firma = $request->firma;
                                    $beneficiario->estado = $request->estado;
                                    $beneficiario->obs = $request->observacion;
                                    $beneficiario->idOcupacion = $request->ocupacion;
                                    $beneficiario->idBarrio = $request->barrio;
                                    $beneficiario->user_id = $id_usuario;
                                    $beneficiario->dea_id = $dea_id;


                                    $beneficiario->save();

                                    $tipos = Barrio::TIPOS;
                                    $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
                                    $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
                                    $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');
                                    $estados = Beneficiario::ESTADOS;
                                    $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                                                        //->orderBy('id', 'desc')
                                                        ->paginate(10);
                                                        //dd($barrios);
                                                        return redirect()->route('beneficiarios.index', compact('tipos','distritos','deas','estados','beneficiarios','barrios'));
}


public function editar($idbeneficiario)
{
    $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
    $ocupaciones = Ocupaciones::where('estado','=',1)->get();
    $beneficiario = Beneficiario::find($idbeneficiario);

    return view('canasta_v2.beneficiario.editar',compact('barrios','ocupaciones','beneficiario'));
}

public function update2(Request $request)
{

    $personal = User::find(Auth::user()->id);
    $id_usuario = $personal->id;
    $dea_id = $personal->dea_id;
    $newestUser = HistorialMod::orderBy('id', 'desc')->first();
    $maxId = $newestUser->id;

    //dd($maxId);
                                //dd($request->idBeneficiario);
                                $beneficiario = Beneficiario::find($request->idBeneficiario);
                                //$beneficiario = new Beneficiario();
                                $beneficiario->nombres = $request->nombres;
                                $beneficiario->ap = $request->ap;
                                $beneficiario->am = $request->am;
                                $beneficiario->fechaNac = $request->fnac;
                                $beneficiario->estadoCivil = $request->estadoCivil;
                                $beneficiario->sexo = $request->sexo;
                                $beneficiario->ci = $request->ci;
                                $beneficiario->expedido = $request->expedido;
                                $beneficiario->direccion = $request->direccion;
                                $beneficiario->firma = $request->firma;
                                $beneficiario->estado = $request->estado;
                                //$beneficiario->obs = $request->observacion;
                                $beneficiario->idOcupacion = $request->ocupacion;
                                $beneficiario->idBarrio = $request->barrio;
                                $beneficiario->user_id = $id_usuario;
                                $beneficiario->dea_id = $dea_id;
                                $beneficiario->save();


                                $Historialmod = new HistorialMod();
                                $Historialmod->id = $maxId + 1;
                                    $Historialmod->observacion = $request->observacion;
                                    $Historialmod->id_beneficiario = $request->idBeneficiario;
                                    $Historialmod->user_id = 16;
                                    $Historialmod->dea_id = 1;
                                    $Historialmod->save();

                                $tipos = Barrio::TIPOS;
                                $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
                                $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
                                $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');
                                $estados = Beneficiario::ESTADOS;
                                $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                                                    //->orderBy('id', 'desc')
                                                    ->paginate(10);
                                                    //dd($barrios);
                                                    return redirect()->route('beneficiarios.index', compact('tipos','distritos','deas','estados','beneficiarios','barrios'));
}


public function update(Request $request)
{

//dd($request->documento);
              $personal = User::find(Auth::user()->id);
              $id_usuario = $personal->id;
              $dea_id = $personal->dea_id;

        $newestUser = HistorialMod::orderBy('id', 'desc')->first();
        $maxId = $newestUser->id;

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        //dd($userdate);

        if ($request->file("documento") != null) {
            if ($request->hasFile("documento")) {
                $file = $request->file("documento");
                $file_name = $file->getClientOriginalName();
                $nombre = time() . "." . $file->guessExtension();

                $ruta = public_path("/imagenes/fotos/". $nombre);

                if ($file->guessExtension() == "jpg") {
                    copy($file, $ruta);
                } else {
                    return back()->with(["error" => "File not available!"]);
                }
            }


        $beneficiario = Beneficiario::find($request->idBeneficiario);
        //$beneficiario = new Beneficiario();
        $beneficiario->nombres = $request->nombres;
        $beneficiario->ap = $request->ap;
        $beneficiario->am = $request->am;
        $beneficiario->fechaNac = $request->fnac;
        $beneficiario->estadoCivil = $request->estadoCivil;
        $beneficiario->sexo = $request->sexo;
        $beneficiario->ci = $request->ci;
        $beneficiario->expedido = $request->expedido;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->firma = $request->firma;
        $beneficiario->estado = $request->estado;
        $beneficiario->dirFoto = '../imagenes/fotos/' . $nombre;;
        $beneficiario->idOcupacion = $request->ocupacion;
        $beneficiario->idBarrio = $request->barrio;
        $beneficiario->user_id = $id_usuario;
        $beneficiario->dea_id = $dea_id;
        $beneficiario->save();


    } else {




        $beneficiario = Beneficiario::find($request->idBeneficiario);
        //$beneficiario = new Beneficiario();
        $beneficiario->nombres = $request->nombres;
        $beneficiario->ap = $request->ap;
        $beneficiario->am = $request->am;
        $beneficiario->fechaNac = $request->fnac;
        $beneficiario->estadoCivil = $request->estadoCivil;
        $beneficiario->sexo = $request->sexo;
        $beneficiario->ci = $request->ci;
        $beneficiario->expedido = $request->expedido;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->firma = $request->firma;
        $beneficiario->estado = $request->estado;

        $beneficiario->idOcupacion = $request->ocupacion;
        $beneficiario->idBarrio = $request->barrio;
        $beneficiario->user_id = $id_usuario;
        $beneficiario->dea_id = $dea_id;
        $beneficiario->save();
    }


    $Historialmod = new HistorialMod();
    $Historialmod->id = $maxId + 1;
        $Historialmod->observacion = $request->observacion;
        $Historialmod->id_beneficiario = $request->idBeneficiario;
        $Historialmod->user_id = $id_usuario;
        $Historialmod->dea_id = $dea_id;
        $Historialmod->save();

    $tipos = Barrio::TIPOS;
    $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
    $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
    $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');
    $estados = Beneficiario::ESTADOS;
    $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                        //->orderBy('id', 'desc')
                        ->paginate(10);
                        //dd($barrios);
                        return redirect()->route('beneficiarios.index', compact('tipos','distritos','deas','estados','beneficiarios','barrios'));


    //return redirect()->action('App\Http\Controllers\ArchivosController@index');
}

}
