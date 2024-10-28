<?php

namespace App\Http\Controllers\Canasta_v2disc;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\CanastaDisc\Barrio;
use App\Models\CanastaDisc\Entrega;
use App\Models\CanastaDisc\Distrito;
use App\Models\CanastaDisc\Beneficiario;
use App\Models\CanastaDisc\PaqueteBarrio;
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
                            //->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->paginate(10);
        $cont = 1;

        return view('canasta_v2disc.entregas.index', compact('paquete_barrio','extensiones','sexos','estados','entregas','cont'));
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
                            //->where('entrega.estado','!=','3')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->paginate(10);
        $cont = 1;

        return view('canasta_v2disc.entregas.index', compact('paquete_barrio','extensiones','sexos','estados','entregas','cont'));
    }

    public function create($paquete_barrio_id)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);

        $beneficiarios = Beneficiario::query()
                        ->byDea(Auth::user()->dea->id)
                        ->byDistrito($paquete_barrio->distrito_id)
                        ->byBarrio($paquete_barrio->id_barrio)
                        ->byEstado('A')
                        ->where('id_tipo','=',2)
                        ->whereNotIn('id', function ($query) use ($paquete_barrio_id) {
                            $query->select('id_beneficiario')
                                  ->from('entrega')
                                  ->where('paquete_barrio_id',$paquete_barrio_id);
                        })
                        ->get();

        $cont = 1;
        return view('canasta_v2disc.entregas.create', compact('paquete_barrio','beneficiarios','cont'));
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
                    'id_tipo' => '2',
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

            return redirect()->route('entregasdisc.index',$request->paquete_barrio_id)->with('success_message', 'Beneficiarios registrados exitosamente...');

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
            'estado' => '4',
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

            return redirect()->route('entregasdisc.index',$paquete_barrio_id)->with('success_message', '[Canasta entregada a todos los beneficiarios]');

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

            return redirect()->route('entregasdisc.index',$paquete_barrio_id)->with('info_message', '[Devolucion de canasta beneficiarios procesada]');

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
            $pdf = PDF::loadView('canasta_v2disc.entregas.generar-boleta-pdf', compact(['entrega','qrCode']));
            $pdf->setPaper(array(0,0,612,396.81));
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

            $pdf = PDF::loadView('canasta_v2disc.entregas.generar-boleta-all-pdf', compact(['array_entrega']));
            //$pdf->setPaper(array(0,0,612,935.43));
            $pdf->setPaper(array(0,0,612,396.81));
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

                $pdf = PDF::loadView('canasta_v2disc.entregas.pdf-habilitados-sin-registro', compact(['paquete_barrio','entregas','cont']));
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
//dd($entregas);
                $pdf = PDF::loadView('canasta_v2disc.entregas.pdf-habilitados-con-registro', compact(['paquete_barrio','entregas','cont']));
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

        return redirect()->route('entregasdisc.index',$paquete_barrio_id)->with('info_message', '[ENTREGA FINALIZADA]');
    }

    public function restablecer($paquete_barrio_id)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);
        $paquete_barrio->update([
            'estado' => '1'
        ]);

        return redirect()->route('entregasdisc.index',$paquete_barrio_id)->with('success_message', '[ENTREGA RESTABLECIDA]');
    }

    public function editar($entrega_id)
    {
        $entrega = Entrega::find($entrega_id);
        $barrios = Barrio::select('id','nombre')->where('dea_id',Auth::user()->dea->id)->where('id','!=',$entrega->id_barrio)->pluck('nombre','id');

        return view('canasta_v2disc.entregas.editar', compact('entrega','barrios'));
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

                return redirect()->route('entregasdisc.index',$request->paquete_barrio_id)->with('success_message', 'Solicitud procesada.');
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
