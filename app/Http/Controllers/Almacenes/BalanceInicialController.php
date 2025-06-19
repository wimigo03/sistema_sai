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
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::byEstado(IngresoAlmacenDetalle::HABILITADO)->where('ingreso_almacen_id', $id)->get();
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

        return view('almacenes.balance_inicial.editar',compact('ingreso_almacen','ingreso_almacen_detalles','old_total','total','almacenes','proveedores','categorias_programaticas','areas'));
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
        $ingreso_almacen_detalles = IngresoAlmacenDetalle::with([
            'categoria_programatica:id,codigo,nombre',
            'partida_presupuestaria:id,numeracion,nombre',
            'producto:id,codigo,nombre,detalle,unidad_id',
            'producto.unidad_medida:id,nombre,alias'
        ])
        ->where('estado', IngresoAlmacenDetalle::HABILITADO)
        ->where('ingreso_almacen_id', $ingreso_almacen_id)
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
