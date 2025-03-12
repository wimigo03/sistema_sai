<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/* use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Canasta\Dea;
use App\Models\Compra\Item;
use App\Models\Compra\IngresoCompraDetalle;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\UnidadMedida; */

class InventarioInicialController extends Controller
{
    public function index(Request $request)
    {dd($request->all());
        $dea_id = Auth::user()->dea->id;

        $almacenes = Almacen::query()
                        ->byDea($dea_id)
                        ->pluck('nombre','id');

        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea($dea_id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->pluck('categoria_programatica','id');

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea($dea_id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as partida_presupuestaria"),'id')
                                        ->where('detalle','1')
                                        ->pluck('partida_presupuestaria','id');

        $unidades = UnidadMedida::query()
                        ->byDea($dea_id)
                        ->pluck('nombre','id');

        $ingreso_compra_detalles = IngresoCompraDetalle::query()
                                            ->whereHas('ingresoCompra', function ($query) {
                                                $query->where('estado', '2');
                                            })
                                            ->byDea($dea_id)
                                            /* ->byAlmacen($almacen_id) */
                                            ->where('ingresos_compras_detalles.estado','1')
                                            ->select(
                                                'almacen_id',
                                                'item_id',
                                                'categoria_programatica_id',
                                                'partida_presupuestaria_id',
                                                'unidad_id',
                                                DB::raw("sum(cantidad) as saldo_total")
                                                )
                                            ->groupBy(
                                                'almacen_id',
                                                'item_id',
                                                'categoria_programatica_id',
                                                'partida_presupuestaria_id',
                                                'unidad_id')
                                            ->orderBy('categoria_programatica_id')
                                            ->paginate(10);

        return view('almacenes.inventario.index',compact('almacenes','categorias_programaticas','partidas_presupuestarias','unidades','ingreso_compra_detalles'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;

        $almacenes = Almacen::query()
                        ->byDea($dea_id)
                        ->pluck('nombre','id');

        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea($dea_id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->pluck('categoria_programatica','id');

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea($dea_id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as partida_presupuestaria"),'id')
                                        ->where('detalle','1')
                                        ->pluck('partida_presupuestaria','id');

        $unidades = UnidadMedida::query()
                        ->byDea($dea_id)
                        ->pluck('nombre','id');

        $ingreso_compra_detalles = IngresoCompraDetalle::query()
                                            ->whereHas('ingresoCompra', function ($query) {
                                                $query->where('estado', '2');
                                            })
                                            ->byDea($dea_id)
                                            ->byAlmacen($request->almacen_id)
                                            ->byCategoriaProgramatica($request->categoria_programatica_id)
                                            ->byPartidaPresupuestaria($request->partida_presupuestaria_id)
                                            ->byCodigo($request->codigo)
                                            ->byItem($request->item)
                                            ->byUnidad($request->unidad_id)
                                            ->where('ingresos_compras_detalles.estado','1')
                                            ->select(
                                                'almacen_id',
                                                'item_id',
                                                'categoria_programatica_id',
                                                'partida_presupuestaria_id',
                                                'unidad_id',
                                                DB::raw("sum(cantidad) as saldo_total")
                                                )
                                            ->groupBy(
                                                'almacen_id',
                                                'item_id',
                                                'categoria_programatica_id',
                                                'partida_presupuestaria_id',
                                                'unidad_id')
                                            ->orderBy('categoria_programatica_id')
                                            ->paginate(10);

        return view('almacenes.inventario.index',compact('almacenes','categorias_programaticas','partidas_presupuestarias','unidades','ingreso_compra_detalles'));
    }
}
