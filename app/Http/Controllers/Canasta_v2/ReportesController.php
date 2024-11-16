<?php

namespace App\Http\Controllers\Canasta_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use Carbon\Carbon;
use DataTables;
use DB;
use PDF;
use Image;

use App\Models\Canasta\Dea;
use App\Models\Canasta\Beneficiario;
use App\Models\Canasta\HistorialMod;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\Canasta\BeneficiariosPorFechasExcel;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        return view('canasta_v2.reportes.index');
    }

    public function BeneficiariosEntreFechas()
    {
        $estados = Beneficiario::ESTADOS;
        return view('canasta_v2.reportes.beneficiarios-entre-fechas',compact('estados'));
    }

    public function ExportarBeneficiariosEntreFechas(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');

            $beneficiarios = Beneficiario::query()
                            ->join('distritos','beneficiarios.distrito_id','distritos.id')
                            ->join('barrios','beneficiarios.id_barrio','barrios.id')
                            ->byDea(Auth::user()->dea->id)
                            ->byTipoSistema(Beneficiario::TERCERA_EDAD)
                            ->byEntreFechas($request->finicial, $request->ffinal)
                            ->byEstado($request->estado)
                            ->select(
                                'beneficiarios.id as beneficiario_id',
                                'distritos.nombre as distrito',
                                'barrios.nombre as barrio',
                                'beneficiarios.nombres',
                                'beneficiarios.ap as apellido_paterno',
                                'beneficiarios.am as apellido_materno',
                                'beneficiarios.ci as nro_carnet',
                                'beneficiarios.expedido',
                                DB::raw("TO_CHAR(beneficiarios.fecha_nac, 'dd/mm/yyyy') as _fecha_nac"),
                                'beneficiarios.estado_civil',
                                'beneficiarios.sexo',
                                'beneficiarios.firma',
                                'beneficiarios.celular',
                                'beneficiarios.estado',
                                DB::raw("
                                    CASE
                                        WHEN beneficiarios.estado = 'A' THEN 'HABILITADO'
                                        WHEN beneficiarios.estado = 'F' THEN 'FALLECIDO'
                                        WHEN beneficiarios.estado = 'B' THEN 'BAJA'
                                        WHEN beneficiarios.estado = 'X' THEN 'PENDIENTE'
                                        WHEN beneficiarios.estado = 'E' THEN 'ELIMINADO'
                                        ELSE 'DESCONOCIDO'
                                    END as _estado
                                "),
                                DB::raw("
                                    CASE
                                        WHEN beneficiarios.censado = '1' THEN 'NO'
                                        WHEN beneficiarios.censado = '2' THEN 'SI'
                                        ELSE 'DESCONOCIDO'
                                    END as _censado
                                "),
                                DB::raw("TO_CHAR(fecha, 'dd/mm/yyyy') as _fecha"),
                                'observacion',)
                            ->orderBy('fecha', 'desc')
                            ->get();

                return Excel::download(new BeneficiariosPorFechasExcel($beneficiarios),'beneficiarios.xlsx');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message','[Ocurrio un Error]')->withInput();
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function reprocesarUltimo($beneficiarios)
    {
        foreach($beneficiarios as $datos)
        {
            $historial = HistorialMod::create([
                'observacion' => 'REGULARIZACION DE SISTEMA',
                'id_beneficiario' => $datos->beneficiario_id,
                'user_id' => Auth::user()->id,
                'dea_id' => Auth::user()->dea->id,
                'fecha' => date('2018-12-31 00:00:00')
            ]);
        }
        dd("ok terminado");
    }
}
