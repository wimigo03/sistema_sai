<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\SolicitudCompra;
use App\Models\Compra\SolicitudCompraDetalle;
use App\Models\AreasModel;
use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\Compra\Item;
use App\Models\Canasta\Dea;
use App\Models\Compra\OrdenCompra;
use App\Models\Compra\OrdenCompraDetalle;
use DB;

class SolicitudCompraController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = AreasModel::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $solicitudes_compras = SolicitudCompra::query()
                                                ->ByDea($dea_id)
                                                ->orderBy('id','desc')
                                                ->paginate(10);
        $tipos = SolicitudCompra::TIPOS;
        $estados = SolicitudCompra::ESTADOS;
        return view('compras.solicitud_compra.index',compact('dea_id','areas','users','solicitudes_compras','tipos','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $areas = AreasModel::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
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
        return view('compras.solicitud_compra.index',compact('dea_id','areas','users','solicitudes_compras','tipos','estados'));
    }

    public function create($dea_id)
    {
        $empleado = EmpleadosModel::find(Auth::user()->idemp);
        $user = User::find(Auth::user()->id);
        $tipos = SolicitudCompra::TIPOS;
        return view('compras.solicitud_compra.create',compact('dea_id','empleado','user','tipos'));
    }

    public function getItems(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $dea_id = Auth::user()->dea->id;
            $items = DB::table('items as a')
                            ->join('unidades as b','b.id','a.unidad_id')
                            ->where('a.dea_id',$dea_id)
                            ->where('a.tipo', $id)
                            ->where('a.estado','1')
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
        try{
            $function = DB::transaction(function () use ($request) {
                $date = date('Y-m-d');
                $solicitudesCompras = SolicitudCompra::where('dea_id',$request->dea_id)
                                            ->where('tipo',$request->tipo)
                                            ->whereYear('fecha_registro', date('Y', strtotime($date)))
                                            ->get()
                                            ->count();
                $codigo_dea = Auth::user()->dea->nombre;
                $gestion = substr(date('Y', strtotime($date)), -2);
                $numero = $solicitudesCompras + 1;
                $codigo = $codigo_dea . $gestion . '-' . (str_pad($numero,3,"0",STR_PAD_LEFT));

                $datos = [
                    'idarea' => $request->area_id,
                    'user_id' => $request->user_id,
                    'dea_id' => $request->dea_id,
                    'codigo' => $codigo,
                    'detalle' => $request->detalle,
                    'tipo' => $request->tipo,
                    'c_interno' => $request->c_interno,
                    'fecha_registro' => $date,
                    'estado' => '1'
                ];

                $solicitud_compra = SolicitudCompra::create($datos);

                $cont = 0;
                while($cont < count($request->item_id)){
                    $item = Item::find($request->item_id[$cont]);
                    $datos_detalle = [
                        'solicitud_compra_id' => $solicitud_compra->id,
                        'idarea' => $request->area_id,
                        'user_id' => $request->user_id,
                        'dea_id' => $request->dea_id,
                        'item_id' => $item->id,
                        'partida_id' => $item->partida_id,
                        'unidad_id' => $item->unidad_id,
                        'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'saldo' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'estado' => '1'
                    ];

                    $solicitud_compra_detalle = SolicitudCompraDetalle::create($datos_detalle);
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
                $datos = [
                    'estado' => '2',
                    'user_aprob_id' => Auth::user()->id,
                    'fecha_aprob' => date('Y-m-d')
                ];

                $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
                $solicitud_compra->update($datos);

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

                $oc_datos = [
                    'dea_id' => $solicitud_compra->dea_id,
                    'idarea' => $solicitud_compra->idarea,
                    'user_id' => $solicitud_compra->user_id,
                    'almacen_id' => 1,
                    'solicitud_compra_id' => $solicitud_compra->id,
                    'codigo' => $codigo,
                    'justificacion' => $solicitud_compra->detalle,
                    'tipo' => $solicitud_compra->tipo,
                    'fecha_registro' => $date,
                    'estado' => '1'
                ];

                $orden_compra = OrdenCompra::create($oc_datos);

                foreach($solicitud_compras_detalles as $solicitud_compra_detalle){
                    $item = Item::select('precio')->where('id',$solicitud_compra_detalle->item_id)->first();
                    $oc_datos_detalle = [
                        'item_id' => $solicitud_compra_detalle->item_id,
                        'dea_id' => $solicitud_compra_detalle->dea_id,
                        'user_id' => $solicitud_compra_detalle->user_id,
                        'partida_id' => $solicitud_compra_detalle->partida_id,
                        'unidad_id' => $solicitud_compra_detalle->unidad_id,
                        'orden_compra_id' => $orden_compra->id,
                        'idarea' => $solicitud_compra_detalle->idarea,
                        'almacen_id' => $orden_compra->almacen_id,
                        'solicitud_compra_id' => $solicitud_compra->id,
                        'solicitud_compra_detalle_id' => $solicitud_compra_detalle->id,
                        'cantidad' => $solicitud_compra_detalle->cantidad,
                        'precio' => $item->precio != null ? $item->precio : 0,
                        'saldo' => $solicitud_compra_detalle->cantidad,
                        'estado' => '1'
                    ];

                    $orden_compra_detalle = OrdenCompraDetalle::create($oc_datos_detalle);
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
                $datos = [
                    'estado' => '3',
                    'user_aprob_id' => Auth::user()->id,
                    'fecha_aprob' => date('Y-m-d')
                ];

                $solicitud_compra = SolicitudCompra::find($solicitud_compra_id);
                $solicitud_compra->update($datos);

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
                    'obs' => null
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
        $dea_id = $solicitud_compra->dea_id;
        $empleado = EmpleadosModel::find(Auth::user()->idemp);
        $user = User::find(Auth::user()->id);
        $tipos = SolicitudCompra::TIPOS;
        $solicitud_compra_detalles = SolicitudCompraDetalle::where('solicitud_compra_id',$solicitud_compra_id)->where('estado','1')->get();
        return view('compras.solicitud_compra.editar',compact('solicitud_compra','dea_id','empleado','user','tipos','solicitud_compra_detalles'));
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
                    'idarea' => $request->area_id,
                    'user_id' => $request->user_id,
                    'dea_id' => $request->dea_id,
                    'detalle' => $request->detalle,
                    'tipo' => $request->tipo,
                    'c_interno' => $request->c_interno,
                ]);

                if(isset($request->item_id) > 0){
                    $cont = 0;
                    while($cont < count($request->item_id)){
                        $item = Item::find($request->item_id[$cont]);
                        $datos_detalle = [
                            'solicitud_compra_id' => $solicitud_compra->id,
                            'idarea' => $request->area_id,
                            'user_id' => $request->user_id,
                            'dea_id' => $request->dea_id,
                            'item_id' => $item->id,
                            'partida_id' => $item->partida_id,
                            'unidad_id' => $item->unidad_id,
                            'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'saldo' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'estado' => '1'
                        ];

                        $solicitud_compra_detalle = SolicitudCompraDetalle::create($datos_detalle);
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
            return redirect()->route('solicitud.compra.index')->with('success_message', '[La solicitud de compra fue actualizada correctamente.]');
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
