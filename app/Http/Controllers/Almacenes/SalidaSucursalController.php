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
use App\Models\Almacenes\IngresoAlmacenDetalle;
use App\Models\Almacenes\SalidaAlmacen;
use App\Models\Almacenes\SalidaAlmacenDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\Proveedor;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Area;
use App\Models\Almacenes\Producto;
use App\Models\Almacenes\InventarioAlmacen;
use App\Models\Almacenes\MovimientoInventario;

class SalidaSucursalController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes = Almacen::byDea($dea_id)->get();
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->get();
        }

        $salidas_almacenes = SalidaAlmacen::byDea($dea_id)
                                            ->byAlmacenes($almacenes)
                                            ->orderBy('estado','asc')
                                            ->orderBy('fecha_salida','desc')
                                            ->orderBy('id','desc')
                                            ->paginate(10);

        $estados = SalidaAlmacen::ESTADOS;

        return view('almacenes.salida_sucursal.index',compact('salidas_almacenes','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes = Almacen::byDea($dea_id)->get();
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->get();
        }

        $salidas_almacenes = SalidaAlmacen::byDea($dea_id)
                                            ->byAlmacenes($almacenes)
                                            ->byCodigo($request->codigo)
                                            ->bySucursal($request->sucursal)
                                            ->byProveedor($request->proveedor)
                                            ->bySolicitante($request->solicitante)
                                            ->byNroSolicitud($request->nro_solicitud)
                                            ->byFechaRegistro($request->fecha_registro)
                                            ->byFechaSalida($request->fecha_salida)
                                            ->byEstado($request->estado)
                                            ->orderBy('estado','asc')
                                            ->orderBy('id','desc')
                                            ->paginate(10);

        $estados = SalidaAlmacen::ESTADOS;

        return view('almacenes.salida_sucursal.index',compact('salidas_almacenes','estados'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes = Almacen::byDea($dea_id)->pluck('nombre','id');
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->pluck('nombre','id');
        }

        $proveedores = Proveedor::byDea($dea_id)->pluck('nombre','id');
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');
        $areas = Area::byDea($dea_id)->byEstado(Area::HABILITADO)->pluck('nombrearea','idarea');

        $empleados_solicitantes = DB::table('empleados_contratos as a')
                                        ->join('empleados as b', 'a.idemp', 'b.idemp')
                                        ->join('areas as c', 'a.idarea_asignada', 'c.idarea')
                                        ->select('a.idemp',DB::raw("CONCAT(nombres, ' ', ap_pat, ' ', ap_mat, ' (', c.nombrearea, ')') as solicitante"))
                                        ->pluck('solicitante', 'idemp');

        return view('almacenes.salida_sucursal.create',compact('almacenes','proveedores','categorias_programaticas','areas','empleados_solicitantes'));
    }

    public function getPartidasPresupuestarias(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        try{
            $partidas_presupuestarias = DB::table('categorias_presupuestarias as a')
                            ->join('partidas_presupuestarias as b','a.partida_presupuestaria_id','b.id')
                            ->where('b.dea_id', $dea_id)
                            ->where('b.estado', '1')
                            ->where('b.detalle', '1')
                            ->where('a.estado', '1')
                            ->where('a.categoria_programatica_id',$request->id)
                            ->select(DB::raw("concat(b.numeracion,' - ',b.nombre) as data_completo"),'b.id as partida_presupuestaria_id')
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

    public function getProductos(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        try{
            $productos = DB::table('productos as a')
                            ->join('unidades as b','a.unidad_id','b.id')
                            ->where('a.dea_id', $dea_id)
                            ->where('a.tipo', Producto::PRODUCTO)
                            ->where('a.estado', Producto::HABILITADO)
                            ->where('a.partida_presupuestaria_id',$request->id)
                            ->select(DB::raw("concat(a.codigo,' - ',a.nombre, ' - ', b.nombre ) as data_completo"),'a.id as producto_id')
                            ->get()
                            ->toJson();
            if($productos){
                return response()->json([
                    'productos' => $productos
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProductoData(Request $request)
    {
        try{
            $producto = DB::table('productos as a')
                            ->join('unidades as b','a.unidad_id','b.id')
                            ->where('a.id',$request->id)
                            ->select('a.codigo','a.nombre','b.alias')
                            ->first();
            if($producto){
                return response()->json([
                    'producto' => $producto
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCodigo(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $salida_almacen_id = isset($request->salida_almacen_id) ? $request->salida_almacen_id : null;

        try{
            $codigo = DB::table('salidas_almacen')
                            ->where('dea_id', $dea_id)
                            ->where('codigo',$request->codigo)
                            ->where('id','!=',$salida_almacen_id)
                            ->whereYear('fecha_salida',date('Y'))
                            ->get()
                            ->count();

            $codigo = !($codigo > 0);

            return response()->json([
                'codigo' => $codigo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStockDisponibleValido(Request $request)
    {
        $inventario_almacen_ids = $request->inventario_almacen_ids;
        $cantidads = $request->cantidads;
        $stockDisponibleValido = true;

        try {
            foreach ($inventario_almacen_ids as $index => $inventario_almacen_id) {
                $inventario_almacen = InventarioAlmacen::select('stock_actual','stock_reservado')->byInventarioAlmacen($inventario_almacen_id)->first();
                if (!$inventario_almacen || ($inventario_almacen->stock_actual + $inventario_almacen->stock_reservado) < $cantidads[$index]) {
                    $stockDisponibleValido = false;
                    break;
                }
            }

            return response()->json([
                'stock_disponible_valido' => $stockDisponibleValido
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStockDisponible(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $almacen_id = $request->almacen_id;
        $categoria_programatica_id = $request->categoria_programatica_id;
        $partida_presupuestaria_id = $request->partida_presupuestaria_id;
        $producto_id = $request->producto_id;

        try {
            $inventario_almacen = InventarioAlmacen::byDea($dea_id)
                                ->byAlmacen($almacen_id)
                                ->byCategoriaProgramatica($categoria_programatica_id)
                                ->byPartidaPresupuestaria($partida_presupuestaria_id)
                                ->byProducto($producto_id)
                                ->first();

            if($inventario_almacen){
                $id = $inventario_almacen->id;
                $cantidad_actual = $inventario_almacen->stock_actual;
                $cantidad_reservada = $inventario_almacen->stock_reservado;
            }else{
                $id = 0;
                $cantidad_actual = 0;
                $cantidad_reservada = 0;
            }

            return response()->json([
                'inventario_almacen_id' => $id,
                'stock_actual' => $cantidad_actual,
                'stock_reserva' => $cantidad_reservada,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $dea_id = Auth::user()->dea->id;
                $user_id = Auth::user()->id;

                $salida_almacen = SalidaAlmacen::create([
                    'dea_id' => $dea_id,
                    'almacen_id' => $request->almacen_id,
                    'user_id' => $user_id,
                    'proveedor_id' => $request->proveedor_id,
                    'area_id' => $request->area_id,
                    'codigo' => $request->codigo,
                    'n_factura' => isset($request->n_factura) ? $request->n_factura : null,
                    'n_solicitud' => $request->n_solicitud,
                    'fecha_salida' => date('Y-m-d', strtotime($request->fecha_salida)),
                    'obs' => $request->glosa,
                    'estado' => salidaAlmacen::PENDIENTE,
                    'solicitante_id' => $request->solicitante_id,
                    'tipo' => salidaAlmacen::SALIDA
                ]);

                return $salida_almacen;
            });
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salida Almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('salida.sucursal.editar', $data->id)->with('success_message', '[COMPROBANTE CREADO CON EXITO]');
        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al crear un registro de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }
    }

    public function show($salida_almacen_id)
    {
        $salida_almacen = SalidaAlmacen::find($salida_almacen_id);
        $salida_almacen_detalles = SalidaAlmacenDetalle::where('salida_almacen_id',$salida_almacen_id)->where('estado',SalidaAlmacenDetalle::HABILITADO)->get();
        $total = 0;

        return view('almacenes.salida_sucursal.show',compact('salida_almacen','salida_almacen_detalles','total'));
    }

    public function getCargarMateriales(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        try{
            $ingresos_almacen = DB::table('ingresos_almacen as a')
                            ->where('a.dea_id', $dea_id)
                            ->where('a.estado', '2')
                            ->where('almacen_id', $request->almacen_id)
                            ->where('a.codigo','!=','0')
                            ->whereYear('a.fecha_ingreso', date('Y'))
                            ->select(DB::raw("concat('N° de Ingreso ',a.codigo,' | N° Preventivo ',a.n_preventivo,' | (',a.fecha_ingreso,')') as data_completo"),'a.id as ingreso_almacen_id')
                            ->get()
                            ->toJson();
            if($ingresos_almacen){
                return response()->json([
                    'ingresos_almacen' => $ingresos_almacen
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function insertarProducto(Request $request)
    {
        try{
            $salida_almacen_detalle = SalidaAlmacenDetalle::create([
                'salida_almacen_id' => $request->salida_almacen_id,
                'categoria_programatica_id' => $request->categoria_programatica_id,
                'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                'producto_id' => $request->producto_id,
                'cantidad' => 0,
                'precio_unitario' => 0,
                'estado' => SalidaAlmacenDetalle::HABILITADO,
            ]);

            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salida detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if($salida_almacen_detalle){
                return response()->json([
                    'salida_almacen_detalle_id' => $salida_almacen_detalle->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return response()->json([
                'success' => false,
                'message' => 'Error al insertar el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function updateStockReservado($id)
    {
        try{
            $udpate_stock_reservado = true;
            $salida_almacen_detalle = SalidaAlmacenDetalle::find($id);
            $salida_almacen = $salida_almacen_detalle->salida_almacen;

            $inventario_almacen = InventarioAlmacen::byDea($salida_almacen->dea_id)
                                ->byAlmacen($salida_almacen->almacen_id)
                                ->byCategoriaProgramatica($salida_almacen_detalle->categoria_programatica_id)
                                ->byPartidaPresupuestaria($salida_almacen_detalle->partida_presupuestaria_id)
                                ->byProducto($salida_almacen_detalle->producto_id)
                                ->first();

            if($inventario_almacen != null && $salida_almacen_detalle->cantidad <= $inventario_almacen->stock_actual){
                $inventario_almacen->update([
                    'stock_actual' => $inventario_almacen->stock_actual - $salida_almacen_detalle->cantidad,
                    'stock_reservado' => $inventario_almacen->stock_reservado + $salida_almacen_detalle->cantidad,
                ]);
            }else{
                $udpate_stock_reservado = false;
            }

            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salida detalle detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            return $udpate_stock_reservado;

        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return response()->json([
                'success' => false,
                'message' => 'Error al insertar el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function updateRegistroCantidad(Request $request)
    {

        $cantidad = floatval(str_replace(",", "", $request->cantidad));

        try{
            $salida_almacen_detalle = SalidaAlmacenDetalle::find($request->id);
            $cantidad_anterior = $salida_almacen_detalle->cantidad;
            $salida_almacen_detalle->update([
                'cantidad' => $cantidad,
            ]);

            $inventario_almacen = InventarioAlmacen::find($request->inventario_almacen_id);
            $stock_actual = $inventario_almacen->stock_actual;
            $stock_reserva = $inventario_almacen->stock_reservado;
            $stock_total = $stock_actual + $stock_reserva;

            if($cantidad <= $stock_total){
                if ($cantidad !== $cantidad_anterior) {
                    $diferencia = abs($cantidad - $cantidad_anterior);

                    if ($cantidad > $cantidad_anterior) {
                        if ($stock_actual >= $diferencia) {
                            $stock_actual -= $diferencia;
                            $stock_reserva += $diferencia;
                        } else {
                            $stock_reserva += $stock_actual;
                            $stock_actual = 0;
                        }
                    } else {
                        if ($stock_reserva >= $diferencia) {
                            $stock_reserva -= $diferencia;
                            $stock_actual += $diferencia;
                        } else {
                            $stock_actual += $stock_reserva;
                            $stock_reserva = 0;
                        }
                    }
                }

                $inventario_almacen->update([
                    'stock_actual' => $stock_actual,
                    'stock_reservado' => $stock_reserva
                ]);
            }

            //$updateStockReservado = $this->updateStockReservado($request->id);

            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salida detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if($salida_almacen_detalle){
                return response()->json([
                    'salida_almacen_detalle_id' => $salida_almacen_detalle->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return response()->json([
                'success' => false,
                'message' => 'Error al insertar el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function updateRegistroPrecioUnitario(Request $request)
    {
        try{
            $salida_almacen_detalle = SalidaAlmacenDetalle::find($request->id);
            $salida_almacen_detalle->update([
                'precio_unitario' => floatval(str_replace(",", "", $request->precio_unitario)),
            ]);

            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salida detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if($salida_almacen_detalle){
                return response()->json([
                    'salida_almacen_detalle_id' => $salida_almacen_detalle->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return response()->json([
                'success' => false,
                'message' => 'Error al insertar el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function editar($id)
    {
        $salida_almacen = SalidaAlmacen::find($id);
        $salida_almacen_detalles_count = SalidaAlmacenDetalle::byEstado(SalidaAlmacenDetalle::HABILITADO)->where('salida_almacen_id', $id)->count();
        //$salida_almacen_detalles = SalidaAlmacenDetalle::byEstado(SalidaAlmacenDetalle::HABILITADO)->where('salida_almacen_id', $id)->get();
        $salida_almacen_detalles = SalidaAlmacenDetalle::byEstado(SalidaAlmacenDetalle::HABILITADO)
            ->where('salida_almacen_id', $id)
            ->with(['categoria_programatica', 'partida_presupuestaria', 'producto.unidad_medida'])
            ->orderBy('id', 'desc')
            ->get();

        $old_total = $salida_almacen_detalles->map(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        })->sum();

        $total = 0;

        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes = Almacen::byDea($dea_id)->pluck('nombre','id');
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->pluck('nombre','id');
        }

        $proveedores = Proveedor::byDea($dea_id)->pluck('nombre','id');
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');
        $areas = Area::byDea($dea_id)->byEstado(Area::HABILITADO)->pluck('nombrearea','idarea');

        $empleados_solicitantes = DB::table('empleados_contratos as a')
                                        ->join('empleados as b', 'a.idemp', 'b.idemp')
                                        ->join('areas as c', 'a.idarea_asignada', 'c.idarea')
                                        ->select('a.idemp',DB::raw("CONCAT(nombres, ' ', ap_pat, ' ', ap_mat, ' (', c.nombrearea, ')') as solicitante"))
                                        ->pluck('solicitante', 'idemp');

        return view('almacenes.salida_sucursal.editar',compact('salida_almacen','salida_almacen_detalles_count','salida_almacen_detalles','total','old_total','almacenes','proveedores','categorias_programaticas','areas','empleados_solicitantes'));
    }

    public function eliminarRegistro($id, $inventario_almacen_id, $cantidad)
    {
        $cantidad = floatval(str_replace(",", "", $cantidad));

        $salida_almacen_detalle = SalidaAlmacenDetalle::find($id);
        if($salida_almacen_detalle != null){
            $inventario_almacen = InventarioAlmacen::find($inventario_almacen_id);
            $inventario_almacen->update([
                'stock_actual' => $inventario_almacen->stock_actual + $cantidad,
                'stock_reservado' => $inventario_almacen->stock_reservado - $cantidad,
            ]);

            $salida_almacen_detalle->update([
                'estado' => SalidaAlmacenDetalle::NO_HABILITADO
            ]);

            return response()->json([
                'Eliminado' => $inventario_almacen->id
            ]);
        }

        return response()->json(['error'=>'[ERROR]']);
    }

    public function update(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $user_id = Auth::user()->id;
                $salida_almacen = SalidaAlmacen::find($request->salida_almacen_id);
                $salida_almacen->update([
                    'almacen_id' => $request->almacen_id,
                    'user_id' => $user_id,
                    'proveedor_id' => isset($request->proveedor_id) ? $request->proveedor_id : null,
                    'area_id' => isset($request->area_id) ? $request->area_id : null,
                    'codigo' => isset($request->codigo) ? $request->codigo : null,
                    'n_solicitud' => isset($request->n_solicitud) ? $request->n_solicitud : null,
                    'fecha_salida' => date('Y-m-d', strtotime($request->fecha_salida)),
                    'obs' => $request->glosa,
                    'solicitante_id' => $request->solicitante_id
                ]);

                return $salida_almacen;
            });
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salidas Almacen modificados con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            return redirect()->route('salida.sucursal.index')->with('success_message', '[Guardado correctamente.]');

        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al modificar un registro de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el registro.]')->withInput();
        }
    }

    public function pdf($salida_almacen_id)
    {
        $salida_almacen = SalidaAlmacen::find($salida_almacen_id);
        $salida_almacen_detalles = SalidaAlmacenDetalle::with([
            'categoria_programatica:id,codigo,nombre',
            'partida_presupuestaria:id,numeracion,nombre',
            'producto:id,codigo,nombre,detalle,unidad_id',
            'producto.unidad_medida:id,nombre,alias'
        ])
        ->where('estado', SalidaAlmacenDetalle::HABILITADO)
        ->where('salida_almacen_id', $salida_almacen_id)
        ->get()
        ->groupBy([
            fn($item) => optional($item->categoria_programatica)->nombre ?? 'Sin categoría',
            fn($item) => optional($item->partida_presupuestaria)->nombre ?? 'Sin partida',
        ]);

        $totalGeneral = $salida_almacen_detalles->flatten()->sum(fn($d) => $d->cantidad * $d->precio_unitario);

        $username = User::find(Auth::user()->id);
        $numero_letras = new NumeroALetras();
        $total_en_letras = $numero_letras->toInvoice($totalGeneral, 2, 'Bolivianos');
        $username = $username != null ? $username->nombre_completo : $username->name;
        $pdf = PDF::loadView('almacenes.salida_sucursal.pdf',compact('salida_almacen','salida_almacen_detalles','totalGeneral','total_en_letras','username'));
        $pdf->setPaper('LETTER', 'portrait');
        return $pdf->stream('Salida-' . $salida_almacen->codigo);
    }

    public function egresar(Request $request)
    {
        $salida_almacen_detalles = SalidaAlmacenDetalle::where('salida_almacen_id', $request->salida_almacen_id)
            ->where('estado',SalidaAlmacenDetalle::HABILITADO)
            ->get();

        if ($salida_almacen_detalles->isEmpty()) {
            return redirect()->route('salida.sucursal.index')->with('error_message', '[Algo salió mal. Intenta nuevamente.]');
        }

        $dea_id = Auth::user()->dea_id;
        $stockDisponibleValido = true;
        $inventario_almacen_ids = [];
        $cantidads = [];

        foreach ($salida_almacen_detalles as $salida_almacen_detalle) {
            $inventario_almacen = InventarioAlmacen::query()
                ->byDea($dea_id)
                ->byAlmacen($salida_almacen_detalle->salida_almacen->almacen_id)
                ->byCategoriaProgramatica($salida_almacen_detalle->categoria_programatica_id)
                ->byPartidaPresupuestaria($salida_almacen_detalle->partida_presupuestaria_id)
                ->byProducto($salida_almacen_detalle->producto_id)
                ->first();

            if (!$inventario_almacen || ($inventario_almacen->stock_reservado < $salida_almacen_detalle->cantidad)) {
                $stockDisponibleValido = false;
                break;
            }

            $inventario_almacen_ids[] = $inventario_almacen->id;
            $cantidads[] = $salida_almacen_detalle->cantidad;
        }

        if (!$stockDisponibleValido) {
            return redirect()->route('salida.sucursal.index')->with('error_message', '[Stock no disponible, Algo salió mal en el inventario. Intenta nuevamente.]');
        }

        try {
            $data = DB::transaction(function () use ($inventario_almacen_ids, $cantidads, $salida_almacen_detalles) {

                $movimientos_inventario = [];

                foreach ($inventario_almacen_ids as $index => $inventario_almacen_id) {
                    $inventario_almacen = InventarioAlmacen::find($inventario_almacen_id);
                    $inventario_almacen->update([
                        'stock_reservado' => $inventario_almacen->stock_reservado - $cantidads[$index]
                    ]);

                    $salida_almacen_detalle = $salida_almacen_detalles[$index];

                    $movimiento_inventario = MovimientoInventario::create([
                        'dea_id' => $inventario_almacen->dea_id,
                        'almacen_id' => $inventario_almacen->almacen_id,
                        'categoria_programatica_id' => $salida_almacen_detalle->categoria_programatica_id,
                        'partida_presupuestaria_id' => $salida_almacen_detalle->partida_presupuestaria_id,
                        'producto_id' => $salida_almacen_detalle->producto_id,
                        'tipo_movimiento' => '2', //SALIDA
                        'cantidad' => $salida_almacen_detalle->cantidad,
                        'fecha' => $salida_almacen_detalle->salida_almacen->fecha_salida,
                        'referencia_id' => $salida_almacen_detalle->salida_almacen_id,
                        'estado' => '1' //HABILITADO
                    ]);

                    $movimientos_inventario[] = $movimiento_inventario;
                }

                $salida_almacen = SalidaAlmacen::find($salida_almacen_detalle->salida_almacen_id);
                $salida_almacen->update([
                    'estado' => SalidaAlmacen::EGRESADO
                ]);

                return $movimientos_inventario;
            });

            Log::channel('salidas_almacen')->info(
                "\n" .
                "Materiales egresados correctamente" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('salida.sucursal.index')->with('info_message', '[Registro procesado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al egresar los materiales: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return redirect()->back()->with('error_message', '[Ocurrió un error al procesar el registro]')->withInput();
        }
    }

    public function pendiente(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $salida_almacen = SalidaAlmacen::find($request->salida_almacen_id);
                $salida_almacen->update([
                    'user_id' => Auth::user()->id,
                    'estado' => SalidaAlmacen::PENDIENTE
                ]);

                return $salida_almacen;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Estado modificado a pendiente correctamente" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('salida.sucursal.index')->with('info_message', '[Registro procesado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al modificar el registro: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al procesar el registro]')->withInput();
        }
    }

    public function anular(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $salida_almacen = SalidaAlmacen::find($request->salida_almacen_id);
                $salida_almacen->update([
                    'user_id' => Auth::user()->id,
                    'estado' => SalidaAlmacen::ANULADO
                ]);

                return $salida_almacen;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Estado modificado a anulado correctamente" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('salida.sucursal.index')->with('info_message', '[Registro procesado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al modificar el registro: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al procesar el registro]')->withInput();
        }
    }

    public function procesarCargarDatos(Request $request)
    {
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::where('ingreso_almacen_id', $request->ingreso_almacen_id)->get();

        if($ingreso_almacen_detalles->isEmpty()){
            return redirect()->route('salida.sucursal.index')->with('error_message', '[Algo salio mal. intenta nuevamente.]');
        }

        try{
            $data = DB::transaction(function () use ($ingreso_almacen_detalles, $request) {
                foreach($ingreso_almacen_detalles as $ingreso_almacen_detalle){
                    SalidaAlmacenDetalle::create([
                        'salida_almacen_id' => $request->salida_almacen_id,
                        'categoria_programatica_id' => $ingreso_almacen_detalle->categoria_programatica_id,
                        'partida_presupuestaria_id' => $ingreso_almacen_detalle->partida_presupuestaria_id,
                        'producto_id' => $ingreso_almacen_detalle->producto_id,
                        'cantidad' => 0,
                        'precio_unitario' => $ingreso_almacen_detalle->precio_unitario,
                        'estado' => '1'
                    ]);
                }

                return $ingreso_almacen_detalle;
            });
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Salidas Almacen modificados con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            return redirect()->route('salida.sucursal.editar', $request->salida_almacen_id)->with('success_message', '[Generado.]');

        } catch (\Exception $e) {
            Log::channel('salidas_almacen')->info(
                "\n" .
                "Error al modificar un registro de salida de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el registro.]')->withInput();
        }
    }
}
