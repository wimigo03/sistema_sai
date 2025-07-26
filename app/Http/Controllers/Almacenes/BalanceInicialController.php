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

use App\Http\Controllers\Almacenes\IngresoSucursalController;;
use App\Models\Almacenes\BalanceInicial;
use App\Models\Almacenes\IngresoAlmacen;
use App\Models\Almacenes\IngresoAlmacenDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\Proveedor;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Area;
use App\Models\Almacenes\Producto;

class BalanceInicialController extends Controller
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

        $balances_iniciales = BalanceInicial::byDea($dea_id)
                                                    ->byAlmacenes($almacenes)
                                                    ->orderBy('id','desc')
                                                    ->paginate(10);

        return view('almacenes.balance_inicial.index',compact('almacenes','balances_iniciales'));
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

        $balances_iniciales = BalanceInicial::byDea($dea_id)
                                                    ->byAlmacenes($almacenes)
                                                    ->bySucursal($request->sucursal)
                                                    ->byGestion($request->gestion)
                                                    ->orderBy('id','desc')
                                                    ->paginate(10);

        return view('almacenes.balance_inicial.index',compact('almacenes','balances_iniciales'));
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

        return view('almacenes.balance_inicial.create',compact('almacenes'));
    }

    public function store(Request $request)
    {
        $validar_gestion = BalanceInicial::byGestion($request->gestion)->get()->count();
        if($validar_gestion > 0){
            return redirect()->route('balance.inicial.create')->with('error_message', '[ERROR] . La gestion ya tiene un balance inicial.');
        }

        try{
            $data = DB::transaction(function () use ($request) {
                $dea_id = Auth::user()->dea->id;
                $user_id = Auth::user()->id;

                $ingreso_almacen = IngresoAlmacen::create([
                    'dea_id' => $dea_id,
                    'almacen_id' => $request->almacen_id,
                    'user_id' => $user_id,
                    'codigo' => 0,
                    'fecha_ingreso' => $request->gestion . '-01-01',
                    'obs' => 'Balance Inicial',
                    'estado' => IngresoAlmacen::PENDIENTE
                ]);

                $balance_inicial = BalanceInicial::create([
                    'dea_id' => $dea_id,
                    'almacen_id' => $request->almacen_id,
                    'ingreso_almacen_id' => $ingreso_almacen->id,
                    'gestion' => $request->gestion
                ]);

                return $balance_inicial;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Balance Inicial registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('balance.inicial.index')->with('success_message', '[El ingreso fue registrado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al crear el balance inicial " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }
    }

    public function editar($id)
    {
        $ingreso_sucursal_controller = new IngresoSucursalController();
        $ingreso_almacen_ids = $ingreso_sucursal_controller->balances_iniciales();

        $cont = 0;
        $validado = false;

        while($cont < count($ingreso_almacen_ids)){
            if($ingreso_almacen_ids[$cont] == $id){
                $validado = true;
            }
            $cont++;
        }

        if(!$validado){
            return redirect()->route('balance.inicial.index');
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

        return view('almacenes.balance_inicial.editar',compact('ingreso_almacen','ingreso_almacen_detalles_count','ingreso_almacen_detalles','old_total','total','almacenes','proveedores','categorias_programaticas','areas'));
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

    public function pdf($ingreso_almacen_id)
    {
        $ingreso_sucursal_controller = new IngresoSucursalController();
        $ingreso_almacen_ids = $ingreso_sucursal_controller->balances_iniciales();

        $cont = 0;
        $validado = false;

        while($cont < count($ingreso_almacen_ids)){
            if($ingreso_almacen_ids[$cont] == $ingreso_almacen_id){
                $validado = true;
            }
            $cont++;
        }

        if(!$validado){
            return redirect()->route('balance.inicial.index');
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

    public function show($ingreso_almacen_id)
    {
        $ingreso_sucursal_controller = new IngresoSucursalController();
        $ingreso_almacen_ids = $ingreso_sucursal_controller->balances_iniciales();

        $cont = 0;
        $validado = false;

        while($cont < count($ingreso_almacen_ids)){
            if($ingreso_almacen_ids[$cont] == $ingreso_almacen_id){
                $validado = true;
            }
            $cont++;
        }

        if(!$validado){
            return redirect()->route('balance.inicial.index');
        }

        $ingreso_almacen = IngresoAlmacen::find($ingreso_almacen_id);
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::where('ingreso_almacen_id',$ingreso_almacen_id)->where('estado',IngresoAlmacenDetalle::HABILITADO)->get();
        $total = $ingreso_almacen_detalles->map(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        })->sum();

        return view('almacenes.ingreso_sucursal.show',compact('ingreso_almacen','ingreso_almacen_detalles','total'));
    }
}
