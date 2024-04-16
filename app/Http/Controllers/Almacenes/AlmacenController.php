<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Almacenes\Almacen;
use App\Models\User;
use App\Models\Canasta\Dea;
/*use App\Models\Compra\OrdenCompra;
use App\Models\Compra\OrdenCompraDetalle;
use App\Models\Compra\SolicitudCompra;
use App\Models\AreasModel;
use App\Models\Compra\Proveedor;

use App\Models\EmpleadosModel;
use App\Models\Compra\Item;

use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\Programa;*/
use DB;

class AlmacenController extends Controller
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
        return view('almacenes.almacen.index',compact('dea_id','users','almacenes','estados'));
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
        return view('almacenes.almacen.index',compact('dea_id','users','almacenes','estados'));
    }

    public function create($dea_id)
    {
        $dea = Dea::find($dea_id);
        $encargados = User::where('dea_id',$dea_id)->pluck('name','id');
        return view('almacenes.almacen.create',compact('dea','encargados'));
    }

    public function store(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                $almacen = Almacen::create([
                    'dea_id' => $request->dea_id,
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
    {dd($almacen_id);
        $orden_compra = OrdenCompra::find($orden_compra_id);
        $orden_compra_detalles = OrdenCompraDetalle::where('orden_compra_id',$orden_compra_id)->where('estado','1')->get();
        return view('compras.orden_compra.show',compact('orden_compra','orden_compra_detalles'));
    }

    public function editar($almacen_id)
    {
        $almacen = Almacen::find($almacen_id);
        $dea = Dea::find($almacen->dea_id);
        $encargados = User::where('dea_id',$almacen->dea_id)->get();
        return view('almacenes.almacen.editar',compact('almacen','dea','encargados'));
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
