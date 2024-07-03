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
use App\Models\Empleado;
use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BeneficiariosExcel;
use DataTables;
use DB;
use PDF;

class BeneficiariosV2Controller extends Controller
{
     private function copiarbeneficiarios()
     {
         $beneficiarios = DB::connection('mysql_canasta')
                                ->table("usuarios")
                                //->join('ocupaciones as o', 'o.id_ocupacion', '=', 'u.id_ocupacion')
                                // ->select('o.ocupacion','u.nombres')
                                ->where('idUsuario','>',14822)
                                //->where('idUsuario','<',12000)
                                ->get();

        foreach ($beneficiarios as $data){
            $datos = ([
                'id' => $data->idUsuario,
                'nombres' => $data->nombres,
                'ap' => $data->ap,
                'am' => $data->am,
                'ci' => $data->ci,
                'expedido' => $data->expedido,
                'fecha_nac' => $data->fecha_nac,
                'estado_civil' => $data->estado_civil,
                'sexo' => $data->sexo,
                'direccion' => $data->direccion,
                'dir_foto' => $data->dir_foto,
                'firma' => $data->firma,
                'obs' => $data->obs,
                'id_ocupacion' => $data->id_ocupacion,
                'id_barrio' => $data->id_barrio,
                'dea_id' => 1,
                'user_id' => 29,
                'created_att' => $data->_registrado,
                'updated_att' => $data->_modificado,
                'id_barrio' => $data->id_barrio,
                'estado' => $data->estado
            ]);
            $beneficiario=Beneficiario::create($datos);
        }
    }

    public function index(Request $request)
    {
         //$this->copiarbeneficiarios();
        if ($request->ajax()) {
            $data = DB::table('beneficiarios as a')
                    ->join('barrios as b','b.id','a.id_barrio')
                    ->select(
                        'a.id as beneficiario_id',
                        'a.nombres',
                        'a.ap',
                        'a.am',
                        DB::raw("CONCAT(a.ci,'-',a.expedido) as nro_carnet"),
                        'b.nombre as barrio',
                        'a.sexo',
                        'a.dir_foto',
                        'a.estado'
                    );

            return Datatables::of($data)
                            //->orderColumn('beneficiario_id', 'a.id $1')
                            ->addIndexColumn()
                            ->addColumn('columna_foto', 'canasta_v2.beneficiario.partials.columna-foto')
                            ->addColumn('columna_estado', 'canasta_v2.beneficiario.partials.columna-estado')
                            ->addColumn('columna_btn', 'canasta_v2.beneficiario.partials.columna-btn')
                            ->filterColumn('nro_carnet', function($query, $keyword) {
                                $sql = "CONCAT(a.ci, ' - ', a.expedido) like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->rawColumns(['columna_foto','columna_estado','columna_btn'])
                            ->make(true);
        }

        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $barrios = Barrio::where('dea_id',$dea_id)->pluck('nombre','nombre');
        $sexos = Beneficiario::SEXOS;
        $estados = Beneficiario::ESTADOS;

        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','sexos','estados','barrios'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $barrios = Barrio::where('dea_id',$dea_id)->pluck('nombre','nombre');
        $sexos = Beneficiario::SEXOS;
        $estados = Beneficiario::ESTADOS;
        $beneficiarios = Beneficiario::query()
                                        ->byDea($dea_id)
                                        ->byCodigo($request->codigo)
                                        ->byNombre($request->nombre)
                                        ->byApellidoPaterno($request->ap)
                                        ->byApellidoMaterno($request->am)
                                        ->byNumeroCarnet($request->ci)
                                        ->bySexo($request->sexo)
                                        ->byBarrio($request->barrio)
                                        ->byEstado($request->estado)
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','sexos','estados','beneficiarios','barrios'));
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $dea_id = Auth::user()->dea->id;
                $beneficiarios = Beneficiario::query()
                                                ->byDea($dea_id)
                                                ->byCodigo($request->codigo)
                                                ->byNombre($request->nombre)
                                                ->byApellidoPaterno($request->ap)
                                                ->byApellidoMaterno($request->am)
                                                ->byNumeroCarnet($request->ci)
                                                ->bySexo($request->sexo)
                                                ->byBarrio($request->barrio)
                                                ->byEstado($request->estado)
                                                ->orderBy('id', 'desc')
                                                ->get();
                $contador = $beneficiarios->count();
                if($contador >= 5000){
                    return redirect()->route('beneficiarios.index')->with('info_message', 'Los datos de la consulta exceden el limite permitido. Por favor comunicarse con el area de sistemas para resolver esta situacion');
                }

                return Excel::download(new BeneficiariosExcel($beneficiarios),'beneficiarios.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
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
        $beneficiario->fecha_nac = date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac)));
        $beneficiario->estado_civil = $request->estado_civil;
        $beneficiario->sexo = $request->sexo;
        $beneficiario->ci = $request->ci;
        $beneficiario->expedido = $request->expedido;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->firma = $request->firma;
        $beneficiario->estado = $request->estado;
        $beneficiario->obs = $request->observacion;
        $beneficiario->id_ocupacion = $request->ocupacion;
        $beneficiario->id_barrio = $request->barrio;
        $beneficiario->user_id = $id_usuario;
        $beneficiario->dea_id = $dea_id;
        $beneficiario->save();
        return redirect()->route('beneficiarios.index')->with('success_message', 'datos registrados correctamente...');
    }


    public function editar($idbeneficiario)
    {
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado','=',1)->get();
        $beneficiario = Beneficiario::find($idbeneficiario);

        return view('canasta_v2.beneficiario.editar',compact('barrios','ocupaciones','beneficiario'));
    }

    public function beneficiario_datos($idbeneficiario)
    {
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado','=',1)->get();
        $beneficiario = Beneficiario::find($idbeneficiario);

        return view('canasta_v2.beneficiario.beneficiario_datos',compact('barrios','ocupaciones','beneficiario'));
    }

    public function update2(Request $request)
    {

        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $newestUser = HistorialMod::orderBy('id', 'desc')->first();
        $maxId = $newestUser->id;

        $beneficiario = Beneficiario::find($request->idBeneficiario);
        $beneficiario->nombres = $request->nombres;
        $beneficiario->ap = $request->ap;
        $beneficiario->am = $request->am;
        $beneficiario->fecha_nac =  date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac)));
        $beneficiario->estado_civil = $request->estado_civil;
        $beneficiario->sexo = $request->sexo;
        $beneficiario->ci = $request->ci;
        $beneficiario->expedido = $request->expedido;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->firma = $request->firma;
        $beneficiario->estado = $request->estado;
        $beneficiario->id_ocupacion = $request->ocupacion;
        $beneficiario->id_barrio = $request->barrio;
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

        return redirect()->route('beneficiarios.index')->with('info_message', 'datos actualizados correctamente...');
    }

    public function update(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $newestUser = HistorialMod::orderBy('id', 'desc')->first();
        $maxId = $newestUser->id;

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

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
            $beneficiario->nombres = $request->nombres;
            $beneficiario->ap = $request->ap;
            $beneficiario->am = $request->am;
            $beneficiario->fecha_nac = date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac)));
            $beneficiario->estado_civil = $request->estado_civil;
            $beneficiario->sexo = $request->sexo;
            $beneficiario->ci = $request->ci;
            $beneficiario->expedido = $request->expedido;
            $beneficiario->direccion = $request->direccion;
            $beneficiario->firma = $request->firma;
            $beneficiario->estado = $request->estado;
            $beneficiario->dir_foto = '../imagenes/fotos/' . $nombre;;
            $beneficiario->id_ocupacion = $request->ocupacion;
            $beneficiario->id_barrio = $request->barrio;
            $beneficiario->user_id = $id_usuario;
            $beneficiario->dea_id = $dea_id;
            $beneficiario->update();
        } else {
            $beneficiario = Beneficiario::find($request->idBeneficiario);
            $beneficiario->nombres = $request->nombres;
            $beneficiario->ap = $request->ap;
            $beneficiario->am = $request->am;
            $beneficiario->fecha_nac = date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac)));
            $beneficiario->estado_civil = $request->estado_civil;
            $beneficiario->sexo = $request->sexo;
            $beneficiario->ci = $request->ci;
            $beneficiario->expedido = $request->expedido;
            $beneficiario->direccion = $request->direccion;
            $beneficiario->firma = $request->firma;
            $beneficiario->estado = $request->estado;
            $beneficiario->id_ocupacion = $request->ocupacion;
            $beneficiario->id_barrio = $request->barrio;
            $beneficiario->user_id = $id_usuario;
            $beneficiario->dea_id = $dea_id;
            $beneficiario->update();
        }

        $Historialmod = new HistorialMod();
        $Historialmod->id = $maxId + 1;
        $Historialmod->observacion = $request->observacion;
        $Historialmod->id_beneficiario = $request->idBeneficiario;
        $Historialmod->user_id = $id_usuario;
        $Historialmod->dea_id = $dea_id;
        $Historialmod->save();

        return redirect()->route('beneficiarios.index')->with('info_message', 'datos actualizados correctamente...');
    }
}
