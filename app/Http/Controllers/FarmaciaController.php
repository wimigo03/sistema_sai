<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Farmacia;
use App\Models\Canasta\Barrio;

class FarmaciaController extends Controller
{
    public function index()
    {
        $farmacias = Farmacia::paginate();
        return view('farmacias.index',compact('farmacias'));
    }

    public function search(Request $request)
    {
        $farmacias = Farmacia::byBarrio($request->barrio)
            ->byFarmacia($request->farmacia)
            ->paginate();
        return view('farmacias.index',compact('farmacias'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $barrios = Barrio::where('dea_id',$dea_id)->pluck('nombre', 'id');

        return view('farmacias.create',compact('barrios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:farmacias,nombre',
        ]);

        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $data = DB::transaction(function () use ($request) {
                $farmacia = Farmacia::create([
                    'barrio_id' => $request->barrio_id,
                    'nombre' => $request->nombre,
                    'direccion' => $request->direccion,
                    'whatsapp' => $request->whatsapp,
                    'facebook' => $request->facebook,
                    'lat' => $request->latitud,
                    'lng' => $request->longitud,
                    'estado' => Farmacia::HABILITADO
                ]);

                return $farmacia;
            });
            Log::channel('farmacia')->info(
                "\n" .
                "farmacia registrada con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('farmacias.index')->with('success_message', '[FARMACIA CREADA CON EXITO.]');

        } catch (\Exception $e) {
            Log::channel('farmacia')->info(
                "\n" .
                "Error al crear una farmacia " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function editar($farmacia_id)
    {
        $farmacia = Farmacia::find($farmacia_id);
        $dea_id = Auth::user()->dea->id;
        $barrios = Barrio::where('dea_id',$dea_id)->pluck('nombre', 'id');

        return view('farmacias.editar',compact('farmacia','barrios'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('farmacias', 'nombre')->ignore($request->farmacia_id),
            ],
        ]);

        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $data = DB::transaction(function () use ($request) {
                $farmacia = Farmacia::find($request->farmacia_id);
                $farmacia->update([
                    'barrio_id' => $request->barrio_id,
                    'nombre' => $request->nombre,
                    'direccion' => $request->direccion,
                    'whatsapp' => $request->whatsapp,
                    'facebook' => $request->facebook,
                    'lat' => $request->latitud,
                    'lng' => $request->longitud
                ]);

                return $farmacia;
            });
            Log::channel('farmacia')->info(
                "\n" .
                "farmacia registrada con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('farmacias.index')->with('info_message','[]');

        } catch (\Exception $e) {
            Log::channel('farmacia')->info(
                "\n" .
                "Error al crear una farmacia " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
