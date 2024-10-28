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
use App\Models\Compra\CategoriaProgramatica;

class AreaCategoriaController extends Controller
{
    public function index($categoria_programatica_id)
    {
        $dea_id = Auth::user()->dea->id;
        $categoria_programatica = CategoriaProgramatica::find($categoria_programatica_id);
        $areas = Area::query()
                    ->ByDea($dea_id)
                    ->where('categoria_programatica_id',null)
                    ->pluck('nombrearea','idarea');

        $areas_categorias = Area::query()
                                ->ByDea($dea_id)
                                ->ByCategoriaProgramatica($categoria_programatica_id)
                                ->get();

        return view('compras.area_categoria.index',compact('categoria_programatica','areas','areas_categorias'));
    }

    public function search(Request $request)
    {
        dd("search");
    }

    public function create()
    {
        dd("create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'idarea' => 'required',
            'categoria_programatica_id' => 'required',
        ]);

        try{
            $function = DB::transaction(function () use ($request) {
                $area = Area::find($request->idarea);
                $area->update([
                    'categoria_programatica_id' => $request->categoria_programatica_id
                ]);

                return $area;
            });

            return redirect()->back()->with('success_message','[Proceso realizado exitosamente.]')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la solicitud de Material.]')->withInput();
        }
    }

    public function eliminar($id)
    {
        $area_categoria = Area::find($id);
        $area_categoria->update([
            'categoria_programatica_id' => null,
        ]);

        return redirect()->back()->with('info_message','[Habilitacion realizada exitosamente.]')->withInput();
    }
}
