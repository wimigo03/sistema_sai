<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\Programa;
use DB;

class ProgramaController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $programas = Programa::query()
                                ->ByDea($dea_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Programa::ESTADOS;
        return view('compras.programa.index',compact('dea_id','programas','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $programas = Programa::query()
                                ->ByDea($dea_id)
                                ->ByNombre($request->nombre)
                                ->ByFechaRegistro($request->fecha_registro)
                                ->ByEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Programa::ESTADOS;
        return view('compras.programa.index',compact('dea_id','programas','estados'));
    }

    public function create($dea_id)
    {
        return view('compras.programa.create',compact('dea_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'dea_id' => $request->dea_id,
                    'user_id' => Auth::user()->id,
                    'nombre' => $request->nombre,
                    'fecha_registro' => date('Y-m-d'),
                    'estado' => '1'
                ];

                $programa = Programa::create($datos);

                return $programa;
            });
            Log::channel('programas')->info(
                "Programa: Creado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('programa.index')->with('success_message', '[El programa fue creado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('programas')->info(
                "Error al crear programa: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el programa.]')->withInput();
        }
    }

    public function habilitar($programa_id)
    {
        try{
            $function = DB::transaction(function () use ($programa_id) {
                $datos = [
                    'estado' => '1'
                ];

                $programa = Programa::find($programa_id);
                $programa->update($datos);

                return $programa;
            });
            Log::channel('programas')->info(
                "Programa: " . $function->nombre . " fue habilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('programa.index')->with('success_message', '[El programa ' . $function->nombre . ' fue habilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('programas')->info(
                "Error al habilitar programa: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar el programa.]')->withInput();
        }
    }

    public function deshabilitar($programa_id)
    {
        try{
            $function = DB::transaction(function () use ($programa_id) {
                $datos = [
                    'estado' => '2'
                ];

                $programa = Programa::find($programa_id);
                $programa->update($datos);

                return $programa;
            });
            Log::channel('programas')->info(
                "Programa: " . $function->nombre . " fue deshabilitado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('programa.index')->with('success_message', '[El programa ' . $function->nombre . ' fue deshabilitado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('programas')->info(
                "Error al deshabilitar programa: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar el programa.]')->withInput();
        }
    }

    public function editar($programa_id)
    {
        $programa = Programa::find($programa_id);
        return view('compras.programa.editar',compact('programa'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'nombre' => $request->nombre
                ];
                $programa = Programa::find($request->programa_id);
                $programa->update($datos);

                return $programa;
            });
            Log::channel('programas')->info(
                "Programa: Modificado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('programa.index')->with('success_message', '[El programa fue modificado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('programas')->info(
                "Error al modificar programa: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el programa.]')->withInput();
        }
    }
}
