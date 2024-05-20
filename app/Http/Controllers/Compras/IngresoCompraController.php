<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\IngresoCompra;
use App\Models\Compra\IngresoCompraDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Compra\Proveedor;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\Programa;
/*use App\Models\Compra\OrdenCompra;
use App\Models\Compra\OrdenCompraDetalle;
use App\Models\Compra\SolicitudCompra;
use App\Models\Area;


use App\Models\Empleado;
use App\Models\Compra\Item;
use App\Models\Canasta\Dea;
*/
use DB;

class IngresoCompraController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $almacenes = Almacen::where('dea_id',$dea_id)->pluck('nombre','id');
        $proveedores = Proveedor::where('dea_id',$dea_id)->pluck('nombre','id');
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' ',nombre) as categoria"),'id')->where('dea_id',$dea_id)->pluck('categoria','id');
        $programas = Programa::where('dea_id',$dea_id)->pluck('nombre','id');
        $ingresos_compras = IngresoCompra::query()
                                            ->ByDea($dea_id)
                                            ->orderBy('id','desc')
                                            ->paginate(10);
        $estados = IngresoCompra::ESTADOS;
        return view('compras.ingreso_compra.index',compact('dea_id','almacenes','proveedores','categorias_programaticas','programas','ingresos_compras','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $almacenes = Almacen::where('dea_id',$dea_id)->pluck('nombre','id');
        $proveedores = Proveedor::where('dea_id',$dea_id)->pluck('nombre','id');
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' ',nombre) as categoria"),'id')->where('dea_id',$dea_id)->pluck('categoria','id');
        $programas = Programa::where('dea_id',$dea_id)->pluck('nombre','id');
        $ingresos_compras = IngresoCompra::query()
                                            ->ByDea($dea_id)
                                            ->ByCodigo($request->codigo)
                                            ->ByAlmacen($request->almacen_id)
                                            ->ByProveedor($request->proveedor_id)
                                            ->ByCodigoOC($request->codigo_oc)
                                            ->ByCategoriaProgramatica($request->categoria_programatica_id)
                                            ->ByPrograma($request->programa_id)
                                            ->ByEstado($request->estado)
                                            ->orderBy('id','desc')
                                            ->paginate(10);
        $estados = IngresoCompra::ESTADOS;
        return view('compras.ingreso_compra.index',compact('dea_id','almacenes','proveedores','categorias_programaticas','programas','ingresos_compras','estados'));
    }

    public function show($ingreso_compra_id)
    {
        $ingreso_compra = IngresoCompra::find($ingreso_compra_id);
        $ingreso_compra_detalles = IngresoCompraDetalle::where('ingreso_compra_id',$ingreso_compra_id)->get();
        return view('compras.ingreso_compra.show',compact('ingreso_compra','ingreso_compra_detalles'));
    }

    public function ingresar(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $ingreso_compra = IngresoCompra::find($request->ingreso_compra_id);
                $ingreso_compra->update([
                    'user_id' => Auth::user()->id,
                    'fecha_ingreso' => date('Y-m-d'),
                    'obs' => $request->obs,
                    'estado' => '2'
                ]);

                $ingreso_compra_detalles = IngresoCompraDetalle::where('ingreso_compra_id',$request->ingreso_compra_id)->get();
                foreach($ingreso_compra_detalles as $datos){
                    $ingreso_compra_detalle = IngresoCompraDetalle::find($datos->id);
                    $ingreso_compra_detalle->update([
                        'user_id' => Auth::user()->id
                    ]);
                }
                return $ingreso_compra;
            });
            Log::channel('ingresos_compras')->info(
                "\n" .
                "Item ingresados correctamente" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('ingreso.compra.index')->with('success_message', '[Los item fueron ingresados correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_compras')->info(
                "\n" .
                "Error al ingresar intems: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al ingresar items.]')->withInput();
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
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' ',nombre) as categoria"),'id')
                                                            ->where('dea_id',$orden_compra->dea_id)
                                                            ->where('estado','1')->get();
        $programas = Programa::where('dea_id',$orden_compra->dea_id)->where('estado','1')->get();
        return view('compras.orden_compra.editar',compact('orden_compra','orden_compra_detalles','proveedores','categorias_programaticas','programas'));
    }

    public function update(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $orden_compra = OrdenCompra::find($request->orden_compra_id);
                $orden_compra->update([
                    'proveedor_id' => $request->proveedor_id,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'programa_id' => $request->programa_id,
                    'objeto' => $request->objeto,
                    'justificacion' => $request->justificacion,
                    'nro_preventivo' => $request->nro_preventivo,
                    'c_interno' => $request->c_interno
                ]);

                return $orden_compra;
            });
            Log::channel('orden_compras')->info(
                "\n" .
                "Orden de compra actualizada con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('orden.compra.index')->with('success_message', '[La orden de compra fue actualizada correctamente.]');
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
