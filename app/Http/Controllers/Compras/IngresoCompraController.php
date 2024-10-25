<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use NumeroALetras;
use PDF;
use DB;

use App\Models\Compra\OrdenCompra;
use App\Models\Compra\IngresoCompra;
use App\Models\Compra\IngresoCompraDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Compra\Proveedor;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Area;
use App\Models\Canasta\Dea;

class IngresoCompraController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $almacenes = Almacen::where('dea_id',$dea_id)->pluck('nombre','id');
        $proveedores = Proveedor::where('dea_id',$dea_id)->pluck('nombre','id');
        $ingresos_compras = IngresoCompra::query()
                                            ->ByDea($dea_id)
                                            ->orderBy('id','desc')
                                            ->paginate(10);
        $estados = IngresoCompra::ESTADOS;
        return view('compras.ingreso_compra.index',compact('areas','almacenes','proveedores','ingresos_compras','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $almacenes = Almacen::where('dea_id',$dea_id)->pluck('nombre','id');
        $proveedores = Proveedor::where('dea_id',$dea_id)->pluck('nombre','id');
        $ingresos_compras = IngresoCompra::query()
                                            ->ByDea($dea_id)
                                            ->ByCodigo($request->codigo)
                                            ->ByArea($request->area_id)
                                            ->ByAlmacen($request->almacen_id)
                                            ->ByProveedor($request->proveedor_id)
                                            ->ByCodigoOC($request->codigo_oc)
                                            ->ByEstado($request->estado)
                                            ->orderBy('id','desc')
                                            ->paginate(10);
        $estados = IngresoCompra::ESTADOS;
        return view('compras.ingreso_compra.index',compact('areas','almacenes','proveedores','ingresos_compras','estados'));
    }

    public function show($ingreso_compra_id)
    {
        $ingreso_compra = IngresoCompra::find($ingreso_compra_id);
        $ingreso_compra_detalles = IngresoCompraDetalle::where('ingreso_compra_id',$ingreso_compra_id)->get();
        return view('compras.ingreso_compra.show',compact('ingreso_compra','ingreso_compra_detalles'));
    }

    public function pdf($ingreso_compra_id)
    {
        $ingreso_compra = IngresoCompra::find($ingreso_compra_id);
        $categorias_programaticas = IngresoCompraDetalle::where('ingreso_compra_id',$ingreso_compra_id)
                                    ->join('orden_compra_detalles as ocd','ingresos_compras_detalles.orden_compra_detalle_id','ocd.id')
                                    ->join('categorias_programaticas as cp','ingresos_compras_detalles.categoria_programatica_id','cp.id')
                                    ->select(
                                        'ingresos_compras_detalles.categoria_programatica_id',
                                        'cp.codigo',
                                        'cp.nombre',
                                        DB::raw('SUM(ingresos_compras_detalles.cantidad * ocd.precio) as total_categorias_programaticas')
                                        )
                                    ->groupby(
                                        'ingresos_compras_detalles.categoria_programatica_id',
                                        'cp.codigo',
                                        'cp.nombre')
                                    ->orderBy('ingresos_compras_detalles.categoria_programatica_id')
                                    ->get();

        $partidas_presupuestarias = IngresoCompraDetalle::where('ingreso_compra_id',$ingreso_compra_id)
                                    ->join('orden_compra_detalles as ocd','ingresos_compras_detalles.orden_compra_detalle_id','ocd.id')
                                    ->join('partidas_presupuestarias as pp','ingresos_compras_detalles.partida_presupuestaria_id','pp.id')
                                    ->select(
                                        'ingresos_compras_detalles.categoria_programatica_id',
                                        'ingresos_compras_detalles.partida_presupuestaria_id',
                                        'pp.codigo',
                                        'pp.nombre',
                                        DB::raw('SUM(ingresos_compras_detalles.cantidad * ocd.precio) as total_partidas_presupuestarias')
                                        )
                                    ->groupby(
                                        'ingresos_compras_detalles.categoria_programatica_id',
                                        'ingresos_compras_detalles.partida_presupuestaria_id',
                                        'pp.codigo',
                                        'pp.nombre')
                                    ->orderBy('ingresos_compras_detalles.partida_presupuestaria_id')
                                    ->get();

        $ingresos_compras_detalles = IngresoCompraDetalle::where('ingreso_compra_id', $ingreso_compra_id)
                                    ->orderBy('partida_presupuestaria_id')
                                    ->get();

        $total = $categorias_programaticas->sum('total_categorias_programaticas');
        $username = User::find(Auth::user()->id);
        $cont = 1;
        $numero_letras = new NumeroALetras();
        $total_en_letras = $numero_letras->toInvoice($total, 2, 'Bolivianos');
        $username = $username != null ? $username->nombre_completo : $username->name;
        $pdf = PDF::loadView('compras.ingreso_compra.pdf',compact('ingreso_compra','categorias_programaticas','partidas_presupuestarias','ingresos_compras_detalles','cont','total','total_en_letras','username'));
        $pdf->setPaper('LETTER', 'portrait');
        return $pdf->stream($ingreso_compra->codigo);
    }

    public function ingresar(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $ingreso_compra = IngresoCompra::find($request->ingreso_compra_id);
                /* $orden_compra = OrdenCompra::find($ingreso_compra->orden_compra_id);
                $orden_compra->update([
                    'estado' => '4'
                ]); */

                $ingreso_compra->update([
                    'user_id' => Auth::user()->id,
                    'fecha_ingreso' => date('Y-m-d'),
                    'idemp' => Auth::user()->idemp,
                    'obs' => $request->obs,
                    'estado' => '2'
                ]);

                $ingreso_compra_detalles = IngresoCompraDetalle::where('ingreso_compra_id',$request->ingreso_compra_id)->get();
                foreach($ingreso_compra_detalles as $datos){
                    $ingreso_compra_detalle = IngresoCompraDetalle::find($datos->id);
                    $ingreso_compra_detalle->update([
                        'user_id' => Auth::user()->id,
                        'idemp' => Auth::user()->idemp,
                        'saldo' => 0,
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
