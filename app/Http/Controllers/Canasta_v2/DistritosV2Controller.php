<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Dea;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
//use App\Exportar\BarriosExcel;
use DB;
use PDF;


class DistritosV2Controller extends Controller
{
    public function index(){
        $deas = Dea::pluck('nombre','id');
        $estados = Distrito::ESTADOS;
        $distritos = Distrito::orderBy('id', 'desc')->paginate(10);
        return view('canasta_v2.distrito.index', compact('deas','estados','distritos'));
    }

    public function search(Request $request){
        $tipos_barrio = CanastaBarriosModel::TIPOS_BARRIO;
        $distritos = CanastaBarriosModel::DISTRITOS;
        $estados = CanastaBarriosModel::ESTADOS;
        $barrios = CanastaBarriosModel::query()
                                        ->byCodigo($request->codigo)
                                        ->byNombre($request->nombre)
                                        ->byTipo($request->tipo)
                                        ->byDistrito($request->distrito)
                                        ->byEstado($request->estado)
                                        ->orderBy('idBarrio', 'desc')
                                        ->paginate(10);
        return view('canasta.barrios.index', compact('tipos_barrio','distritos','estados','barrios'));
    }

    public function excel(Request $request){
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $barrios = CanastaBarriosModel::query()
                                        ->byCodigo($request->codigo)
                                        ->byNombre($request->nombre)
                                        ->byTipo($request->tipo)
                                        ->byDistrito($request->distrito)
                                        ->byEstado($request->estado)
                                        ->orderBy('idBarrio', 'desc')
                                        ->get();
            return Excel::download(new BarriosExcel($barrios),'barrios.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
