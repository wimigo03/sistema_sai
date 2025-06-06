<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Almacenes\UnidadMedida;

class UnidadMedidaController extends Controller
{
    private function copiar()
    {
        $unidades = DB::table('umedida')->get();
        foreach($unidades as $datos){
            $unidad_medida = UnidadMedida::create([
                'dea_id' => Auth::user()->dea->id,
                'nombre' => $datos->nombreumedida,
                'tipo' => '1',
                'estado' => $datos->estadoumedida
            ]);
        }

        dd("copiar finalizado...");
    }

    public function index()
    {
        /*if(Auth::user()->id == 102){
            //$this->copiar();
        }*/
        $unidades = UnidadMedida::query()
                                ->ByDea(Auth::user()->dea->id)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $tipos = UnidadMedida::TIPOS;
        $estados = UnidadMedida::ESTADOS;
        return view('almacenes.unidad_medida.index',compact('unidades','tipos','estados'));
    }

    public function search(Request $request)
    {
        $unidades = UnidadMedida::query()
                                ->ByDea(Auth::user()->dea->id)
                                ->ByNombre($request->nombre)
                                ->ByAlias($request->alias)
                                ->ByTipo($request->tipo)
                                ->ByEstado($request->estado)
                                ->orderBy('id','desc')
                                ->paginate(10);
        $tipos = UnidadMedida::TIPOS;
        $estados = UnidadMedida::ESTADOS;
        return view('almacenes.unidad_medida.index',compact('unidades','tipos','estados'));
    }

    public function create()
    {
        $tipos = UnidadMedida::TIPOS;
        return view('almacenes.unidad_medida.create',compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'nombre' => 'required|unique:unidades,nombre,null,id,dea_id,' . Auth::user()->dea->id,
            'alias' => 'required|unique:unidades,alias,null,id,dea_id,' . Auth::user()->dea->id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $datos = [
                    'dea_id' => Auth::user()->dea->id,
                    'nombre' => $request->nombre,
                    'alias' => $request->alias,
                    'tipo' => $request->tipo,
                    'estado' => '1'
                ];

                $unidad_medida = UnidadMedida::create($datos);

                return $unidad_medida;
            });
            Log::channel('unidades')->info(
                "\n" .
                "Unidad de medida creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('unidad.medida.index')->with('success_message', '[Unidad de medida creada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('unidades')->info(
                "\n" .
                "Error al crear unidad de medida: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la unidad de medida.]')->withInput();
        }
    }

    public function habilitar($unidad_medida_id)
    {
        try{
            $function = DB::transaction(function () use ($unidad_medida_id) {
                $datos = [
                    'estado' => '1'
                ];

                $unidad_medida = UnidadMedida::find($unidad_medida_id);
                $unidad_medida->update($datos);

                return $unidad_medida;
            });
            Log::channel('unidades')->info(
                "\n" .
                "Unidad de medida habilitada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('unidad.medida.index')->with('success_message', '[Unidad de medida habilitada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('unidades')->info(
                "\n" .
                "Error al habilitar la unidad de medida " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al habilitar la unidad de medida.]')->withInput();
        }
    }

    public function deshabilitar($unidad_medida_id)
    {
        try{
            $function = DB::transaction(function () use ($unidad_medida_id) {
                $datos = [
                    'estado' => '2'
                ];

                $unidad_medida = UnidadMedida::find($unidad_medida_id);
                $unidad_medida->update($datos);

                return $unidad_medida;
            });
            Log::channel('unidades')->info(
                "\n" .
                "Unidad de medida deshabilitada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('unidad.medida.index')->with('success_message', '[Unidad de medida deshabilitada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('unidades')->info(
                "\n" .
                "Error al deshabilitar la unidad de medida " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al deshabilitar la unidad de medida.]')->withInput();
        }
    }

    public function editar($unidad_medida_id)
    {
        $unidad_medida = UnidadMedida::find($unidad_medida_id);
        $dea_id = $unidad_medida->dea_id;
        $tipos = UnidadMedida::TIPOS;
        return view('almacenes.unidad_medida.editar',compact('unidad_medida','dea_id','tipos'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'nombre' => 'required|unique:unidades,nombre,' . $request->unidad_medida_id . ',id,dea_id,' . $request->dea_id,
            'alias' => 'required|unique:unidades,alias,' . $request->unidad_medida_id . ',id,dea_id,' . $request->dea_id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $unidad_medida = UnidadMedida::find($request->unidad_medida_id);
                $unidad_medida->update([
                    'nombre' => $request->nombre,
                    'alias' => $request->alias,
                    'tipo' => $request->tipo
                ]);
                return $unidad_medida;
            });
            Log::channel('unidades')->info(
                "\n" .
                "Unidad de modificada creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('unidad.medida.index')->with('success_message', '[Unidad de medida modificada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('unidades')->info(
                "\n" .
                "Error al modificar unidad de medida: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar la unidad de medida.]')->withInput();
        }
    }
}
