<?php

namespace App\Http\Controllers\Canasta_v2;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Entrega;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\Ocupaciones;
use App\Models\Canasta\Paquetes;
use App\Models\Canasta\BarrioEntrega;
use App\Models\Canasta\Periodos;
use App\Models\Canasta\PaquetePeriodo;
use App\Models\Canasta\Dea;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\PaquetesBarrioExcel;
use DB;
use PDF;
use Carbon\Carbon;
use App\Models\Canasta\PaqueteBarrio;
use App\Models\User;
use App\Models\Empleado;

class PaqueteBarrioV2Controller extends Controller
{
    public function index($idpaquete)
    {
        $paquete = Paquetes::find($idpaquete);
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $barrios = DB::table('paquete_barrios as a')
                            ->join('barrios as b','b.id','a.id_barrio')
                            ->where('a.id_paquete',$idpaquete)
                            ->orderBy('b.id','asc')
                            ->pluck('b.nombre','b.id');

        $lugares_entregas = PaqueteBarrio::query()
                            ->select(DB::raw("COALESCE(lugar_entrega, 'LUGARES NO DEFINIDOS') as lugar_entrega"))
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($idpaquete)
                            ->groupBy('lugar_entrega')
                            ->orderByRaw("CASE WHEN lugar_entrega IS NULL THEN 0 ELSE 1 END, lugar_entrega ASC")
                            ->pluck('lugar_entrega','lugar_entrega');

        $estados = PaqueteBarrio::ESTADOS;

        $paquetes_barrios = PaqueteBarrio::query()
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($idpaquete)
                            ->orderBy('id','desc')
                            ->paginate(10);

        return view('canasta_v2disc.paquetes-barrio.index', compact('paquete','distritos','barrios','lugares_entregas','estados','paquetes_barrios'));
    }

    public function search($idpaquete, Request $request)
    {
        $paquete = Paquetes::find($idpaquete);
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $barrios = DB::table('paquete_barrios as a')
                            ->join('barrios as b','b.id','a.id_barrio')
                            ->where('a.id_paquete',$idpaquete)
                            ->orderBy('b.id','asc')
                            ->pluck('b.nombre','b.id');

        $lugares_entregas = PaqueteBarrio::query()
                            ->select(DB::raw("COALESCE(lugar_entrega, 'LUGARES NO DEFINIDOS') as lugar_entrega"))
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($idpaquete)
                            ->groupBy('lugar_entrega')
                            ->orderByRaw("CASE WHEN lugar_entrega IS NULL THEN 0 ELSE 1 END, lugar_entrega ASC")
                            ->pluck('lugar_entrega','lugar_entrega');

        $estados = PaqueteBarrio::ESTADOS;

        $paquetes_barrios = PaqueteBarrio::query()
                            ->byDea(Auth::user()->dea->id)
                            ->byPaquete($idpaquete)
                            ->byDistrito($request->distrito_id)
                            ->byBarrio($request->barrio_id)
                            ->byLugarEntrega($request->lugar_entrega)
                            ->byFechaEntrega($request->fecha_inicial, $request->fecha_final)
                            ->byEstado($request->estado)
                            ->orderBy('id','desc')
                            ->paginate(10);

        return view('canasta_v2.paquetes-barrio.index', compact('paquete','distritos','barrios','lugares_entregas','estados','paquetes_barrios'));
    }

    public function pdf($idpaquete, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $paquete = Paquetes::find($idpaquete);
                $paquetes_barrios = PaqueteBarrio::query()
                                    ->byDea(Auth::user()->dea->id)
                                    ->byPaquete($idpaquete)
                                    ->byDistrito($request->distrito_id)
                                    ->byBarrio($request->barrio_id)
                                    ->byLugarEntrega($request->lugar_entrega)
                                    ->byFechaEntrega($request->fecha_inicial, $request->fecha_final)
                                    ->byEstado($request->estado)
                                    ->orderBy('distrito_id','asc')
                                    ->get();

                $pdf = PDF::loadView('canasta_v2.paquetes-barrio.pdf', compact(['paquete','paquetes_barrios']));
                $pdf->setPaper('LETTER', 'portrait');
                $pdf->render();
                return $pdf->stream('cronograma_' . $paquete->numero .  '.pdf');
                //return $pdf->download('cronograma_' . $paquete->numero .  '.pdf');
        } finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function excel($idpaquete, Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $paquete = Paquetes::find($idpaquete);
            $paquetes_barrios = PaqueteBarrio::query()
                                ->byDea(Auth::user()->dea->id)
                                ->byPaquete($idpaquete)
                                ->byDistrito($request->distrito_id)
                                ->byBarrio($request->barrio_id)
                                ->byLugarEntrega($request->lugar_entrega)
                                ->byFechaEntrega($request->fecha_inicial, $request->fecha_final)
                                ->byEstado($request->estado)
                                ->orderBy('id','desc')
                                ->get();
            $cont = 1;

            return Excel::download(new PaquetesBarrioExcel($paquete,$paquetes_barrios,$cont),'cronograma_barrios.xlsx');
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

    public function create($paquete_id)
    {
        $distritos = Distrito::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        return view('canasta_v2.paquetes-barrio.create', compact('paquete_id','distritos'));
    }

    public function getBarrios(Request $request){
        try{
            $paquete_id = $request->paquete_id;
            $distrito_id = $request->distrito_id;
            $barrios = DB::table('barrios as a')
                            ->select('a.id as barrio_id','a.nombre')
                            ->where('a.distrito_id',$distrito_id)
                            ->where('a.estado','1')
                            ->whereNotIn('a.id', function ($query) use ($paquete_id) {
                                $query->select('id_barrio')
                                      ->from('paquete_barrios')
                                      ->where('id_paquete',$paquete_id);
                            })
                            ->orderBy('a.id','asc')
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

    public function store(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $cont = 0;
            while($cont < count($request->barrio_id)){
                $datos_paquete_barrio = ([
                    'id_paquete' => $request->paquete_id,
                    'dea_id' => Auth::user()->dea->id,
                    'id_barrio' => $request->barrio_id[$cont],
                    'distrito_id' => $request->distrito_id[$cont],
                    'lugar_entrega' => $request->lugar_entrega[$cont],
                    'fecha_entrega' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_entrega[$cont]))),
                    'hora_inicio' => $request->hora_inicio[$cont],
                    'hora_final' => $request->hora_final[$cont],
                    'estado' => '1'
                ]);

                $paquete_barrio_id = PaqueteBarrio::create($datos_paquete_barrio);
                $cont++;
            }

            return redirect()->route('paquetes.barrio.index',$request->paquete_id)->with('success_message', 'Cronograma procesado correctamente...');

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

    public function editar($paquete_barrio_id)
    {
        $paquete_barrio = PaqueteBarrio::find($paquete_barrio_id);

        return view('canasta_v2.paquetes-barrio.editar', compact('paquete_barrio'));
    }

    public function update(Request $request)
    {
        $paquete_barrio = PaqueteBarrio::find($request->paquete_barrio_id);
        $paquete_barrio->update([
            'lugar_entrega' => $request->lugar_entrega,
            'fecha_entrega' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_entrega))),
            'hora_inicio' => $request->hora_inicio,
            'hora_final' => $request->hora_final
        ]);

        return redirect()->route('paquetes.barrio.index',$paquete_barrio->id_paquete)->with('success_message', 'Cronograma actualizado correctamente...');
    }
}
