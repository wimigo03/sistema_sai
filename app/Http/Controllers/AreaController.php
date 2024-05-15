<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Empleado;
//use App\Models\EmpleadoContrato;
use App\Models\Area;
//use App\Models\FileModel;
use App\Models\Customer;
//use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
//use App\Exportar\EmpleadosExcel;
use App\Models\User;
use DB;
use PDF;

class AreaController extends Controller
{
    public function index()
    {
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->orderBy('idarea','asc')->get();
        if(count($areas) > 0){
            $tree = $this->buildTree($areas);
        }else{
            return redirect()->route('area.index')->with('info_message', 'No hay areas para mostrar...');
        }
        return view('areas.index', compact('areas','tree'));
    }

    protected function buildTree($nodes)
    {
        $tree = [];

        foreach ($nodes as $node) {
            if($node->estadoarea == '2'){
                $class = 'class="font-italic text-danger"';
            }else{
                $class = '';
            }
            $item = [
                'id' => $node->idarea,
                'parent' => $node->parent_id ? $node->parent_id : '#',
                'text' => '<span ' . $class .'>' . $node->nombrearea . '</span>',
            ];

            $tree[] = $item;

            if ($node->children) {
                $item['children'] = $this->buildTree($node->children);
            }
        }

        return $tree;
    }

    public function get_datos($id){
        $area = Area::find($id);
        $parent = Area::where('idarea',$area->parent_id)->first();
        $dependiente = $parent != null ? $parent->nombrearea : '-';
        $tipo = $area->tipo == '1' ? 'INSTITUCIONAL' : 'PROGRAMA';
        $nivel = $area->nivel != null ? $area->nivel : '-';
        $estado = $area->estadoarea == '1' ? 'HABILITADO' : 'NO HABILITADO';
        if($area->count()>0){
            return [
                'dependiente' => $dependiente,
                'area_id' => $id,
                'nombre' => $area->nombrearea,
                'tipo' => $tipo,
                'nivel' => $nivel,
                'estado' => $estado
            ];
        } else return response()->json(['error'=>'Algo Salio Mal']);
    }

    public function create($area_id)
    {
        $area = Area::find($area_id);
        $tipos = Area::TIPOS;
        return view('areas.create', compact('area','tipos'));
    }

    public function store(Request $request)
    {
        try{
            $area = DB::transaction(function () use ($request) {
                $area_anterior = Area::find($request->area_id);
                $area = Area::create([
                    'nombrearea' => $request->nombre_area,
                    'estadoarea' => '1',
                    'idnivel' => 1,
                    'dea_id' => $area_anterior->dea_id,
                    'parent_id' => $request->area_id,
                    'tipo' => $request->tipo,
                    'nivel' => $request->nivel,
                ]);

                return $area;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Area: " . $area->idarea . " registrado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('area.index', ['nodeId' => $area->idarea])->with('success_message', 'Se agregó un registro de area correctamente.');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al registrar area: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el registro]')->withInput();
        }
    }

    public function editar($area_id)
    {
        $area_actual = Area::find($area_id);
        $tipos = Area::TIPOS;
        $areas = Area::where('dea_id',$area_actual->dea_id)->where('idarea', '!=', $area_id)->get();
        $estados = Area::ESTADOS;
        return view('areas.editar', compact('area_actual','tipos','areas','estados'));
    }

    public function update(Request $request)
    {
        try{
            $area = DB::transaction(function () use ($request) {
                $area = Area::find($request->area_id);
                $parent = Area::find($request->parent_id);
                $area->update([
                    'nombrearea' => $request->nombre_area,
                    'parent_id' => $request->parent_id,
                    'tipo' => $request->tipo,
                    'nivel' => $parent->nivel + 1,
                    'estadoarea' => $request->estado,
                ]);

                return $area;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Area: " . $area->idarea . " actualizado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('area.index', ['nodeId' => $area->idarea])->with('success_message', 'Se actualizaron los datos correctamente.');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al actualizar area: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al actualizar el registro]')->withInput();
        }
    }

    public function eliminar($area_id)
    {
        $dependientes = Area::where('parent_id',$area_id)->get()->count();
        if($dependientes > 0){
            return redirect()->route('area.index', ['nodeId' => $area_id])->with('info_message', 'Para proceder primero tiene que eliminar todos lo dependientes.');
        }

        $area = Area::find($area_id);
        $area->delete();
        return redirect()->route('area.index')->with('success_message', 'Area eliminada.');
    }
}
