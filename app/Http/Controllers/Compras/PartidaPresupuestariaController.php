<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Compra\CategoriaProgramatica;
use App\Models\Compra\PartidaPresupuestaria;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\PartidaPresupuestariaExcel;
use DB;


class PartidaPresupuestariaController extends Controller
{
    private function copiar()
    {
        $partidas = DB::table('partida')->get();

        foreach($partidas as $datos){
            $partida = Partida::create([
                'dea_id' => Auth::user()->dea->id,
                'codigo' => $datos->codigopartida,
                'nombre' => $datos->nombrepartida,
                'detalle' => $datos->detallepartida,
                'fecha_registro' => date('Y-m-d'),
                'estado' => $datos->estadopartida
            ]);
        }
        dd("copiar finalizado...");
    }

    public function index(Request $request)
    {
        /*if(Auth::user()->id == 102){
            //$this->copiar();
        }*/

        $search_nodeId = 0;
        if(($request->numeracion)){
            $partidas_presupuestaria = PartidaPresupuestaria::where('numeracion',$request->numeracion)->first();
            $search_nodeId = $partidas_presupuestaria != null ? $partidas_presupuestaria->id : 0;
        }

        $partidas_presupuestarias = PartidaPresupuestaria::query()
                                    ->ByDea(Auth::user()->dea->id)
                                    ->orderBy('numeracion')
                                    ->get();
        $tree = $partidas_presupuestarias != null ? $this->buildTree($partidas_presupuestarias) : null;

        return view('compras.partidas_prespuestarias.index',compact('partidas_presupuestarias','tree','search_nodeId'));
    }

    protected function buildTree($nodes)
    {
        $tree = [];

        foreach ($nodes as $node) {
            if($node->estado == '2'){
                $class = 'class="font-italic text-danger"';
                $status = ' (DESHABILITADO)';
            }else{
                $class = '';
                $status = '';
            }
            if($node->detalle == '1'){
                $a = '<i class="fas fa-poll-h fa-fw text-danger"></i>';
            }else{
                $a = '<i class="fas fa-poll-h fa-fw"></i>';
            }
            $item = [
                'id' => $node->id,
                'parent' => $node->parent_id ? $node->parent_id : '#',
                'text' =>
                            $a .
                            ' <span ' . $class .'>' .
                                $node->numeracion . ' <b>(' . $node->codigo . ')</b> ' . $node->nombre . $status .
                            '</span>',
            ];

            $tree[] = $item;

            if ($node->children) {
                $item['children'] = $this->buildTree($node->children);
            }
        }

        return $tree;
    }

    public function getDatos(Request $request)
    {
        try{
            $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
            return response()->json([
                'partida_presupuestaria' => $partida_presupuestaria,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        $partida_presupuestaria = null;
        if(isset($request->partida_presupuestaria_id)){
            $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
        }

        return view('compras.partidas_prespuestarias.create',compact('partida_presupuestaria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numeracion' => 'required|unique:partidas_presupuestarias,numeracion,null,id,dea_id,' . Auth::user()->dea->id
        ]);
        try{
            $function = DB::transaction(function () use ($request) {
                $array = str_split($request->numeracion);
                $cont = 1;
                $codigo = $array[0];
                while($cont < count($array)){
                    if($array[$cont] != 0){
                        $codigo = $codigo . '.' . $array[$cont];
                    }

                    $cont++;
                }

                $datos = [
                    'dea_id' => Auth::user()->dea->id,
                    'numeracion' => $request->numeracion,
                    'codigo' => $codigo,
                    'parent_id' => isset($request->partida_dependiente_id) ? $request->partida_dependiente_id : null,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'detalle' => isset($request->detalle) ? '1' : '0',
                    'estado' => '1'
                ];

                $partida_presupuestaria = PartidaPresupuestaria::create($datos);

                return $partida_presupuestaria;
            });

            Log::channel('partidas_presupuestarias')->info(
                "Partida Presupuestaria: Creada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('partida.presupuestaria.index',['nodeId' => $function->id])->with('success_message', '[La partida presupuestaria fue creada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('partidas_presupuestarias')->info(
                "Error al crear partida presupuestaria: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear la partida presupuestaria.]')->withInput();
        }
    }

    public function editar(Request $request)
    {
        $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
        $parent_presupuestaria = null;
        $partidas_presupuestarias = null;
        if($partida_presupuestaria->parent_id != null){
            $parent_presupuestaria = PartidaPresupuestaria::find($partida_presupuestaria->parent_id);
            $partidas_presupuestarias = PartidaPresupuestaria::query()
                                            ->byDea(Auth::user()->dea->id)
                                            ->select(DB::raw("concat(numeracion,' (',codigo,') ',nombre) as partida_presupuestaria"),'id')
                                            ->get();


        }

        $hijos = PartidaPresupuestaria::query()
                    ->byDea(Auth::user()->dea->id)
                    ->byHijos($partida_presupuestaria->id)
                    ->get()->count();

        return view('compras.partidas_prespuestarias.editar',compact('partida_presupuestaria','parent_presupuestaria','partidas_presupuestarias','hijos'));
    }

    public function update(Request $request)
    {
        try{
            $function = DB::transaction(function () use ($request) {
                if($request->dependiente_id != null){
                    $array = str_split($request->numeracion);
                    $cont = 1;
                    $codigo = $array[0];
                    while($cont < count($array)){
                        if($array[$cont] != 0){
                            $codigo = $codigo . '.' . $array[$cont];
                        }

                        $cont++;
                    }

                    $dependiente = PartidaPresupuestaria::find($request->dependiente_id);
                }

                $partida_presupuestaria = PartidaPresupuestaria::find($request->partida_presupuestaria_id);
                $partida_presupuestaria->update([
                    'numeracion' => isset($request->numeracion) ? $request->numeracion : $partida_presupuestaria->numeracion,
                    'codigo' => isset($codigo) ? $codigo : $partida_presupuestaria->codigo,
                    'parent_id' => isset($request->dependiente_id) ? $request->dependiente_id : $partida_presupuestaria->parent_id,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'detalle' => isset($request->detalle) ? '1' : '0',
                    'estado' => $request->estado
                ]);

                return $partida_presupuestaria;
            });
            Log::channel('partidas_presupuestarias')->info(
                "Partida Presupuestaria: Modificada con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );
            return redirect()->route('partida.presupuestaria.index',['nodeId' => $function->id])->with('success_message', '[La partida presupuestaria fue modificada correctamente.]');
        } catch (\Exception $e) {
            Log::channel('partidas_presupuestarias')->info(
                "Error al modificar partida presupuestaria: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar la partida presupuestaria.]')->withInput();
        }
    }

    public function excel()
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

                $partidas_presupuestarias = PartidaPresupuestaria::query()
                                            ->ByDea(Auth::user()->dea->id)
                                            ->orderBy('numeracion')
                                            ->get();

            return Excel::download(new PartidaPresupuestariaExcel($partidas_presupuestarias),'clasificadores.xlsx');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message','[Ocurrio un Error]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
