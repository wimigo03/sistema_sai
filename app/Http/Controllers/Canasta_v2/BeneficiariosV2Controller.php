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
                            //->orderBy('id', 'desc')
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
}
