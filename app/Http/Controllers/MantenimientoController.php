<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Area;
use App\Models\Mantenimiento;
use App\Models\MantenimientoDetalle;
/*use App\Models\Empleado;
use App\Models\User;

use App\Models\TipoArea;
use App\Models\Archivo;
use App\Models\TipoArchivo;*/
//use App\Models\ControlInterno;

class MantenimientoController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $mantenimientos = Mantenimiento::query()->byDea($dea_id)->paginate(10);

        /*$areas = Area::query()->byDea(Auth::user()->dea->id)->pluck('nombrearea','idarea');
        $estados = ControlInterno::ESTADOS;

        $controles_internos = ControlInterno::query()
                                ->byDea(Auth::user()->dea->id)
                                ->byArea(Auth::user()->area_asignada_id)
                                ->orderBy('fecha','desc')
                                ->orderBy('nro','desc')
                                ->paginate(10);*/

        return view('mantenimiento.index',compact('mantenimientos'));
    }

    /*public function search(Request $request)
    {
        $tipos = DB::TABLE('tipoarea as a')
                    ->join('tipoarchivo as b','b.idtipo','a.idtipo')
                    ->select('b.nombretipo as tipo','b.idtipo as id')
                    ->where('a.idarea',Auth::user()->area_asignada_id)
                    ->where('a.dea_id',Auth::user()->dea->id)
                    ->where('b.subtipo','1')
                    ->pluck('tipo','id');

        $areas = Area::query()->byDea(Auth::user()->dea->id)->pluck('nombrearea','idarea');
        $estados = ControlInterno::ESTADOS;

        $controles_internos = ControlInterno::query()
                                ->byDea(Auth::user()->dea->id)
                                ->byArea(Auth::user()->area_asignada_id)
                                ->byNumero($request->numero)
                                ->byTipo($request->tipo_id)
                                ->bySolicitante($request->solicitante)
                                ->byAreaDestino($request->area_id)
                                ->byDirigido($request->dirigido)
                                ->byReferencia($request->referencia)
                                ->byFecha($request->fecha)
                                ->byEstado($request->estado)
                                ->orderBy('fecha','desc')
                                ->orderBy('nro','desc')
                                ->paginate(10);

        return view('control-interno.index', compact('tipos','areas','estados','controles_internos'));
    }*/
//dilson
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

        return view('mantenimiento.create',compact('areas','clasificaciones','clasificaciones','empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required',
            'empleado_id' => 'required',
            'nro_comunicacion_interna' => 'required',
        ]);

        try {
	        $datos = DB::transaction(function () use($request) {

                $año_i = date('Y') . '-01-01 00:00:00';
                $año_f = date('Y') . '-12-31 23:59:59';
                $_registros = Mantenimiento::where('created_at','>=',$año_i)->where('created_at','<=',$año_f)->get()->count() + 1;
                $_registros = $_registros != null ? str_pad($_registros, 3, '0', STR_PAD_LEFT) : '001';
                $codigo = date('y') . date('m') . $_registros;

                $mantenimiento = Mantenimiento::create([
                    'dea_id' => Auth::user()->dea->id,
                    'idarea' => $request->area_id,
                    'idemp' => $request->empleado_id,
                    'user_id' => Auth::user()->id,
                    'codigo' => $codigo,
                    'nro_comunicacion_interna' => $request->nro_comunicacion_interna,
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
                        'fecha_r' => date('Y-m-d H:i'),
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
        $control_interno = ControlInterno::find($id);

        $solicitantes = DB::TABLE('empleados_contratos as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->where('a.dea_id',Auth::user()->dea->id)
                        ->where('a.idarea_asignada',Auth::user()->area_asignada_id)
                        ->where('a.estado','1')
                        ->select(DB::raw("concat(b.ap_pat, ' ', b.ap_mat, ' ', b.nombres) as empleado"),'a.idemp as id')
                        ->get();

        $destinatarios = DB::TABLE('empleados as a')
                        ->join('empleados_contratos as b','b.idemp','a.idemp')
                        ->join('areas as c','c.idarea','b.idarea_asignada')
                        ->where('a.dea_id',Auth::user()->dea->id)
                        ->where('a.idemp','!=',Auth::user()->idemp)
                        ->select(DB::raw("concat(c.nombrearea , ' - ',a.ap_pat, ' ', a.ap_mat, ' ', a.nombres) as empleado"),'a.idemp as id')
                        ->get();

        return view('control-interno.editar',compact('control_interno','solicitantes','destinatarios'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'word_file' => 'nullable|mimes:doc,docx|max:5120',
            'pdf_file' => 'nullable|mimes:pdf,jpg,jpeg|max:5120'
        ]);
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $empleado = Empleado::find($request->destinatario_id);
                $_empleado = Empleado::find($request->solicitante_id);
                $control_interno = ControlInterno::find($request->control_interno_id);
                $area_id = $control_interno->idarea;
                $tipo_id = $control_interno->idtipo;
                $numero = $control_interno->nro;
                $nombre_area = $control_interno->area->nombrearea;
                $fecha = substr($control_interno->fecha, 0, 10);
                $gestion = substr($fecha, 0, 4);
                $control_interno->update([
                    'empleado_destinatario_id' => $request->destinatario_id,
                    'empleado_solicitante_id' => $request->solicitante_id,
                    'destinatario_idarea' => $empleado->ultima_area_asignada_id,
                    'nro' => $request->numero,
                    'referencia' => $request->referencia,
                    'fecha' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha))),
                    'observaciones' => $request->observaciones
                ]);


                if(isset($request->word_file)){
                    $word_file_name = isset($request->word_file) ?  Auth::user()->id . '_' . date('Ymdhis') . '.' . pathinfo($request->word_file->getClientOriginalName(), PATHINFO_EXTENSION) : null;
                    $word_ruta = 'file-control-interno/';
                    $cargar_word_file_name = $request->word_file->move(public_path($word_ruta), $word_file_name);
                    $control_interno->update([
                        'nombre_archivo' => $word_file_name
                    ]);
                }

                if(isset($request->pdf_file)){
                    $nombre = "pdf_" . time() . "." . $request->pdf_file->guessExtension();
                    $cargar_pdf_file_name = $request->pdf_file->move(public_path("/documentos/" . $nombre_area), $nombre);
                    $archivo_local = Archivo::create([
                        'idarea' => $area_id,
                        'dea_id' => Auth::user()->dea->id,
                        'idtipo' => $tipo_id,
                        'nombrearchivo' => $numero,
                        'documento' => $nombre_area . '/' . $nombre,
                        'estado1' => 1,
                        'referencia' => $request->referencia,
                        'gestion' => $gestion,
                        'id' => Auth::user()->id,
                        'fecha' => $fecha
                    ]);

                    $url = 'https://sistemas.granchaco.gob.bo/archivos/documentacion/' . $archivo_local->idarchivo;
                    $qr = QrCode::format('png')->margin(0)->size(300)->generate($url, public_path() . '/documentos/qr/' . $archivo_local->idarchivo . '.png');

                    $control_interno->update([
                        'idarchivo' => $archivo_local->idarchivo
                    ]);
                }

                return redirect()->route('control.interno.index')->with('success_message', 'Proceso realizado exitosamente.');
        } catch (\Throwable $th){
            return '[ERROR_500]';
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function descargarWord($id)
    {
        $control_interno = ControlInterno::find($id);
        if($control_interno != null){
            if($control_interno->nombre_archivo != null){
                $nombre_archivo = asset('file-control-interno/' . $control_interno->nombre_archivo);
                return redirect()->away($nombre_archivo);
            }
        }

        return back()->with('info_message', 'Archivo no encontrado.');
    }

    public function anular($id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $control_interno = ControlInterno::find($id);
                $control_interno->update([
                    'estado' => '2'
                ]);

                return redirect()->route('control.interno.index')->with('success_message', 'Proceso realizado exitosamente.');
        } catch (\Throwable $th){
            return '[ERROR_500]';
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function habilitar($id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $control_interno = ControlInterno::find($id);
                $control_interno->update([
                    'estado' => '1'
                ]);

                return redirect()->route('control.interno.editar', $id)->with('success_message', 'Proceso realizado exitosamente.');
        } catch (\Throwable $th){
            return '[ERROR_500]';
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
