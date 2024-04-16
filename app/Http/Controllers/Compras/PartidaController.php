<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\Partida;
use DB;


class PartidaController extends Controller
{

    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $partidas = Partida::query()
                                ->ByDea($dea_id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Partida::ESTADOS;
        return view('compras.partida.index',compact('dea_id','partidas','estados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $partidas = Partida::query()
                                ->ByDea($dea_id)
                                ->ByCodigo($request->codigo)
                                ->ByNombre($request->nombre)
                                ->ByDetalle($request->detalle)
                                ->ByFechaRegistro($request->fecha_registro)
                                ->ByEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $estados = Partida::ESTADOS;
        return view('compras.partida.index',compact('dea_id','partidas','estados'));
    }

    public function create($dea_id)
    {
        return view('compras.partida.create',compact('dea_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:partidas,codigo,null,id,dea_id,' . $request->dea_id,
            'nombre' => 'required',
            'detalle' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'dea_id' => $request->dea_id,
                    'user_id' => Auth::user()->id,
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle,
                    'fecha_registro' => date('Y-m-d'),
                    'estado' => '1'
                ];

                $partida = Partida::create($datos);

                return $partida;
            });
            Log::channel('partidas')->info(
                "Partida Presupuestaria: Creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('partida.index')->with('success_message', '[La partida presupuestaria fue creada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('partidas')->info(
                "Error al crear partida presupuestaria: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la partida presupuestaria.]')->withInput();
        }
    }

    public function habilitar($partida_id)
    {
        try{
            $function = DB::transaction(function () use ($partida_id) {
                $datos = [
                    'estado' => '1'
                ];

                $partida = Partida::find($partida_id);
                $partida->update($datos);

                return $partida;
            });
            Log::channel('partidas')->info(
                "Partida Presupuestaria: " . $function->codigo . " fue habilitada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('partida.index')->with('success_message', '[La partida presupuestaria ' . $function->codigo . ' fue habilitada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('partidas')->info(
                "Error al habilitar partida presupuestaria: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar el partida presupuestaria.]')->withInput();
        }
    }

    public function deshabilitar($partida_id)
    {
        try{
            $function = DB::transaction(function () use ($partida_id) {
                $datos = [
                    'estado' => '2'
                ];

                $partida = Partida::find($partida_id);
                $partida->update($datos);

                return $partida;
            });
            Log::channel('partidas')->info(
                "Partida Presupuestaria: " . $function->codigo . " fue deshabilitada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('partida.index')->with('success_message', '[La partida presupuestaria ' . $function->codigo . ' fue deshabilitada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('partidas')->info(
                "Error al deshabilitar partida presupuestaria: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar el partida presupuestaria.]')->withInput();
        }
    }

    public function editar($partida_id)
    {
        $partida = Partida::find($partida_id);
        return view('compras.partida.editar',compact('partida'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:partidas,codigo,' . $request->partida_id . ',id,dea_id,' . $request->dea_id,
            'nombre' => 'required',
            'detalle' => 'required'
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'detalle' => $request->detalle
                ];

                $partida = Partida::find($request->partida_id);
                $partida->update($datos);

                return $partida;
            });
            Log::channel('partidas')->info(
                "Partida Presupuestaria: Modificada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('partida.index')->with('success_message', '[La partida presupuestaria fue modificada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('partidas')->info(
                "Error al modificar partida presupuestaria: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar la partida presupuestaria.]')->withInput();
        }
    }
}
