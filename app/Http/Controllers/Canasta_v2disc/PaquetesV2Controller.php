<?php

namespace App\Http\Controllers\Canasta_v2;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Paquetes;
use App\Models\Canasta\PaquetePeriodo;
use App\Models\Canasta\PaqueteBarrio;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Entrega;
use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\EntregasBeneficiariosExcel;
use DB;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Canasta\Periodos;

class PaquetesV2Controller extends Controller
{
    private function completar_paquete_barrios()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $paquetes = Paquetes::where('dea_id',Auth::user()->dea->id)->where('estado','1')->get();
            foreach($paquetes as $paquete){
                $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->where('estado','1')->get();
                foreach($barrios as $barrio){
                    $datos_paquete_barrio = ([
                        'id_paquete' => $paquete->id,
                        'dea_id' => Auth::user()->dea->id,
                        'id_barrio' => $barrio->id,
                        'distrito_id' => $barrio->distrito_id,
                        'estado' => '1',
                    ]);
                    $paquete_barrio = PaqueteBarrio::create($datos_paquete_barrio);

                    $entregas = DB::table('entrega')->where('id_paquete',$paquete->id)->where('id_barrio',$barrio->id)->get();
                    foreach($entregas as $datos){
                        $entrega = Entrega::find($datos->id);
                        $entrega->update([
                            'id_ocupacion' => $entrega->beneficiario->id_ocupacion,
                            'distrito_id' => $barrio->distrito_id,
                            'paquete_barrio_id' => $paquete_barrio->id
                        ]);
                    }
                }
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
        dd("completar_paquete_barrios finalizado.");
    }

    private function actualizar_estados_entrega()
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $entregas_1 = DB::table('entrega')->whereIn('estado',['1','2'])->get();
            foreach($entregas_1 as $datos_1){
                $entrega_1 = Entrega::find($datos_1->id);
                if($entrega_1->beneficiario->estado == 'A'){
                    $entrega_1->update([
                        'estado' => '1'
                    ]);
                }else{
                    $entrega_1->update([
                        'estado' => '4'
                    ]);
                }
            }

            $entregas_2 = DB::table('entrega')->where('estado','3')->get();
            foreach($entregas_2 as $datos_2){
                $entrega_2 = Entrega::find($datos_2->id);
                if($entrega_2->beneficiario->estado == 'A'){
                    $entrega_2->update([
                        'estado' => '2'
                    ]);
                }else{
                    $entrega_2->update([
                        'estado' => '4'
                    ]);
                }
            }

            $entregas_3 = DB::table('entrega')->where('estado','4')->get();
            foreach($entregas_3 as $datos_3){
                $entrega_3 = Entrega::find($datos_3->id);
                $entrega_3->update([
                    'estado' => '3'
                ]);
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
        dd("actualizar_estados_entrega finalizado.");
    }

    public function index()
    {
        //if(Auth::user()->dea->id == 1){
            //$this->completar_paquete_barrios();
            //$this->actualizar_estados_entrega();
        //}
        $periodos = Periodos::pluck('mes','id');
        $entregas = Paquetes::select('numero')->groupBy('numero')->pluck('numero','numero');
        $paquetes = Paquetes::query()
                        ->byDea(Auth::user()->dea->id)
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('canasta_v2.paquetes.index',compact('periodos','entregas','paquetes'));
    }

    public function search(Request $request)
    {
        $periodos = Periodos::pluck('mes','id');
        $entregas = Paquetes::select('numero')->groupBy('numero')->pluck('numero','numero');
        $paquetes = Paquetes::query()
                        ->byDea(Auth::user()->dea->id)
                        ->byGestion($request->gestion)
                        ->byPeriodo($request->periodo_id)
                        ->byEntrega($request->entrega)
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('canasta_v2.paquetes.index',compact('periodos','entregas','paquetes'));
    }

    public function create()
    {
        $anho = date('Y');
        for($i = $anho - 2; $i <= $anho + 2; $i++){
            $gestiones[$i] = $i;
        }
        $numeros_entrega = Paquetes::NUMEROS_ENTREGA;
        $periodos = Periodos::pluck('mes','id');
        return view('canasta_v2.paquetes.create',compact('gestiones','numeros_entrega','periodos'));
    }

    public function store(Request $request)
    {
        $datos = ([
            'gestion' => $request->gestion,
            'items' => $request->items,
            'user_id' => Auth::user()->id,
            'dea_id' => Auth::user()->dea->id,
            'estado' => 1,
            'numero' => $request->numero
        ]);

        $paquete = Paquetes::create($datos);

        $cont = 0;
        while($cont < count($request->periodo_id)){
            $datos_paquete_barrio = ([
                'id_paquete' => $paquete->id,
                'id_periodo' => $request->periodo_id[$cont],
                'dea_id' => Auth::user()->dea->id,
                'estado' => '1'
            ]);
            $paquete_periodo = PaquetePeriodo::create($datos_paquete_barrio);

            $cont++;
        }

        /*$barrios = Barrio::where('dea_id',Auth::user()->dea->id)->where('estado','1')->get();
        foreach($barrios as $barrio){
            $datos_paquete_barrio = ([
                'id_paquete' => $paquete->id,
                'dea_id' => Auth::user()->dea->id,
                'id_barrio' => $barrio->id,
                'distrito_id' => $barrio->distrito_id,
                'estado' => '1',
            ]);
            $paquete_barrio = PaqueteBarrio::create($datos_paquete_barrio);
        }*/

        return redirect()->route('paquetes.index')->with('success_message', 'Registro procesado correctamente...');
    }

    public function editar($id_paquete)
    {
        $paquetes = Paquetes::find($id_paquete);
        return view('canasta_v2.paquetes.editar', compact('paquetes'));
    }

    public function update(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id_usuario = $personal->id;
        $dea_id = $personal->dea_id;
        $paquetes = Paquetes::find($request->id_paquete);
        $paquetes->gestion = $request->gestion;
        $paquetes->items = $request->items;
        $paquetes->numero = $request->numero;
        $paquetes->user_id = $id_usuario;
        $paquetes->dea_id = $dea_id;
        $paquetes->estado = 1;
        $paquetes->save();
        return redirect()->route('paquetes.index')->with('success_message', 'Registro procesado correctamente...');
    }

    public function beneficiarios($paquete_id)
    {
        $paquete_barrio = PaqueteBarrio::where('id_paquete',$paquete_id)->first();
        $extensiones = Beneficiario::EXTENSIONES;
        $sexos = Beneficiario::SEXOS;
        $estados = Entrega::ESTADOS;
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->join('barrios as c','c.id','entrega.id_barrio')
                            ->join('distritos as d','d.id','entrega.distrito_id')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($paquete_id)
                            ->select(
                                'c.nombre as _barrio',
                                'd.nombre as _distrito',
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
        if($entregas->count() == 0){
            return back()->with('info_message', '[No existen datos para mostrar.]');
        }
        return view('canasta_v2.paquetes.beneficiarios', compact('paquete_barrio','extensiones','sexos','estados','distritos','barrios','entregas'));
    }

    public function beneficiariosSearch($paquete_id, Request $request)
    {
        $paquete_barrio = PaqueteBarrio::where('id_paquete',$paquete_id)->first();
        $extensiones = Beneficiario::EXTENSIONES;
        $sexos = Beneficiario::SEXOS;
        $estados = Entrega::ESTADOS;
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $barrios = Barrio::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->join('barrios as c','c.id','entrega.id_barrio')
                            ->join('distritos as d','d.id','entrega.distrito_id')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($paquete_id)
                            ->byDistritos($request->distrito_id)
                            ->byBarrios($request->barrio_id)
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
                                'c.nombre as _barrio',
                                'd.nombre as _distrito',
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
                            ->orderBy('c.nombre','asc')
                            ->orderBy('d.nombre','asc')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->paginate(10);

        return view('canasta_v2.paquetes.beneficiarios', compact('paquete_barrio','extensiones','sexos','estados','distritos','barrios','entregas'));
    }

    public function beneficiariosExcel($paquete_id, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $paquete_barrio = PaqueteBarrio::where('id_paquete',$paquete_id)->first();
            $entregas = Entrega::query()
                        ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                        ->join('barrios as c','c.id','entrega.id_barrio')
                        ->join('distritos as d','d.id','entrega.distrito_id')
                        ->byDea(Auth::user()->dea->id)
                        ->byPaquete($paquete_id)
                        ->byDistritos($request->distrito_id)
                        ->byBarrios($request->barrio_id)
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
                            'c.nombre as _barrio',
                            'd.nombre as _distrito',
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
                            'entrega.resagado',
                            'b.created_att')
                        ->where('entrega.estado','!=','3')
                        ->orderBy('c.nombre','asc')
                        ->orderBy('d.nombre','asc')
                        ->orderBy('b.nombres','asc')
                        ->orderBy('b.ap','asc')
                        ->get();
            $cont = 1;

            return Excel::download(new EntregasBeneficiariosExcel($paquete_barrio,$entregas,$cont),'entrega_beneficiarios_canasta.xlsx');
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

    public function beneficiariosPdf($paquete_id, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $paquete_barrio = PaqueteBarrio::where('id_paquete',$paquete_id)->first();
                $entregas = Entrega::query()
                            ->join('beneficiarios as b','b.id','entrega.id_beneficiario')
                            ->join('barrios as c','c.id','entrega.id_barrio')
                            ->join('distritos as d','d.id','entrega.distrito_id')
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($paquete_id)
                            ->byDistritos($request->distrito_id)
                            ->byBarrios($request->barrio_id)
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
                                'c.nombre as _barrio',
                                'd.nombre as _distrito',
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
                                'entrega.resagado',
                                'b.created_att')
                            ->where('entrega.estado','!=','3')
                            ->orderBy('c.nombre','asc')
                            ->orderBy('d.nombre','asc')
                            ->orderBy('b.nombres','asc')
                            ->orderBy('b.ap','asc')
                            ->get();
                $cont = 1;

                $pdf = PDF::loadView('canasta_v2.paquetes.beneficiarios-pdf', compact(['paquete_barrio','entregas','cont']));
                $pdf->setPaper(array(0,0,612,935.43));
                $pdf->render();
                return $pdf->stream('Paquete_beneficiarios.pdf');

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
