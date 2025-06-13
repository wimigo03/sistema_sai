<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Almacenes\InventarioInicial;
use App\Models\Almacenes\CategoriaProgramatica;
use App\Models\Almacenes\Presupuesto;

class PresupuestoController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;

        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->pluck('data_completo','id');
        $trimestres = Presupuesto::TRIMESTRES;

        $ejecuciones_presupuestarias = Presupuesto::byDea($dea_id)
                                                ->orderBy('id','desc')
                                                ->paginate(10);

        return view('almacenes.presupuestos.index',compact('categorias_programaticas','trimestres','ejecuciones_presupuestarias'));
    }

    public function search(Request $request)
    {
        $dea_id = Auth::user()->dea->id;

        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->pluck('data_completo','id');
        $trimestres = Presupuesto::TRIMESTRES;

        $ejecuciones_presupuestarias = Presupuesto::byDea($dea_id)
                                                ->byCategoriaProgramatica($request->categoria_programatica_id)
                                                ->byPartidaPresupuestaria($request->partida_presupuestaria_id)
                                                ->byTrimestre($request->trimestre)
                                                ->byGestion($request->gestion)
                                                ->orderBy('id','desc')
                                                ->paginate(10);

        return view('almacenes.presupuestos.index',compact('categorias_programaticas','trimestres','ejecuciones_presupuestarias'));
    }

    public function create()
    {
        $dea_id = Auth::user()->dea->id;
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');

        $trimestres = Presupuesto::TRIMESTRES;
        $gestion = InventarioInicial::where('gestion', date('Y'))->first()->gestion;
        if(!$gestion){
            return redirect()->route('presupuesto.index')->with('error_message', '[ERROR] . La gestion actual aun no tiene inventario inicial.');
        }

        return view('almacenes.presupuestos.create',compact('categorias_programaticas','trimestres', 'gestion'));
    }

    public function getPartidasPresupuestarias(Request $request)
    {
        $dea_id = Auth::user()->dea->id;
        try{
            $partidas_presupuestarias = DB::table('categorias_presupuestarias as a')
                            ->join('partidas_presupuestarias as b','a.partida_presupuestaria_id','b.id')
                            ->where('b.dea_id', $dea_id)
                            ->where('b.estado', '1')
                            ->where('b.detalle', '1')
                            ->where('a.estado', '1')
                            ->where('a.categoria_programatica_id',$request->id)
                            ->select(DB::raw("concat(b.numeracion,' - ',b.nombre) as data_completo"),'b.id as partida_presupuestaria_id')
                            ->get()
                            ->toJson();
            if($partidas_presupuestarias){
                return response()->json([
                    'partidas_presupuestarias' => $partidas_presupuestarias
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validar_presupuesto = Presupuesto::byCategoriaProgramatica($request->categoria_programatica_id)
                                            ->byPartidaPresupuestaria($request->partida_presupuestaria)
                                            ->byTrimestre($request->trimestre)
                                            ->byGestion($request->gestion)
                                            ->get()
                                            ->count();
        if($validar_presupuesto){
            return redirect()->route('presupuesto.create')->with('error_message', '[ERROR] . Registro duplicado.');
        }

        try{
            $data = DB::transaction(function () use ($request) {
                $dea_id = Auth::user()->dea->id;

                $presupuesto = Presupuesto::create([
                    'dea_id' => $dea_id,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'monto' => floatval(str_replace(",", "", $request->monto)),
                    'trimestre' => $request->trimestre,
                    'gestion' => $request->gestion
                ]);

                return $presupuesto;
            });
            Log::channel('varios')->info(
                "\n" .
                "Presupuesto registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('presupuesto.index')->with('success_message', '[Registro creado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('varios')->info(
                "\n" .
                "Error al crear el registro " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }
    }

    public function editar($id)
    {
        $presupuesto = Presupuesto::find($id);
        $dea_id = Auth::user()->dea->id;
        $categorias_programaticas = CategoriaProgramatica::select(DB::raw("concat(codigo,' - ', nombre) as data_completo"),'id')
                                                            ->byDea($dea_id)
                                                            ->byEstado(CategoriaProgramatica::HABILITADO)
                                                            ->pluck('data_completo','id');

        $trimestres = Presupuesto::TRIMESTRES;

        $gestion = InventarioInicial::where('gestion', date('Y'))->first()->gestion;
        if(!$gestion){
            return redirect()->route('presupuesto.index')->with('error_message', '[ERROR] . La gestion actual aun no tiene inventario inicial.');
        }

        return view('almacenes.presupuestos.editar',compact('presupuesto','categorias_programaticas','trimestres', 'gestion'));
    }

    public function update(Request $request)
    {
        $validar_presupuesto = Presupuesto::byCategoriaProgramatica($request->categoria_programatica_id)
                                            ->byPartidaPresupuestaria($request->partida_presupuestaria)
                                            ->byTrimestre($request->trimestre)
                                            ->byGestion($request->gestion)
                                            ->where('id', '!=', $request->presupuesto_id)
                                            ->get()
                                            ->count();
        if($validar_presupuesto){
            return redirect()->route('presupuesto.editar')->with('error_message', '[ERROR] . Registro duplicado.');
        }

        try{
            $data = DB::transaction(function () use ($request) {
                $presupuesto = Presupuesto::find($request->presupuesto_id);
                $presupuesto->update([
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'monto' => floatval(str_replace(",", "", $request->monto)),
                    'trimestre' => $request->trimestre,
                    'gestion' => $request->gestion
                ]);

                return $presupuesto;
            });
            Log::channel('varios')->info(
                "\n" .
                "Presupuesto registrado con exito." . "\n" .
                "Por el usuario " . Auth::user()->id . "\n"
            );
            return redirect()->route('presupuesto.index')->with('success_message', '[Registro modificado correctamente.]');
        } catch (\Exception $e) {
            Log::channel('varios')->info(
                "\n" .
                "Error al modificar el registro " . "\n" .
                "Por el usuario  " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al realizar el registro.]')->withInput();
        }
    }
}
