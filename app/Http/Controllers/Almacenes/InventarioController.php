<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Almacenes\Almacen;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Compra\IngresoCompraDetalle;
use App\Models\Compra\Item;
use DB;

class InventarioController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $inventario = Almacen::query()
                    ->join('ingresos_compras_detalles as a','a.almacen_id','almacenes.id')
                    ->join('partidas_presupuestarias as b','b.id','a.partida_presupuestaria_id')
                    ->join('items as c','c.id','a.item_id')
                    ->join('ingresos_compras as d','d.id','a.ingreso_compra_id')
                    ->join('unidades as e','e.id','a.unidad_id')
                    ->byDea($dea_id)
                    ->where('d.estado','2')
                    ->select(
                        'almacenes.nombre',
                        'a.item_id',
                        'b.codigo',
                        'b.nombre as partida_presupuestaria',
                        'c.nombre as material',
                        'a.partida_presupuestaria_id',
                        'a.unidad_id',
                        'e.nombre as unidad_medida',
                        DB::raw("sum(a.cantidad) as saldo_total"))
                    ->groupBy('almacenes.nombre','a.item_id','b.codigo','b.nombre','c.nombre','a.partida_presupuestaria_id','a.unidad_id','e.nombre')
                    ->orderBy('a.item_id','desc')
                    ->paginate(10);

        return view('almacenes.inventario.index',compact('inventario'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $almacenes = Almacen::query()
                                ->ByDea($dea_id)
                                ->ByNombre($request->nombre)
                                ->ByDireccion($request->direccion)
                                ->ByEncargado($request->user_id)
                                ->ByEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Almacen::ESTADOS;
        return view('almacenes.almacen.index',compact('users','almacenes','estados'));
    }

    public function create()
    {
        $encargados = DB::table('users as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->select(DB::raw("concat(upper(a.name),' - ',b.nombres,' ',b.ap_pat,' ',b.ap_mat) as empleado"),'a.id as id')
                        ->where('a.dea_id',Auth::user()->dea->id)
                        ->pluck('empleado','id');

        return view('almacenes.almacen.create',compact('encargados'));
    }

    public function store(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $almacen = Almacen::create([
                    'dea_id' => Auth::user()->dea->id,
                    'user_id' => $request->user_id,
                    'nombre' => $request->nombre,
                    'direccion' => $request->direccion,
                    'estado' => '1'
                ]);
                return $almacen;
            });
            Log::channel('almacenes')->info(
                "\n" .
                "Almacen Creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('almacen.index')->with('success_message', '[El almacen fue registrado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('almacenes')->info(
                "\n" .
                "Error al crear el almacen: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el almacen.]')->withInput();
        }
    }

    public function show($almacen_id)
    {
        $almacen = Almacen::find($almacen_id);
        $partidas_presupuestarias = Partida::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        $ingreso_compra_detalles = IngresoCompraDetalle::query()
                                            ->whereHas('ingresoCompra', function ($query) {
                                                $query->where('estado', '2');
                                            })
                                            ->byDea(Auth::user()->dea->id)
                                            ->byAlmacen($almacen_id)
                                            ->select('item_id','partida_id','unidad_id',DB::raw("sum(saldo) as saldo_total"))
                                            ->groupBy('item_id','partida_id','unidad_id')
                                            ->paginate(10);

        return view('almacenes.almacen.show',compact('almacen','partidas_presupuestarias','ingreso_compra_detalles'));
    }

    public function showSearch(Request $request)
    {
        $almacen = Almacen::find($request->almacen_id);
        $partidas_presupuestarias = Partida::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        $ingreso_compra_detalles = IngresoCompraDetalle::query()
                                            ->whereHas('ingresoCompra', function ($query) {
                                                $query->where('estado', '2');
                                            })
                                            ->byDea(Auth::user()->dea->id)
                                            ->byAlmacen($request->almacen_id)
                                            ->byPartidaPresupuestaria($request->partida_presupuestaria_id)
                                            ->byItem($request->item)
                                            ->select('item_id','partida_id','unidad_id',DB::raw("sum(saldo) as saldo_total"))
                                            ->groupBy('item_id','partida_id','unidad_id')
                                            ->paginate(10);

        return view('almacenes.almacen.show',compact('almacen','partidas_presupuestarias','ingreso_compra_detalles'));
    }

    public function editar($almacen_id)
    {
        $almacen = Almacen::find($almacen_id);
        $encargados = DB::table('users as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->select(DB::raw("concat(upper(a.name),' - ',b.nombres,' ',b.ap_pat,' ',b.ap_mat) as empleado"),'a.id as id')
                        ->where('a.dea_id',Auth::user()->dea->id)
                        ->get();
        return view('almacenes.almacen.editar',compact('almacen','encargados'));
    }

    public function update(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $almacen = Almacen::find($request->almacen_id);
                $almacen->update([
                    'user_id' => $request->user_id,
                    'nombre' => $request->nombre,
                    'direccion' => $request->direccion
                ]);
                return $almacen;
            });
            Log::channel('almacenes')->info(
                "\n" .
                "Almacen Modificado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('almacen.index')->with('success_message', '[El almacen fue modificado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('almacenes')->info(
                "\n" .
                "Error al modificar el almacen: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el almacen.]')->withInput();
        }
    }
}
