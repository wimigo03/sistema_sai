<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Compra\Item;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;
use App\Models\Compra\UnidadMedida;
use App\Models\Compra\SolicitudCompraDetalle;
use DB;

class ItemController extends Controller
{
    private function copiar()
    {
        $productos = DB::table('prodserv')->where('partida_idpartida',124)->get();
        foreach($productos as $datos){
            $producto = Item::create([
                'categoria_programatica_id' => 1,
                'partida_presupuestaria_id' => 3,
                'dea_id' => Auth::user()->dea->id,
                'user_id' => Auth::user()->id,
                'unidad_id' => 1,
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

    private function actualizarCodigo()
    {
        $items = Item::get();
        foreach($items as $datos){
            $item = Item::find($datos->id);
            $partida_presupuestaria = PartidaPresupuestaria::find($item->partida_presupuestaria_id);
            $cont = Item::where('partida_presupuestaria_id',$item->partida_presupuestaria_id)->where('id','<',$datos->id)->get()->count() + 1;
            $codigo = $partida_presupuestaria->numeracion . '-' . (str_pad($cont,5,"0",STR_PAD_LEFT));

            $item->update([
                'codigo' => $codigo
            ]);
        }

        dd("actualizarCodigo finalizado....");
    }

    public function index()
    {
        /* if(Auth::user()->id == 102){
            //$this->copiar();
            //$this->actualizarCodigo();
        } */
        $items = Item::query()
                        ->ByDea(Auth::user()->dea->id)
                        ->where('estado','!=','3')
                        ->orderBy('id','desc')
                        ->paginate(10);

        $tipos = Item::TIPOS;

        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');
        $estados = Item::ESTADOS;

        return view('compras.item.index',compact('items','tipos','unidades','partidas_presupuestarias','estados'));
    }

    public function search(Request $request)
    {
        $items = Item::query()
                        ->ByDea(Auth::user()->dea->id)
                        ->ByCodigo($request->codigo)
                        ->ByNombre($request->nombre)
                        ->ByDetalle($request->detalle)
                        ->ByUnidadMedida($request->unidad_id)
                        ->ByPartidaPresupuestaria($request->partida_presupuestaria_id)
                        ->ByEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);

        $tipos = Item::TIPOS;

        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');

        $estados = Item::ESTADOS;

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea(Auth::user()->dea->id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        return view('compras.item.index',compact('items','tipos','unidades','partidas_presupuestarias','estados'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea($dea_id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        $unidades = UnidadMedida::where('dea_id',$dea_id)
                                ->where('tipo','1')
                                ->where('estado','1')
                                ->pluck('nombre','id');

        $tipos = Item::TIPOS;

        return view('compras.item.create',compact('partidas_presupuestarias','unidades','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:items,nombre,null,null,dea_id,'. Auth::user()->dea->id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
                $cont = Item::where('partida_presupuestaria_id',$request->partida_presupuestaria_id)->get()->count() + 1;
                $codigo = $partida_presupuestaria->numeracion . '-' . (str_pad($cont,5,"0",STR_PAD_LEFT));

                $datos = [
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'dea_id' => Auth::user()->dea->id,
                    'user_id' => Auth::user()->id,
                    'unidad_id' => $request->unidad_id,
                    'codigo' => $codigo,
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

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea($item->dea_id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        $unidades = UnidadMedida::where('dea_id',$item->dea_id)->where('estado','1')->get();

        $tipos = Item::TIPOS;

        return view('compras.item.editar',compact('item','partidas_presupuestarias','unidades','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('items', 'nombre')
                    ->ignore($request->item_id)
                    ->where(function ($query) {
                        $query->where('estado', 1)
                              ->where('dea_id', Auth::user()->dea->id);
                    }),
            ]
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $item = Item::find($request->item_id);
                if($item->partida_presupuestaria_id != $request->partida_presupuestaria_id){
                    $searchItemsPartidas = SolicitudCompraDetalle::where('item_id',$item->id)->get()->count();
                    if($searchItemsPartidas == 0){
                        $item->update([
                            'estado' => '3',
                            'detalle' => 'ELIMINADO POR ACTUALIZACION',
                        ]);

                        $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
                        $cont = Item::where('partida_presupuestaria_id',$request->partida_presupuestaria_id)->get()->count() + 1;
                        $codigo = $partida_presupuestaria->numeracion . '-' . (str_pad($cont,5,"0",STR_PAD_LEFT));

                        $_item = Item::create([
                            'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                            'dea_id' => Auth::user()->dea->id,
                            'user_id' => Auth::user()->id,
                            'codigo' => $codigo,
                            'unidad_id' => $request->unidad_id,
                            'nombre' => $request->nombre,
                            'detalle' => $request->detalle,
                            'precio' => floatval(str_replace(",", "", $request->precio)),
                            'tipo' => '1',
                            'fecha_registro' => date('Y-m-d'),
                            'estado' => '1'
                        ]);

                        return $_item;
                    }else{
                        return null;
                    }
                }else{
                    $item->update([
                        'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                        'user_id' => Auth::user()->id,
                        'codigo' => $request->codigo,
                        'unidad_id' => $request->unidad_id,
                        'nombre' => $request->nombre,
                        'detalle' => $request->detalle,
                        'precio' => floatval(str_replace(",", "", $request->precio))
                    ]);

                    return $item;
                }
            });
            Log::channel('items')->info(
                "Item: Modificado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            if($function == null){
                return redirect()->back()->with('error_message','[ERROR]. EL ITEM QUE DESEA MODIFICAR YA TIENE PROCESOS REALIZADOS')->withInput();
            }else{
                return redirect()->route('item.index')->with('success_message', '[Item modificado correctamente.]');
            }

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
