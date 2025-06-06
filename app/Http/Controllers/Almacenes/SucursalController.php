<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Almacenes\Almacen;
use App\Models\User;
use App\Models\Area;

class SucursalController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $users = User::where('dea_id',$dea_id)->pluck('name','id');
        $almacenes = Almacen::query()
                                ->ByDea($dea_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Almacen::ESTADOS;
        return view('almacenes.sucursal.index',compact('users','almacenes','estados'));
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
        return view('almacenes.sucursal.index',compact('users','almacenes','estados'));
    }

    public function create()
    {
        $encargados = DB::table('users as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->select(DB::raw("concat(upper(a.name),' - ',b.nombres,' ',b.ap_pat,' ',b.ap_mat) as empleado"),'a.id as id')
                        ->where('a.dea_id',Auth::user()->dea->id)
                        ->pluck('empleado','id');

        return view('almacenes.sucursal.create',compact('encargados'));
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

    /* public function show($almacen_id)
    {
        $almacen = Almacen::find($almacen_id);
        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->where('estado','1')
                                        ->pluck('categoria_programatica','id');

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as partida_presupuestaria"),'id')
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->pluck('partida_presupuestaria','id');

        $unidades = UnidadMedida::query()
                        ->byDea(Auth::user()->dea->id)
                        ->where('estado','1')
                        ->pluck('nombre','id');

        $ingreso_compra_detalles = IngresoCompraDetalle::query()
                                            ->whereHas('ingresoCompra', function ($query) {
                                                $query->where('estado', '2');
                                            })
                                            ->byDea(Auth::user()->dea->id)
                                            ->byAlmacen($almacen_id)
                                            ->where('ingresos_compras_detalles.estado','1')
                                            ->select(
                                                'item_id',
                                                'categoria_programatica_id',
                                                'partida_presupuestaria_id',
                                                'unidad_id',
                                                DB::raw("sum(cantidad) as saldo_total")
                                                )
                                            ->groupBy('item_id','categoria_programatica_id','partida_presupuestaria_id','unidad_id')
                                            ->orderBy('categoria_programatica_id')
                                            ->paginate(10);

        return view('almacenes.almacen.show',compact('almacen','categorias_programaticas','partidas_presupuestarias','unidades','ingreso_compra_detalles'));
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
    } */

    public function editar($almacen_id)
    {
        $almacen = Almacen::find($almacen_id);
        $encargados = DB::table('users as a')
                        ->join('empleados as b','b.idemp','a.idemp')
                        ->select(DB::raw("concat(upper(a.name),' - ',b.nombres,' ',b.ap_pat,' ',b.ap_mat) as empleado"),'a.id as id')
                        ->where('a.dea_id',Auth::user()->dea->id)
                        ->get();
        return view('almacenes.sucursal.editar',compact('almacen','encargados'));
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
            return redirect()->route('sucursal.index')->with('success_message', '[El almacen fue modificado correctamente.]');
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

    public function asignar($id)
    {
        $almacen = Almacen::find($id);
        $areas = Area::
                leftjoin('almacenes as a','areas.almacen_id','a.id')
                ->where('areas.dea_id',Auth::user()->dea->id)
                ->where('areas.almacen_id',null)
                ->pluck('areas.nombrearea','areas.idarea');
        $areas_almacenes = Area::where('dea_id',Auth::user()->dea->id)->where('almacen_id',$id)->get();
        return view('almacenes.areas_almacen.index',compact('almacen','areas','areas_almacenes'));
    }

    public function asignarStore(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required',
            'area_id' => 'required',
        ]);

        $validar_area = Area::where('idarea',$request->area_id)->where('almacen_id',$request->almacen_id)->first();
        if($validar_area != null){
            return redirect()->back()->with('success_message','[ALMACE DUPLICADO]')->withInput();
        }
        try{
            $function = DB::transaction(function () use ($request) {
                $area = Area::find($request->area_id);
                $area->update([
                    'almacen_id' => $request->almacen_id,
                ]);
                return $area;
            });
            Log::channel('almacenes')->info(
                "\n" .
                "Area asignada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->back()->with('success_message','[Area Asignada.]')->withInput();
        } catch (\Exception $e) {
            Log::channel('almacenes')->info(
                "\n" .
                "Error al agregar area: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el almacen.]')->withInput();
        }
    }

    public function eliminarArea($area_id)
    {
        try{
            $function = DB::transaction(function () use ($area_id) {
                $area = Area::find($area_id);
                $area->update([
                    'almacen_id' => null,
                ]);
                return $area;
            });
            Log::channel('almacenes')->info(
                "\n" .
                "Area eliminada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->back()->with('error_message','[Area Eliminada.]')->withInput();
        } catch (\Exception $e) {
            Log::channel('almacenes')->info(
                "\n" .
                "Error al eliminar area: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el almacen.]')->withInput();
        }
    }

    public function configuracion()
    {
        return view('almacenes.sucursal.configuracion');
    }
}
