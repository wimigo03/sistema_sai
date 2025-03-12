<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Empleado;
use App\Models\User;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\CategoriaPresupuestaria;
use App\Models\Almacenes\SolicitudMaterial;
use App\Models\Almacenes\SolicitudMaterialDetalle;
use App\Models\Almacenes\SalidaAlmacen;
use App\Models\Almacenes\SalidaAlmacenDetalle;
use App\Models\Compra\Item;
use App\Models\Area;

class SolicitudMaterialController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $programas = CategoriaProgramatica::where('dea_id',$dea_id)->pluck('codigo','id');
        $estados = SolicitudMaterial::ESTADOS;
        $solicitudes_materiales = SolicitudMaterial::query()
                                                ->ByDea(Auth::user()->dea->id)
                                                ->where('estado','!=','4')
                                                ->orderBy('id','desc')
                                                ->paginate(10);

        return view('almacenes.solicitud_material.index',compact('areas','users','programas','estados','solicitudes_materiales'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $programas = CategoriaProgramatica::where('dea_id',$dea_id)->pluck('codigo','id');
        $estados = SolicitudMaterial::ESTADOS;
        $solicitudes_materiales = SolicitudMaterial::query()
                                                ->ByDea(Auth::user()->dea->id)
                                                ->ByCodigo($request->codigo)
                                                ->ByFecha($request->fecha)
                                                ->ByArea($request->area_id)
                                                ->BySolicitante($request->solicitante_id)
                                                ->ByPrograma($request->programa_id)
                                                ->ByEstado($request->estado)
                                                ->where('estado','!=','4')
                                                ->orderBy('id','desc')
                                                ->paginate(10);

        return view('almacenes.solicitud_material.index',compact('areas','users','programas','estados','solicitudes_materiales'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $empleado = Empleado::find(Auth::user()->idemp);
        $user = User::find(Auth::user()->id);
        $fecha_inicial = '01/01/' . date('Y');
        $fecha_final = '31/12/' . date('Y');
        $solicitudes = SolicitudMaterial::query()
                                ->ByDea($dea_id)
                                ->ByArea(Auth::user()->idarea)
                                ->ByFechas($fecha_inicial,$fecha_final)
                                ->get()
                                ->count();

        $codigo_solicitud = substr(date('Y'), -2) . '-' . (str_pad($solicitudes + 1,3,"0",STR_PAD_LEFT));

        $categoria_programatica_id = Area::find(Auth::user()->area_asignada_id)->categoria_programatica_id;
        if($categoria_programatica_id == null){
            return redirect()->back()->with('error_message','<b>[ERROR]</b>. PROGRAMA NO ASIGNADO')->withInput();
        }

        $partidas_presupuestarias = CategoriaPresupuestaria::where('categoria_programatica_id',$categoria_programatica_id)->where('estado','1')->get();
        foreach($partidas_presupuestarias as $datos){
            $partidas[] = $datos->partida_presupuestaria_id;
        }

        $items = Item::join('unidades as b', 'b.id', 'items.unidad_id')
                    ->where('items.dea_id', $dea_id)
                    ->where('items.tipo', '1')
                    ->where('items.estado', '1')
                    ->whereIn('items.partida_presupuestaria_id',$partidas)
                    ->select(DB::raw("concat(items.codigo, '-', items.nombre, '_(', b.nombre, ')') as material"), 'items.id as item_id')
                    ->pluck('material', 'item_id');

        $cont = 0;

        return view('almacenes.solicitud_material.create',compact('empleado','user','codigo_solicitud','categoria_programatica_id','items','cont'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_solicitud' => 'required',
        ]);

        $user_solicitud = User::find(Auth::user()->id);
        $area = Area::find($user_solicitud->area_asignada_id);
        if($area == null){
            return redirect()->back()->with('error_message','[EL AREA SELECCIONADA NO TIENE ASIGNADO UN ALMACEN]')->withInput();
        }
        if($area->almacen_id == null){
            return redirect()->back()->with('error_message','[NO TIENES UN ALMACEN ASIGNADO]')->withInput();
        }

        try{
            $function = DB::transaction(function () use ($request, $user_solicitud, $area) {
                $dea_id = Auth::user()->dea->id;
                $solicitud_material = SolicitudMaterial::create([
                    'dea_id' => $dea_id,
                    'user_solicitud_id' => $user_solicitud->id,
                    'solicitud_idemp' => $user_solicitud->idemp,
                    'solicitud_idarea' => $area->idarea,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'almacen_id' => $area->almacen_id,
                    'cod_solicitud' => $request->cod_solicitud,
                    'fsolicitud' => date('Y-m-d H:i:s'),
                    'obs' => $request->obs,
                    'estado' => '1',
                ]);

                $cont = 0;
                while($cont < count($request->item_id)){
                    $item = Item::find($request->item_id[$cont]);
                    $solicitud_material_detalle = SolicitudMaterialDetalle::create([
                        'solicitud_material_id' => $solicitud_material->id,
                        'dea_id' => $solicitud_material->dea_id,
                        'user_solicitud_id' => $solicitud_material->user_solicitud_id,
                        'solicitud_idemp' => $solicitud_material->solicitud_idemp,
                        'solicitud_idarea' => $solicitud_material->solicitud_idarea,
                        'categoria_programatica_id' => $request->categoria_programatica_id,
                        'partida_presupuestaria_id' => $item->partida_presupuestaria_id,
                        'item_id' => $item->id,
                        'unidad_id' => $item->unidad_id,
                        'almacen_id' => $solicitud_material->almacen_id,
                        'cant_solicitada' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'estado' => '1',
                    ]);

                    $cont++;
                }

                return $solicitud_material;
            });
            Log::channel('solicitud_materiales')->info(
                "Solicitud de Material: Creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.material.index')->with('success_message', '[La solicitud de Material fue registrada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitud_materiales')->info(
                "Error al crear la solicitud de Material: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la solicitud de Material.]')->withInput();
        }
    }

    public function show($id)
    {
        $data = SolicitudMaterial::find($id);
        $detalles = SolicitudMaterialDetalle::where('solicitud_material_id',$id)->where('estado','1')->get();
        $cont = 1;
        return view('almacenes.solicitud_material.show',compact('data','detalles','cont'));
    }

    public function aprobar(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $function = DB::transaction(function () use ($request) {

                $user_aprobado = User::find(Auth::user()->id);
                $solicitud_material = SolicitudMaterial::find($request->id);
                $solicitud_material->update([
                    'estado' => '2',
                    'user_aprobado_id' => $user_aprobado->id,
                    'aprobado_idarea' => $user_aprobado->area_asignada_id,
                    'aprobado_idemp' => $user_aprobado->idemp,
                    'faprobacion' => date('Y-m-d H:i:s')
                ]);

                $cont = 0;
                while($cont < count($request->detalle_id)){
                    $solicitud_material_detalle = SolicitudMaterialDetalle::find($request->detalle_id[$cont]);
                    $solicitud_material_detalle->update([
                        'user_aprobado_id' => $user_aprobado->id,
                        'aprobado_idarea' => $user_aprobado->area_asignada_id,
                        'aprobado_idemp' => $user_aprobado->idemp,
                        'cant_autorizada' => $request->cant_autorizada[$cont],
                    ]);
                    $cont++;
                }

                $date = date('Y-m-d');
                $salidasAlmacen = SalidaAlmacen::where('dea_id',$solicitud_material->dea_id)
                                            ->whereYear('fcreate', date('Y', strtotime($date)))
                                            ->get()
                                            ->count();
                $codigo_dea = Auth::user()->dea->nombre;
                $gestion = substr(date('Y', strtotime($date)), -2);
                $numero = $salidasAlmacen + 1;
                $codigo = $codigo_dea . $gestion . '-' . (str_pad($numero,3,"0",STR_PAD_LEFT));

                $salida_almacen = SalidaAlmacen::create([
                    'dea_id' => $solicitud_material->dea_id,
                    'solicitud_material_id' => $solicitud_material->id,
                    'user_solicitud_id' => $solicitud_material->user_solicitud_id,
                    'solicitud_idarea' => $solicitud_material->solicitud_idarea,
                    'solicitud_idemp' => $solicitud_material->solicitud_idemp,
                    'user_aprobado_id' => $solicitud_material->user_aprobado_id,
                    'aprobado_idemp' => $solicitud_material->aprobado_idemp,
                    'aprobado_idarea' => $solicitud_material->aprobado_idarea,
                    'categoria_programatica_id' => $solicitud_material->categoria_programatica_id,
                    'almacen_id' => $solicitud_material->almacen_id,
                    'cod_salida' => $codigo,
                    'fcreate' => date('Y-m-d H:i:s'),
                    'estado' => '1'
                ]);

                $solicitud_materiales_detalles = SolicitudMaterialDetalle::where('solicitud_material_id',$request->id)->where('estado','1')->get();

                foreach($solicitud_materiales_detalles as $datos){
                    $salida_almacen_detalle = SalidaAlmacenDetalle::create([
                        'dea_id' => $datos->dea_id,
                        'salida_almacen_id' => $salida_almacen->id,
                        'solicitud_material_id' => $datos->solicitud_material_id,
                        'solicitud_material_detalle_id' => $datos->id,
                        'user_solicitud_id' => $datos->user_solicitud_id,
                        'solicitud_idemp' => $datos->solicitud_idemp,
                        'solicitud_idarea' => $datos->solicitud_idarea,
                        'user_aprobado_id' => $datos->user_aprobado_id,
                        'aprobado_idemp' => $datos->aprobado_idemp,
                        'aprobado_idarea' => $datos->aprobado_idarea,
                        'categoria_programatica_id' => $datos->categoria_programatica_id,
                        'partida_presupuestaria_id' => $datos->partida_presupuestaria_id,
                        'item_id' => $datos->item_id,
                        'unidad_id' => $datos->unidad_id,
                        'almacen_id' => $datos->almacen_id,
                        'cant_salida' => $datos->cant_autorizada,
                        'estado' => '1',
                    ]);
                }

                return $salida_almacen;
            });
            Log::channel('solicitud_materiales')->info(
                "Solicitud de Materiales: " . $function->cod_salida . " fue aprobada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.material.index')->with('success_message', '[La Solicitud de Material ' . $function->cod_salida . ' fue aprobada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitud_materiales')->info(
                "Error al aprobar la solicitud de material: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al aprobar la solicitud de material.]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function rechazar($id)
    {
        try{
            $function = DB::transaction(function () use ($id) {
                $user_rechazado = User::find(Auth::user()->id);
                $solicitud_material = SolicitudMaterial::find($id);
                $solicitud_material->update([
                    'estado' => '3',
                    'user_aprobado_id' => $user_rechazado->id,
                    'aprobado_idarea' => $user_rechazado->area_asignada_id,
                    'aprobado_idemp' => $user_rechazado->idemp,
                    'faprobacion' => date('Y-m-d H:i:s')
                ]);

                return $solicitud_material;
            });
            Log::channel('solicitud_materiales')->info(
                "Solicitud de Material: " . $function->cod_solicitud . " fue rechazada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.material.index')->with('info_message', '[La Solicitud de Material ' . $function->cod_solicitud . ' fue rechazada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitud_materiales')->info(
                "Error al rechazar la solicitud de material: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al rechazar la solicitud de material.]')->withInput();
        }
    }

    public function pendiente($id)
    {
        try{
            $function = DB::transaction(function () use ($id) {
                $solicitud_material = SolicitudMaterial::find($id);
                $solicitud_material->update([
                    'estado' => '1',
                    'user_aprobado_id' => null,
                    'aprobado_idarea' => null,
                    'aprobado_idemp' => null,
                    'faprobacion' => null
                ]);

                return $solicitud_material;
            });
            Log::channel('solicitud_materiales')->info(
                "\n" .
                "Solicitud de Material " . $function->cod_solicitud . " fue reprocesado a pendiente con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.material.index')->with('success_message', '[La Solicitud de Compra ' . $function->cod_solicitud . ' fue reprocesada a pendiente correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitud_materiales')->info(
                "\n" .
                "Error al reprocesar la solicitud de material: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al reprocesar la solicitud de compra.]')->withInput();
        }
    }

    public function pdf($solicitud_compra_id)
    {
        dd($solicitud_compra_id);
    }

    public function editar($id)
    {
        $data = SolicitudMaterial::find($id);
        $detalles = SolicitudMaterialDetalle::where('solicitud_material_id',$id)->where('estado','1')->get();

        $empleado = Empleado::find(Auth::user()->idemp);
        $user = User::find(Auth::user()->id);

        $categoria_programatica_id = Area::find($data->solicitud_idarea)->categoria_programatica_id;
        if($categoria_programatica_id == null){
            return redirect()->back()->with('error_message','<b>[ERROR]</b>. SIN CATEGORIA PROGRAMATICA')->withInput();
        }

        $partidas_presupuestarias = CategoriaPresupuestaria::where('categoria_programatica_id',$categoria_programatica_id)->where('estado','1')->get();
        foreach($partidas_presupuestarias as $datos){
            $partidas[] = $datos->partida_presupuestaria_id;
        }

        $items = Item::join('unidades as b', 'b.id', 'items.unidad_id')
                    ->where('items.dea_id', $data->dea_id)
                    ->where('items.tipo', '1')
                    ->where('items.estado', '1')
                    ->whereIn('items.partida_presupuestaria_id',$partidas)
                    ->select(DB::raw("concat(items.codigo, '-', items.nombre, '_(', b.nombre, ')') as material"), 'items.id as item_id')
                    ->pluck('material', 'item_id');

        $cont = 1;
        $old_cont = $detalles->count();

        return view('almacenes.solicitud_material.create',compact('empleado','user','data','detalles','categoria_programatica_id','items','cont','old_cont'));
    }

    public function eliminarRegistro($id)
    {
        $solicitud_material_detalle = SolicitudMaterialDetalle::find($id);
        if($solicitud_material_detalle != null){
            $solicitud_material_detalle->update([
                'estado' => '2'
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
            'cod_solicitud' => 'required',
        ]);

        try{
            $function = DB::transaction(function () use ($request) {
                $dea_id = Auth::user()->dea->id;
                $user_solicitud = User::find(Auth::user()->id);
                $solicitud_material = SolicitudMaterial::find($request->id);
                $solicitud_material->update([
                    'user_solicitud_id' => $user_solicitud->id,
                    'dea_id' => $dea_id,
                    'solicitud_idarea' => $user_solicitud->area_asignada_id,
                    'solicitud_idemp' => $user_solicitud->idemp,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'cod_solicitud' => $request->cod_solicitud,
                    'fsolicitud' => date('Y-m-d H:i:s'),
                    'obs' => $request->obs
                ]);

                if(isset($request->detalle_id)){
                    $old_cont = 0;
                    while($old_cont < count($request->detalle_id)){
                        $solicitud_material_detalle = SolicitudMaterialDetalle::find($request->detalle_id[$old_cont]);
                        $solicitud_material_detalle->update([
                            'cant_solicitada' => floatval(str_replace(",", "", $request->old_cantidad[$old_cont])),
                        ]);

                        $old_cont++;
                    }
                }
                if(isset($request->item_id)){
                    $cont = 0;
                    while($cont < count($request->item_id)){
                        $item = Item::find($request->item_id[$cont]);
                        $solicitud_material_detalle = SolicitudMaterialDetalle::create([
                            'solicitud_material_id' => $solicitud_material->id,
                            'user_solicitud_id' => $solicitud_material->user_solicitud_id,
                            'dea_id' => $solicitud_material->dea_id,
                            'solicitud_idarea' => $solicitud_material->solicitud_idarea,
                            'solicitud_idemp' => $solicitud_material->solicitud_idemp,
                            'item_id' => $item->id,
                            'partida_presupuestaria_id' => $item->partida_presupuestaria_id,
                            'unidad_id' => $item->unidad_id,
                            'categoria_programatica_id' => $request->categoria_programatica_id,
                            'cant_solicitada' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'estado' => '1',
                        ]);

                        $cont++;
                    }
                }

                return $solicitud_material;
            });
            Log::channel('solicitud_materiales')->info(
                "Solicitud de Material: Actualizada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.material.show',$function->id)->with('success_message', '[La solicitud de Material fue procesada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitud_materiales')->info(
                "Error al actualizar la solicitud de Material: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al actualizar la solicitud de Material.]')->withInput();
        }
    }
}
