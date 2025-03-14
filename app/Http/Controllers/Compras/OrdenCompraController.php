<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\OrdenCompra;
use App\Models\Compra\OrdenCompraDetalle;
use App\Models\Compra\SolicitudCompra;
use App\Models\Area;
use App\Models\Compra\Proveedor;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Compra\Item;
use App\Models\Canasta\Dea;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\IngresoCompra;
use App\Models\Compra\IngresoCompraDetalle;
use DB;

class OrdenCompraController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $proveedores = Proveedor::where('dea_id',$dea_id)->pluck('nombre','id');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $orden_compras = OrdenCompra::query()
                                        ->ByDea($dea_id)
                                        ->orderBy('id','desc')
                                        ->paginate(10);
        $tipos = OrdenCompra::TIPOS;
        $estados = OrdenCompra::ESTADOS;
        return view('compras.orden_compra.index',compact('areas','proveedores','users','orden_compras','tipos','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $proveedores = Proveedor::where('dea_id',$dea_id)->pluck('nombre','id');
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $orden_compras = OrdenCompra::query()
                                        ->ByDea($dea_id)
                                        ->ByNroOrdenCompra($request->nro_oc)
                                        ->ByNroSolicitud($request->nro_solicitud)
                                        ->ByNroPreventivo($request->nro_preventivo)
                                        ->ByTipo($request->tipo)
                                        ->ByArea($request->area_id)
                                        ->ByProveedor($request->proveedor_id)
                                        ->BySolicitante($request->solicitante_id)
                                        ->ByFechaRegistro($request->fecha_registro)
                                        ->ByEstado($request->estado)
                                        ->orderBy('id','desc')
                                        ->paginate(10);
        $tipos = OrdenCompra::TIPOS;
        $estados = OrdenCompra::ESTADOS;
        return view('compras.orden_compra.index',compact('dea_id','areas','proveedores','users','orden_compras','tipos','estados'));
    }

    public function create()
    {
        dd("ok");
    }

    /*public function getItems(Request $request)
    {
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
    }*/

    /*public function store(Request $request)
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
    }*/

    public function show($orden_compra_id)
    {
        $orden_compra = OrdenCompra::find($orden_compra_id);
        $orden_compra_detalles = OrdenCompraDetalle::where('orden_compra_id',$orden_compra_id)->where('estado','1')->get();
        $total = 0;
        return view('compras.orden_compra.show',compact('orden_compra','orden_compra_detalles','total'));
    }

    public function aprobar($orden_compra_id)
    {
        try{
            $function = DB::transaction(function () use ($orden_compra_id) {
                $orden_compra = OrdenCompra::find($orden_compra_id);
                $orden_compra->update([
                    'user_aprob_id' => Auth::user()->id,
                    'fecha_aprob' => date('Y-m-d'),
                    'estado' => '2'
                ]);

                $date = date('Y-m-d');
                $ingresosCompras = IngresoCompra::where('dea_id',$orden_compra->dea_id)->get()->count();
                $codigo_dea = Auth::user()->dea->nombre;
                $gestion = substr(date('Y', strtotime($date)), -2);
                $numero = $ingresosCompras + 1;
                $codigo = $codigo_dea . $gestion . '-' . (str_pad($numero,3,"0",STR_PAD_LEFT));

                //EL ALMACEN_ID SE CONVIERTE A ALMACEN_ORIGEN_ID PARA INGRESAR AL PRIMER ALMACEN(CENTRAL)
                $ingreso_compra = IngresoCompra::create([
                    'almacen_id' => OrdenCompra::ALMACEN_CENTRAL,
                    'dea_id' => $orden_compra->dea_id,
                    'proveedor_id' => $orden_compra->proveedor_id,
                    'orden_compra_id' => $orden_compra->id,
                    'solicitud_compra_id' => $orden_compra->solicitud_compra_id,
                    'categoria_programatica_id' => $orden_compra->categoria_programatica_id,
                    'idarea' => $orden_compra->idarea,
                    'almacen_origen_id' => $orden_compra->almacen_id,
                    'codigo' => $codigo,
                    'estado' => '1'
                ]);

                $orden_compra_detalles = OrdenCompraDetalle::where('orden_compra_id',$orden_compra_id)->where('estado','1')->get();
                foreach($orden_compra_detalles as $datos){
                    $ingreso_compra_detalle = IngresoCompraDetalle::create([
                        'ingreso_compra_id' => $ingreso_compra->id,
                        'almacen_id' => OrdenCompra::ALMACEN_CENTRAL,
                        'dea_id' => $datos->dea_id,
                        'proveedor_id' => $datos->proveedor_id,
                        'orden_compra_id' => $datos->orden_compra_id,
                        'solicitud_compra_id' => $datos->solicitud_compra_id,
                        'orden_compra_detalle_id' => $datos->id,
                        'item_id' => $datos->item_id,
                        'partida_presupuestaria_id' => $datos->partida_presupuestaria_id,
                        'unidad_id' => $datos->unidad_id,
                        'solicitud_compra_detalle_id' => $datos->solicitud_compra_detalle_id,
                        'categoria_programatica_id' => $datos->categoria_programatica_id,
                        'idarea' => $datos->idarea,
                        'almacen_origen_id' => $datos->almacen_id,
                        'cantidad' => $datos->cantidad,
                        'saldo' => $datos->saldo,
                        'estado' => '1'
                    ]);
                }

                return $orden_compra;
            });
            Log::channel('orden_compras')->info(
                "\n" .
                "Orden de Compra: " . $function->codigo . " fue aprobada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('orden.compra.index')->with('success_message', '[La Orden de Compra ' . $function->codigo . ' fue aprobada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('orden_compras')->info(
                "\n" .
                "Error al aprobar la orden de compra: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al aprobar la orden de compra.]')->withInput();
        }
    }

    public function rechazar($orden_compra_id)
    {
        try{
            $function = DB::transaction(function () use ($orden_compra_id) {
                $orden_compra = OrdenCompra::find($orden_compra_id);
                $orden_compra->update([
                    'user_aprob_id' => Auth::user()->id,
                    'fecha_aprob' => date('Y-m-d'),
                    'estado' => '3'
                ]);

                $solicitud_compra = SolicitudCompra::find($orden_compra->solicitud_compra_id);
                $solicitud_compra->update([
                    'estado' => '3',
                    'obs' => 'SOLICITUD RECHAZADA DESDE LA ORDEN DE COMPRA'
                ]);

                return $orden_compra;
            });
            Log::channel('orden_compras')->info(
                "\n" .
                "Orden de Compra: " . $function->codigo . " fue rechazada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('orden.compra.index')->with('success_message', '[La Orden de Compra ' . $function->codigo . ' fue rechazada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('orden_compras')->info(
                "\n" .
                "Error al rechazar la orden de compra: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al rechazar la orden de compra.]')->withInput();
        }
    }

    public function editar($orden_compra_id)
    {
        $orden_compra = OrdenCompra::find($orden_compra_id);
        $orden_compra_detalles = OrdenCompraDetalle::where('orden_compra_id',$orden_compra_id)->where('estado','1')->get();
        $proveedores = Proveedor::where('dea_id',$orden_compra->dea_id)->where('estado','1')->get();
        $total = 0;
        return view('compras.orden_compra.editar',compact('orden_compra','orden_compra_detalles','proveedores','total'));
    }

    public function update(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $orden_compra = OrdenCompra::find($request->orden_compra_id);
                $orden_compra->update([
                    'proveedor_id' => $request->proveedor_id,
                    'objeto' => $request->objeto,
                    'justificacion' => $request->justificacion,
                    'nro_preventivo' => $request->nro_preventivo,
                    'c_interno' => $request->c_interno
                ]);

                $cont = 0;
                if(isset($request->precio)){
                    while($cont < count($request->precio)){
                        $orden_compra_detalle = OrdenCompraDetalle::find($request->orden_compra_detalle_id[$cont]);
                        $orden_compra_detalle->update([
                            'cantidad' => $request->cantidad[$cont],
                            'precio' => floatval(str_replace(",", "", $request->precio[$cont])),
                            'proveedor_id' => $request->proveedor_id
                        ]);

                        $cont++;
                    }
                }

                return $orden_compra;
            });
            Log::channel('orden_compras')->info(
                "\n" .
                "Orden de compra actualizada con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('orden.compra.show',$function->id)->with('success_message', '[La orden de compra fue actualizada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('orden_compras')->info(
                "\n" .
                "Error al crear la orden de compra " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al actualizar la orden de compra.]')->withInput();
        }
    }
}
