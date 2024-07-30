<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\Item;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\UnidadMedida;
use DB;

class ItemController extends Controller
{
    private function copiar()
    {
        $productos = DB::table('prodserv')->where('partida_idpartida',124)->get();
        foreach($productos as $datos){
            $producto = Item::create([
                //'partida_id' => 125,
                //'partida_id' => 151,
                'dea_id' => Auth::user()->dea->id,
                'user_id' => Auth::user()->id,
                'unidad_id' => 3,
                'nombre' => $datos->nombreprodserv,
                'detalle' => $datos->detalleprodserv,
                'precio' => $datos->precioprodserv,
                'tipo' => '1',
                'fecha_registro' => date('Y-m-d'),
                'estado' => $datos->estadoprodserv
            ]);
        }

        dd("copiar finalizado....");
    }

    public function index()
    {
        /*if(Auth::user()->id == 102){
            //$this->copiar();
        }*/
        $items = Item::query()
                        ->ByDea(Auth::user()->dea->id)
                        ->orderBy('id','desc')
                        ->paginate(10);
        $tipos = Item::TIPOS;
        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->orderBy('codigo','asc')
                                        ->pluck('categoria_programatica','id');

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');
        $estados = Item::ESTADOS;
        return view('compras.item.index',compact('items','tipos','unidades','categorias_programaticas','partidas_presupuestarias','estados'));
    }

    public function search(Request $request)
    {
        $items = Item::query()
                        ->ByDea(Auth::user()->dea->id)
                        ->ByNombre($request->nombre)
                        ->ByDetalle($request->detalle)
                        //->ByPrecio($request->precio)
                        //->ByTipo($request->tipo)
                        ->ByUnidadMedida($request->unidad_id)
                        ->ByCategoriaProgramatica($request->categoria_programatica_id)
                        ->ByPartidaPresupuestaria($request->partida_presupuestaria_id)
                        ->ByEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);
        $tipos = Item::TIPOS;
        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $estados = Item::ESTADOS;

        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->orderBy('codigo','asc')
                                        ->pluck('categoria_programatica','id');

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');
        return view('compras.item.index',compact('items','tipos','unidades','categorias_programaticas','partidas_presupuestarias','estados'));
    }

    public function create()
    {
        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->orderBy('codigo','asc')
                                        ->pluck('categoria_programatica','id');

        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->where('tipo','1')->where('estado','1')->pluck('nombre','id');
        $tipos = Item::TIPOS;
        return view('compras.item.create',compact('categorias_programaticas','unidades','tipos'));
    }

    public function getPartidasPresupuestarias(Request $request)
    {
        try{
            $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->where('categoria_programatica_id',$request->id)
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:items,nombre,null,null,dea_id,'. Auth::user()->dea->id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'dea_id' => Auth::user()->dea->id,
                    'user_id' => Auth::user()->id,
                    'unidad_id' => $request->unidad_id,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle,
                    'precio' => floatval(str_replace(",", "", $request->precio)),
                    'tipo' => '1',
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
                $item = Item::find($item_id);
                $item->update([
                    'estado' => '1'
                ]);

                return $item;
            });
            Log::channel('items')->info(
                "Item: " . $function->nombre . " fue habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('item.editar',$item_id)->with('success_message', '[El item ' . $function->nombre . ' fue habilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al habilitar item: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar el item.]')->withInput();
        }
    }

    public function inhabilitar($item_id)
    {
        try{
            $function = DB::transaction(function () use ($item_id) {
                $item = Item::find($item_id);
                $item->update([
                    'estado' => '2'
                ]);

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
        $categorias_programaticas = CategoriaProgramatica::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->select(DB::raw("concat(codigo,' - ',nombre) as categoria_programatica"),'id')
                                        ->orderBy('codigo','asc')
                                        ->get();
        /*$partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->get();*/
        $unidades = UnidadMedida::where('dea_id',$item->dea_id)->where('estado','1')->get();
        $tipos = Item::TIPOS;
        return view('compras.item.editar',compact('item','categorias_programaticas','unidades','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:items,nombre,' . $request->item_id . ',id,dea_id,'. Auth::user()->dea->id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $item = Item::find($request->item_id);
                $item->update([
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'user_id' => Auth::user()->id,
                    'unidad_id' => $request->unidad_id,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle,
                    'precio' => floatval(str_replace(",", "", $request->precio))
                ]);

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
