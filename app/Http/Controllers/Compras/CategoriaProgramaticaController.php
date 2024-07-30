<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\CategoriaProgramatica;
use DB;

class CategoriaProgramaticaController extends Controller
{
    public function index()
    {
        $categorias_programaticas = CategoriaProgramatica::query()
                                                            ->ByDea(Auth::user()->dea->id)
                                                            ->orderBy('id','desc')
                                                            ->paginate(10);
        $estados = CategoriaProgramatica::ESTADOS;
        return view('compras.categoria_programatica.index',compact('categorias_programaticas','estados'));
    }

    public function search(Request $request)
    {
        $categorias_programaticas = CategoriaProgramatica::query()
                                                            ->ByDea(Auth::user()->dea->id)
                                                            ->ByCodigo($request->codigo)
                                                            ->ByNombre($request->nombre)
                                                            ->ByEstado($request->estado)
                                                            ->orderBy('id','desc')
                                                            ->paginate(10);
        $estados = CategoriaProgramatica::ESTADOS;
        return view('compras.categoria_programatica.index',compact('categorias_programaticas','estados'));
    }

    public function create()
    {
        return view('compras.categoria_programatica.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'dea_id' => Auth::user()->dea->id,
                    'user_id' => Auth::user()->id,
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'fecha_registro' => date('Y-m-d'),
                    'estado' => '1'
                ];

                $categoria_programatica = CategoriaProgramatica::create($datos);

                return $categoria_programatica;
            });
            Log::channel('categorias_programaticas')->info(
                "Categoria Programatica: Creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('categoria.programatica.index')->with('success_message', '[La Categoria Programatica fue creada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('categorias_programaticas')->info(
                "Error al crear categoria programatica: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el categoria programatica.]')->withInput();
        }
    }

    public function habilitar($categoria_programatica_id)
    {
        try{
            $function = DB::transaction(function () use ($categoria_programatica_id) {
                $datos = [
                    'estado' => '1'
                ];

                $categoria_programatica = CategoriaProgramatica::find($categoria_programatica_id);
                $categoria_programatica->update($datos);

                return $categoria_programatica;
            });
            Log::channel('categorias_programaticas')->info(
                "Categoria Programatica: " . $function->nombre . " fue habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('categoria.programatica.index')->with('success_message', '[La categoria programatica ' . $function->nombre . ' fue habilitada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('categorias_programaticas')->info(
                "Error al habilitar categoria programatica: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar la categoria programatica.]')->withInput();
        }
    }

    public function deshabilitar($categoria_programatica_id)
    {
        try{
            $function = DB::transaction(function () use ($categoria_programatica_id) {
                $datos = [
                    'estado' => '2'
                ];

                $categoria_programatica = CategoriaProgramatica::find($categoria_programatica_id);
                $categoria_programatica->update($datos);

                return $categoria_programatica;
            });
            Log::channel('categorias_programaticas')->info(
                "Categoria Programatica: " . $function->nombre . " fue deshabilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('categoria.programatica.index')->with('success_message', '[La categoria programatica ' . $function->nombre . ' fue deshabilitada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('categorias_programaticas')->info(
                "Error al deshabilitar categoria programatica: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar la categoria programatica.]')->withInput();
        }
    }

    public function editar($categoria_programatica_id)
    {
        $categoria_programatica = CategoriaProgramatica::find($categoria_programatica_id);
        return view('compras.categoria_programatica.editar',compact('categoria_programatica'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre
                ];

                $categoria_programatica = CategoriaProgramatica::find($request->categoria_programatica_id);
                $categoria_programatica->update($datos);

                return $categoria_programatica;
            });
            Log::channel('categorias_programaticas')->info(
                "Categoria Programatica: Modificada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('categoria.programatica.index')->with('success_message', '[La Categoria Programatica fue modificada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('categorias_programaticas')->info(
                "Error al modificar categoria programatica: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el categoria programatica.]')->withInput();
        }
    }
}
