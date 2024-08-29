<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DataTables;
use DB;
use PDF;
use Image;

use App\Models\Canasta\Barrio;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\Ocupaciones;
use App\Models\Canasta\HistorialMod;
use App\Models\Canasta\HistorialBaja;
use App\Models\Canasta\Paquetes;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BeneficiariosExcel;

class BeneficiariosV2Controller extends Controller
{
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

            dd("actualizar_historial Finalizado...");
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function copiar_nombre_foto()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $beneficiarios = DB::table('beneficiarios')->select('id','dir_foto')->where('id_tipo',Paquetes::TERCERA_EDAD)->where('dir_foto','!=',null)->get();
                foreach($beneficiarios as $datos){
                    $nombre = explode("/", $datos->dir_foto);
                    $beneficiario = Beneficiario::find($datos->id);
                    $beneficiario->update([
                        'photo' => $nombre[3]
                    ]);
                }

                dd("copiar_nombre_foto Finalizado...");
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function resize_photos()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $beneficiarios = DB::table('beneficiarios')->select('dir_foto')->where('id_tipo',Paquetes::TERCERA_EDAD)->where('dir_foto','!=',null)->get();
                foreach($beneficiarios as $beneficiario){
                    $nombre = explode("/", $beneficiario->dir_foto);
                    if (file_exists(substr($beneficiario->dir_foto, 3))){
                        $img = Image::make(substr($beneficiario->dir_foto,3));
                        $img->resize(150, 150);
                        $img->save(public_path('imagenes/fotos-150px/' . $nombre[3]));
                    }else{
                        echo '[ERROR] - ' . $nombre[3] . '<br>';
                    }
                }

                dd("resize_photos Finalizado...");
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function index(Request $request)
    {
        /*if(Auth::user()->dea->id == 1){
            //$this->copiarbeneficiarios();
            //$this->actualizar_distritos();
            //$this->actualizar_historial();
            //$this->copiar_nombre_foto();
            //$this->resize_photos();
        }*/
        //$this->copiarbeneficiarios2();
        $dea_id = Auth::user()->dea->id;
        $tipos = Barrio::TIPOS;
        $distritos = Distrito::where('dea_id',$dea_id)->pluck('nombre','id');
        $sexos = Beneficiario::SEXOS;
        $estados = Beneficiario::ESTADOS;
        $estados_censo = Beneficiario::ESTADOS_CENSO;
        $ocupaciones = Ocupaciones::where('estado','1')->pluck('ocupacion','id');

        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','sexos','estados','estados_censo','ocupaciones'));
    }

    public function indexAjax(Request $request)
    {
        $query = DB::table('beneficiarios as a')
                    ->join('barrios as b','b.id','a.id_barrio')
                    ->join('distritos as c','c.id','a.distrito_id')
                    ->join('ocupaciones as d','d.id','a.id_ocupacion')
                    ->where('a.id_tipo',Paquetes::TERCERA_EDAD);
                    //->where('a.estado', Beneficiario::HABILITADO);

        $query = !is_null($request->id_distrito) ? $query->where('a.distrito_id',$request->id_distrito) : $query;
        $query = !is_null($request->id_barrio) ? $query->where('a.id_barrio',$request->id_barrio) : $query;
        $query = !is_null($request->nombre) ? $query->where('a.nombres',$request->nombre) : $query;
        $query = !is_null($request->ap) ? $query->where('a.ap',$request->ap) : $query;
        $query = !is_null($request->am) ? $query->where('a.am',$request->am) : $query;
        $query = !is_null($request->ci) ? $query->where('a.ci',$request->ci) : $query;
        $query = !is_null($request->sexo) ? $query->where('a.sexo',$request->sexo) : $query;
        if(!is_null($request->edad_inicial) && !is_null($request->edad_final)){
            $fecha_actual = Carbon::now();
            $fecha_nacimiento_final = $fecha_actual->copy()->subYears($request->edad_final + 1)->startOfDay();
            $fecha_nacimiento_inicial = $fecha_actual->copy()->subYears($request->edad_inicial)->addDay()->startOfDay();
            $query->whereBetween('a.fecha_nac', [$fecha_nacimiento_final, $fecha_nacimiento_inicial]);
        }
        $query = !is_null($request->id_ocupacion) ? $query->where('a.id_ocupacion',$request->id_ocupacion) : $query;
        $query = !is_null($request->estado) ? $query->where('a.estado',$request->estado) : $query;
        $query = !is_null($request->estado_censo) ? $query->where('a.censado',$request->estado_censo) : $query;

        $query->select(
                    'a.id as beneficiario_id',
                    'c.nombre as distrito',
                    'a.nombres',
                    'a.ap',
                    'a.am',
                    DB::raw("CONCAT(a.ci,'-',a.expedido) as nro_carnet"),
                    'b.nombre as barrio',
                    'a.sexo',
                    DB::raw("DATE_PART('year',AGE(a.fecha_nac)) as edad"),
                    'd.ocupacion',
                    'a.dir_foto',
                    DB::raw("
                        CASE
                            WHEN a.estado = 'A' THEN 'HABILITADO'
                            WHEN a.estado = 'F' THEN 'FALLECIDO'
                            WHEN a.estado = 'B' THEN 'BAJA'
                            WHEN a.estado = 'X' THEN 'PENDIENTE'
                            WHEN a.estado = 'E' THEN 'ELIMINADO'
                            ELSE 'DESCONOCIDO'
                        END as status
                    "),
                    'a.photo',
                    'a.latitud',
                    'a.longitud',
                    DB::raw("
                        CASE
                            WHEN a.censado = '1' THEN 'PENDIENTE'
                            ELSE 'CENSADO'
                        END as censo_2024
                    "),
                )
                ->orderBy('a.id','desc');

        return datatables()->query($query)
                            ->filterColumn('nro_carnet', function($query, $keyword) {
                                $query->whereRaw("CONCAT(a.ci, ' - ', a.expedido) like ?", ["%{$keyword}%"]);
                            })
                            ->filterColumn('edad', function($query, $keyword) {
                                $query->whereRaw("DATE_PART('year',AGE(a.fecha_nac))::text like ?", ["$keyword"]);
                            })
                            ->filterColumn('status', function($query, $keyword) {
                                $query->whereRaw("
                                    CASE
                                        WHEN a.estado = 'A' THEN 'HABILITADO'
                                        WHEN a.estado = 'F' THEN 'FALLECIDO'
                                        WHEN a.estado = 'B' THEN 'BAJA'
                                        WHEN a.estado = 'X' THEN 'PENDIENTE'
                                        WHEN a.estado = 'E' THEN 'ELIMINADO'
                                        ELSE 'DESCONOCIDO'
                                    END
                                    like ?", ["$keyword"]);
                            })
                            ->filterColumn('censo_2024', function($query, $keyword) {
                                $query->whereRaw("
                                    CASE
                                        WHEN a.censado = '1' THEN 'CENSADO'
                                        ELSE '-'
                                    END
                                    like ?", ["$keyword"]);
                            })
                            ->addColumn('columna_foto','canasta_v2.beneficiario.partials.columna-foto')
                            ->addColumn('columna_btn', 'canasta_v2.beneficiario.partials.columna-btn')
                            ->rawColumns(['columna_foto','columna_btn'])
                            ->toJson();
    }

    public function getBarrios(Request $request){
        try{
            $barrios = Barrio::select('nombre','id')
                            ->where('distrito_id',$request->id)
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
        $ocupaciones = Ocupaciones::where('estado','1')->pluck('ocupacion','id');
        $beneficiarios = Beneficiario::query()
                                        ->byDea($dea_id)
                                        ->byTipoSistema(Paquetes::TERCERA_EDAD)
                                        ->byDistrito($request->distrito)
                                        ->byBarrio($request->barrio)
                                        ->byCodigo($request->codigo)
                                        ->byNombre($request->nombre)
                                        ->byApellidoPaterno($request->ap)
                                        ->byApellidoMaterno($request->am)
                                        ->byNumeroCarnet($request->ci)
                                        ->bySexo($request->sexo)
                                        ->byEdad($request->edad_inicial, $request->edad_final)
                                        ->byOcupacion($request->id_ocupacion)
                                        ->byEstado($request->estado)
                                        ->where('id_tipo','=',1)
                                        ->orderBy('nombres', 'asc')
                                        ->paginate(10);

        return view('canasta_v2.beneficiario.index', compact('tipos','distritos','barrios','sexos','estados','ocupaciones','beneficiarios'));
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $dea_id = Auth::user()->dea->id;
                $beneficiarios = Beneficiario::query()
                                        ->byDea($dea_id)
                                        ->byTipoSistema(Paquetes::TERCERA_EDAD)
                                        ->byDistrito($request->distrito)
                                        ->byBarrio($request->barrio)
                                        ->byCodigo($request->codigo)
                                        ->byNombre($request->nombre)
                                        ->byApellidoPaterno($request->ap)
                                        ->byApellidoMaterno($request->am)
                                        ->byNumeroCarnet($request->ci)
                                        ->bySexo($request->sexo)
                                        ->byEdad($request->edad_inicial, $request->edad_final)
                                        ->byOcupacion($request->id_ocupacion)
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
        $beneficiario->id_tipo = Paquetes::TERCERA_EDAD;
        $beneficiario->expedido = $request->expedido;
        $beneficiario->id_ocupacion = $request->ocupacion;
        $beneficiario->distrito_id = $barrio->distrito_id;
        $beneficiario->latitud = $request->latitud;
        $beneficiario->longitud = $request->longitud;
        $beneficiario->save();
        return redirect()->route('beneficiarios.index')->with('success_message', 'datos registrados correctamente...');
    }


    public function editar($idbeneficiario)
    {
        $censador = false;
        if(count(Auth::user()->roles) == 1){
            foreach(Auth::user()->roles as $role){
                if($role->id == 29){
                    $censador = true;
                }
            }
        }

        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $profesiones = Ocupaciones::where('tipo',Ocupaciones::PROFESIONES)->where('estado','1')->get();
        $ocupaciones = Ocupaciones::where('tipo',Ocupaciones::OCUPACIONES)->where('estado','1')->get();
        $tipos_viviendas = Beneficiario::TIPOS_VIVIENDAS;
        $materiales_viviendas = Beneficiario::MATERIALES_VIVIENDAS;
        $_seguros = Beneficiario::_SEGUROS;
        $beneficiario = Beneficiario::find($idbeneficiario);

        return view('canasta_v2.beneficiario.editar',compact('censador','barrios','profesiones','ocupaciones','tipos_viviendas','materiales_viviendas','_seguros','beneficiario'));
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

    public function subirImagen(Request $request)
    {
        $beneficiario = Beneficiario::find($request->id);
        if($beneficiario != null){
            if($beneficiario->id_tipo == Beneficiario::TERCERA_EDAD){
                if ($request->hasFile('file_ci_anverso')) {
                    $file_ci_anverso = $request->file("file_ci_anverso");
                    $size = $file_ci_anverso->getSize() / 1048576;
                    $round_size = round($size, 2);

                    $file_ci_anverso_name = "a_" . time() . "." . $file_ci_anverso->guessExtension();
                    $ruta_file_ci_anverso = "/imagenes/fotos/cedulas/" . $file_ci_anverso_name;
                    $_ruta_file_ci_anverso = public_path($ruta_file_ci_anverso);
                    if($round_size > 0.5 ){
                        $img = Image::make($file_ci_anverso);
                        $img->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $file_ci_anverso = $img;
                        $file_ci_anverso->save($_ruta_file_ci_anverso);
                    }else{
                        copy($file_ci_anverso, $_ruta_file_ci_anverso);
                    }

                    $beneficiario->update([
                        'file_ci_anverso' => $ruta_file_ci_anverso
                    ]);

                    return response()->json([
                        'success' => 'Anverso Cargado.'
                    ]);
                }

                if ($request->hasFile('file_ci_reverso')) {
                    $file_ci_reverso = $request->file("file_ci_reverso");
                    $size = $file_ci_reverso->getSize() / 1048576;
                    $round_size = round($size, 2);

                    $file_ci_reverso_name = "a_" . time() . "." . $file_ci_reverso->guessExtension();
                    $ruta_file_ci_reverso = "/imagenes/fotos/cedulas/" . $file_ci_reverso_name;
                    $_ruta_file_ci_reverso = public_path($ruta_file_ci_reverso);
                    if($round_size > 0.5 ){
                        $img = Image::make($file_ci_reverso);
                        $img->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $file_ci_reverso = $img;
                        $file_ci_reverso->save($_ruta_file_ci_reverso);
                    }else{
                        copy($file_ci_reverso, $_ruta_file_ci_reverso);
                    }

                    $beneficiario->update([
                        'file_ci_reverso' => $ruta_file_ci_reverso
                    ]);

                    return response()->json([
                        'success' => 'Reverso Cargado.'
                    ]);
                }

                if($request->hasFile('file_documento')) {
                    $file_documento = $request->file("file_documento");
                    $size = $file_documento->getSize() / 1048576;
                    $round_size = round($size, 2);

                    $file_documento_name = time() . "." . $file_documento->guessExtension();
                    $ruta_documento = "/imagenes/fotos/" . $file_documento_name;
                    $_ruta_documento = public_path($ruta_documento);
                    if($round_size > 0.5 ){
                        $img = Image::make($file_documento);
                        $img->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $file_documento = $img;
                        $file_documento->save($_ruta_documento);
                    }else{
                        copy($file_documento, $_ruta_documento);
                    }

                    $beneficiario->update([
                        'dir_foto' => '..' . $ruta_documento,
                        'photo' => $file_documento_name
                    ]);

                    $img_25 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_25->resize(25, 25);
                    $img_25->save(public_path('imagenes/fotos-25px/' . $file_documento_name));

                    $img_30 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_30->resize(30, 30);
                    $img_30->save(public_path('imagenes/fotos-30px/' . $file_documento_name));

                    $img_80 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_80->resize(80, 80);
                    $img_80->save(public_path('imagenes/fotos-80px/' . $file_documento_name));

                    $img_150 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_150->resize(150, 150);
                    $img_150->save(public_path('imagenes/fotos-150px/' . $file_documento_name));

                    return response()->json([
                        'success' => 'Foto Documento Cargado.'
                    ]);
                }
            }else{
                if ($request->hasFile('file_ci_anverso')) {
                    $file_ci_anverso = $request->file("file_ci_anverso");
                    $size = $file_ci_anverso->getSize() / 1048576;
                    $round_size = round($size, 2);

                    $file_ci_anverso_name = "a_" . time() . "." . $file_ci_anverso->guessExtension();
                    $ruta_file_ci_anverso = "/imagenes/fotosdisc/cedulas/" . $file_ci_anverso_name;
                    $_ruta_file_ci_anverso = public_path($ruta_file_ci_anverso);
                    if($round_size > 0.5 ){
                        $img = Image::make($file_ci_anverso);
                        $img->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $file_ci_anverso = $img;
                        $file_ci_anverso->save($_ruta_file_ci_anverso);
                    }else{
                        copy($file_ci_anverso, $_ruta_file_ci_anverso);
                    }

                    $beneficiario->update([
                        'file_ci_anverso' => $ruta_file_ci_anverso
                    ]);

                    return response()->json([
                        'success' => 'Anverso Cargado.'
                    ]);
                }

                if ($request->hasFile('file_ci_reverso')) {
                    $file_ci_reverso = $request->file("file_ci_reverso");
                    $size = $file_ci_reverso->getSize() / 1048576;
                    $round_size = round($size, 2);

                    $file_ci_reverso_name = "a_" . time() . "." . $file_ci_reverso->guessExtension();
                    $ruta_file_ci_reverso = "/imagenes/fotosdisc/cedulas/" . $file_ci_reverso_name;
                    $_ruta_file_ci_reverso = public_path($ruta_file_ci_reverso);
                    if($round_size > 0.5 ){
                        $img = Image::make($file_ci_reverso);
                        $img->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $file_ci_reverso = $img;
                        $file_ci_reverso->save($_ruta_file_ci_reverso);
                    }else{
                        copy($file_ci_reverso, $_ruta_file_ci_reverso);
                    }

                    $beneficiario->update([
                        'file_ci_reverso' => $ruta_file_ci_reverso
                    ]);

                    return response()->json([
                        'success' => 'Reverso Cargado.'
                    ]);
                }

                if($request->hasFile('file_documento')) {
                    $file_documento = $request->file("file_documento");
                    $size = $file_documento->getSize() / 1048576;
                    $round_size = round($size, 2);

                    $file_documento_name = time() . "." . $file_documento->guessExtension();
                    $ruta_documento = "/imagenes/fotosdisc/" . $file_documento_name;
                    $_ruta_documento = public_path($ruta_documento);
                    if($round_size > 0.5 ){
                        $img = Image::make($file_documento);
                        $img->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $file_documento = $img;
                        $file_documento->save($_ruta_documento);
                    }else{
                        copy($file_documento, $_ruta_documento);
                    }

                    $beneficiario->update([
                        'dir_foto' => '..' . $ruta_documento,
                        'photo' => $file_documento_name
                    ]);

                    $img_25 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_25->resize(25, 25);
                    $img_25->save(public_path('imagenes/fotos-25px/' . $file_documento_name));

                    $img_30 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_30->resize(30, 30);
                    $img_30->save(public_path('imagenes/fotos-30px/' . $file_documento_name));

                    $img_80 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_80->resize(80, 80);
                    $img_80->save(public_path('imagenes/fotos-80px/' . $file_documento_name));

                    $img_150 = Image::make(substr($beneficiario->dir_foto,3));
                    $img_150->resize(150, 150);
                    $img_150->save(public_path('imagenes/fotos-150px/' . $file_documento_name));

                    return response()->json([
                        'success' => 'Foto Documento Cargado.'
                    ]);
                }
            }
        }
        return response()->json(['error' => 'Archivo no cargado']);
    }

    public function update(Request $request)
    {//dd($request->all());
        $censador = false;
        if(count(Auth::user()->roles) == 1){
            foreach(Auth::user()->roles as $role){
                if($role->id == 29){
                    $censador = true;
                }
            }
        }

        if($censador == true){
            $beneficiario = Beneficiario::find($request->idBeneficiario);
            if($beneficiario->censado == '2'){
                return redirect()->route('beneficiarios.brigadista.index')->with('error_message', 'El beneficiario ya fue ACTUALIZADO');
            }
        }

        $fecha_nacimiento = $request->fnac != null ? date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac))) : null;
        $barrio = Barrio::select('distrito_id')->where('id',$request->barrio)->first();
        $beneficiario = Beneficiario::find($request->idBeneficiario);
        $seguro_medico = null;
        $informacion = '1';
        $titular_seguro_medico = '1';
        if(isset($request->check_seguro_medico)){
            $seguro_medico = $request->seguro_medico;
            if(isset($request->check_titular)){
                $titular_seguro_medico = '2';
            }
        }
        if(isset($request->informacion)){
            $informacion = '2';
        }
        $beneficiario->update([
            'nombres' => $request->nombres,
            'ap' => $request->ap,
            'am' => $request->am,
            'fecha_nac' => $fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'sexo' => $request->sexo,
            'direccion' => $request->direccion,
            'firma' => $request->firma,
            'obs' => $request->observacion,
            'id_barrio' => $request->barrio,
            'user_id' => Auth::user()->id,
            'ci' => $request->ci,
            'expedido' => $request->expedido,
            'id_ocupacion' => $request->ocupacion,
            'distrito_id' => $barrio->distrito_id,
            'celular' => $request->celular,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'utmy' => $request->utmy,
            'utmx' => $request->utmx,
            'profesion_id' => $request->profesion,
            'seguro_medico' => $seguro_medico,
            'detalle_vivienda' => $request->detalle_vivienda,
            'tipo_vivienda' => $request->tipo_vivienda,
            'vecino_1' => $request->vecino_1,
            'vecino_2' => $request->vecino_2,
            'vecino_3' => $request->vecino_3,
            'titular_seguro_medico' => $titular_seguro_medico,
            'material_vivienda' => $request->material_vivienda,
            'informacion' => $informacion
        ]);

        if($beneficiario->id_tipo == Beneficiario::TERCERA_EDAD){
            /*if(isset($request->documento)){
                $file_documento = $request->file("documento");
                $size = $file_documento->getSize() / 1048576;
                $round_size = round($size, 2);

                $file_documento_name = time() . "." . $file_documento->guessExtension();
                $ruta_documento = "/imagenes/fotos/" . $file_documento_name;
                $_ruta_documento = public_path($ruta_documento);
                if($round_size > 0.5 ){
                    $img = Image::make($file_documento);
                    $img->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $file_documento = $img;
                    $file_documento->save($_ruta_documento);
                }else{
                    copy($file_documento, $_ruta_documento);
                }

                $beneficiario->update([
                    'dir_foto' => '..' . $ruta_documento,
                    'photo' => $file_documento_name
                ]);

                $img_25 = Image::make(substr($beneficiario->dir_foto,3));
                $img_25->resize(25, 25);
                $img_25->save(public_path('imagenes/fotos-25px/' . $file_documento_name));

                $img_30 = Image::make(substr($beneficiario->dir_foto,3));
                $img_30->resize(30, 30);
                $img_30->save(public_path('imagenes/fotos-30px/' . $file_documento_name));

                $img_80 = Image::make(substr($beneficiario->dir_foto,3));
                $img_80->resize(80, 80);
                $img_80->save(public_path('imagenes/fotos-80px/' . $file_documento_name));

                $img_150 = Image::make(substr($beneficiario->dir_foto,3));
                $img_150->resize(150, 150);
                $img_150->save(public_path('imagenes/fotos-150px/' . $file_documento_name));
            }

            if(isset($request->file_ci_anverso)){
                $file_ci_anverso = $request->file("file_ci_anverso");
                $size = $file_ci_anverso->getSize() / 1048576;
                $round_size = round($size, 2);

                $file_ci_anverso_name = "a_" . time() . "." . $file_ci_anverso->guessExtension();
                $ruta_file_ci_anverso = "/imagenes/fotos/cedulas/" . $file_ci_anverso_name;
                $_ruta_file_ci_anverso = public_path($ruta_file_ci_anverso);
                if($round_size > 0.5 ){
                    $img = Image::make($file_ci_anverso);
                    $img->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $file_ci_anverso = $img;
                    $file_ci_anverso->save($_ruta_file_ci_anverso);
                }else{
                    copy($file_ci_anverso, $_ruta_file_ci_anverso);
                }

                $beneficiario->update([
                    'file_ci_anverso' => $ruta_file_ci_anverso
                ]);
            }

            if(isset($request->file_ci_reverso)){
                $file_ci_reverso = $request->file("file_ci_reverso");
                $size = $file_ci_reverso->getSize() / 1048576;
                $round_size = round($size, 2);

                $file_ci_reverso_name = "r_" . time() . "." . $file_ci_reverso->guessExtension();
                $ruta_file_ci_reverso = "/imagenes/fotos/cedulas/" . $file_ci_reverso_name;
                $_ruta_file_ci_reverso = public_path($ruta_file_ci_reverso);
                if($round_size > 0.5 ){
                    $img = Image::make($file_ci_reverso);
                    $img->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $file_ci_reverso = $img;
                    $file_ci_reverso->save($_ruta_file_ci_reverso);
                }else{
                    copy($file_ci_reverso, $_ruta_file_ci_reverso);
                }

                $beneficiario->update([
                    'file_ci_reverso' => $ruta_file_ci_reverso
                ]);
            }*/
        }else{
            /*if(isset($request->documento)){
                $file_documento = $request->file("documento");
                $size = $file_documento->getSize() / 1048576;
                $round_size = round($size, 2);

                $file_documento_name = time() . "." . $file_documento->guessExtension();
                $ruta_documento = "/imagenes/fotosdisc/" . $file_documento_name;
                $_ruta_documento = public_path($ruta_documento);
                if($round_size > 0.5 ){
                    $img = Image::make($file_documento);
                    $img->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $file_documento = $img;
                    $file_documento->save($_ruta_documento);
                }else{
                    copy($file_documento, $_ruta_documento);
                }

                $beneficiario->update([
                    'dir_foto' => '..' . $ruta_documento,
                    'photo' => $file_documento_name
                ]);
            }

            if(isset($request->file_ci_anverso)){
                $file_ci_anverso = $request->file("file_ci_anverso");
                $size = $file_ci_anverso->getSize() / 1048576;
                $round_size = round($size, 2);

                $file_ci_anverso_name = "a_" . time() . "." . $file_ci_anverso->guessExtension();
                $ruta_file_ci_anverso = "/imagenes/fotosdisc/cedulas/" . $file_ci_anverso_name;
                $_ruta_file_ci_anverso = public_path($ruta_file_ci_anverso);
                if($round_size > 0.5 ){
                    $img = Image::make($file_ci_anverso);
                    $img->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $file_ci_anverso = $img;
                    $file_ci_anverso->save($_ruta_file_ci_anverso);
                }else{
                    copy($file_ci_anverso, $_ruta_file_ci_anverso);
                }

                $beneficiario->update([
                    'file_ci_anverso' => $ruta_file_ci_anverso
                ]);
            }

            if(isset($request->file_ci_reverso)){
                $file_ci_reverso = $request->file("file_ci_reverso");
                $size = $file_ci_reverso->getSize() / 1048576;
                $round_size = round($size, 2);

                $file_ci_reverso_name = "r_" . time() . "." . $file_ci_reverso->guessExtension();
                $ruta_file_ci_reverso = "/imagenes/fotosdisc/cedulas/" . $file_ci_reverso_name;
                $_ruta_file_ci_reverso = public_path($ruta_file_ci_reverso);
                if($round_size > 0.5 ){
                    $img = Image::make($file_ci_reverso);
                    $img->resize(750, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $file_ci_reverso = $img;
                    $file_ci_reverso->save($_ruta_file_ci_reverso);
                }else{
                    copy($file_ci_reverso, $_ruta_file_ci_reverso);
                }

                $beneficiario->update([
                    'file_ci_reverso' => $ruta_file_ci_reverso
                ]);
            }*/
        }

        $Historial = HistorialMod::create([
            'observacion' => $request->observacion,
            'id_beneficiario' => $request->idBeneficiario,
            'user_id' => Auth::user()->id,
            'dea_id' => Auth::user()->dea->id,
            'fecha' => date('Y-m-d')
        ]);

        if($censador == true){
            $beneficiario = Beneficiario::find($request->idBeneficiario);
            if($beneficiario->censado == '1'){
                $beneficiario->update([
                    'censado' => '2'
                ]);
            }
        }

        if(isset($request->censado)){
            return redirect()->route('beneficiarios.brigadista.index')->with('info_message', 'datos actualizados correctamente...');
        }else{
            return redirect()->route('beneficiarios.index')->with('info_message', 'datos actualizados correctamente...');
        }
    }

    public function pdfListar(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $dea_id = Auth::user()->dea->id;
                $beneficiarios = Beneficiario::query()
                                    ->byDea($dea_id)
                                    ->byTipoSistema(Paquetes::TERCERA_EDAD)
                                    ->byDistrito($request->distrito)
                                    ->byBarrio($request->barrio)
                                    ->byCodigo($request->codigo)
                                    ->byNombre($request->nombre)
                                    ->byApellidoPaterno($request->ap)
                                    ->byApellidoMaterno($request->am)
                                    ->byNumeroCarnet($request->ci)
                                    ->bySexo($request->sexo)
                                    ->byEdad($request->edad_inicial, $request->edad_final)
                                    ->byOcupacion($request->id_ocupacion)
                                    ->byEstado($request->estado)
                                    ->orderBy('distrito_id')
                                    ->orderBy('id_barrio')
                                    ->get();

                if(Auth::user()->id != 102){
                    $contador = $beneficiarios->count();
                    if($contador >= 1000){
                        return redirect()->route('beneficiarios.index')->with('info_message', 'Los datos de la consulta exceden el limite permitido. Por favor comunicarse con el area de sistemas.');
                    }
                }

                $cont = 1;
                $pdf = PDF::loadView('canasta_v2.beneficiario.pdf-listar', compact(['beneficiarios','cont']));
                $pdf->setPaper(array(0,0,935.43,612));
                $pdf->render();
                return $pdf->stream('beneficiarios.pdf');

        } catch (\Throwable $th) {
            return response()->view('errors.500', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ], 500);
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function brigadistaIndex()
    {
        return view('canasta_v2.beneficiario.brigadista.index');
    }

    public function brigadistaSearch(Request $request)
    {
        $request->validate([
            'ci' => ['required']
        ], [
            'ci' => 'Se requiere un N° de documento para continuar.',
        ]);
        $dea_id = Auth::user()->dea->id;
        $estados = [Beneficiario::HABILITADO,Beneficiario::PENDIENTE];
        $beneficiarios = Beneficiario::query()
                                        ->byDea($dea_id)
                                        //->byTipoSistema(Beneficiario::TERCERA_EDAD)
                                        ->byNumeroCarnetBrigadista($request->ci)
                                        ->byEstadoBrigadista($estados)
                                        ->get();
        if(count($beneficiarios) > 1){
            return redirect()->route('beneficiarios.brigadista.index')->with('error_message', 'Beneficiario con doble registro');
        }else{
            $beneficiario = Beneficiario::query()
                                        ->byDea($dea_id)
                                        //->byTipoSistema(Beneficiario::TERCERA_EDAD)
                                        ->byNumeroCarnetBrigadista($request->ci)
                                        ->byEstadoBrigadista($estados)
                                        ->first();
            if($beneficiario != null){
                if($beneficiario->censado == '2'){
                    return redirect()->route('beneficiarios.brigadista.index')->with('error_message', 'El beneficiario ya fue ACTUALIZADO');
                }else{
                    return redirect()->route('beneficiarios.editar',$beneficiario->id);
                }
            }else{
                return redirect()->route('beneficiarios.brigadista.index')->with('error_message', 'Beneficiario no encontrado o no habilitado');
            }
        }
    }
}
