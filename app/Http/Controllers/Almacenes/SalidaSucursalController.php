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

use App\Models\Almacenes\SalidaAlmacen;
use App\Models\Almacenes\SalidaAlmacenDetalle;
use App\Models\User;
use App\Models\Almacenes\Almacen;
use App\Models\Almacenes\Proveedor;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Area;
use App\Models\Almacenes\Producto;

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
        $almacen_id = $request->almacen_id;
        $categoria_programatica_ids = $request->categoria_programatica_ids;
        $partida_presupuestaria_ids = $request->partida_presupuestaria_ids;
        $producto_ids = $request->producto_ids;
        $cantidads = $request->cantidads;
        $dea_id = Auth::user()->dea->id;
        $stockDisponibleValido = true;

        try {
            foreach ($producto_ids as $index => $producto_id) {
                $stockDisponible = DB::table('ingresos_almacen_detalles as iad')
                    ->join('ingresos_almacen as ia', 'iad.ingreso_almacen_id', '=', 'ia.id')
                    ->where('ia.dea_id', $dea_id)
                    ->where('ia.almacen_id', $almacen_id)
                    ->where('ia.estado', '2')
                    ->where('iad.categoria_programatica_id', $categoria_programatica_ids[$index])
                    ->where('iad.partida_presupuestaria_id', $partida_presupuestaria_ids[$index])
                    ->where('iad.producto_id', $producto_id)
                    ->where('iad.estado', '1')
                    ->leftJoin('salidas_almacen_detalles as sad', function ($join) use ($almacen_id, $categoria_programatica_ids, $partida_presupuestaria_ids, $producto_id, $dea_id, $index) {
                        $join->on('sad.producto_id', '=', 'iad.producto_id')
                            ->where('sad.categoria_programatica_id', '=', $categoria_programatica_ids[$index])
                            ->where('sad.partida_presupuestaria_id', '=', $partida_presupuestaria_ids[$index])
                            ->where('sad.estado', '=', '1')
                            ->join('salidas_almacen as sa', 'sad.salida_almacen_id', '=', 'sa.id')
                            ->where('sa.dea_id', '=', $dea_id)
                            ->where('sa.almacen_id', '=', $almacen_id)
                            ->where('sa.estado', '=', '2');
                    })
                    ->selectRaw('SUM(iad.cantidad) - COALESCE(SUM(sad.cantidad), 0) as stock_disponible')
                    ->groupBy('iad.producto_id')
                    ->first();

                $stock_disponible = $stockDisponible ? $stockDisponible->stock_disponible : 0;
                $cantidad = $cantidads[$index];
                if ($stock_disponible < $cantidad) {
                    $stockDisponibleValido = false;
                    break;
                }
            }

            return response()->json([
                'stock_disponible_valido' => $stockDisponibleValido,
                'cantidad_egreso' => $cantidad,
                'stock_disponible' => $stock_disponible,
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
            $stockDisponible = DB::table('ingresos_almacen_detalles as iad')
                ->join('ingresos_almacen as ia', 'iad.ingreso_almacen_id', '=', 'ia.id')
                ->where('ia.dea_id', $dea_id)
                ->where('ia.almacen_id', $almacen_id)
                ->where('ia.estado', '2')
                ->where('iad.categoria_programatica_id', $categoria_programatica_id)
                ->where('iad.partida_presupuestaria_id', $partida_presupuestaria_id)
                ->where('iad.producto_id', $producto_id)
                ->where('iad.estado', '1')

                ->leftJoin('salidas_almacen_detalles as sad', function ($join) use ($almacen_id, $categoria_programatica_id, $partida_presupuestaria_id, $producto_id, $dea_id) {
                    $join->on('sad.producto_id', '=', 'iad.producto_id')
                        ->where('sad.categoria_programatica_id', '=', $categoria_programatica_id)
                        ->where('sad.partida_presupuestaria_id', '=', $partida_presupuestaria_id)
                        ->where('sad.estado', '=', '1')
                        ->join('salidas_almacen as sa', 'sad.salida_almacen_id', '=', 'sa.id')
                        ->where('sa.dea_id', '=', $dea_id)
                        ->where('sa.almacen_id', '=', $almacen_id)
                        ->where('sa.estado', '=', '2');
                })
                ->selectRaw('SUM(iad.cantidad) - COALESCE(SUM(sad.cantidad), 0) as stock_disponible, MAX(iad.precio_unitario) as ultimo_precio_unitario')
                ->groupBy('iad.producto_id')
                ->first();

            return response()->json([
                'stock_disponible' => $stockDisponible ? $stockDisponible->stock_disponible : 0,
                'ultimo_precio_unitario' => $stockDisponible ? $stockDisponible->ultimo_precio_unitario : 0
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
                    'solicitante_id' => $request->solicitante_id
                ]);

                $cont = 0;

                while($cont < count($request->producto_id)){
                    $salida_almacen_detalle = SalidaAlmacenDetalle::create([
                        'salida_almacen_id' => $salida_almacen->id,
                        'categoria_programatica_id' => $request->categoria_programatica_id[$cont],
                        'partida_presupuestaria_id' => $request->partida_presupuestaria_id[$cont],
                        'producto_id' => $request->producto_id[$cont],
                        'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'precio_unitario' => floatval(str_replace(",", "", $request->precio_unitario[$cont])),
                        'estado' => SalidaAlmacenDetalle::HABILITADO,
                    ]);

                    $cont++;
                }

                return $salida_almacen_detalle;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Salida Almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('salida.sucursal.index')->with('success_message', '[El egreso fue registrado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
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

    public function editar($id)
    {
        $salida_almacen = SalidaAlmacen::find($id);
        $salida_almacen_detalles = SalidaAlmacenDetalle::byEstado(SalidaAlmacenDetalle::HABILITADO)->where('salida_almacen_id', $id)->get();
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

        return view('almacenes.salida_sucursal.editar',compact('salida_almacen','salida_almacen_detalles','total','almacenes','proveedores','categorias_programaticas','areas','empleados_solicitantes'));
    }

    public function eliminarRegistro($id)
    {
        $salida_almacen_detalle = SalidaAlmacenDetalle::find($id);
        if($salida_almacen_detalle != null){
            $salida_almacen_detalle->update([
                'estado' => SalidaAlmacenDetalle::NO_HABILITADO
            ]);
            return response()->json([
                'Eliminado' => 'Eliminado'
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
                    'proveedor_id' => $request->proveedor_id,
                    'area_id' => $request->area_id,
                    'codigo' => $request->codigo,
                    'n_factura' => isset($request->n_factura) ? $request->n_factura : null,
                    'n_solicitud' => $request->n_solicitud,
                    'fecha_salida' => date('Y-m-d', strtotime($request->fecha_salida)),
                    'obs' => $request->glosa,
                    'solicitante_id' => $request->solicitante_id
                ]);

                if ($request->filled('old_salida_almacen_detalle_id')) {

                    $cont = 0;

                    while($cont < count($request->old_salida_almacen_detalle_id)){
                        $salida_almacen_detalle = SalidaAlmacenDetalle::find($request->old_salida_almacen_detalle_id[$cont]);
                        $salida_almacen_detalle->update([
                            'cantidad' => floatval(str_replace(",", "", $request->old_cantidad[$cont])),
                            'precio_unitario' => floatval(str_replace(",", "", $request->old_precio_unitario[$cont])),
                        ]);

                        $cont++;
                    }
                }

                if ($request->filled('producto_id')) {

                    $cont = 0;

                    while($cont < count($request->producto_id)){
                        $salida_almacen_detalle = SalidaAlmacenDetalle::create([
                            'salida_almacen_id' => $salida_almacen->id,
                            'categoria_programatica_id' => $request->categoria_programatica_id[$cont],
                            'partida_presupuestaria_id' => $request->partida_presupuestaria_id[$cont],
                            'producto_id' => $request->producto_id[$cont],
                            'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                            'precio_unitario' => floatval(str_replace(",", "", $request->precio_unitario[$cont])),
                            'estado' => SalidaAlmacenDetalle::HABILITADO,
                        ]);

                        $cont++;
                    }
                }

                return $salida_almacen_detalle;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Egresos Almacen modificados con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('salida.sucursal.index')->with('success_message', '[El registro fue modificado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al modificar un registro de egreso de almacen " . "\n" .
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
        try{
            $data = DB::transaction(function () use ($request) {
                $salida_almacen = SalidaAlmacen::find($request->salida_almacen_id);
                $salida_almacen->update([
                    'user_id' => Auth::user()->id,
                    'estado' => SalidaAlmacen::EGRESADO
                ]);

                return $salida_almacen;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Materiales egresados correctamente" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('salida.sucursal.index')->with('info_message', '[Registro procesado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al egresar los materiales: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al procesar el registro]')->withInput();
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
}
