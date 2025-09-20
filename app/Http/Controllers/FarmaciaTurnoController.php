<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Farmacia;
use App\Models\FarmaciaTurno;
use App\Models\Canasta\Dea;

class FarmaciaTurnoController extends Controller
{
    public function index()
    {
        $farmacias = DB::table('farmacias as a')
            ->join('deas as b','a.dea_id','=','b.id')
            ->where('a.estado', 1)
            //->where('a.dea_id', Auth::user()->dea->id)
            ->where('a.dea_id', '!=', 4)
            ->select(DB::raw("CONCAT(b.descripcion, ' - ', a.nombre) as detalle"), 'a.id as id')
            ->orderBy('a.id', 'desc')
            ->pluck('detalle', 'id');

        $farmaciasTurnos = FarmaciaTurno::where('estado', FarmaciaTurno::HABILITADO)->orderBy('id', 'desc')->paginate();

        return view('farmacias-turno.index',compact('farmacias', 'farmaciasTurnos'));
    }

    public function search(Request $request)
    {
        $farmacias = DB::table('farmacias as a')
            ->join('deas as b','a.dea_id','=','b.id')
            ->where('a.estado', 1)
            //->where('a.dea_id', Auth::user()->dea->id)
            ->where('a.dea_id', '!=', 4)
            ->select(DB::raw("CONCAT(b.descripcion, ' - ', a.nombre) as detalle"), 'a.id as id')
            ->orderBy('a.id', 'desc')
            ->pluck('detalle', 'id');

        $farmaciasTurnos = FarmaciaTurno::where('estado', FarmaciaTurno::HABILITADO)
            ->byFechas($request->fecha_i, $request->fecha_f)
            ->byFarmacia($request->farmacia)
            ->orderBy('id', 'desc')
            ->paginate();

        return view('farmacias-turno.index',compact('farmacias', 'farmaciasTurnos'));
    }

    public function create()
    {
        return view('farmacias-turno.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_i'  => ['required','date'],
            'cantidad' => ['required','integer','min:1','max:1000'], // ajusta max según tu caso
        ]);

        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $fi = Carbon::parse($request->fecha_i)->startOfDay();    // 00:00:00
            $ff = Carbon::parse($request->fecha_i)->endOfDay();      // 23:59:59
            $cantidad = (int) $request->cantidad;

            $insertedCount = 0;

            DB::transaction(function () use ($fi, $ff, $cantidad, &$insertedCount) {

                // (Opcional) Si NO quieres duplicados de ese día, descomenta este bloque:
                /*
                $yaExisten = DB::table('farmacias_turno')
                    ->whereDate('fecha_i', $fi->toDateString())
                    ->exists();

                if ($yaExisten) {
                    // Si ya existen, no insertamos (o decide otra lógica)
                    return;
                }
                */

                $rows = [];
                for ($i = 0; $i < $cantidad; $i++) {
                    $rows[] = [
                        'fecha_i' => $fi->copy(),
                        'fecha_f' => $ff->copy(),
                        'estado'  => FarmaciaTurno::HABILITADO, // o el valor que uses por defecto
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($rows)) {
                    DB::table('farmacias_turno')->insert($rows);
                    $insertedCount = count($rows);
                }
            });

            Log::channel('farmacia')->info(
                "\nTurnos registrados: {$insertedCount}\n".
                "Usuario: ".Auth::id()."\n".
                "Día: {$fi->toDateString()} (fi={$fi->toDateTimeString()} | ff={$ff->toDateTimeString()})\n".
                "Cantidad solicitada: {$request->cantidad}\n"
            );

            $msg = "[Insertados: {$insertedCount}]";
            return redirect()
                ->route('farmacias.turnos.index')
                ->with('success_message', $msg);

        } catch (\Throwable $e) {
            Log::channel('farmacia')->error(
                "\nError al crear turnos por día\n".
                "Usuario: ".Auth::id()."\n".
                "Error: ".$e->getMessage()."\n"
            );

            return redirect()
                ->back()
                ->with('error_message','[Ocurrió un error al realizar el registro.]')
                ->withInput();
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'farmacia_id' => ['required']
        ]);

        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $data = DB::transaction(function () use ($request) {
                $farmacia_turno = FarmaciaTurno::find($request->farmacia_turno_id);
                $farmacia_turno->update([
                    'farmacia_id' => $request->farmacia_id
                ]);
            });

            Log::channel('farmacia')->info(
                "\n".
                "Turnos registrados/actualizados: {$data}\n".
                "Usuario: ".Auth::id()."\n"
            );

            return redirect()
                ->route('farmacias.turnos.index')
                ->with('success_message');

        } catch (\Throwable $e) {
            Log::channel('farmacia')->error(
                "\n".
                "Error al crear farmacia\n".
                "Usuario: ".Auth::id()."\n".
                "Error: ".$e->getMessage()."\n"
            );

            return redirect()
                ->back()
                ->with('error_message','[Ocurrió un error al realizar el registro.]')
                ->withInput();
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function delete($farmacia_turno_id)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $data = DB::transaction(function () use ($farmacia_turno_id) {
                $farmacia_turno = FarmaciaTurno::find($farmacia_turno_id);
                $farmacia_turno->update([
                    'farmacia_id' => NULL,
                    'estado' => FarmaciaTurno::NO_HABILITADO
                ]);
            });

            Log::channel('farmacia')->info(
                "\n".
                "Turnos registrados/actualizados: {$data}\n".
                "Usuario: ".Auth::id()."\n"
            );

            return redirect()
                ->route('farmacias.turnos.index')
                ->with('info_message');

        } catch (\Throwable $e) {
            Log::channel('farmacia')->error(
                "\n".
                "Error al crear farmacia\n".
                "Usuario: ".Auth::id()."\n".
                "Error: ".$e->getMessage()."\n"
            );

            return redirect()
                ->back()
                ->with('error_message','[Ocurrió un error al realizar el registro.]')
                ->withInput();
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
