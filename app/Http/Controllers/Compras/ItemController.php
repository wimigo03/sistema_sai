<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\Item;
use App\Models\Compra\Partida;
use App\Models\Compra\UnidadMedida;
use DB;



class ItemController extends Controller
{

    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $items = Item::query()
                        ->ByDea($dea_id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        $tipos = Item::TIPOS;
        $unidades = UnidadMedida::where('dea_id',$dea_id)->pluck('nombre','id');
        $estados = Item::ESTADOS;
        return view('compras.item.index',compact('dea_id','items','tipos','unidades','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $items = Item::query()
                        ->ByDea($dea_id)
                        ->ByNombre($request->nombre)
                        ->ByDetalle($request->detalle)
                        ->ByPrecio($request->precio)
                        ->ByTipo($request->tipo)
                        ->ByUnidadMedida($request->unidad_id)
                        ->ByCodigoPartidaPresupuestaria($request->codigo_partida)
                        ->ByPartidaPresupuestaria($request->partida_presupuestaria)
                        ->ByFechaRegistro($request->fecha_registro)
                        ->ByEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);
        $tipos = Item::TIPOS;
        $unidades = UnidadMedida::where('dea_id',$dea_id)->pluck('nombre','id');
        $estados = Item::ESTADOS;
        return view('compras.item.index',compact('dea_id','items','tipos','unidades','estados'));
    }

    public function create($dea_id)
    {
        $partidas_presupuestarias = Partida::where('dea_id',$dea_id)->where('estado','1')->pluck('nombre','id');
        $unidades = UnidadMedida::where('dea_id',$dea_id)->where('tipo','1')->where('estado','1')->pluck('nombre','id');
        $tipos = Item::TIPOS;
        return view('compras.item.create',compact('dea_id','partidas_presupuestarias','unidades','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'partida_id' => 'required',
            'nombre' => 'required',
            'unidad_id' => 'required',
            'precio' => 'required',
            'tipo' => 'required',
            'detalle' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'partida_id' => $request->partida_id,
                    'dea_id' => $request->dea_id,
                    'user_id' => Auth::user()->id,
                    'unidad_id' => $request->unidad_id,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle,
                    'precio' => floatval(str_replace(",", "", $request->precio)),
                    'tipo' => $request->tipo,
                    'fecha_registro' => date('Y-m-d'),
                    'estado' => '1'
                ];

                $item = Item::create($datos);

                return $item;
            });
            Log::channel('items')->info(
                "Item: Creado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('item.index')->with('success_message', '[Item creado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al crear item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el item.]')->withInput();
        }
    }

    public function habilitar($item_id)
    {
        try{
            $function = DB::transaction(function () use ($item_id) {
                $datos = [
                    'estado' => '1'
                ];

                $item = Item::find($item_id);
                $item->update($datos);

                return $item;
            });
            Log::channel('items')->info(
                "Item: " . $function->nombre . " fue habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('item.index')->with('success_message', '[El item ' . $function->nombre . ' fue habilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al habilitar item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar el item.]')->withInput();
        }
    }

    public function deshabilitar($item_id)
    {
        try{
            $function = DB::transaction(function () use ($item_id) {
                $datos = [
                    'estado' => '2'
                ];

                $item = Item::find($item_id);
                $item->update($datos);

                return $item;
            });
            Log::channel('items')->info(
                "Item: " . $function->nombre . " fue deshabilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('item.index')->with('success_message', '[El item ' . $function->nombre . ' fue deshabilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al deshabilitar item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar el item.]')->withInput();
        }
    }

    public function editar($item_id)
    {
        $item = Item::find($item_id);
        $partidas_presupuestarias = Partida::where('dea_id',$item->dea_id)->where('estado','1')->get();
        $unidades = UnidadMedida::where('dea_id',$item->dea_id)->where('estado','1')->get();
        $tipos = Item::TIPOS;
        return view('compras.item.editar',compact('item','partidas_presupuestarias','unidades','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'partida_id' => 'required',
            'nombre' => 'required',
            'unidad_id' => 'required',
            'precio' => 'required',
            'tipo' => 'required',
            'detalle' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'partida_id' => $request->partida_id,
                    'dea_id' => $request->dea_id,
                    'user_id' => Auth::user()->id,
                    'unidad_id' => $request->unidad_id,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle,
                    'precio' => floatval(str_replace(",", "", $request->precio)),
                    'tipo' => $request->tipo
                ];

                $item = Item::find($request->item_id);
                $item->update($datos);

                return $item;
            });
            Log::channel('items')->info(
                "Item: Modificado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('item.index')->with('success_message', '[Item modificado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al modificar item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el item.]')->withInput();
        }
    }
}
