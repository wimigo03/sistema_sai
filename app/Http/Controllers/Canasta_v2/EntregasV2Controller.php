<?php

namespace App\Http\Controllers\Canasta_v2;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Entrega;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\PaqueteBarrio;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\EntregasExcel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
use PDF;
use Carbon\Carbon;

class EntregasV2Controller extends Controller
{
    public function index($paquete_barrio_id)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
        $extensiones = Beneficiario::EXTENSIONES;
        $sexos = Beneficiario::SEXOS;
        $estados = Entrega::ESTADOS;

        $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaqueteBarrio($paquete_barrio_id)
                            ->select(
                                'b.nombres',
                                'b.ap',
                                'b.am',
                                'b.ci',
                                'b.expedido',
                                'b.fecha_nac',
                                'b.sexo',
                                'b.dir_foto',
                                'entrega.estado',
                                'entrega.id as entrega_id',
                                'entrega.resagado')
                            ->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->paginate(10);
        $cont = 1;

        return view('canasta_v2.entregas.index', compact('paquete_barrio','extensiones','sexos','estados','entregas','cont'));
    }

    public function search($paquete_barrio_id, Request $request)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
        $extensiones = Beneficiario::EXTENSIONES;
        $sexos = Beneficiario::SEXOS;
        $estados = Entrega::ESTADOS;

        $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaqueteBarrio($paquete_barrio_id)
                            ->byNombre($request->nombre)
                            ->byApellidoPaterno($request->ap_paterno)
                            ->byApellidoMaterno($request->ap_materno)
                            ->byNroCarnet($request->nro_carnet)
                            ->byExtension($request->extension)
                            ->byFechaNacimiento($request->fecha_nac)
                            ->byEdad($request->edad_inicial, $request->edad_final)
                            ->bySexo($request->sexo)
                            ->byEstado($request->estado)
                            ->select(
                                'b.nombres',
                                'b.ap',
                                'b.am',
                                'b.ci',
                                'b.expedido',
                                'b.fecha_nac',
                                'b.sexo',
                                'b.dir_foto',
                                'entrega.estado',
                                'entrega.id as entrega_id',
                                'entrega.resagado')
                            ->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->paginate(10);
        $cont = 1;

        return view('canasta_v2.entregas.index', compact('paquete_barrio','extensiones','sexos','estados','entregas','cont'));
    }

    public function create($paquete_barrio_id)
    {
                                                 $estados = Entrega::ESTADOS;
                                                $deas = Dea::where('id',Auth::user()->dea->id)->get();
                                                $barrioEntrega = BarrioEntrega::select('id_barrio')->where('id_paquete','=',$idpaquete)->pluck('id_barrio','id_barrio');
                                                $barrioEntregaSel = BarrioEntrega::All()->where('id_paquete','=',$idpaquete);
                                                $barrioEntregaSel2 = BarrioEntrega::All()
                                                ->where('estado','=',2)
                                                ->where('id_paquete','=',$idpaquete);
                                                //dd($barrioEntrega);
                                            // $barrios2 = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','nombre');
                                                $botonImprimir=0;

                                                if ($barrioEntrega->isEmpty()) {
                                                        $barrios3 = DB::table('barrios')
                                                        ->select('id', 'nombre')
                                                        ->get();

                                                } else {
                                                        $botonImprimir=1;
                                                        $barrios3 = DB::table('barrios')
                                                        ->whereIn('id', $barrioEntregaSel->pluck('id_barrio'))
                                                        ->select('id', 'nombre')
                                                        ->get();
                                                }

                                                if ($barrioEntrega->isEmpty()) {
                                                    $barrios4 = DB::table('barrios')->select('id', 'nombre')->get();
                                                } else {
                                                    $botonImprimir = 1;
                                                    $barrios4 = DB::table('barrios')->whereIn('id', $barrioEntregaSel2->pluck('id_barrio'))
                                                                                    ->select('id', 'nombre')
                                                                                    ->get();
                                                }

                                                if ($barrioEntrega->isEmpty()) {
                                                        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)
                                                        ->get();
                                                } else {

                                                        $barrios = DB::table('barrios')
                                                        ->whereNotIn('id', DB::table('barriosEntrega')->pluck('id_barrio'))
                                                        ->select('id', 'nombre')
                                                        ->get();
                                                }



                                                if ($barrioEntrega->isEmpty()) {
                                                    $barrios2 = DB::table('barrios')
                                                    ->select('nombre', 'nombre')
                                                    ->get();

                                            } else {
                                                // $botonImprimir=1;
                                                    $barrios2 = DB::table('barrios')
                                                    ->whereIn('id', $barrioEntregaSel->pluck('id_barrio'))
                                                    ->select('nombre', 'nombre')
                                                    ->get();
                                            }

                                            if ($barrioEntrega->isEmpty()) {
                                                $barrios1 = DB::table('barrios')
                                                    ->select('id', 'nombre')
                                                    ->get();
                                            } else {
                                                $botonImprimir = 1;
                                                $barrios1 = DB::table('barrios')
                                                    ->whereIn('id', $barrioEntregaSel2->pluck('id_barrio'))
                                                    ->select('id', 'nombre')
                                                    ->get();
                                            }



                                        $beneficiarioControl =0;

                                        if ($request->barrio == null || $request->estado == null) {
                                            $entregas =Entrega::query()
                                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                                            ->join('paquete as p','p.id','entrega.id_paquete')
                                            ->join('barrios as bb','bb.id','entrega.id_barrio')
                                            //->Join('barriosEntrega as be','be.id_paquete','p.id')
                                            ->select('entrega.id','entrega.estado','entrega.id_paquete','p.gestion','p.periodo','bb.id AS idbarrio','b.nombres', 'b.ap', 'b.am', 'b.ci', 'bb.nombre', 'b.dir_foto')
                                            ->where('entrega.dea_id',Auth::user()->dea->id)
                                            ->where('entrega.id_paquete',$idpaquete)
                                            //->where('entrega.estado','=',3)
                                            //->where('entrega.estado',$request->estado)
                                            ->byNombre($request->nombres)
                                                                        ->byAp($request->ap)
                                                                        ->byAm($request->am)
                                                                            ->byCi($request->ci)
                                                                        ->byBarrio($request->barrio)
                                                                            ->byEstado($request->estado)
                                            ->orderBy('b.nombres', 'asc')
                                            ->paginate(100);


//dd($request->barrio);
                                            $entregados = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->where('estado','=',3)
                                            ->count();

                                            $sin_entrega_imp = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->where('estado','=',2)
                                            //->where('estado','=',1)
                                            ->count();

                                            $sin_entrega_sinImp = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->where('estado','=',1)
                                            //->where('estado','=',1)
                                            ->count();

                                            $sin_entrega=$sin_entrega_imp + $sin_entrega_sinImp;

                                            $total = Entrega::query()
                                            ->byBarrio($request->barrio)
                                            ->where('dea_id',Auth::user()->dea->id)
                                            ->where('id_paquete','=',$idpaquete)
                                            ->count();

                                    } else {

                                        $entregas = Entrega::query()
                                        ->byNombre($request->nombres)
                                        ->byAp($request->ap)
                                        ->byAm($request->am)
                                        ->byCi($request->ci)
                                        ->byBarrio($request->barrio)
                                        ->byEstado($request->estado)
                                        ->where('dea_id',Auth::user()->dea->id)
                                        ->where('id_paquete','=',$idpaquete)
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);

                                        $entregados = 0;

                                        $sin_entrega_imp = 0;
                                        $sin_entrega_sinImp = 0;
                                        $sin_entrega=$sin_entrega_imp + $sin_entrega_sinImp;

                                         $total =0;
                                    }




     return view('canasta_v2.entregas.entrega_index', ["sin_entrega" => $sin_entrega,"entregados" => $entregados,"total" => $total,"estados" => $estados,"barrios1" => $barrios1,"barrios4" => $barrios4,"barrios3" => $barrios3,"botonImprimir" => $botonImprimir,"barrios2" => $barrios2,"barrios" => $barrios,"beneficiarioControl" => $beneficiarioControl,"entrega" => $entregas,"idpaquete" => $idpaquete]);
}


    public function createEntrega(Request $request)
        {

                                     $personal = User::find(Auth::user()->id);
                                      $id_usuario = $personal->id;
                                     $dea_id = $personal->dea_id;
                                        $date = Carbon::now();

                                        $deas = Dea::where('id',Auth::user()->dea->id)->pluck('nombre','id');

                                        $beneficiarios = Beneficiario::find($request->beneficiario);


                                        //$entrega = Entrega::find($request->beneficiario);
                                        $entrega = new Entrega();
                                        $entrega->fecha = $date;
                                        $entrega->id_paquete = $request->idpaquete;
                                        $entrega->id_beneficiario = $beneficiarios->id;
                                        $entrega->id_barrio = $beneficiarios->id_barrio;
                                        $entrega->user_id = $id_usuario;
                                        $entrega->dea_id = $dea_id;
                                        $entrega->estado = 2;

                                        $entrega->save();
                                        $request->session()->flash('message', 'Registro Agregado');



        return redirect()->route('entregas.entrega_index2',$request->idpaquete);
    }


    public function agregarporbarrio(Request $request,$idpaquete)
    {
                                            $personal = User::find(Auth::user()->id);
                                            $id_usuario = $personal->id;
                                        $dea_id = $personal->dea_id;
                                        $beneficiarios= Beneficiario::where('dea_id',Auth::user()->dea->id)
                                                        ->Where('id_barrio','=',$request->barrio)
                                                        ->Where('estado','=','A')
                                                        ->get();

                                        $date = Carbon::now();
                                        foreach ($beneficiarios as $data){

                                        $datos=([

                                            'fecha'=>$date,
                                            'id_paquete'=>$idpaquete,
                                            'id_beneficiario'=>$data->id,
                                            'id_barrio'=>$data->id_barrio,
                                            'user_id'=>$id_usuario,
                                            'dea_id'=>$dea_id,
                                            'estado'=>1
                                                ]

                                                );
                                        $entrega=Entrega::CREATE($datos);
                                        }

                                        $barrioEntrega = new BarrioEntrega;
                                        $barrioEntrega->id_barrio = $request->barrio;
                                        $barrioEntrega->id_paquete = $idpaquete;
                                        $barrioEntrega->estado = 1;
                                        $barrioEntrega->save();

    return redirect()->route('entregas.entrega_index',$idpaquete);

    }


    public function generarboleta(Request $request)
    {
                                         $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                         'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                                        $fecha_actual=$meses[date('n')] . '-' . date('Y');
                                        $personal = User::find(Auth::user()->id);
                                        $id = $personal->id;
                                        $userdate = User::find($id)->usuariosempleados;
                                        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

                                        $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                                            ->get();

                                        $entregas = Entrega::join('beneficiarios as b', 'b.id', '=', 'entrega.id_beneficiario')
                                        ->where('entrega.dea_id',Auth::user()->dea->id)
                                        ->where('entrega.id_paquete',$request->idpaquete)
                                        ->where('entrega.id_barrio',$request->barrio3)
                                        ->orderBy('b.nombres', 'asc')
                                        ->get();

                                          //  $entregas = DB::table('entrega as e')
                                            //->join('paquete as p', 'p.id', '=', 'e.id_paquete')
                                            //->join('barrios as b', 'b.id', '=', 'e.id_barrio')
                                            //->join('beneficiarios as be', 'be.id', '=', 'e.id_beneficiario')
                                            //->select('e.id','p.periodo','p.items','p.gestion','b.nombre','be.dir_foto', 'be.ci', 'be.nombres', 'be.ap', 'be.am','be.firma', 'be.fecha_nac', 'be.created_att')
                                            //->where('e.id_paquete',$request->idpaquete)
                                            //->where('e.id_barrio',$request->barrio3)
                                            //->orderBy('be.nombres', 'asc')
                                            //->get();

                                            $barrio_entrega = BarrioEntrega::where('id_paquete',$request->idpaquete)
                                            ->where('id_barrio',$request->barrio3)
                                            //->take(2)
                                             ->first();

                                             if ($barrio_entrega->estado == 1) {

                                                $entregas2 = Entrega::where('dea_id',Auth::user()->dea->id)
                                                ->where('id_paquete',$request->idpaquete)
                                                ->where('id_barrio',$request->barrio3)
                                                //->take(2)
                                                ->get();

                                                foreach ($entregas2 as $data){
                                                    $entrega3 = Entrega::find($data->id);


                                                    $entrega3->estado = 2;


                                                    $entrega3->save();
                                                    }

                                          //dd($barrio_entrega->id);
                                          $barrio_entrega2 = BarrioEntrega::find($barrio_entrega->id);
                                          $barrio_entrega2->update([
                                              'estado' => 2
                                          ]);
                                            }



                                        //dd($entregas);

                                            // $pdf = PDF::loadView('canasta_v2/entregas/generarboleta', compact(['entregas']));
                                            //$pdf->setPaper('LETTER', 'portrait'); //landscape
                                           //return $pdf->stream();

                                        return view('canasta_v2/entregas/generarboleta', ["fecha_actual" => $fecha_actual,"entregas" => $entregas,"userdate" => $userdate,"personalArea" => $personalArea]);


                }



   public function generarboleta2($id_entrega)
                                        {

                                            $meses = array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                        $fecha_actual=$meses[date('n')] . '-' . date('Y');

                        $personal = User::find(Auth::user()->id);
                        $id = $personal->id;
                        $userdate = User::find($id)->usuariosempleados;
                        $personalArea = Empleado::find($userdate->idemp)->empleadosareas;

                        $beneficiarios = Beneficiario::where('dea_id',Auth::user()->dea->id)
                        ->get();

        $cont = 1;
        return view('canasta_v2.entregas.create', compact('paquete_barrio','beneficiarios','cont'));
    }

    public function store(Request $request)
    {
        if(!isset($request->beneficiario_id)){
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el registro]')->withInput();
        }
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $paquete_barrio = PaqueteBarrio::find($request->paquete_barrio_id);
            $dea_id = Auth::user()->dea->id;

            $cont = 0;

            while($cont < count($request->beneficiario_id)){
                $datos_entrega = ([
                    'id_barrio' => $paquete_barrio->id_barrio,
                    'id_beneficiario' => $request->beneficiario_id[$cont],
                    'id_paquete' => $paquete_barrio->id_paquete,
                    'tipo_entrega_id' => '1',
                    'id_ocupacion' => $request->ocupacion_id[$cont],
                    'distrito_id' => $paquete_barrio->distrito_id,
                    'dea_id' => $dea_id,
                    'paquete_barrio_id' => $paquete_barrio->id,
                    'fecha' => date('Y-m-d'),
                    'user_id' => Auth::user()->id,
                    'estado' => '1'
                ]);

                $entrega = Entrega::create($datos_entrega);

                $cont++;
            }

            return redirect()->route('entregas.index',$request->paquete_barrio_id)->with('success_message', 'Beneficiarios registrados exitosamente...');

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

    public function habilitar(Request $request)
    {
        $entrega = Entrega::find($request->entrega_id);
        $entrega->update([
            'estado' => '2',
            'observacion' => $request->observacion,
            'resagado' => '1'
        ]);

        return back()->with('success_message', '[Canasta entregada]');
    }

    public function deshabilitar($entrega_id)
    {
        $entrega = Entrega::find($entrega_id);
        $entrega->update([
            'estado' => '1'
        ]);

        return back()->with('info_message', '[Devolucion procesada]');
    }

    public function habilitar_todo($paquete_barrio_id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $entregas = Entrega::where('paquete_barrio_id',$paquete_barrio_id)->whereIn('estado',['1','2'])->get();;
            foreach($entregas as $datos){
                $entrega = Entrega::find($datos->id);
                $entrega->update([
                    'estado' => '2'
                ]);
            }

            return redirect()->route('entregas.index',$paquete_barrio_id)->with('success_message', '[Canasta entregada a todos los beneficiarios]');

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

    public function deshabilitar_todo($paquete_barrio_id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $entregas = Entrega::where('paquete_barrio_id',$paquete_barrio_id)->whereIn('estado',['1','2'])->get();;
            foreach($entregas as $datos){
                $entrega = Entrega::find($datos->id);
                $entrega->update([
                    'estado' => '1'
                ]);
            }

            return redirect()->route('entregas.index',$paquete_barrio_id)->with('info_message', '[Devolucion de canasta beneficiarios procesada]');

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

    public function get_boleta_entrega($entrega_id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $entrega = Entrega::find($entrega_id);
            $contenido_qr = "CODIGO : " . (string) $entrega->id .
                            "\nENTREGA DEL MES DE " . $entrega->paquete_barrio->periodos . " / " . $entrega->paquete->gestion .
                            "\nB/C : " . $entrega->barrio->nombre .
                            "\nBENEFICIARIO : " . $entrega->beneficiario->nombres . " " . $entrega->beneficiario->ap . " " . $entrega->beneficiario->am .
                            "\nNRO. DE CARNET : " . $entrega->beneficiario->ci . " " . $entrega->beneficiario->expedido;
            $contenido_qr = mb_convert_encoding($contenido_qr, "UTF-8", "auto");
            $qrCode = base64_encode(QrCode::format('png')->margin(0)->size(200)->generate($contenido_qr));
            $pdf = PDF::loadView('canasta_v2.entregas.generar-boleta-pdf', compact(['entrega','qrCode']));
            $pdf->setPaper(array(0,0,612,311.81));
            $pdf->render();
            return $pdf->stream('Bolenta_de_entrega.pdf');

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

    public function get_boletas_entrega($paquete_barrio_id, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaqueteBarrio($paquete_barrio_id)
                            ->byNombre($request->nombre)
                            ->byApellidoPaterno($request->ap_paterno)
                            ->byApellidoMaterno($request->ap_materno)
                            ->byNroCarnet($request->nro_carnet)
                            ->byExtension($request->extension)
                            ->byFechaNacimiento($request->fecha_nac)
                            ->byEdad($request->edad_inicial, $request->edad_final)
                            ->bySexo($request->sexo)
                            ->byEstado($request->estado)
                            ->select(
                                'b.nombres',
                                'b.ap',
                                'b.am',
                                'b.ci',
                                'b.expedido',
                                'b.fecha_nac',
                                'b.sexo',
                                'b.dir_foto',
                                'entrega.estado',
                                'entrega.id as entrega_id')
                            ->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->get();

            $array_entrega = array();
            foreach($entregas as $datos){
                $entrega = Entrega::find($datos->entrega_id);
                $array_entrega[] = $entrega;

            }

            $pdf = PDF::loadView('canasta_v2.entregas.generar-boleta-all-pdf', compact(['array_entrega']));
            //$pdf->setPaper(array(0,0,612,935.43));
            $pdf->setPaper(array(0,0,612,311.81));
            $pdf->render();
            return $pdf->stream('Boletas_de_entrega.pdf');

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

    public function pdf_habilitados_sin_registro($paquete_barrio_id, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
                $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaqueteBarrio($paquete_barrio_id)
                            ->byNombre($request->nombre)
                            ->byApellidoPaterno($request->ap_paterno)
                            ->byApellidoMaterno($request->ap_materno)
                            ->byNroCarnet($request->nro_carnet)
                            ->byExtension($request->extension)
                            ->byFechaNacimiento($request->fecha_nac)
                            ->byEdad($request->edad_inicial, $request->edad_final)
                            ->bySexo($request->sexo)
                            ->byEstado($request->estado)
                            ->select(
                                'b.nombres',
                                'b.ap',
                                'b.am',
                                'b.ci',
                                'b.expedido',
                                'b.fecha_nac',
                                'b.sexo',
                                'b.dir_foto',
                                'entrega.estado',
                                'entrega.id as entrega_id')
                            ->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->get();
                $cont = 1;

                $pdf = PDF::loadView('canasta_v2.entregas.pdf-habilitados-sin-registro', compact(['paquete_barrio','entregas','cont']));
                $pdf->setPaper(array(0,0,612,935.43));
                $pdf->render();
                return $pdf->stream('Habilitados_1.pdf');

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

    public function pdf_habilitados_con_registro($paquete_barrio_id, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
                $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaqueteBarrio($paquete_barrio_id)
                            ->byNombre($request->nombre)
                            ->byApellidoPaterno($request->ap_paterno)
                            ->byApellidoMaterno($request->ap_materno)
                            ->byNroCarnet($request->nro_carnet)
                            ->byExtension($request->extension)
                            ->byFechaNacimiento($request->fecha_nac)
                            ->byEdad($request->edad_inicial, $request->edad_final)
                            ->bySexo($request->sexo)
                            ->byEstado($request->estado)
                            ->select(
                                'b.nombres',
                                'b.ap',
                                'b.am',
                                'b.ci',
                                'b.expedido',
                                'b.fecha_nac',
                                'b.sexo',
                                'b.dir_foto',
                                'entrega.estado',
                                'entrega.id as entrega_id',
                                'b.created_att')
                            ->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->get();
                $cont = 1;

                $pdf = PDF::loadView('canasta_v2.entregas.pdf-habilitados-con-registro', compact(['paquete_barrio','entregas','cont']));
                $pdf->setPaper(array(0,0,612,935.43));
                $pdf->render();
                return $pdf->stream('Habilitados_2.pdf');

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

    public function excel($paquete_barrio_id, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
            $entregas = Entrega::query()
                        ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                        ->byDea(Auth::user()->dea->id)
                        ->byPaqueteBarrio($paquete_barrio_id)
                        ->byNombre($request->nombre)
                        ->byApellidoPaterno($request->ap_paterno)
                        ->byApellidoMaterno($request->ap_materno)
                        ->byNroCarnet($request->nro_carnet)
                        ->byExtension($request->extension)
                        ->byFechaNacimiento($request->fecha_nac)
                        ->byEdad($request->edad_inicial, $request->edad_final)
                        ->bySexo($request->sexo)
                        ->byEstado($request->estado)
                        ->select(
                            'b.nombres',
                            'b.ap',
                            'b.am',
                            'b.ci',
                            'b.expedido',
                            'b.fecha_nac',
                            'b.sexo',
                            'b.dir_foto',
                            'entrega.estado',
                            'entrega.id as entrega_id',
                            'b.created_att')
                        ->where('entrega.estado','!=','3')
                        ->orderBy('b.nombres','asc')
                        ->orderBy('b.ap','asc')
                        ->get();
            $cont = 1;

            return Excel::download(new EntregasExcel($paquete_barrio,$entregas,$cont),'entrega_canasta.xlsx');
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

    public function finalizar($paquete_barrio_id)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
        $paquete_barrio->update([
            'estado' => '2'
        ]);

        return redirect()->route('entregas.index',$paquete_barrio_id)->with('info_message', '[ENTREGA FINALIZADA]');
    }

    public function restablecer($paquete_barrio_id)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
        $paquete_barrio->update([
            'estado' => '1'
        ]);

        return redirect()->route('entregas.index',$paquete_barrio_id)->with('success_message', '[ENTREGA RESTABLECIDA]');
    }

    public function editar($entrega_id)
    {
        $entrega = Entrega::find($entrega_id);
        $barrios = Barrio::select('id','nombre')->where('dea_id',Auth::user()->dea->id)->where('id','!=',$entrega->id_barrio)->pluck('nombre','id');

        return view('canasta_v2.entregas.editar', compact('entrega','barrios'));
    }

    public function update(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $barrio = Barrio::find($request->barrio_id);
            $paquete_barrio = PaqueteBarrio::where('id_paquete',$request->paquete_id)
                                        ->where('id_barrio',$barrio->id)
                                        ->where('distrito_id',$barrio->distrito_id)
                                        ->first();
            if($paquete_barrio != null){
                $entrega = Entrega::find($request->entrega_id);
                $entrega->update([
                    'id_barrio' => $paquete_barrio->id_barrio,
                    'distrito_id' => $paquete_barrio->distrito_id,
                    'paquete_barrio_id' => $paquete_barrio->id
                ]);

                return redirect()->route('entregas.index',$request->paquete_barrio_id)->with('success_message', 'Solicitud procesada.');
            }else{
                return back()->with('info_message', '[Error al cambiar de barrio. por favor contactarse con el area de sistemas.]');
            }
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
}
