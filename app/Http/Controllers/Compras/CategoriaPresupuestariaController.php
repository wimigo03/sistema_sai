<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use DB;

use App\Models\Empleado;
use App\Models\User;
use App\Models\Area;
use App\Models\Compra\CategoriaPresupuestaria;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;

class CategoriaPresupuestariaController extends Controller
{
    public function index($categoria_programatica_id)
    {
        $dea_id = Auth::user()->dea->id;
        $categoria_programatica = CategoriaProgramatica::find($categoria_programatica_id);
        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                        ->ByDea($dea_id)
                                        ->where('detalle','1')
                                        ->select(DB::raw("concat(numeracion,'-',nombre) as partida_presupuestaria"),'id')
                                        ->pluck('partida_presupuestaria','id');

        $categorias_presupuestarias = CategoriaPresupuestaria::query()
                                        ->ByDea($dea_id)
                                        ->ByCategoriaProgramatica($categoria_programatica_id)
                                        ->get();

        return view('compras.categoria_presupuestaria.index',compact('categoria_programatica','partidas_presupuestarias','categorias_presupuestarias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'partida_presupuestaria_id' => [
                'required',
                Rule::unique('categorias_presupuestarias')
                    ->where('categoria_programatica_id', $request->categoria_programatica_id)
            ],
            'categoria_programatica_id' => 'required',
        ]);

        try{
            $function = DB::transaction(function () use ($request) {
                $categoria_presupuestaria = CategoriaPresupuestaria::create([
                    'dea_id' => Auth::user()->dea->id,
                    'partida_presupuestaria_id' => $request->partida_presupuestaria_id,
                    'categoria_programatica_id' => $request->categoria_programatica_id,
                    'estado' => '1'
                ]);

                return $categoria_presupuestaria;
            });

            return redirect()->back()->with('success_message','[Proceso realizado exitosamente.]')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la solicitud de Material.]')->withInput();
        }
    }

    public function habilitar($id)
    {
        $categoria_presupuestaria = CategoriaPresupuestaria::find($id);
        $categoria_presupuestaria->update([
            'estado' => '1',
        ]);

        return redirect()->back()->with('success_message','[Habilitacion realizada exitosamente.]')->withInput();
    }

    public function deshabilitar($id)
    {
        $categoria_presupuestaria = CategoriaPresupuestaria::find($id);
        $categoria_presupuestaria->update([
            'estado' => '2',
        ]);

        return redirect()->back()->with('info_message','[Habilitacion realizada exitosamente.]')->withInput();
    }
}
