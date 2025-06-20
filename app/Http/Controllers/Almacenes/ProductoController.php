<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Almacenes\Producto;
use App\Models\Almacenes\PartidaPresupuestaria;
use App\Models\Almacenes\UnidadMedida;

class ProductoController extends Controller
{
    private function copiar()
    {
        $productos = DB::table('prodserv')->where('partida_idpartida',124)->get();
        foreach($productos as $datos){
            $producto = Producto::create([
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
        $items = Producto::get();
        foreach($items as $datos){
            $item = Producto::find($datos->id);
            $partida_presupuestaria = PartidaPresupuestaria::find($item->partida_presupuestaria_id);
            $cont = Producto::where('partida_presupuestaria_id',$item->partida_presupuestaria_id)->where('id','<',$datos->id)->get()->count() + 1;
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
        $productos = Producto::query()
                        ->ByDea(Auth::user()->dea->id)
                        ->where('estado','!=','3')
                        ->orderBy('id','desc')
                        ->paginate(10);

        $tipos = Producto::TIPOS;
        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $estados = Producto::ESTADOS;

        return view('almacenes.productos.index',compact('productos','tipos','unidades','estados'));
    }

    public function search(Request $request)
    {
        $productos = Producto::query()
                        ->ByDea(Auth::user()->dea->id)
                        ->ByCodigo($request->codigo)
                        ->ByNombre($request->nombre)
                        ->ByDetalle($request->detalle)
                        ->ByUnidadMedida($request->unidad_id)
                        ->ByEstado($request->estado)
                        ->orderBy('id','desc')
                        ->paginate(10);

        $tipos = Producto::TIPOS;
        $unidades = UnidadMedida::where('dea_id',Auth::user()->dea->id)->pluck('nombre','id');
        $estados = Producto::ESTADOS;

        return view('almacenes.productos.index',compact('productos','tipos','unidades','estados'));
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

        $tipos = Producto::TIPOS;

        return view('almacenes.productos.create',compact('partidas_presupuestarias','unidades','tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:productos,nombre,null,null,dea_id,'. Auth::user()->dea->id,
        ]);

        /*$request->validate([
            'nombre' => [
                'required',
                Rule::unique('productos')->where(function ($query) use($request) {
                    return $query->where('dea_id', '!=', Auth::user()->dea->id)
                                ->where('unidad_id', '!=', $request->unidad_id);
                }),
            ],
        ]);*/

        $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
        $codigo = $partida_presupuestaria->numeracion . '-' . (str_pad($request->numeracion,5,"0",STR_PAD_LEFT));

        $search_codigo = Producto::where('codigo',$codigo)->first();

        if($search_codigo != null){
            return redirect()->back()->with('error_message','[EL CODIGO QUE DESEA REGISTRAR YA EXISTE...]')->withInput();
        }

        try{
            $function = DB::transaction(function () use ($request, $codigo) {
                /* $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
                $cont = Producto::where('partida_presupuestaria_id',$request->partida_presupuestaria_id)->get()->count() + 1;
                $codigo = $partida_presupuestaria->numeracion . '-' . (str_pad($cont,5,"0",STR_PAD_LEFT)); */

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

                $producto = Producto::create($datos);

                return $producto;
            });
            Log::channel('items')->info(
                "Producto: Creado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('producto.index')->with('success_message', '[Material registrado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al crear Producto: " . "\n" .
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
                $item = Producto::find($item_id);
                $item->update([
                    'estado' => '1'
                ]);

                return $item;
            });
            Log::channel('items')->info(
                "Producto: " . $function->nombre . " fue habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('producto.editar',$item_id)->with('success_message', '[El material ' . $function->nombre . ' fue habilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al habilitar Producto: " . "\n" .
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
                $item = Producto::find($item_id);
                $item->update([
                    'estado' => '2'
                ]);

                return $item;
            });
            Log::channel('items')->info(
                "Producto: " . $function->nombre . " fue deshabilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('producto.index')->with('success_message', '[El material ' . $function->nombre . ' fue deshabilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al deshabilitar Producto: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar el item.]')->withInput();
        }
    }

    public function editar($producto_id)
    {
        $producto = Producto::find($producto_id);

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->byDea($producto->dea_id)
                                        ->where('detalle','1')
                                        ->where('estado','1')
                                        ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        $unidades = UnidadMedida::where('dea_id',$producto->dea_id)->where('estado','1')->get();

        $tipos = Producto::TIPOS;

        return view('almacenes.productos.editar',compact('producto','partidas_presupuestarias','unidades','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('productos', 'nombre')
                    ->ignore($request->item_id)
                    ->where(function ($query) {
                        $query->where('estado', 1)
                              ->where('dea_id', Auth::user()->dea->id);
                    }),
            ]
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $producto = Producto::find($request->item_id);
                $producto->update([
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'user_id' => Auth::user()->id,
                    'codigo' => $request->codigo,
                    'unidad_id' => $request->unidad_id,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle,
                    'precio' => floatval(str_replace(",", "", $request->precio))
                ]);

                return $producto;
            });
            Log::channel('items')->info(
                "Producto: Modificado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            if($function == null){
                return redirect()->back()->with('error_message','[ERROR]. EL ITEM QUE DESEA MODIFICAR YA TIENE PROCESOS REALIZADOS')->withInput();
            }else{
                return redirect()->route('producto.index')->with('success_message', '[Item modificado correctamente.]');
            }

        } catch (\Exception $e) {
            Log::channel('items')->info(
                "Error al modificar Producto: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el item.]')->withInput();
        }
    }
}
