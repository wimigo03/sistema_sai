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

use App\Http\Controllers\Almacenes\IngresoSuursalController;
use App\Models\Almacenes\BalanceInicial;
use App\Models\Almacenes\IngresoAlmacen;
use App\Models\Almacenes\IngresoAlmacenDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\Proveedor;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Area;
use App\Models\Almacenes\Producto;
use App\Models\Almacenes\TraspasoAlmacen;
use App\Models\Almacenes\TraspasoAlmacenDetalle;
use App\Models\Almacenes\InventarioAlmacen;

class TraspasoSucursalController extends Controller
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

        /*$ingreso_almacen_ids = $this->balances_iniciales();

        $ingresos_almacenes = IngresoAlmacen::byDea($dea_id)
                                            ->byAlmacenes($almacenes)
                                            ->whereNotIn('id', $ingreso_almacen_ids)
                                            ->orderBy('estado','asc')
                                            ->orderBy('fecha_ingreso','desc')
                                            ->orderBy('id','desc')
                                            ->paginate(10);*/

        $traspasos_almacenes = TraspasoAlmacen::byDea($dea_id)
                                            ->byAlmacenesSalida($almacenes)
                                            ->paginate(10);

        //$estados = IngresoAlmacen::ESTADOS;

        return view('almacenes.traspaso_sucursal.index', compact('traspasos_almacenes'));
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

        $ingreso_almacen_ids = $this->balances_iniciales();

        $ingresos_almacenes = IngresoAlmacen::byDea($dea_id)
                                            ->byAlmacenes($almacenes)
                                            ->whereNotIn('id', $ingreso_almacen_ids)
                                            ->byCodigo($request->codigo)
                                            ->bySucursal($request->sucursal)
                                            ->byProveedor($request->proveedor)
                                            ->bySolicitante($request->solicitante)
                                            ->byNroPreventivo($request->nro_preventivo)
                                            ->byNroOrdenCompra($request->nro_orden_compra)
                                            ->byNroSolicitud($request->nro_solicitud)
                                            ->byFechaRegistro($request->fecha_registro)
                                            ->byFechaIngreso($request->fecha_ingreso)
                                            ->byEstado($request->estado)
                                            ->orderBy('estado','asc')
                                            ->orderBy('fecha_ingreso','desc')
                                            ->orderBy('id','desc')
                                            ->paginate(10);

        $estados = IngresoAlmacen::ESTADOS;

        return view('almacenes.ingreso_sucursal.index',compact('ingresos_almacenes','estados'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $user_id = Auth::user()->id;

        if($user_id == 102)
        {
            $almacenes_origenes = Almacen::byDea($dea_id)->pluck('nombre','id');
        }else{
            $almacenes_origenes = Almacen::byDea($dea_id)->byEncargado($user_id)->pluck('nombre','id');
        }

        $almacenes_destinos = Almacen::byDea($dea_id)->pluck('nombre','id');

        return view('almacenes.traspaso_sucursal.create',compact('almacenes_origenes', 'almacenes_destinos'));
    }

    public function getIngresoMateriales(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        try{
            $ingresos_materiales = DB::table('ingresos_almacen')
                            ->where('dea_id', $dea_id)
                            ->where('almacen_id', $request->id)
                            ->where('codigo', '!=', 0) // NO SE PERMITE EL BALANCE INICIAL
                            ->where('estado', '2') //SOLO INGRESADOS
                            ->whereYear('fecha_ingreso', date('Y'))
                            ->select(DB::raw("concat('N° ', codigo, ' / ', EXTRACT(YEAR FROM fecha_ingreso), ' | ', obs) as data_completo"), 'id')
                            ->get()
                            ->toJson();
            if($ingresos_materiales){
                return response()->json([
                    'ingresos_materiales' => $ingresos_materiales
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function comprobarStockDisponible($ingresos_almacen_detalles)
    {
        $stock_disponible = true;

        foreach($ingresos_almacen_detalles as $datos){
            $inventario_almacen = InventarioAlmacen::select('stock_actual')
                                ->byDea($datos->dea_id)
                                ->byAlmacen($datos->almacen_id)
                                ->byCategoriaProgramatica($datos->categoria_programatica_id)
                                ->byPartidaPresupuestaria($datos->partida_presupuestaria_id)
                                ->byProducto($datos->producto_id)
                                ->first();

            if($inventario_almacen === null || $inventario_almacen->stock_actual <= 0){
                $stock_disponible = false;
                break;
            }
        }

        return $stock_disponible;
    }

    public function store(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $user_id = Auth::user()->id;
                $ingreso_almacen = IngresoAlmacen::find($request->ingreso_almacen_id);
                if (!$ingreso_almacen) {
                    throw new \Exception('Ingreso de almacén no encontrado');
                }

                $ingresos_almacen_detalles = IngresoAlmacenDetalle::where('ingreso_almacen_id', $request->ingreso_almacen_id)->where('estado',IngresoAlmacenDetalle::HABILITADO)->get();

                $stock_disponible = $this->comprobarStockDisponible($ingresos_almacen_detalles);

                if($stock_disponible){
                    $gestion = substr(date('Y'), -2);
                    $count = TraspasoAlmacen::where('dea_id', $ingreso_almacen->dea_id)->whereYear('fecha_traspaso',date('Y'))->get()->count() + 1;
                    $codigo = $gestion . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

                    $traspaso_almacen = TraspasoAlmacen::create([
                        'dea_id' => $ingreso_almacen->dea_id,
                        'ingreso_almacen_id' => $ingreso_almacen->id,
                        'almacen_origen_id' => $ingreso_almacen->almacen_id, //ALMACEN DE DONDE ESTA SALIENDO LOS PRODUCTOS
                        'almacen_destino_id' => $request->almacen_destino_id,
                        'user_traspaso_id' => $ingreso_almacen->user_id,
                        'codigo' => $codigo,
                        'fecha_traspaso' => date('Y-m-d H:i:s'),
                        'obs' => $request->obs,
                        'estado' => '1'
                    ]);

                    foreach ($ingresos_almacen_detalles as $datos) {
                        $traspaso_almacen_detalle = TraspasoAlmacenDetalle::create([
                            'traspaso_almacen_id' => $traspaso_almacen->id,
                            'categoria_programatica_id' => $datos->categoria_programatica_id,
                            'partida_presupuestaria_id' => $datos->partida_presupuestaria_id,
                            'producto_id' => $datos->producto_id,
                            'cantidad' => $datos->cantidad,
                            'precio_unitario' => $datos->precio_unitario,
                            'estado' => '1' //HABILITADO POR DEFECTO
                        ]);

                        $inventarioAlmacenController = new IngresoSucursalController();
                        $inventario_almacen = $inventarioAlmacenController->obtenerInventarioAlmacenId([
                            'dea_id' => $ingreso_almacen->dea_id,
                            'almacen_id' => $ingreso_almacen->almacen_id,
                            'categoria_programatica_id' => $datos->categoria_programatica_id,
                            'partida_presupuestaria_id' => $datos->partida_presupuestaria_id,
                            'producto_id' => $datos->producto_id
                        ]);

                        $inventarioAlmacen = InventarioAlmacen::find($inventario_almacen['id']);
                        if (!$inventarioAlmacen) {
                            throw new \Exception('Inventario de almacén no encontrado');
                        }

                        $inventarioAlmacen->update([
                            'stock_actual' => $inventario_almacen['cantidad'] - $datos->cantidad,
                            'stock_reservado' => $inventario_almacen['cantidad_reservada'] + $datos->cantidad
                        ]);
                    }

                    $ingreso_almacen->update([
                        'estado' => '4' //CAMBIA EL ESTADO A TRASPASO_SALIDA
                    ]);
                }else{
                    return redirect()->back()->with('error_message','[No existe stock disponible para realizar el proceso.]')->withInput();
                }

                return $traspaso_almacen;
            });
            Log::channel('traspasos_almacen')->info(
                "\n" .
                "Traspaso Almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('traspaso.sucursal.index', $data->id)->with('success_message', '[COMPROBANTE CREADO CON EXITO]');
        } catch (\Exception $e) {
            Log::channel('traspasos_almacen')->info(
                "\n" .
                "Error al crear un registro de traspaso de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }
    }

    public function show($id)
    {
        $traspaso_almacen = TraspasoAlmacen::find($id);
        $traspaso_almacen_detalles = TraspasoAlmacenDetalle::where('traspaso_almacen_id',$id)->where('estado',TraspasoAlmacenDetalle::HABILITADO)->get();
        $total = $traspaso_almacen_detalles->map(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        })->sum();

        return view('almacenes.traspaso_sucursal.show',compact('traspaso_almacen','traspaso_almacen_detalles','total'));
    }

    public function editar($id)
    {
        $ingreso_almacen_ids = $this->balances_iniciales();

        $cont = 0;

        while($cont < count($ingreso_almacen_ids)){
            if($ingreso_almacen_ids[$cont] == $id){
                return redirect()->route('ingreso.sucursal.index');
            }
            $cont++;
        }

        $ingreso_almacen = IngresoAlmacen::find($id);
        $ingreso_almacen_detalles_count = IngresoAlmacenDetalle::byEstado(IngresoAlmacenDetalle::HABILITADO)->where('ingreso_almacen_id', $id)->count();
        //$ingreso_almacen_detalles = IngresoAlmacenDetalle::byEstado(IngresoAlmacenDetalle::HABILITADO)->where('ingreso_almacen_id', $id)->orderBy('id','desc')->get();
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::byEstado(IngresoAlmacenDetalle::HABILITADO)
            ->where('ingreso_almacen_id', $id)
            ->with(['categoria_programatica', 'partida_presupuestaria', 'producto.unidad_medida'])
            ->orderBy('id', 'desc')
            ->get();

        $old_total = $ingreso_almacen_detalles->map(function ($detalle) {
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

        return view('almacenes.ingreso_sucursal.editar',compact('ingreso_almacen','ingreso_almacen_detalles_count','ingreso_almacen_detalles','total','old_total','almacenes','proveedores','categorias_programaticas','areas'));
    }

    public function insertarProducto(Request $request)
    {
        try{
            $ingreso_almacen_detalle = IngresoAlmacenDetalle::create([
                'ingreso_almacen_id' => $request->ingreso_almacen_id,
                'categoria_programatica_id' => $request->categoria_programatica_id,
                'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                'producto_id' => $request->producto_id,
                'cantidad' => 0,
                'precio_unitario' => 0,
                'estado' => IngresoAlmacenDetalle::HABILITADO,
            ]);

            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Ingreso detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if($ingreso_almacen_detalle){
                return response()->json([
                    'ingreso_almacen_detalle_id' => $ingreso_almacen_detalle->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de ingreso de almacen " . "\n" .
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
        try{
            $ingreso_almacen_detalle = IngresoAlmacenDetalle::find($request->id);
            $ingreso_almacen_detalle->update([
                'cantidad' => floatval(str_replace(",", "", $request->cantidad)),
            ]);

            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Ingreso detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if($ingreso_almacen_detalle){
                return response()->json([
                    'ingreso_almacen_detalle_id' => $ingreso_almacen_detalle->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de ingreso de almacen " . "\n" .
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
            $ingreso_almacen_detalle = IngresoAlmacenDetalle::find($request->id);
            $ingreso_almacen_detalle->update([
                'precio_unitario' => floatval(str_replace(",", "", $request->precio_unitario)),
            ]);

            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Ingreso detalle almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if($ingreso_almacen_detalle){
                return response()->json([
                    'ingreso_almacen_detalle_id' => $ingreso_almacen_detalle->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al crear un registro detalle de ingreso de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return response()->json([
                'success' => false,
                'message' => 'Error al insertar el producto: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminarRegistro($id)
    {
        $ingreso_almacen_detalle = IngresoAlmacenDetalle::find($id);
        if($ingreso_almacen_detalle != null){
            $ingreso_almacen_detalle->update([
                'estado' => IngresoAlmacenDetalle::NO_HABILITADO
            ]);
            return response()->json([
                'Eliminado' => 'Eliminado'
            ]);
        }

        return response()->json(['error'=>'[ERROR]']);
    }

    public function update(Request $request)
    {//dd($request->all());
        try{
            $data = DB::transaction(function () use ($request) {
                $user_id = Auth::user()->id;
                $ingreso_almacen = IngresoAlmacen::find($request->ingreso_almacen_id);
                $ingreso_almacen->update([
                    'almacen_id' => $request->almacen_id,
                    'user_id' => $user_id,
                    'proveedor_id' => isset($request->proveedor_id) ? $request->proveedor_id : null,
                    'area_id' => isset($request->area_id) ? $request->area_id : null,
                    'codigo' => isset($request->codigo) ? $request->codigo : null,
                    'n_preventivo' => isset($request->n_preventivo) ? $request->n_preventivo : null,
                    'n_factura' => isset($request->n_factura) ? $request->n_factura : null,
                    'n_orden_compra' => isset($request->n_orden_compra) ? $request->n_orden_compra : null,
                    'n_cotizacion' => isset($request->n_cotizacion) ? $request->n_cotizacion : null,
                    'n_solicitud' => isset($request->n_solicitud) ? $request->n_solicitud : null,
                    'fecha_ingreso' => date('Y-m-d', strtotime($request->fecha_ingreso)),
                    'obs' => $request->glosa
                ]);

                if ($request->filled('ingreso_almacen_detalle_id')) {

                    $cont = 0;

                    while($cont < count($request->ingreso_almacen_detalle_id)){
                        $ingreso_almacen_detalle = IngresoAlmacenDetalle::find($request->ingreso_almacen_detalle_id[$cont]);
                        $ingreso_almacen_detalle->update([
                            'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'precio_unitario' => floatval(str_replace(",", "", $request->precio_unitario[$cont])),
                        ]);

                        $cont++;
                    }
                }

                return $ingreso_almacen;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Ingresos Almacen modificados con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            if(isset($request->area_id)){
                return redirect()->route('ingreso.sucursal.index')->with('success_message', '[Guardado correctamente.]');
            }else{
                return redirect()->route('balance.inicial.index')->with('success_message', '[Guardado correctamente.]');
            }

        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al modificar un registro de ingreso de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el registro.]')->withInput();
        }
    }

    public function pdf($ingreso_almacen_id)
    {
        $ingreso_almacen_ids = $this->balances_iniciales();

        $cont = 0;

        while($cont < count($ingreso_almacen_ids)){
            if($ingreso_almacen_ids[$cont] == $ingreso_almacen_id){
                return redirect()->route('ingreso.sucursal.index');
            }
            $cont++;
        }

        $ingreso_almacen = IngresoAlmacen::find($ingreso_almacen_id);

        $datos = DB::table('ingresos_almacen_detalles as iad')
            ->join('categorias_presupuestarias as cp', function ($join) {
                $join->on('iad.categoria_programatica_id', '=', 'cp.categoria_programatica_id')
                    ->on('iad.partida_presupuestaria_id', '=', 'cp.partida_presupuestaria_id');
            })
            ->join('categorias_programaticas as cat', 'iad.categoria_programatica_id', '=', 'cat.id')
            ->join('partidas_presupuestarias as pp', 'iad.partida_presupuestaria_id', '=', 'pp.id')
            ->join('productos as prod', 'iad.producto_id', '=', 'prod.id')
            ->leftJoin('unidades as u', 'prod.unidad_id', '=', 'u.id')
            ->select(
                'cat.codigo as codigo_categoria',
                'cat.nombre as nombre_categoria',
                'pp.numeracion as numeracion_partida',
                'pp.nombre as nombre_partida',
                'prod.codigo as codigo_producto',
                'prod.nombre as nombre_producto',
                'u.alias as unidad',
                'iad.cantidad',
                'iad.precio_unitario',
                DB::raw('(iad.cantidad * iad.precio_unitario) as subtotal')
            )
            ->where('iad.estado', '1')
            ->where('cp.estado', '1')
            ->where('iad.ingreso_almacen_id', $ingreso_almacen_id)
            ->orderBy('iad.id')
            ->orderBy('cat.codigo')
            ->orderBy('pp.numeracion')
            ->orderBy('prod.codigo')
            ->get();

        $estructura = [];
        $totalGeneral = 0;

        foreach ($datos as $item) {
            $categoriaKey = $item->codigo_categoria . ' - ' . $item->nombre_categoria;
            $partidaKey = $item->numeracion_partida . ' - ' . $item->nombre_partida;

            if (!isset($estructura[$categoriaKey])) {
                $estructura[$categoriaKey] = [
                    'total_categoria' => 0,
                    'partidas' => []
                ];
            }

            if (!isset($estructura[$categoriaKey]['partidas'][$partidaKey])) {
                $estructura[$categoriaKey]['partidas'][$partidaKey] = [
                    'total_partida' => 0,
                    'productos' => []
                ];
            }

            $estructura[$categoriaKey]['partidas'][$partidaKey]['productos'][] = [
                'codigo_producto' => $item->codigo_producto,
                'nombre_producto' => $item->nombre_producto,
                'unidad' => $item->unidad ?? 'N/A',
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'subtotal' => $item->subtotal,
            ];

            // Sumar totales
            $estructura[$categoriaKey]['total_categoria'] += $item->subtotal;
            $estructura[$categoriaKey]['partidas'][$partidaKey]['total_partida'] += $item->subtotal;
            $totalGeneral += $item->subtotal;
        }

        $username = User::find(Auth::user()->id);
        $numero_letras = new NumeroALetras();
        $total_en_letras = $numero_letras->toInvoice($totalGeneral, 2, 'Bolivianos');
        $username = $username != null ? $username->name : '';
        $pdf = PDF::loadView('almacenes.ingreso_sucursal.pdf',compact('ingreso_almacen','estructura','totalGeneral','total_en_letras','username'));
        $pdf->setPaper('LETTER', 'portrait');
        return $pdf->stream('Ingreso-' . $ingreso_almacen->codigo);
    }

    public function ingresar(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $ingreso_almacen = IngresoAlmacen::find($request->ingreso_almacen_id);
                $ingreso_almacen->update([
                    'user_id' => Auth::user()->id,
                    'estado' => IngresoAlmacen::INGRESADO
                ]);

                return $ingreso_almacen;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Materiales ingresados correctamente" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('ingreso.sucursal.index')->with('success_message', '[Registro procesado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al ingresar los materiales: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al procesar el registro]')->withInput();
        }
    }
}
