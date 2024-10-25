<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\SolicitudCompra;
use App\Models\Compra\SolicitudCompraDetalle;
use App\Models\Area;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Compra\Item;
use App\Models\Canasta\Dea;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\CategoriaPresupuestaria;
use App\Models\Compra\OrdenCompra;
use App\Models\Compra\OrdenCompraDetalle;
use DB;

class SolicitudCompraController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $solicitudes_compras = SolicitudCompra::query()
                                                ->ByDea($dea_id)
                                                ->orderBy('id','desc')
                                                ->paginate(10);
        $tipos = SolicitudCompra::TIPOS;
        $estados = SolicitudCompra::ESTADOS;
        return view('compras.solicitud_compra.index',compact('areas','users','solicitudes_compras','tipos','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $solicitudes_compras = SolicitudCompra::query()
                                                ->ByDea($dea_id)
                                                ->ByNroSolicitud($request->codigo)
                                                ->ByArea($request->area_id)
                                                ->BySolicitante($request->solicitante_id)
                                                ->ByAprobante($request->aprobante_id)
                                                ->ByTipo($request->tipo)
                                                ->ByControlInterno($request->c_interno)
                                                ->ByFechaRegistro($request->fecha_registro)
                                                ->ByEstado($request->estado)
                                                ->orderBy('id','desc')
                                                ->paginate(10);
        $tipos = SolicitudCompra::TIPOS;
        $estados = SolicitudCompra::ESTADOS;
        return view('compras.solicitud_compra.index',compact('areas','users','solicitudes_compras','tipos','estados'));
    }

    public function create()
    {
        $empleado = Empleado::find(Auth::user()->idemp);
        $user = User::find(Auth::user()->id);
        $tipos = SolicitudCompra::TIPOS;

        $categoria_programatica_id = Area::find(Auth::user()->area_asignada_id)->categoria_programatica_id;
        if($categoria_programatica_id == null){
            return redirect()->back()->with('error_message','<b>[ERROR]</b>. SIN CATEGORIA PROGRAMATICA')->withInput();
        }

        $partidas_presupuestarias = CategoriaPresupuestaria::
                                        join('partidas_presupuestarias as pp','categorias_presupuestarias.partida_presupuestaria_id','pp.id')
                                        ->where('categorias_presupuestarias.estado','1')
                                        ->where('pp.detalle','1')
                                        ->where('pp.estado','1')
                                        ->where('pp.dea_id',Auth::user()->dea->id)
                                        ->where('categorias_presupuestarias.categoria_programatica_id',$categoria_programatica_id)
                                        ->select(
                                            DB::raw("concat(pp.numeracion,' (',pp.codigo,') ',pp.nombre) as partida_presupuestaria"),'pp.id')
                                        ->pluck('partida_presupuestaria','id');

        return view('compras.solicitud_compra.create',compact('empleado','user','tipos','partidas_presupuestarias','categoria_programatica_id'));
    }

    public function getPartidasPresupuestarias(Request $request)
    {
        try{
            $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->where('categoria_programatica_id',$request->id)
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->get()
                                        ->toJson();
            if($partidas_presupuestarias){
                return response()->json([
                    'partidas_presupuestarias' => $partidas_presupuestarias
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getItems(Request $request)
    {
        try{
            $items = DB::table('items as a')
                            ->join('unidades as b','b.id','a.unidad_id')
                            ->where('a.dea_id',Auth::user()->dea->id)
                            ->where('a.tipo', '1')
                            ->where('a.estado','1')
                            ->where('a.partida_presupuestaria_id',$request->id)
                            ->select(DB::raw("concat(a.nombre,'_(',b.nombre,')') as producto"),'a.id as item_id')
                            ->get()
                            ->toJson();
            if($items){
                return response()->json([
                    'items' => $items
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required',
        ]);

        $area = Area::find($request->area_id);
        if($area == null){
            return redirect()->back()->with('error_message','[EL AREA SELECCIONADA NO TIENE ASIGNADO UN ALMACEN]')->withInput();
        }
        try{
            $function = DB::transaction(function () use ($request, $area) {
                $dea_id = Auth::user()->dea->id;
                $date = date('Y-m-d');
                $solicitudesCompras = SolicitudCompra::where('dea_id',$dea_id)
                                            ->where('tipo','1')
                                            ->whereYear('fecha_registro', date('Y', strtotime($date)))
                                            ->get()
                                            ->count();
                $codigo_dea = Auth::user()->dea->nombre;
                $gestion = substr(date('Y', strtotime($date)), -2);
                $numero = $solicitudesCompras + 1;
                $codigo = $codigo_dea . $gestion . '-' . (str_pad($numero,3,"0",STR_PAD_LEFT));

                $solicitud_compra = SolicitudCompra::create([
                    'user_id' => Auth::user()->id,
                    'dea_id' => $dea_id,
                    'idemp' => Auth::user()->idemp,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'almacen_id' => $area->almacen_id,
                    'idarea' => $area->idarea,
                    'codigo' => $codigo,
                    'detalle' => $request->detalle,
                    'tipo' => '1',
                    'c_interno' => $request->c_interno,
                    'fecha_registro' => $date,
                    'estado' => '1'
                ]);

                $cont = 0;
                while($cont < count($request->item_id)){
                    $item = Item::find($request->item_id[$cont]);
                    $solicitud_compra_detalle = SolicitudCompraDetalle::create($datos_detalle = [
                        'solicitud_compra_id' => $solicitud_compra->id,
                        'user_id' => Auth::user()->id,
                        'dea_id' => $dea_id,
                        'item_id' => $item->id,
                        'partida_presupuestaria_id' => $request->partida_presupuestaria_id[$cont],
                        'unidad_id' => $item->unidad_id,
                        'idemp' => Auth::user()->idemp,
                        'categoria_programatica_id' => $request->categoria_programatica_id,
                        'almacen_id' => $area->almacen_id,
                        'idarea' => $area->idarea,
                        'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'saldo' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'estado' => '1'
                    ]);

                    $cont++;
                }

                return $solicitud_compra;
            });
            Log::channel('solicitudes_compras')->info(
                "Solicitud de Compra: Creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.compra.index')->with('success_message', '[La solicitud de compra fue registrada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitudes_compras')->info(
                "Error al crear la solicitud de compra: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la solicitud de compra.]')->withInput();
        }
    }

    public function show($solicitud_compra_id)
    {
        $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
        $solicitud_compra_detalles = SolicitudCompraDetalle::where('solicitud_compra_id',$solicitud_compra_id)->where('estado','1')->get();
        return view('compras.solicitud_compra.show',compact('solicitud_compra','solicitud_compra_detalles'));
    }

    public function aprobar($solicitud_compra_id)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $function = DB::transaction(function () use ($solicitud_compra_id) {

                $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
                $solicitud_compra->update([
                    'estado' => '2',
                    'user_aprob_id' => Auth::user()->id,
                    'fecha_aprob' => date('Y-m-d')
                ]);

                $solicitud_compras_detalles = SolicitudCompraDetalle::where('solicitud_compra_id',$solicitud_compra->id)->where('estado','1')->get();
                foreach($solicitud_compras_detalles as $datos_detalle){
                    $solicitud_compra_detalle = SolicitudCompraDetalle::find($datos_detalle->id);
                    $solicitud_compra_detalle->update([
                        'user_aprob_id' => Auth::user()->id
                    ]);
                }

                $date = date('Y-m-d');
                $ordenesCompras = OrdenCompra::where('dea_id',$solicitud_compra->dea_id)
                                            ->where('tipo',$solicitud_compra->tipo)
                                            ->whereYear('fecha_registro', date('Y', strtotime($date)))
                                            ->get()
                                            ->count();
                $codigo_dea = Auth::user()->dea->nombre;
                $gestion = substr(date('Y', strtotime($date)), -2);
                $numero = $ordenesCompras + 1;
                $codigo = $codigo_dea . $gestion . '-' . (str_pad($numero,3,"0",STR_PAD_LEFT));

                $orden_compra = OrdenCompra::create([
                    'dea_id' => $solicitud_compra->dea_id,
                    'idarea' => $solicitud_compra->idarea,
                    'user_id' => $solicitud_compra->user_id,
                    'almacen_id' => $solicitud_compra->almacen_id,
                    'solicitud_compra_id' => $solicitud_compra->id,
                    'idemp' => Auth::user()->idemp,
                    'categoria_programatica_id' => $solicitud_compra->categoria_programatica_id,
                    'codigo' => $codigo,
                    'justificacion' => $solicitud_compra->detalle,
                    'tipo' => $solicitud_compra->tipo,
                    'fecha_registro' => $date,
                    'estado' => '1'
                ]);

                foreach($solicitud_compras_detalles as $solicitud_compra_detalle){
                    $item = Item::select('precio')->where('id',$solicitud_compra_detalle->item_id)->first();
                    $orden_compra_detalle = OrdenCompraDetalle::create([
                        'item_id' => $solicitud_compra_detalle->item_id,
                        'orden_compra_id' => $orden_compra->id,
                        'dea_id' => $solicitud_compra_detalle->dea_id,
                        'user_id' => $solicitud_compra_detalle->user_id,
                        'partida_presupuestaria_id' => $solicitud_compra_detalle->partida_presupuestaria_id,
                        'unidad_id' => $solicitud_compra_detalle->unidad_id,
                        'almacen_id' => $orden_compra->almacen_id,
                        'solicitud_compra_id' => $solicitud_compra->id,
                        'solicitud_compra_detalle_id' => $solicitud_compra_detalle->id,
                        'idemp' => $solicitud_compra_detalle->idemp,
                        'categoria_programatica_id' => $solicitud_compra->categoria_programatica_id,
                        'idarea' => $solicitud_compra_detalle->idarea,
                        'cantidad' => $solicitud_compra_detalle->cantidad,
                        'precio' => $item->precio != null ? $item->precio : 0,
                        'saldo' => $solicitud_compra_detalle->cantidad,
                        'estado' => '1'
                    ]);
                }

                return $solicitud_compra;
            });
            Log::channel('solicitudes_compras')->info(
                "Solicitud de Compra: " . $function->codigo . " fue aprobada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.compra.index')->with('success_message', '[La Solicitud de Compra ' . $function->codigo . ' fue aprobada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitudes_compras')->info(
                "Error al aprobar la solicitud de compra: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al aprobar la solicitud de compra.]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function rechazar($solicitud_compra_id)
    {
        try{
            $function = DB::transaction(function () use ($solicitud_compra_id) {
                $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
                $solicitud_compra->update([
                    'estado' => '3',
                    'user_aprob_id' => Auth::user()->id,
                    'fecha_aprob' => date('Y-m-d')
                ]);

                return $solicitud_compra;
            });
            Log::channel('solicitudes_compras')->info(
                "Solicitud de Compra: " . $function->codigo . " fue rechazada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.compra.index')->with('success_message', '[La Solicitud de Compra ' . $function->codigo . ' fue rechazada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitudes_compras')->info(
                "Error al rechazar la solicitud de compra: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al rechazar la solicitud de compra.]')->withInput();
        }
    }

    public function pendiente($solicitud_compra_id)
    {
        try{
            $function = DB::transaction(function () use ($solicitud_compra_id) {
                $datos = [
                    'estado' => '1',
                    'user_aprob_id' => null,
                    'fecha_aprob' => null,
                    'detalle' => null
                ];

                $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
                $solicitud_compra->update($datos);

                return $solicitud_compra;
            });
            Log::channel('solicitudes_compras')->info(
                "\n" .
                "Solicitud de Compra " . $function->codigo . " fue reprocesado a pendiente con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.compra.index')->with('success_message', '[La Solicitud de Compra ' . $function->codigo . ' fue reprocesada a pendiente correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitudes_compras')->info(
                "\n" .
                "Error al reprocesar la solicitud de compra: " . "\n" .
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

    public function editar($solicitud_compra_id)
    {
        $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
        $empleado = Empleado::find(Auth::user()->idemp);
        $user = User::find(Auth::user()->id);
        $tipos = SolicitudCompra::TIPOS;

        $categoria_programatica_id = Area::find(Auth::user()->area_asignada_id)->categoria_programatica_id;
        if($categoria_programatica_id == null){
            return redirect()->back()->with('error_message','<b>[ERROR]</b>. SIN CATEGORIA PROGRAMATICA')->withInput();
        }

        $partidas_presupuestarias = CategoriaPresupuestaria::
                                        join('partidas_presupuestarias as pp','categorias_presupuestarias.partida_presupuestaria_id','pp.id')
                                        ->where('categorias_presupuestarias.estado','1')
                                        ->where('pp.detalle','1')
                                        ->where('pp.estado','1')
                                        ->where('pp.dea_id',Auth::user()->dea->id)
                                        ->where('categorias_presupuestarias.categoria_programatica_id',$categoria_programatica_id)
                                        ->select(
                                            DB::raw("concat(pp.numeracion,' (',pp.codigo,') ',pp.nombre) as partida_presupuestaria"),'pp.id')
                                        ->pluck('partida_presupuestaria','id');

        $solicitud_compra_detalles = SolicitudCompraDetalle::where('solicitud_compra_id',$solicitud_compra_id)->where('estado','1')->get();

        return view('compras.solicitud_compra.editar',compact('solicitud_compra','empleado','user','tipos','categoria_programatica_id','partidas_presupuestarias','solicitud_compra_detalles'));
    }

    public function eliminarRegistro($id)
    {
        $solicitud_compra_detalle = SolicitudCompraDetalle::find($id);
        if($solicitud_compra_detalle != null){
            $solicitud_compra_detalle->update([
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
        try{
            $function = DB::transaction(function () use ($request) {
                $solicitud_compra = SolicitudCompra::find($request->solicitud_compra_id);
                $solicitud_compra->update([
                    'user_id' => Auth::user()->id,
                    'idemp' => Auth::user()->idemp,
                    'detalle' => $request->detalle,
                    'c_interno' => $request->c_interno
                ]);

                $old_solicitudes_compra_detalle = SolicitudCompraDetalle::where('solicitud_compra_id',$request->solicitud_compra_id)
                                                                ->whereNotIn('id',$request->solicitud_compra_detalle_id)
                                                                ->where('estado','1')->get();
                foreach($old_solicitudes_compra_detalle as $old_datos){
                    $solicitudes_compra_detalle = SolicitudCompraDetalle::find($old_datos->id);
                    $solicitudes_compra_detalle->update([
                        'estado' => '2'
                    ]);
                }

                if(isset($request->solicitud_compra_detalle_id)){
                    $cont = 0;
                    while($cont < count($request->solicitud_compra_detalle_id)){
                        $old_solicitud_compra_detalle = SolicitudCompraDetalle::find($request->solicitud_compra_detalle_id[$cont]);
                        $old_solicitud_compra_detalle->update([
                            'cantidad' => floatval(str_replace(",", "", $request->old_cantidad[$cont])),
                            'saldo' => floatval(str_replace(",", "", $request->old_cantidad[$cont]))
                        ]);

                        $cont++;
                    }
                }

                if(isset($request->item_id)){
                    $cont = 0;
                    while($cont < count($request->item_id)){
                        $item = Item::find($request->item_id[$cont]);
                        $solicitud_compra_detalle = SolicitudCompraDetalle::create([
                            'solicitud_compra_id' => $solicitud_compra->id,
                            'idarea' => Auth::user()->idarea,
                            'user_id' => Auth::user()->id,
                            'dea_id' => Auth::user()->dea->id,
                            'idemp' => Auth::user()->idemp,
                            'categoria_programatica_id' => $request->categoria_programatica_id,
                            'item_id' => $item->id,
                            'partida_presupuestaria_id' => $request->partida_presupuestaria_id[$cont],
                            'unidad_id' => $item->unidad_id,
                            'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'saldo' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'estado' => '1'
                        ]);

                        $cont++;
                    }
                }

                return $solicitud_compra;
            });
            Log::channel('solicitudes_compras')->info(
                "\n" .
                "Solicitud de Compra actualizada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('solicitud.compra.show',$function->id)->with('success_message', '[La solicitud de compra fue actualizada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('solicitudes_compras')->info(
                "\n" .
                "Error al actualizar la solicitud de compra: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar la solicitud de compra.]')->withInput();
        }
    }
}
