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
use App\Models\Area;
use App\Models\Almacenes\Producto;

class IngresoSucursalController extends Controller
{
    public function balances_iniciales(){
        $balances_iniciales = BalanceInicial::select('ingreso_almacen_id')->get();
        $ingreso_almacen_ids = $balances_iniciales->pluck('ingreso_almacen_id')->toArray();
        return $ingreso_almacen_ids;
    }

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

        $ingreso_almacen_ids = $this->balances_iniciales();

        $ingresos_almacenes = IngresoAlmacen::byDea($dea_id)
                                            ->byAlmacenes($almacenes)
                                            ->whereNotIn('id', $ingreso_almacen_ids)
                                            ->orderBy('estado','asc')
                                            ->orderBy('id','desc')
                                            ->paginate(10);

        $estados = IngresoAlmacen::ESTADOS;

        return view('almacenes.ingreso_sucursal.index',compact('ingresos_almacenes','estados'));
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
            $almacenes = Almacen::byDea($dea_id)->pluck('nombre','id');
        }else{
            $almacenes = Almacen::byDea($dea_id)->byEncargado($user_id)->pluck('nombre','id');
        }

        $old_total = 0;

        $proveedores = Proveedor::byDea($dea_id)->pluck('nombre','id');
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');
        $areas = Area::byDea($dea_id)->byEstado(Area::HABILITADO)->pluck('nombrearea','idarea');

        return view('almacenes.ingreso_sucursal.create',compact('almacenes','old_total','proveedores','categorias_programaticas','areas'));
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

    public function getNroPreventivo(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $ingreso_almacen_id = isset($request->ingreso_almacen_id) ? $request->ingreso_almacen_id : null;

        try{
            $nro_preventivo = DB::table('ingresos_almacen')
                            ->where('dea_id', $dea_id)
                            ->where('n_preventivo',$request->nro_preventivo)
                            ->where('id','!=',$ingreso_almacen_id)
                            ->whereYear('fecha_ingreso',date('Y'))
                            ->get()
                            ->count();

            $nro_preventivo = !($nro_preventivo > 0);

            return response()->json([
                'n_preventivo' => $nro_preventivo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getNroOrdenCompra(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $ingreso_almacen_id = isset($request->ingreso_almacen_id) ? $request->ingreso_almacen_id : null;

        try{
            $nro_orden_compra = DB::table('ingresos_almacen')
                            ->where('dea_id', $dea_id)
                            ->where('n_orden_compra',$request->nro_orden_compra)
                            ->where('id','!=',$ingreso_almacen_id)
                            ->whereYear('fecha_ingreso',date('Y'))
                            ->get()
                            ->count();

            $nro_orden_compra = !($nro_orden_compra > 0);

            return response()->json([
                'n_orden_compra' => $nro_orden_compra
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCodigo(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $ingreso_almacen_id = isset($request->ingreso_almacen_id) ? $request->ingreso_almacen_id : null;

        try{
            $codigo = DB::table('ingresos_almacen')
                            ->where('dea_id', $dea_id)
                            ->where('codigo',$request->codigo)
                            ->where('id','!=',$ingreso_almacen_id)
                            ->whereYear('fecha_ingreso',date('Y'))
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

    public function store(Request $request)
    {
        try{
            $data = DB::transaction(function () use ($request) {
                $dea_id = Auth::user()->dea->id;
                $user_id = Auth::user()->id;

                $ingreso_almacen = IngresoAlmacen::create([
                    'dea_id' => $dea_id,
                    'almacen_id' => $request->almacen_id,
                    'user_id' => $user_id,
                    'proveedor_id' => $request->proveedor_id,
                    'area_id' => $request->area_id,
                    'codigo' => $request->codigo,
                    'n_preventivo' => $request->n_preventivo,
                    'n_factura' => isset($request->n_factura) ? $request->n_factura : null,
                    'n_orden_compra' => $request->n_orden_compra,
                    'n_cotizacion' => isset($request->n_cotizacion) ? $request->n_cotizacion : null,
                    'n_solicitud' => $request->n_solicitud,
                    'fecha_ingreso' => date('Y-m-d', strtotime($request->fecha_ingreso)),
                    'obs' => $request->glosa,
                    'estado' => IngresoAlmacen::PENDIENTE
                ]);

                /*$cont = 0;

                while($cont < count($request->producto_id)){
                    $ingreso_almacen_detalle = IngresoAlmacenDetalle::create([
                        'ingreso_almacen_id' => $ingreso_almacen->id,
                        'categoria_programatica_id' => $request->categoria_programatica_id[$cont],
                        'partida_presupuestaria_id' => $request->partida_presupuestaria_id[$cont],
                        'producto_id' => $request->producto_id[$cont],
                        'cantidad' => floatval(str_replace(",", "", $request->cantidad[$cont])),
                        'precio_unitario' => floatval(str_replace(",", "", $request->precio_unitario[$cont])),
                        'estado' => IngresoAlmacenDetalle::HABILITADO,
                    ]);

                    $cont++;
                }*/

                return $ingreso_almacen;
            });
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Ingresos Almacen registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('ingreso.sucursal.editar', $data->id)->with('success_message', '[COMPROBANTE CREADO CON EXITO]');
        } catch (\Exception $e) {
            Log::channel('ingresos_almacen')->info(
                "\n" .
                "Error al crear un registro de ingreso de almacen " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }
    }

    public function show($ingreso_almacen_id)
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
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::where('ingreso_almacen_id',$ingreso_almacen_id)->where('estado',IngresoAlmacenDetalle::HABILITADO)->get();
        $total = $ingreso_almacen_detalles->map(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        })->sum();

        return view('almacenes.ingreso_sucursal.show',compact('ingreso_almacen','ingreso_almacen_detalles','total'));
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
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::byEstado(IngresoAlmacenDetalle::HABILITADO)->where('ingreso_almacen_id', $id)->orderBy('id','desc')->get();
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
    {
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
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::with([
            'categoria_programatica:id,codigo,nombre',
            'partida_presupuestaria:id,numeracion,nombre',
            'producto:id,codigo,nombre,detalle,unidad_id',
            'producto.unidad_medida:id,nombre,alias'
        ])
        ->where('estado', IngresoAlmacenDetalle::HABILITADO)
        ->where('ingreso_almacen_id', $ingreso_almacen_id)
        ->orderBy('ingresos_almacen_detalles.id','asc')
        ->get()
        ->groupBy([
            fn($item) => optional($item->categoria_programatica)->nombre ?? 'Sin categoría',
            fn($item) => optional($item->partida_presupuestaria)->nombre ?? 'Sin partida',
        ]);

        $totalGeneral = $ingreso_almacen_detalles->flatten()->sum(fn($d) => $d->cantidad * $d->precio_unitario);

        $username = User::find(Auth::user()->id);
        $numero_letras = new NumeroALetras();
        $total_en_letras = $numero_letras->toInvoice($totalGeneral, 2, 'Bolivianos');
        $username = $username != null ? $username->nombre_completo : $username->name;
        $pdf = PDF::loadView('almacenes.ingreso_sucursal.pdf',compact('ingreso_almacen','ingreso_almacen_detalles','totalGeneral','total_en_letras','username'));
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
