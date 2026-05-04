<?php

namespace App\Http\Controllers\Canasta_v2disc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CanastaDisc\Paquetes;
use App\Models\CanastaDisc\PaquetePeriodo;
use App\Models\CanastaDisc\PaqueteBarrio;
use App\Models\CanastaDisc\Beneficiario;
use App\Models\CanastaDisc\Barrio;
use App\Models\CanastaDisc\Distrito;
use App\Models\CanastaDisc\Entrega;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\EntregasBeneficiariosExcel;
use DB;
use PDF;
use App\Models\User;
use App\Models\Canasta\Periodos;

class PaquetesV2Controller extends Controller
{
    public function index()
    {
        $periodos = Periodos::pluck('mes','id');
        $entregas = Paquetes::select('numero')->groupBy('numero')->pluck('numero','numero');
        $paquetes = Paquetes::query()
                        ->byDea(Auth::user()->dea->id)
                        ->where('id_tipo','=',2)
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('canasta_v2disc.paquetes.index',compact('periodos','entregas','paquetes'));
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
        return view('canasta_v2disc.paquetes.create',compact('gestiones','numeros_entrega','periodos'));
    }

    public function store(Request $request)
    {
        $datos = ([
            'gestion' => $request->gestion,
            'items' => $request->items,
            'user_id' => Auth::user()->id,
            'dea_id' => Auth::user()->dea->id,
            'estado' => 1,
            'id_tipo' => 2,
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

        return redirect()->route('paquetesdisc.index')->with('success_message', 'Registro procesado correctamente...');
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
        return view('canasta_v2disc.paquetes.beneficiarios', compact('paquete_barrio','extensiones','sexos','estados','distritos','barrios','entregas'));
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
