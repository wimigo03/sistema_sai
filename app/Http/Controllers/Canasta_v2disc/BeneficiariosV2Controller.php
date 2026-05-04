<?php

namespace App\Http\Controllers\Canasta_v2disc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\CanastaDisc\Barrio;
use App\Models\CanastaDisc\Distrito;
use App\Models\CanastaDisc\Beneficiario;
use App\Models\CanastaDisc\Discgrado;
use App\Models\CanastaDisc\Ocupaciones;
use App\Models\CanastaDisc\HistorialMod;
use App\Models\User;
use App\Models\Empleado;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BeneficiariosExcel;
use DataTables;
use DB;
use PDF;

class BeneficiariosV2Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('beneficiarios as a')
                    ->join('barrios as b','b.id','a.id_barrio')
                    ->join('distritos as c','c.id','a.distrito_id')
                   // ->join('distritos as c','c.id','a.distrito_id')
                    ->where('a.id_tipo','=',2)
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
                            ->addColumn('columna_foto', 'canasta_v2disc.beneficiario.partials.columna-foto')
                            ->addColumn('columna_estado', 'canasta_v2disc.beneficiario.partials.columna-estado')
                            ->addColumn('columna_btn', 'canasta_v2disc.beneficiario.partials.columna-btn')
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
        $discapacidad = Discgrado::All()->pluck('discapacidad','id');
        //$discapacidad = Discgrado::All();


        return view('canasta_v2disc.beneficiario.index', compact('discapacidad','tipos','distritos','barrios','sexos','estados'));
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
       // dd($request->discgrado);
        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $barrios = DB::table('barrios')
                            ->where('dea_id',$dea_id)
                            ->orderBy('id','asc')
                            ->pluck('nombre','id');
        $sexos = Beneficiario::SEXOS;
        $estados = Beneficiario::ESTADOS;
        $discapacidad = Discgrado::All()->pluck('discapacidad','id');
        $beneficiarios = Beneficiario::query()
                                        ->byDea($dea_id)
                                        ->byDistrito($request->distrito)
                                        ->byBarrio($request->barrio)
                                        ->byCodigo($request->codigo)
                                        ->byDiscgrado($request->discgrado)
                                        ->byNombre($request->nombre)
                                        ->byApellidoPaterno($request->ap)
                                        ->byApellidoMaterno($request->am)
                                        ->byNumeroCarnet($request->ci)
                                        ->bySexo($request->sexo)
                                        ->byEdad($request->edad_inicial, $request->edad_final)
                                        ->byEstado($request->estado)
                                        ->where('id_tipo','=',2)
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

        return view('canasta_v2disc.beneficiario.index', compact('discapacidad','tipos','distritos','barrios','sexos','estados','beneficiarios'));
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
        //dd('hola create');
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado',1)->get();
        $discgrado = Discgrado::where('estado',1)->get();

        return view('canasta_v2disc.beneficiario.create',compact('barrios','ocupaciones','discgrado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => [
                'required',
                Rule::unique('beneficiarios', 'ci')->where(function ($query) use ($request) {
                    return $query->where('dea_id',Auth::user()->dea->id);
                                    //->where('id_tipo',Beneficiario::TERCERA_EDAD);
                }),
            ]
        ], [
            'ci.unique' => 'Numero de Carnet DUPLICADO',
        ]);

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
        $beneficiario->estado_civil = 'Soltero(a)';
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
        $beneficiario->tutor = $request->tutor;
        $beneficiario->parentesco = $request->parentesco;
        $beneficiario->id_ocupacion = 67;
        //$beneficiario->id_ocupacion = $request->ocupacion;
        $beneficiario->codigo = $request->codigo;
        $beneficiario->id_discgrado = $request->discgrado;
        $beneficiario->distrito_id = $barrio->distrito_id;
        $beneficiario->celular = $request->celular;
        $beneficiario->id_tipo = 2;
        $beneficiario->save();
        return redirect()->route('beneficiariosdisc.index')->with('success_message', 'datos registrados correctamente...');
    }


    public function editar($idbeneficiario)
    {
        //dd('hola editar');
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado','=',1)->get();
        $beneficiario = Beneficiario::find($idbeneficiario);
        $discgrado = Discgrado::where('estado',1)->get();

        return view('canasta_v2disc.beneficiario.editar',compact('barrios','ocupaciones','beneficiario','discgrado'));
    }

    public function show($idbeneficiario)
    {
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $ocupaciones = Ocupaciones::where('estado',1)->get();
        $beneficiario = Beneficiario::find($idbeneficiario);
        $historial = HistorialMod::where('id_beneficiario',$idbeneficiario)->orderBy('fecha','desc')->get();

        return view('canasta_v2disc.beneficiario.show',compact('barrios','ocupaciones','beneficiario','historial'));
    }

    public function pdf($beneficiario_id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $beneficiario = Beneficiario::find($beneficiario_id);
                $historial = HistorialMod::where('id_beneficiario',$beneficiario_id)->orderBy('fecha','desc')->get();
                $pdf = PDF::loadView('canasta_v2disc.beneficiario.pdf', compact(['beneficiario','historial']));
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

                $ruta = public_path("/imagenes/fotosdisc/". $nombre);

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
           // $beneficiario->estado_civil = $request->estado_civil;
           $beneficiario->estado_civil = 'Soltero(a)';
            $beneficiario->sexo = $request->sexo;
            $beneficiario->ci = $request->ci;
            $beneficiario->expedido = $request->expedido;
            $beneficiario->direccion = $request->direccion;
            $beneficiario->firma = $request->firma;
            $beneficiario->estado = $request->estado;
            $beneficiario->dir_foto = '../imagenes/fotosdisc/' . $nombre;;
           // $beneficiario->id_ocupacion = $request->ocupacion;
           $beneficiario->id_ocupacion = 67;
            $beneficiario->id_barrio = $request->barrio;
            $beneficiario->codigo = $request->codigo;
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
            //$beneficiario->estado_civil = $request->estado_civil;
            $beneficiario->estado_civil = 'Soltero(a)';
            $beneficiario->sexo = $request->sexo;
            $beneficiario->ci = $request->ci;
            $beneficiario->expedido = $request->expedido;
            $beneficiario->direccion = $request->direccion;
            $beneficiario->firma = $request->firma;
            $beneficiario->estado = $request->estado;
            //$beneficiario->id_ocupacion = $request->ocupacion;
            $beneficiario->id_ocupacion = 67;
            $beneficiario->id_barrio = $request->barrio;
            $beneficiario->tutor = $request->tutor;
            $beneficiario->parentesco = $request->parentesco;
            $beneficiario->id_discgrado = $request->discgrado;
            $beneficiario->codigo = $request->codigo;
            $beneficiario->celular = $request->celular;
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

        return redirect()->route('beneficiariosdisc.index')->with('info_message', 'datos actualizados correctamente...');
    }
}
