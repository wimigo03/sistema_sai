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
use App\Models\Canasta\HistorialBaja;
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

    private function copiarbeneficiarios2()
    {
        $beneficiarios = DB::connection('mysql_canasta')
                               ->table("beneficiarios")
                               //->join('ocupaciones as o', 'o.id_ocupacion', '=', 'u.id_ocupacion')
                               // ->select('o.ocupacion','u.nombres')
                               ->where('id','=',1)
                               //->where('idUsuario','<',12000)
                               ->get();

       foreach ($beneficiarios as $data){
           $datos = ([
              // 'id' => $data->idUsuario,
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

    private function actualizar_distritos(){
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $beneficiarios = Beneficiario::where('distrito_id',null)->get();
            foreach($beneficiarios as $datos){
                $barrio = Barrio::select('distrito_id')->where('id',$datos->id_barrio)->first();
                $beneficiario = Beneficiario::find($datos->id);
                $beneficiario->update([
                    'distrito_id' => $barrio->distrito_id
                ]);
            }
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
        dd("Finalizado...");
    }

    private function actualizar_historial(){
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $historials = HistorialMod::get();
            foreach($historials as $datos){
                $historial = HistorialMod::find($datos->id);
                $historial->update([
                    'fecha' => $historial->created_at
                ]);
            }

            $historial_baja = DB::table('historialbaja')->get();
            foreach($historial_baja as $baja){
                $newestUser = HistorialMod::orderBy('id', 'desc')->first();
                $maxId = $newestUser->id + 1;
                $data = ([
                    'id' => $maxId,
                    'observacion' => $baja->observacion,
                    'id_beneficiario' => $baja->id_beneficiario,
                    'user_id' => $baja->user_id,
                    'dea_id' => $baja->dea_id,
                    'fecha' => $baja->created_at
                ]);

                $baja_historial = HistorialMod::create($data);
            }

        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
        dd("actualizar_historial Finalizado...");
    }

    public function index(Request $request)
    {
        /*if(Auth::user()->dea->id == 1){
            $this->copiarbeneficiarios();
            $this->actualizar_distritos();
            $this->actualizar_historial();
        }*/

        if ($request->ajax()) {
            $data = DB::table('beneficiarios as a')
                    ->join('barrios as b','b.id','a.id_barrio')
                    ->join('distritos as c','c.id','a.distrito_id')
                    ->select(
                        'a.id as beneficiario_id',
                        'c.nombre as distrito',
                        'a.nombres',
                        'a.ap',
                        'a.am',
                        DB::raw("CONCAT(a.ci,'-',a.expedido) as nro_carnet"),
                        'b.nombre as barrio',
                        'a.sexo',
                        DB::raw("DATE_PART('year',AGE(a.fecha_nac)) as edad"),
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
                            ->filterColumn('edad', function($query, $keyword) {
                                $sql = "DATE_PART('year',AGE(a.fecha_nac))::text like ?";
                                $query->whereRaw($sql, ["$keyword"]);
                            })
                            ->rawColumns(['columna_foto','columna_estado','columna_btn'])
                            ->make(true);
        }

        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $barrios = DB::table('barrios')
                            ->where('dea_id',$dea_id)
                            ->orderBy('id','asc')
                            ->pluck('nombre','id');
        $sexos = Beneficiario::SEXOS;
        $estados = Beneficiario::ESTADOS;

        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','barrios','sexos','estados'));
    }

    public function getBarrios(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $barrios = Barrio::select('nombre','id')
                            ->where('distrito_id',$id)
                            ->where('estado','1')
                            ->orderBy('id','asc')
                            ->get()
                            ->toJson();
            if($barrios){
                return response()->json([
                    'barrios' => $barrios
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $barrios = DB::table('barrios')
                            ->where('dea_id',$dea_id)
                            ->orderBy('id','asc')
                            ->pluck('nombre','id');
        $sexos = Beneficiario::SEXOS;
        $estados = Beneficiario::ESTADOS;
        $beneficiarios = Beneficiario::query()
                                        ->byDea($dea_id)
                                        ->byDistrito($request->distrito)
                                        ->byBarrio($request->barrio)
                                        ->byCodigo($request->codigo)
                                        ->byNombre($request->nombre)
                                        ->byApellidoPaterno($request->ap)
                                        ->byApellidoMaterno($request->am)
                                        ->byNumeroCarnet($request->ci)
                                        ->bySexo($request->sexo)
                                        ->byEdad($request->edad_inicial, $request->edad_final)
                                        ->byEstado($request->estado)
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','barrios','sexos','estados','beneficiarios'));
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $dea_id = Auth::user()->dea->id;
                $beneficiarios = Beneficiario::query()
                                                ->byDea($dea_id)
                                                ->byDistrito($request->distrito)
                                                ->byBarrio($request->barrio)
                                                ->byCodigo($request->codigo)
                                                ->byNombre($request->nombre)
                                                ->byApellidoPaterno($request->ap)
                                                ->byApellidoMaterno($request->am)
                                                ->byNumeroCarnet($request->ci)
                                                ->bySexo($request->sexo)
                                                ->byEdad($request->edad_inicial, $request->edad_final)
                                                ->byEstado($request->estado)
                                                ->orderBy('id', 'desc')
                                                ->get();
                /*$contador = $beneficiarios->count();
                if($contador >= 5000){
                    return redirect()->route('beneficiarios.index')->with('info_message', 'Los datos de la consulta exceden el limite permitido. Por favor comunicarse con el area de sistemas para resolver esta situacion');
                }*/

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
        $ocupaciones = Ocupaciones::where('estado',1)->get();

        return view('canasta_v2.beneficiario.create',compact('barrios','ocupaciones'));
    }

    public function store(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $newestUser = Beneficiario::orderBy('id', 'desc')->first();
        $maxId = $newestUser->id;

        $barrio = Barrio::select('distrito_id')->where('id',$request->barrio)->first();
        $beneficiario = new Beneficiario();
        $beneficiario->id = $maxId + 1;
        $beneficiario->nombres = $request->nombres;
        $beneficiario->ap = $request->ap;
        $beneficiario->am = $request->am;
        $beneficiario->fecha_nac = date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac)));
        $beneficiario->estado_civil = $request->estado_civil;
        $beneficiario->sexo = $request->sexo;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->firma = $request->firma;
        $beneficiario->obs = $request->observacion;
        $beneficiario->estado = $request->estado;
        $beneficiario->id_barrio = $request->barrio;
        $beneficiario->user_id = $id_usuario;
        $beneficiario->dea_id = $dea_id;
        $beneficiario->ci = $request->ci;
        $beneficiario->expedido = $request->expedido;
        $beneficiario->id_ocupacion = $request->ocupacion;
        $beneficiario->distrito_id = $barrio->distrito_id;
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

    public function show($idbeneficiario)
    {
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado',1)->get();
        $beneficiario = Beneficiario::find($idbeneficiario);
        $historial = HistorialMod::where('id_beneficiario',$idbeneficiario)->orderBy('fecha','desc')->get();

        return view('canasta_v2.beneficiario.show',compact('barrios','ocupaciones','beneficiario','historial'));
    }

    public function pdf($beneficiario_id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $beneficiario = Beneficiario::find($beneficiario_id);
                $historial = HistorialMod::where('id_beneficiario',$beneficiario_id)->orderBy('fecha','desc')->get();
                $pdf = PDF::loadView('canasta_v2.beneficiario.pdf', compact(['beneficiario','historial']));
                $pdf->set_paper('letter','portrait');
                //$pdf->set_paper(array(0,0,612,396));
                $pdf->render();
                return $pdf->download($beneficiario->id . '.pdf');
        } finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
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
        $barrio = Barrio::select('distrito_id')->where('id',$request->barrio)->first();

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
            $beneficiario->distrito_id = $barrio->distrito_id;
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
            $beneficiario->distrito_id = $barrio->distrito_id;
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
