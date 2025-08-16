<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
//use NumeroALetras;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use App\Models\Recinto;
use App\Models\Mesa;
use App\Models\PartidosYEspeciales;
use App\Models\TipoVotacion;
use App\Models\VotoPorMesa;

class RecintoController extends Controller
{
    public function index()
    {
        $zonas = Recinto::ZONAS;
        $recintosElectorales = Recinto::get();

        return view('recinto-electoral.index',compact('zonas','recintosElectorales'));
    }

    public function store(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $data = DB::transaction(function () use ($request) {
                $municipio_id = 1;

                $recinto = Recinto::create([
                    'municipio_id' => $municipio_id,
                    'nombre' => $request->nombre,
                    'zona' => $request->zona,
                    'estado' => Recinto::HABILITADO
                ]);

                $cont_mesas = 0;

                while($cont_mesas < $request->cantidad){
                    $mesa = Mesa::create([
                        'recinto_id' => $recinto->id,
                        'numero' => $cont_mesas + 1,
                        'estado' => Mesa::HABILITADO
                    ]);

                    $tiposVotacion = TipoVotacion::get();
                    $partidosYEspeciales = PartidosYEspeciales::where('estado', PartidosYEspeciales::HABILITADO)->get();
                    foreach($tiposVotacion as $tipoVotacion){
                        foreach($partidosYEspeciales as $partidoYEspecial){
                            $votorPorMesa = VotoPorMesa::create([
                                'mesa_id' => $mesa->id,
                                'partido_id' => $partidoYEspecial->id,
                                'tipo_votacion_id' => $tipoVotacion->id,
                                'cantidad' => 0,
                                'estado' => VotoPorMesa::HABILITADO,
                            ]);
                        }
                    }

                    $cont_mesas++;
                }

                return $recinto;
            });
            Log::channel('recinto_electoral')->info(
                "\n" .
                "Recinto Electoral registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('recintos.index')->with('success_message', '[RECINTO ELECTORAL CREADO CON EXITO.]');

        } catch (\Exception $e) {
            Log::channel('recinto_electoral')->info(
                "\n" .
                "Error al crear un recinto electoral " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function showMesasElectorales($recinto_id)
    {
        $mesasElectorales = Mesa::where('recinto_id', $recinto_id)->get();

        return view('recinto-electoral.mesas-electorales',compact('mesasElectorales'));
    }

    public function showDetalleMesasElectorales($mesa_id)
    {
        $mesaElectoral = Mesa::find($mesa_id);
        $detalleMesasElectorales = VotoPorMesa::where('mesa_id', $mesa_id)->get();

        return view('recinto-electoral.detalle-mesas-electorales',compact('mesaElectoral', 'detalleMesasElectorales'));
    }

    public function updateRegistroCantidad(Request $request)
    {
        try{
            $votorPorMesa = VotoPorMesa::find($request->id);
            $votorPorMesa->update([
                'cantidad' => floatval($request->cantidad),
            ]);

            Log::channel('recinto_electoral')->info(
                "\n" .
                "Registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );

            if ($votorPorMesa) {
                return response()->json([
                    'success' => true,
                    'message' => 'Voto registrado con éxito para la mesa ' . $votorPorMesa->mesa->numero
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo registrar el voto o no se encontró la mesa.'
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('recinto_electoral')->info(
                "\n" .
                "Error al crear un registro " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );

            return response()->json([
                'success' => false,
                'message' => 'Error al insertar: ' . $e->getMessage()
            ]);
        }
    }

    public function deshabilitarRecinto($recinto_id)
    {
        $recinto = Recinto::find($recinto_id);
        $recinto->update([
            'estado' => 2
        ]);

        return redirect()->route('recintos.index')->with('info_message', '[RECINTO DESHABILITADO]');
    }

    public function habilitarRecinto($recinto_id)
    {
        $recinto = Recinto::find($recinto_id);
        $recinto->update([
            'estado' => 1
        ]);

        return redirect()->route('recintos.index')->with('info_message', '[RECINTO HABILITADO]');
    }

    public function deshabilitarMesa($mesa_id)
    {
        $mesa = Mesa::find($mesa_id);
        $mesa->update([
            'estado' => 2
        ]);

        return redirect()->route('recintos.show.mesas.electorales', $mesa->recinto_id)->with('info_message', '[MESA DESHABILITADO]');
    }

    public function habilitarMesa($mesa_id)
    {
        $mesa = Mesa::find($mesa_id);
        $mesa->update([
            'estado' => 1
        ]);

        return redirect()->route('recintos.show.mesas.electorales', $mesa->recinto_id)->with('info_message', '[MESA HABILITADO]');
    }

    public function deshabilitarMesaDetalle($mesa_detalle_id)
    {
        $mesa_detalle = VotoPorMesa::find($mesa_detalle_id);
        $mesa_detalle->update([
            'estado' => 2
        ]);

        return redirect()->route('recintos.show.detalle.mesas.electorales', $mesa_detalle->mesa_id)->with('info_message', '[MESA DETALLE DESHABILITADO]');
    }

    public function habilitarMesaDetalle($mesa_detalle_id)
    {
        $mesa_detalle = VotoPorMesa::find($mesa_detalle_id);
        $mesa_detalle->update([
            'estado' => 1
        ]);

        return redirect()->route('recintos.show.detalle.mesas.electorales', $mesa_detalle->mesa_id)->with('info_message', '[MESA DETALLE HABILITADO]');
    }
}
