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

class TraspasoSalidaSucursalController extends Controller
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

        return view('almacenes.traspaso_salida_sucursal.index', compact('traspasos_almacenes'));
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

    public function comprobarStockDisponible($dea_id,$almacen_id,$ingresos_almacen_detalles)
    {
        $stock_disponible = true;

        if($dea_id != null && $almacen_id != null)
        {
            foreach($ingresos_almacen_detalles as $datos){
                if($datos->categoria_programatica_id != null && $datos->partida_presupuestaria_id != null && $datos->producto_id != null)
                {
                    $inventario_almacen = InventarioAlmacen::select('stock_actual')
                                        ->byDea($dea_id)
                                        ->byAlmacen($almacen_id)
                                        ->byCategoriaProgramatica($datos->categoria_programatica_id)
                                        ->byPartidaPresupuestaria($datos->partida_presupuestaria_id)
                                        ->byProducto($datos->producto_id)
                                        ->first();

                    if($inventario_almacen === null || $inventario_almacen->stock_actual < $datos->cantidad){
                        $stock_disponible = false;
                        break;
                    }
                }
            }
        }else{
            $stock_disponible = false;
        }

        return $stock_disponible;
    }

    public function comprobarStockDisponibleReservado($dea_id,$almacen_id,$traspasos_almacen_detalles)
    {
        $stock_disponible = true;

        if($dea_id != null && $almacen_id != null)
        {
            foreach($traspasos_almacen_detalles as $datos){
                if($datos->categoria_programatica_id != null && $datos->partida_presupuestaria_id != null && $datos->producto_id != null)
                {
                    $inventario_almacen = InventarioAlmacen::select('stock_reservado')
                                        ->byDea($dea_id)
                                        ->byAlmacen($almacen_id)
                                        ->byCategoriaProgramatica($datos->categoria_programatica_id)
                                        ->byPartidaPresupuestaria($datos->partida_presupuestaria_id)
                                        ->byProducto($datos->producto_id)
                                        ->first();

                    if($inventario_almacen === null || $inventario_almacen->stock_reservado < $datos->cantidad){
                        $stock_disponible = false;
                        break;
                    }
                }else{
                    $stock_disponible = false;
                    break;
                }
            }
        }else{
            $stock_disponible = false;
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

                $stock_disponible = $this->comprobarStockDisponible($ingreso_almacen->dea_id,$ingreso_almacen->almacen_id,$ingresos_almacen_detalles);

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

        return view('almacenes.traspaso_salida_sucursal.show',compact('traspaso_almacen','traspaso_almacen_detalles','total'));
    }

    public function aprobar(Request $request)
    {//dd($request->all());
        try{
            $data = DB::transaction(function () use ($request) {
                $traspaso_almacen = TraspasoAlmacen::find($request->traspaso_almacen_id);
                if (!$traspaso_almacen) {
                    throw new \Exception('Ingreso de almacén no encontrado');
                }

                $traspasos_almacen_detalles = TraspasoAlmacenDetalle::where('traspaso_almacen_id', $request->traspaso_almacen_id)->where('estado',TraspasoAlmacenDetalle::HABILITADO)->get();

                $stock_disponible = $this->comprobarStockDisponibleReservado($traspaso_almacen->dea_id,$traspaso_almacen->almacen_origen_id,$traspasos_almacen_detalles);

                if($stock_disponible){
                    foreach ($traspasos_almacen_detalles as $datos) {
                        $inventarioAlmacenController = new IngresoSucursalController();
                        $inventario_almacen = $inventarioAlmacenController->obtenerInventarioAlmacenId([
                            'dea_id' => $traspaso_almacen->dea_id,
                            'almacen_id' => $traspaso_almacen->almacen_destino_id,
                            'categoria_programatica_id' => $datos->categoria_programatica_id,
                            'partida_presupuestaria_id' => $datos->partida_presupuestaria_id,
                            'producto_id' => $datos->producto_id
                        ]);

                        $inventarioAlmacen = InventarioAlmacen::find($inventario_almacen['id']);
                        if (!$inventarioAlmacen) {
                            throw new \Exception('Inventario de almacén no encontrado');
                        }

                        $inventarioAlmacen->update([
                            'stock_reservado' => $inventario_almacen['cantidad_reservada'] - $datos->cantidad
                        ]);

                        //DILSON TE QUEDASTE AQUI. HAY QUE REVISAR Y REGISTRAR LOS MOVIMIENTOS DE TRASPASO
                        //YA HICISTE LA SALIDA. AHORA TIENES QUE HACER EL INGRESO

                    }

                    $traspaso_almacen->update([
                        'estado' => '2' //CAMBIA EL ESTADO A TRASPASO SALIENTE
                    ]);
                }


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

    public function rechazar(Request $request)
    {dd($request->all());
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
