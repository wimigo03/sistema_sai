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
use App\Models\Canasta\Barrio;

class FarmaciaTurnoController extends Controller
{
    public function index()
    {
        $farmacias = DB::table('farmacias as a')
            ->join('barrios as b','a.barrio_id','b.id')
            ->where('a.estado', 1)
            ->where('b.dea_id', Auth::user()->dea->id)
            ->pluck('a.nombre', 'a.id');

        $farmaciasTurnos = FarmaciaTurno::paginate();

        return view('farmacias-turno.index',compact('farmacias', 'farmaciasTurnos'));
    }

    public function search(Request $request)
    {
        $farmacias = DB::table('farmacias as a')
            ->join('barrios as b','a.barrio_id','b.id')
            ->where('a.estado', 1)
            ->where('b.dea_id', Auth::user()->dea->id)
            ->pluck('a.nombre', 'a.id');

        $farmaciasTurnos = FarmaciaTurno::byFechas($request->fecha_i, $request->fecha_f)
            ->byFarmacia($request->farmacia)
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
            'fecha_i' => ['required','date'],
            'fecha_f' => ['required','date','after_or_equal:fecha_i'],
        ]);

        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $start = Carbon::parse($request->fecha_i)->startOfDay();
            $end   = Carbon::parse($request->fecha_f)->endOfDay();

            $insertedCount = 0;
            $skippedCount  = 0;

            DB::transaction(function () use ($start, $end, &$insertedCount, &$skippedCount) {

                // 1) Construir el rango día a día
                $period = CarbonPeriod::create($start, '1 day', $end);

                $rows      = [];
                $fechaIs   = [];
                $fechaFs   = [];

                foreach ($period as $day) {
                    $fi = $day->copy()->startOfDay();
                    $ff = $day->copy()->endOfDay();

                    $rows[] = [
                        'fecha_i' => $fi,
                        'fecha_f' => $ff,
                        'estado'  => FarmaciaTurno::HABILITADO,
                    ];

                    $fechaIs[] = $fi;
                    $fechaFs[] = $ff;
                }

                // 2) Consultar duplicados existentes (por fecha_i o por fecha_f)
                $existentes = DB::table('farmacias_turno')
                    ->whereIn('fecha_i', $fechaIs)
                    ->orWhereIn('fecha_f', $fechaFs)
                    ->get(['fecha_i', 'fecha_f']);

                // Sets para filtrar rápido
                $setFi = $existentes->pluck('fecha_i')->map(fn($v)=>Carbon::parse($v)->toDateTimeString())->flip();
                $setFf = $existentes->pluck('fecha_f')->map(fn($v)=>Carbon::parse($v)->toDateTimeString())->flip();

                // 3) Filtrar filas que NO estén repetidas
                $rowsNuevos = [];
                foreach ($rows as $r) {
                    $fiStr = Carbon::parse($r['fecha_i'])->toDateTimeString();
                    $ffStr = Carbon::parse($r['fecha_f'])->toDateTimeString();

                    if (!$setFi->has($fiStr) && !$setFf->has($ffStr)) {
                        $rowsNuevos[] = $r;
                    }
                }

                // 4) Insertar solo los nuevos
                if (!empty($rowsNuevos)) {
                    DB::table('farmacias_turno')->insert($rowsNuevos);
                    $insertedCount = count($rowsNuevos);
                }

                // 5) Conteo de saltados
                $skippedCount = count($rows) - $insertedCount;
            });

            Log::channel('farmacia')->info(
                "\nTurnos registrados: {$insertedCount} | Duplicados omitidos: {$skippedCount}\n".
                "Usuario: ".Auth::id()."\n".
                "Rango: {$request->fecha_i} a {$request->fecha_f}\n"
            );

            $msg = "[Insertados: {$insertedCount}";
            if ($skippedCount > 0) {
                $msg .= " | Omitidos por fechas repetidas: {$skippedCount}";
            }
            $msg .= "]";

            return redirect()
                ->route('farmacias.turnos.index')
                ->with('success_message', $msg);

        } catch (\Throwable $e) {
            Log::channel('farmacia')->error(
                "\nError al crear turnos por rango\n".
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
                    'farmacia_id' => NULL
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
