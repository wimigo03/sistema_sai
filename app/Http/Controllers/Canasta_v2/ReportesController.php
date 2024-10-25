<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use Carbon\Carbon;
use DataTables;
use DB;
use PDF;
use Image;

use App\Models\Canasta\Dea;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\HistorialMod;

/* use App\Models\Canasta\Barrio;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Ocupaciones;
use App\Models\Canasta\HistorialMod;
use App\Models\Canasta\HistorialBaja;
use App\Models\Canasta\Paquetes;
use App\Models\User;
use App\Models\Empleado; */


use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BeneficiariosPorFechasExcel;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        return view('canasta_v2.reportes.index');
    }

    public function BeneficiariosEntreFechas()
    {
        $estados = Beneficiario::ESTADOS;
        return view('canasta_v2.reportes.beneficiarios-entre-fechas',compact('estados'));
    }

    public function ExportarBeneficiariosEntreFechas(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $beneficiarios = Beneficiario::query()
                            ->join('distritos','beneficiarios.distrito_id','distritos.id')
                            ->join('barrios','beneficiarios.id_barrio','barrios.id')
                            ->byDea(Auth::user()->dea->id)
                            ->byTipoSistema(Beneficiario::TERCERA_EDAD)
                            ->byEntreFechas($request->finicial, $request->ffinal)
                            ->byEstado($request->estado)
                            ->select(
                                'beneficiarios.id as beneficiario_id',
                                'distritos.nombre as distrito',
                                'barrios.nombre as barrio',
                                'beneficiarios.nombres',
                                'beneficiarios.ap as apellido_paterno',
                                'beneficiarios.am as apellido_materno',
                                'beneficiarios.ci as nro_carnet',
                                'beneficiarios.expedido',
                                DB::raw("TO_CHAR(beneficiarios.fecha_nac, 'dd/mm/yyyy') as _fecha_nac"),
                                'beneficiarios.estado_civil',
                                'beneficiarios.sexo',
                                'beneficiarios.firma',
                                'beneficiarios.celular',
                                'beneficiarios.estado',
                                DB::raw("
                                    CASE
                                        WHEN beneficiarios.estado = 'A' THEN 'HABILITADO'
                                        WHEN beneficiarios.estado = 'F' THEN 'FALLECIDO'
                                        WHEN beneficiarios.estado = 'B' THEN 'BAJA'
                                        WHEN beneficiarios.estado = 'X' THEN 'PENDIENTE'
                                        WHEN beneficiarios.estado = 'E' THEN 'ELIMINADO'
                                        ELSE 'DESCONOCIDO'
                                    END as _estado
                                "),
                                DB::raw("
                                    CASE
                                        WHEN beneficiarios.censado = '1' THEN 'NO'
                                        WHEN beneficiarios.censado = '2' THEN 'SI'
                                        ELSE 'DESCONOCIDO'
                                    END as _censado
                                "),
                                DB::raw("TO_CHAR(fecha, 'dd/mm/yyyy') as _fecha"),
                                'observacion',)
                            ->orderBy('fecha', 'desc')
                            ->get();

                return Excel::download(new BeneficiariosPorFechasExcel($beneficiarios),'beneficiarios.xlsx');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message','[Ocurrio un Error]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function create()
    {
        $brigadista = false;
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->get();
        $profesiones = Ocupaciones::where('tipo',Ocupaciones::PROFESIONES)->where('estado','1')->get();
        $ocupaciones = Ocupaciones::where('tipo',Ocupaciones::OCUPACIONES)->where('estado','1')->get();
        $tipos_viviendas = Beneficiario::TIPOS_VIVIENDAS;
        $materiales_viviendas = Beneficiario::MATERIALES_VIVIENDAS;
        $_seguros = Beneficiario::_SEGUROS;

        return view('canasta_v2.beneficiario.create',compact('barrios','profesiones','ocupaciones','tipos_viviendas','materiales_viviendas','_seguros','brigadista'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => [
                'required',
                Rule::unique('beneficiarios', 'ci')->where(function ($query) use ($request) {
                    return $query->where('dea_id',Auth::user()->dea->id)
                                    ->where('id_tipo',Beneficiario::TERCERA_EDAD);
                }),
            ]
        ], [
            'ci.unique' => 'Numero de Carnet DUPLICADO',
        ]);

        $fecha_nacimiento = $request->fnac != null ? date('Y-m-d', strtotime(str_replace('/', '-', $request->fnac))) : null;
        $barrio = Barrio::select('distrito_id')->where('id',$request->barrio)->first();
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
        $beneficiario = Beneficiario::create([
            'nombres' => $request->nombres,
            'ap' => $request->ap,
            'am' => $request->am,
            'fecha_nac' => $fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'sexo' => $request->sexo,
            'direccion' => $request->direccion,
            'firma' => $request->firma,
            'estado' => $request->estado,
            'obs' => $request->observacion,
            'id_barrio' => $request->barrio,
            'user_id' => Auth::user()->id,
            'dea_id' => Auth::user()->dea->id,
            'ci' => $request->ci,
            'expedido' => $request->expedido,
            'id_ocupacion' => $request->ocupacion,
            'distrito_id' => $barrio->distrito_id,
            'id_tipo' => Beneficiario::TERCERA_EDAD,
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
            'censado' => Beneficiario::NO_CENSADO,
            'titular_seguro_medico' => $titular_seguro_medico,
            'material_vivienda' => $request->material_vivienda,
            'informacion' => $informacion
        ]);

        $Historial = HistorialMod::create([
            'observacion' => $request->observacion,
            'id_beneficiario' => $beneficiario->id,
            'user_id' => Auth::user()->id,
            'dea_id' => Auth::user()->dea->id,
            'fecha' => date('Y-m-d')
        ]);

        return redirect()->route('beneficiarios.index')->with('success_message', 'datos registrados correctamente...');
    }


    public function editar($idbeneficiario)
    {
        $brigadista = false;
        if(count(Auth::user()->roles) == 1){
            foreach(Auth::user()->roles as $role){
                if($role->id == 29 || $role->id == 31){
                    $brigadista = true;
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

        return view('canasta_v2.beneficiario.editar',compact('brigadista','barrios','profesiones','ocupaciones','tipos_viviendas','materiales_viviendas','_seguros','beneficiario'));
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
    {
        $request->validate([
            'ci' => [
                'required',
                Rule::unique('beneficiarios', 'ci')->where(function ($query) use ($request) {
                    return $query->where('dea_id',Auth::user()->dea->id)
                                    ->where('id_tipo',Beneficiario::TERCERA_EDAD)
                                    ->where('id','!=',$request->idBeneficiario);
                }),
            ]
        ], [
            'ci.unique' => 'Numero de Carnet DUPLICADO',
        ]);

        $brigadista = false;
        if(count(Auth::user()->roles) == 1){
            foreach(Auth::user()->roles as $role){
                if($role->id == 29 || $role->id == 31){
                    $brigadista = true;
                }
            }
        }

        if($brigadista == true){
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
            'estado' => $request->estado,
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

        $Historial = HistorialMod::create([
            'observacion' => $request->observacion,
            'id_beneficiario' => $request->idBeneficiario,
            'user_id' => Auth::user()->id,
            'dea_id' => Auth::user()->dea->id,
            'fecha' => date('Y-m-d H:i:s')
        ]);

        if($brigadista == true){
            $beneficiario = Beneficiario::find($request->idBeneficiario);
            if($beneficiario->censado == '1'){
                $beneficiario->update([
                    'censado' => '2',
                    'user_censo_id' => Auth::user()->id,
                    'fecha_censo' => date('Y-m-d H:i:s')
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
                                    //->byCodigo($request->codigo)
                                    ->byNombreCompleto($request->nombre_completo)
                                    ->byNumeroCarnet($request->ci)
                                    ->bySexo($request->sexo)
                                    ->byEdad($request->edad_inicial, $request->edad_final)
                                    ->byOcupacion($request->id_ocupacion)
                                    ->byEstado($request->estado)
                                    ->byUsuarioTwo($request->usuario)
                                    ->byEstadoCenso($request->estado_censo)
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
        $user = User::find(Auth::user()->id);
        return view('canasta_v2.beneficiario.brigadista.index',compact('user'));
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
