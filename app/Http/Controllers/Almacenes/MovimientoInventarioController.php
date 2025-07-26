<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Almacenes\MovimientoInventario;
use App\Models\Almacenes\InventarioAlmacen;

class MovimientoInventarioController extends Controller
{
    public function show($id)
    {
        $inventario_almacen = InventarioAlmacen::find($id);

        $movimientos_inventarios = MovimientoInventario::query()
                                    ->byDea($inventario_almacen->dea_id)
                                    ->byAlmacen($inventario_almacen->almacen_id)
                                    ->byCategoriaProgramatica($inventario_almacen->categoria_programatica_id)
                                    ->byPartidaPresupuestaria($inventario_almacen->partida_presupuestaria_id)
                                    ->byProducto($inventario_almacen->producto_id)
                                    ->byEstado(MovimientoInventario::HABILITADO)
                                    ->get();

        return view('almacenes.movimiento_inventario.show',compact('movimientos_inventarios'));
    }
}
