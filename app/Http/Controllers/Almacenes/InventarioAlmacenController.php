<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
//use NumeroALetras;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use App\Models\Almacenes\BalanceInicial;
use App\Models\Almacenes\IngresoAlmacen;
use App\Models\Almacenes\IngresoAlmacenDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\Proveedor;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Almacenes\PartidaPresupuestaria;
use App\Models\Area;
use App\Models\Almacenes\Producto;
use App\Models\Almacenes\InventarioAlmacen;

class InventarioAlmacenController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes = Almacen::byDea($dea_id)->pluck('nombre','id');
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->pluck('nombre','id');
        }

        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');

        $partidas_presupuestarias = PartidaPresupuestaria::select(DB::raw("concat(numeracion,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->pluck('data_completo','id');

        $productos = Producto::select(DB::raw("concat(codigo,' - ',nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->pluck('data_completo','id');

        return view('almacenes.inventario_almacen.index',compact('almacenes','categorias_programaticas','partidas_presupuestarias','productos'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes = Almacen::byDea($dea_id)->pluck('nombre','id');
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->pluck('nombre','id');
        }

        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');

        $partidas_presupuestarias = PartidaPresupuestaria::select(DB::raw("concat(numeracion,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->pluck('data_completo','id');

        $productos = Producto::select(DB::raw("concat(codigo,' - ',nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->pluck('data_completo','id');

        $inventarios_almacens = InventarioAlmacen::query()
                                ->byDea($dea_id)
                                ->byAlmacen($request->almacen_id)
                                ->byCategoriaProgramatica($request->categoria_programatica_id)
                                ->byPartidaPresupuestaria($request->partida_presupuestaria_id)
                                ->byProducto($request->producto_id)
                                ->paginate(100);

        if ($inventarios_almacens->isEmpty()) {
            return redirect()->route('inventario.almacen.index')->with('info_message', '[No existen datos para mostrar.]');
        }

        return view('almacenes.inventario_almacen.index',compact('almacenes','categorias_programaticas','partidas_presupuestarias','productos','inventarios_almacens'));
    }
}
