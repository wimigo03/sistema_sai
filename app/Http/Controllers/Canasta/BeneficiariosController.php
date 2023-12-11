<?php

namespace App\Http\Controllers\Canasta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CanastaBarriosModel;
use App\Models\CanastaBeneficiariosModel;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\BeneficiariosExcel;
use App\Models\CanastaHistorialBajaModel;
use App\Models\CanastaHistorialModModel;
use App\Http\Requests;
use DB;
use PDF;


class BeneficiariosController extends Controller
{
    public function index(){
        $expediciones = CanastaBeneficiariosModel::EXPEDICIONES;
        $distritos = CanastaBarriosModel::DISTRITOS;
        $barrios = CanastaBarriosModel::select('idBarrio','barrio')->pluck('barrio','idBarrio');
        $estados = CanastaBeneficiariosModel::ESTADOS;
        $sexos = CanastaBeneficiariosModel::SEXOS;
        $beneficiarios = CanastaBeneficiariosModel::query()
                                        ->orderBy('idUsuario', 'desc')
                                        ->paginate(10);
        return view('canasta.beneficiarios.index', compact('expediciones','distritos','barrios','estados','sexos','beneficiarios'));
    }

    public function search(Request $request){
        $expediciones = CanastaBeneficiariosModel::EXPEDICIONES;
        $distritos = CanastaBarriosModel::DISTRITOS;
        $barrios = CanastaBarriosModel::select('idBarrio','barrio')->pluck('barrio','idBarrio');
        $estados = CanastaBeneficiariosModel::ESTADOS;
        $sexos = CanastaBeneficiariosModel::SEXOS;
        $beneficiarios = CanastaBeneficiariosModel::query()
                                        ->byCodigo($request->codigo)
                                        ->byNombres($request->nombres)
                                        ->byAp($request->ap)
                                        ->byAm($request->am)
                                        ->byNroCarnet($request->nro_carnet)
                                        ->byExpedicion($request->expedido)
                                        ->byNatalicio($request->natalicio)
                                        ->bySexo($request->sexo)
                                        ->bydistrito($request->distrito)
                                        ->bybarrio($request->barrio)
                                        ->byEstado($request->estado)
                                        ->orderBy('idUsuario', 'desc')
                                        ->paginate(10);
        return view('canasta.beneficiarios.index', compact('expediciones','distritos','barrios','estados','sexos','beneficiarios'));
    }

    public function excel(Request $request){
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $beneficiarios = CanastaBeneficiariosModel::query()
                                        ->byCodigo($request->codigo)
                                        ->byNombres($request->nombres)
                                        ->byAp($request->ap)
                                        ->byAm($request->am)
                                        ->byNroCarnet($request->nro_carnet)
                                        ->byExpedicion($request->expedido)
                                        ->byNatalicio($request->natalicio)
                                        ->bySexo($request->sexo)
                                        ->bydistrito($request->distrito)
                                        ->bybarrio($request->barrio)
                                        ->byEstado($request->estado)
                                        ->orderBy('idUsuario', 'desc')
                                        ->get();
            return Excel::download(new BeneficiariosExcel($beneficiarios),'beneficiarios.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function show($usuario_id){
        $beneficiario = CanastaBeneficiariosModel::where('idUsuario',$usuario_id)->first();
        $historial_bajas = CanastaHistorialBajaModel::where('idUsuario',$usuario_id)->get();
        $historial_mod = CanastaHistorialModModel::where('idUsuario',$usuario_id)->get();
        return view('canasta.beneficiarios.show', compact('beneficiario','historial_bajas','historial_mod'));
    }

    public function show_pdf($usuario_id){
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
            $beneficiario = CanastaBeneficiariosModel::where('idUsuario',$usuario_id)->first();
            $historial_bajas = CanastaHistorialBajaModel::where('idUsuario',$usuario_id)->get();
            $historial_mod = CanastaHistorialModModel::where('idUsuario',$usuario_id)->get();
            $pdf = PDF::loadView('canasta.beneficiarios.partials.show-pdf', compact('beneficiario','historial_bajas','historial_mod'));
            $pdf->setPaper('LETTER', 'portrait');
            return $pdf->stream();
        } catch (\Throwable $th){
            return '[ERROR_500]';
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
