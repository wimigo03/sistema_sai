<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use DB;
use PDF;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Area;
use App\Models\Mantenimiento;
use App\Models\MantenimientoDetalle;
use App\Models\User;
/*use App\Models\Empleado;


use App\Models\TipoArea;
use App\Models\Archivo;
use App\Models\TipoArchivo;*/
//use App\Models\ControlInterno;

class MantenimientoController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $clasificaciones = MantenimientoDetalle::CLASIFICACIONES;
        $areas = Area::query()->byDea($dea_id)->pluck('nombrearea','idarea');

        $empleados = DB::TABLE('empleados_contratos as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->where('a.dea_id',$dea_id)
                        ->where('a.estado','1')
                        ->select(DB::raw("concat(b.ap_pat, ' ', b.ap_mat, ' ', b.nombres) as empleado"),'a.idemp as id')
                        ->pluck('empleado','id');

        $estados = Mantenimiento::ESTADOS;
        $estados_detalles = MantenimientoDetalle::ESTADOS;

        $mantenimiento_detalles = MantenimientoDetalle::query()
                                    ->byDea($dea_id)
                                    ->orderBy('id','desc')
                                    ->paginate(10);

        return view('mantenimiento.index',compact('clasificaciones','areas','empleados','estados','estados_detalles','mantenimiento_detalles'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $clasificaciones = MantenimientoDetalle::CLASIFICACIONES;
        $areas = Area::query()->byDea($dea_id)->pluck('nombrearea','idarea');

        $empleados = DB::TABLE('empleados_contratos as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->where('a.dea_id',$dea_id)
                        ->where('a.estado','1')
                        ->select(DB::raw("concat(b.ap_pat, ' ', b.ap_mat, ' ', b.nombres) as empleado"),'a.idemp as id')
                        ->pluck('empleado','id');

        $estados = Mantenimiento::ESTADOS;
        $estados_detalles = MantenimientoDetalle::ESTADOS;

        $mantenimiento_detalles = MantenimientoDetalle::query()
                                    ->byDea($dea_id)
                                    ->byCodigo($request->codigo)
                                    ->byCodigoSerie($request->codigo_serie)
                                    ->byProcedencia($request->area_id)
                                    ->byEncargado($request->empleado_id)
                                    ->byClasificacion($request->clasificacion)
                                    ->byFechaRecepcion($request->fecha)
                                    ->byEstado($request->estado)
                                    ->byEstadoDetalle($request->estado_detalle)
                                    ->byAsignado($request->usuario)
                                    ->orderBy('id','desc')
                                    ->paginate(10);

        return view('mantenimiento.index',compact('clasificaciones','areas','empleados','estados','estados_detalles','mantenimiento_detalles'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::byDea($dea_id)->pluck('nombrearea','idarea');
        $clasificaciones = MantenimientoDetalle::CLASIFICACIONES;
        $empleados = DB::TABLE('empleados_contratos as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->where('a.dea_id',$dea_id)
                        ->where('a.estado','1')
                        ->select(DB::raw("concat(b.ap_pat, ' ', b.ap_mat, ' ', b.nombres) as empleado"),'a.idemp as id')
                        ->pluck('empleado','id');

        return view('mantenimiento.create',compact('areas','clasificaciones','empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required',
            'empleado_id' => 'required',
        ]);

        try {
	        $datos = DB::transaction(function () use($request) {

                $año_i = date('Y') . '-01-01 00:00:00';
                $año_f = date('Y') . '-12-31 23:59:59';
                $_registros = Mantenimiento::where('f_h_registro','>=',$año_i)->where('f_h_registro','<=',$año_f)->get()->count() + 1;
                $_registros = $_registros != null ? str_pad($_registros, 3, '0', STR_PAD_LEFT) : '-001';
                $codigo = date('y') . date('m') . '-' . $_registros;

                $mantenimiento = Mantenimiento::create([
                    'dea_id' => Auth::user()->dea->id,
                    'idarea' => $request->area_id,
                    'idemp' => $request->empleado_id,
                    'user_id' => Auth::user()->id,
                    'codigo' => $codigo,
                    'nro_comunicacion_interna' => $request->nro_comunicacion_interna,
                    'f_h_registro' => date('Y-m-d H:i:s'),
                    'observaciones' => $request->observaciones,
                    'estado' => '1',
                ]);

                $cont = 0;
                while($cont < count($request->codigo_serie)){
                    $mantenimiento_detalle = MantenimientoDetalle::create([
                        'mantenimiento_id' => $mantenimiento->id,
                        'dea_id' => Auth::user()->dea->id,
                        'idarea' => $request->area_id,
                        'idemp' => $request->empleado_id,
                        'user_id' => Auth::user()->id,
                        'codigo_serie' => $request->codigo_serie[$cont],
                        'clasificacion' => $request->clasificacion[$cont],
                        'fecha_r' => date('Y-m-d H:i:s'),
                        'problema_equipo' => $request->problema[$cont],
                        'estado' => '1',
                    ]);

                    $cont++;
                }

                return $mantenimiento;
	        });

            Log::channel('mantenimientos')->info(
                "\n" .
                "DATOS AGREGADOS: " . json_encode($datos->toArray()) . "\n" .
                "USUARIO: " . Auth::user()->id . "\n"
            );

            return redirect()->route('mantenimientos.index')->with('success_message', 'Procesado.');

	    } catch (\Throwable $th) {
			Log::channel('mantenimientos')->error(
                "\n" .
                "ERROR: " . $th->getMessage() . "\n" .
                "TRACE: " . $th->getTraceAsString() . "\n" .
                "USUARIO: " . Auth::user()->id . "\n"
            );

            return redirect()->back()->with('error_message','[Ocurrio un error al procesar los datos.]')->withInput();
        }
    }

    public function editar($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento_detalles = MantenimientoDetalle::where('mantenimiento_id',$id)->where('estado','!=','3')->get();

        $dea_id = Auth::user()->dea->id;
        $areas = Area::byDea($dea_id)->pluck('nombrearea','idarea');
        $clasificaciones = MantenimientoDetalle::CLASIFICACIONES;

        $empleados = DB::TABLE('empleados_contratos as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->where('a.dea_id',$dea_id)
                        ->where('a.estado','1')
                        ->select(DB::raw("concat(b.ap_pat, ' ', b.ap_mat, ' ', b.nombres) as empleado"),'a.idemp as id')
                        ->pluck('empleado','id');

        return view('mantenimiento.create',compact('mantenimiento','mantenimiento_detalles','areas','clasificaciones','empleados'));
    }

    public function editarDetalle($id)
    {
        $edicion = MantenimientoDetalle::find($id);
        $mantenimiento = Mantenimiento::find($edicion->mantenimiento_id);
        $mantenimiento_detalles = MantenimientoDetalle::where('mantenimiento_id',$edicion->mantenimiento_id)->where('estado','!=','3')->get();

        $dea_id = Auth::user()->dea->id;
        $areas = Area::byDea($dea_id)->pluck('nombrearea','idarea');
        $clasificaciones = MantenimientoDetalle::CLASIFICACIONES;

        $empleados = DB::TABLE('empleados_contratos as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->where('a.dea_id',$dea_id)
                        ->where('a.estado','1')
                        ->select(DB::raw("concat(b.ap_pat, ' ', b.ap_mat, ' ', b.nombres) as empleado"),'a.idemp as id')
                        ->pluck('empleado','id');

        return view('mantenimiento.edicion-detalle',compact('edicion','mantenimiento','mantenimiento_detalles','areas','clasificaciones','empleados'));
    }

    public function updateDetalle(Request $request)
    {
        $mantenimiento_detalle = MantenimientoDetalle::find($request->mantenimiento_detalle_id);
        $mantenimiento_detalle->update([
            'codigo_serie' => $request->codigo_serie,
            'clasificacion' => $request->clasificacion,
            'problema_equipo' => $request->descripcion,
        ]);

        return redirect()->route('mantenimientos.editar', $mantenimiento_detalle->mantenimiento_id)->with('success_message', 'Procesado.');
    }

    public function eliminarRegistro($id)
    {
        $mantenimiento_detalle = MantenimientoDetalle::find($id);
        if($mantenimiento_detalle != null){
            $mantenimiento_detalle->update([
                'estado' => '3' //ELIMINADO
            ]);
            return response()->json([
                'Eliminado' => 'Eliminado'
            ]);
        }

        return response()->json(['error'=>'[ERROR]']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'area_id' => 'required',
            'empleado_id' => 'required',
        ]);

        try {
	        $datos = DB::transaction(function () use($request) {

                $mantenimiento = Mantenimiento::find($request->mantenimiento_id);
                $mantenimiento->update([
                    'idarea' => $request->area_id,
                    'idemp' => $request->empleado_id,
                    'user_id' => Auth::user()->id,
                    'nro_comunicacion_interna' => $request->nro_comunicacion_interna,
                    'observaciones' => $request->observaciones,
                ]);

                if(isset($request->codigo_serie))
                {
                    $cont = 0;
                    while($cont < count($request->codigo_serie)){
                        $mantenimiento_detalle = MantenimientoDetalle::create([
                            'mantenimiento_id' => $mantenimiento->id,
                            'dea_id' => Auth::user()->dea->id,
                            'idarea' => $request->area_id,
                            'idemp' => $request->empleado_id,
                            'user_id' => Auth::user()->id,
                            'codigo_serie' => $request->codigo_serie[$cont],
                            'clasificacion' => $request->clasificacion[$cont],
                            'fecha_r' => date('Y-m-d H:i:s'),
                            'problema_equipo' => $request->problema[$cont],
                            'estado' => '1',
                        ]);

                        $cont++;
                    }
                }

                return $mantenimiento;
	        });

            Log::channel('mantenimientos')->info(
                "\n" .
                "DATOS MODIFICADOS: " . json_encode($datos->toArray()) . "\n" .
                "USUARIO: " . Auth::user()->id . "\n"
            );

            return redirect()->route('mantenimientos.index')->with('success_message', 'Procesado.');

	    } catch (\Throwable $th) {
			Log::channel('mantenimientos')->error(
                "\n" .
                "ERROR: " . $th->getMessage() . "\n" .
                "TRACE: " . $th->getTraceAsString() . "\n" .
                "USUARIO: " . Auth::user()->id . "\n"
            );

            return redirect()->back()->with('error_message','[Ocurrio un error al procesar los datos.]')->withInput();
        }
    }

    public function pdf($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento_detalles = MantenimientoDetalle::where('mantenimiento_id',$id)->where('estado','!=','3')->get();
        $cont = 1;
        $username = User::find(Auth::user()->id);
        $username = $username != null ? $username->nombre_completo : $username->name;
        $pdf = PDF::loadView('mantenimiento.pdf',compact('mantenimiento','mantenimiento_detalles','cont','username'));
        $pdf->setPaper('LETTER', 'landscape');
        return $pdf->stream();
    }

    public function show($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento_detalles = MantenimientoDetalle::where('mantenimiento_id',$id)->where('estado','!=','3')->get();

        return view('mantenimiento.show',compact('mantenimiento','mantenimiento_detalles'));
    }

    public function storeDetalle(Request $request)
    {
        $cont = 0;
        while($cont < count($request->id)){
            if($request->solucion_equipo[$cont] != null || $request->solucion_equipo[$cont] != ''){
                $mantenimiento_detalle = MantenimientoDetalle::find($request->id[$cont]);
                $mantenimiento_detalle->update([
                    'diagnostico' => $request->diagnostico[$cont],
                    'solucion_equipo' => $request->solucion_equipo[$cont],
                    'fecha_d' => date('Y-m-d H:i:s'),
                    'user_asignado_id' => Auth::user()->id,
                    'estado' => '2',
                ]);
            }else{
                $mantenimiento_detalle = MantenimientoDetalle::find($request->id[$cont]);
                $mantenimiento_detalle->update([
                    'diagnostico' => null,
                    'solucion_equipo' => null,
                    'fecha_d' => null,
                    'user_asignado_id' => null,
                    'estado' => '1',
                ]);
            }

            $cont++;
        }

        return redirect()->route('mantenimientos.index')->with('success_message', 'Procesado.');
    }

    public function finalizar($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento->update([
            'estado' => '2',
        ]);

        return redirect()->route('mantenimientos.index')->with('success_message', 'Procesado.');
    }

    public function habilitar($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento->update([
            'estado' => '1',
        ]);

        return back()->with('success_message', 'Procesado.');
    }
}
