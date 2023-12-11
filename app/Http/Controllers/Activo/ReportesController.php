<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\AreasModel;
use App\Models\EmpleadosModel;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\Model_Activos\CodcontModel;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Model_Activos\Ufv;
use App\Models\Model_Activos\UnidadadminModel;
use App\Traits\DepreciationCalculations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    use DepreciationCalculations;

    public function index()
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidades = UnidadadminModel::all();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $codcont = CodcontModel::all();
        $areas = AreasModel::all();

        $activos = DB::table('actual')
            ->join('unidadadmin', 'actual.unidad', '=', 'unidadadmin.unidad')
            ->where('unidadadmin.estadouni', 1)
            ->where('actual.entidad', 4601)
            ->get();

        return view('activo.reportes.index', compact('entidad', 'unidad', 'unidades', 'codcont', 'areas', 'activos'));
    }
    public function reporte1Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::query()
            ->with([
                'codconts',
                'auxiliars' => function ($query) {
                    $query->join('codcont', function ($join) {
                        $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                            ->whereRaw('codcont.codcont = auxiliar.codcont');
                    });
                    $query->join('actual', function ($join) {
                        $join->on('actual.codaux', '=', 'auxiliar.codaux')
                            ->whereRaw('actual.codcont = auxiliar.codcont');
                    });
                },
                'areas',
                'empleados'
            ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereIn('id', $activosSeleccionados)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->orderBy('codigo')
            ->get()
            ->toArray();

        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }
        $activosPorPagina = array_chunk($activos, 5);

        $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
        $totalCostoAnt = $this->calcularSumatoria($activosPorPagina, 'costo_ant');
        $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
        $pdf = PDF::loadView('activo.reportes.rep1Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalCostoAnt' => $totalCostoAnt,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'entidad' => $entidad,
            'unidad' => $unidad,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "INVENTARIO ORDENADO POR CODIGO DE ACTIVO -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte2Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $grupo = CodcontModel::where('codcont', $request->input('grupo_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();



        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }
        $activosPorPagina = array_chunk($activos, 5);

        $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
        $pdf = PDF::loadView('activo.reportes.rep2Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'grupo' => $grupo,
        ]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $pdf->setPaper('A4', 'landscape');

        $fileName = "INVENTARIO_ORDENADO_POR_GRUPO_CONTABLE_" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte3Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $grupo = CodcontModel::where('codcont', $request->input('grupo_id'))->first();
        $auxiliar = AuxiliarModel::where('entidad', 4601)->where('unidad', $unidad->unidad)->where('codaux', $request->input('auxiliar_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();


        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }

        $activosPorPagina = array_chunk($activos, 5);

        $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
        $pdf = PDF::loadView('activo.reportes.rep3Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'grupo' => $grupo,
            'auxiliar' => $auxiliar,
        ]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $pdf->setPaper('A4', 'landscape');

        $fileName = "INVENTARIO_ORDENADO_POR_GRUPO_Y_AUXILIAR_CONTABLE-" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte4Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $oficina = AreasModel::where('idarea', $request->input('oficina_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();


        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }

        $activosPorPagina = array_chunk($activos, 5);

        $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
        $pdf = PDF::loadView('activo.reportes.rep4Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'oficina' => $oficina,
        ]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $pdf->setPaper('A4', 'landscape');

        $fileName = "INVENTARIO ORDENADO POR CODIGO DE ACTIVO -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte5Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $oficina = AreasModel::where('idarea', $request->input('oficina_id'))->first();
        $responsable = EmpleadosModel::where('idemp', $request->input('empleado_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereIn('id', $activosSeleccionados)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->orderBy('codigo')
            ->get()
            ->toArray();

        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }

        $activosPorPagina = array_chunk($activos, 5);

        $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
        $pdf = PDF::loadView('activo.reportes.rep5Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'oficina' => $oficina,
            'responsable' => $responsable,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "INVENTARIO_ORDENADO_POR_OFICINA_Y_RESPONSABLE_ -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte6Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $grupos = CodcontModel::query()
            ->with(['actuals' => function ($query) use ($activosSeleccionados, $request) {
                $query->where('entidad', 4601)
                    ->where('unidad', 'A')
                    ->whereIn('id', $activosSeleccionados)
                    ->whereBetween('ano', [$request->anio_ini, $request->anio_fin]);
            }])
            ->get()
            ->toArray();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', $request->input('unidad'))->first();
        foreach ($grupos as &$grupo) {
            $grupo['cantidad'] = 0;
            $grupo['costo'] = 0;
            $grupo['depreciacion'] = 0;
            $grupo['valor_neto'] = 0;
            $grupo['depreciacion_gestion'] = 0;
            foreach ($grupo['actuals'] as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
                if ($activo['ano'] > 2022) {
                    $ufInicial =  Ufv::query()
                        ->orderBy('id', 'DESC')
                        ->first()->indice_ufv;
                } else {
                    $ufInicial = Ufv::query()
                        ->where('dia', $activo["dia"])
                        ->where('mes', $activo["mes"])
                        ->where('ano', $activo["ano"])
                        ->first()->indice_ufv;
                }
                $ufActual = Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
                $grupo['costo'] += $activo['costo'];
                $grupo['depreciacion'] += $activo['depreciacion'];
                $grupo['valor_neto'] += $activo['valor_neto'];
                $grupo['depreciacion_gestion'] += $activo['depreciacion_gestion'];
                $grupo['cantidad'] += 1;
            }
        }

        $gruposPorPagina = array_chunk($grupos, 10);
        $cantidadGrupos = $this->calcularSumatoria($gruposPorPagina, 'cantidad');
        $totalCostos = $this->calcularSumatoria($gruposPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($gruposPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($gruposPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($gruposPorPagina, 'depreciacion_gestion');

        $pdf = PDF::loadView('activo.reportes.rep6Pdf', [
            'activosPorPagina' => $gruposPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'cantidadGrupos' => $cantidadGrupos,
            'entidad' => $entidad,
            'unidad' => $unidad,
        ]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $pdf->setPaper('A4', 'landscape');

        $fileName = "RESUMEN DE ACTIVOS FIJOS ORDENADO POR GRUPO CONTABLE -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte7Pdf(Request $request)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', $request->input('unidad'))->first();
        $responsables = EmpleadosModel::with('file')->where('idemp', $request->input('empleado_id'))->get()->toArray();
        $oficina = AreasModel::where('idarea', $request->input('oficina_id'))->first();
        $activosPorPagina = array_chunk($responsables, 1);
        $pdf = PDF::loadView('activo.reportes.rep7Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'oficina' => $oficina,
        ]);
        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "DETALLE DE RESPONSABLES POR OFICINA -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte8Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas',
            'transferencias',
            'transferencias.empleadoEntrante.empleadosareas',
            'transferencias.empleadoSaliente.empleadosareas',
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $activosPorPagina = array_chunk($activos, 3);
        $pdf = PDF::loadView('activo.reportes.rep8Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'entidad' => $entidad,
            'unidad' => $unidad,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "REPORTE_TRANSFERENCIA_ACTIVOS_ -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte10Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $grupo = CodcontModel::where('codcont', $request->input('grupo_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with(['codconts', 'auxiliars', 'empleados', 'areas'])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }

        $activosPorPagina = array_chunk($activos, 5);

        $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
        $pdf = PDF::loadView('activo.reportes.rep10Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'grupo' => $grupo,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "INVENTARIO_ORDENADO_POR_CODIGO_DE_ACTIVO_" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }


    public function reporte13Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $responsable = EmpleadosModel::where('idemp', $request->input('empleado_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }

        $activosPorPagina = array_chunk($activos, 4);
        $activosPorPaginaCount = array_map('count', $activosPorPagina);
        $totalPorPagina = array_sum($activosPorPaginaCount);

        $pdf = PDF::loadView('activo.reportes.rep13Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'responsable' => $responsable,
            'totalPorPagina' => $totalPorPagina,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "ASIGNACION INDIVIDUAL DE BIENES -" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte15Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $grupos = CodcontModel::query()
            ->with(['actuals' => function ($query) use ($activosSeleccionados, $request) {
                $query->where('entidad', 4601)
                    ->where('unidad', 'A')
                    ->whereIn('id', $activosSeleccionados)
                    ->whereBetween('ano', [$request->anio_ini, $request->anio_fin]);
            }])
            ->get()
            ->toArray();

        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', $request->input('unidad'))->first();

        foreach ($grupos as &$grupo) {
            $grupo['cantidad'] = 0;
            $grupo['costo'] = 0;
            $grupo['depreciacion'] = 0;
            $grupo['valor_neto'] = 0;
            $grupo['depreciacion_gestion'] = 0;

            foreach ($grupo['actuals'] as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
                if ($activo['ano'] > 2022) {
                    $ufInicial =  Ufv::query()
                        ->orderBy('id', 'DESC')
                        ->first()->indice_ufv;
                } else {
                    $ufInicial = Ufv::query()
                        ->where('dia', $activo["dia"])
                        ->where('mes', $activo["mes"])
                        ->where('ano', $activo["ano"])
                        ->first()->indice_ufv;
                }
                $ufActual = Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
                $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
                $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
                $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');

                $grupo['costo'] += $activo['costo'];
                $grupo['depreciacion'] += $activo['depreciacion'];
                $grupo['valor_neto'] += $activo['valor_neto'];
                $grupo['depreciacion_gestion'] += $activo['depreciacion_gestion'];
                $grupo['cantidad'] += 1;
            }
        }

        $gruposPorPagina = array_chunk($grupos, 10);
        $cantidadGrupos = $this->calcularSumatoria($gruposPorPagina, 'cantidad');
        $totalCostos = $this->calcularSumatoria($gruposPorPagina, 'costo');
        $totalDepreciacion = $this->calcularSumatoria($gruposPorPagina, 'depreciacion');
        $totalValorNeto = $this->calcularSumatoria($gruposPorPagina, 'valor_neto');
        $totalDepreciacionAnual = $this->calcularSumatoria($gruposPorPagina, 'depreciacion_gestion');

        $pdf = PDF::loadView('activo.reportes.rep15Pdf', [
            'activosPorPagina' => $gruposPorPagina,
            'totalCostos' => $totalCostos,
            'totalDepreciacion' => $totalDepreciacion,
            'totalValorNeto' => $totalValorNeto,
            'totalDepreciacionAnual' => $totalDepreciacionAnual,
            'cantidadGrupos' => $cantidadGrupos,
            'entidad' => $entidad,
            'unidad' => $unidad,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "RESUMEN_ACTIVOS_ORDENADO_POR_GRUPO_CONTABLE_" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte16Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $responsable = EmpleadosModel::where('idemp', $request->input('empleado_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();
        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }

        $gruposPorPagina = array_chunk($activos, 10);

        $pdf = PDF::loadView('activo.reportes.rep16Pdf', [
            'activosPorPagina' => $gruposPorPagina,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'responsable' => $responsable,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "ASIGNACION_INDIVIDUAL_DE_BIENES_" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte17Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $grupo = CodcontModel::where('codcont', $request->input('grupo_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'codconts',
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
            'empleados',
            'areas'
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = "{$activo['ano']}-{$activo['mes']}-{$activo['dia']}";
            if ($activo['ano'] > 2022) {
                $ufInicial =  Ufv::query()
                    ->orderBy('id', 'DESC')
                    ->first()->indice_ufv;
            } else {
                $ufInicial = Ufv::query()
                    ->where('dia', $activo["dia"])
                    ->where('mes', $activo["mes"])
                    ->where('ano', $activo["ano"])
                    ->first()->indice_ufv;
            }
            $ufActual = Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil, $ufInicial, $ufActual), 2, '.', '');
            $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
            $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial, $ufInicial, $ufActual), 2, '.', '');
        }
        $activosPorPagina = array_chunk($activos, 9);

        $pdf = PDF::loadView('activo.reportes.rep17Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'grupo' => $grupo,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'landscape');

        $fileName = "ASIGNACION_INDIVIDUAL_DE_BIENES_" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }

    public function reporte18Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $grupo = CodcontModel::where('codcont', $request->input('grupo_id'))->first();
        $responsable = EmpleadosModel::where('idemp', $request->input('empleado_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $activos = ActualModel::with([
            'auxiliars' => function ($query) {
                $query->join('codcont', function ($join) {
                    $join->on('auxiliar.codcont', '=', 'codcont.codcont')
                        ->whereRaw('codcont.codcont = auxiliar.codcont');
                });
                $query->join('actual', function ($join) {
                    $join->on('actual.codaux', '=', 'auxiliar.codaux')
                        ->whereRaw('actual.codcont = auxiliar.codcont');
                });
            },
        ])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->where('observaciones', '!=', '')
            ->whereBetween('ano', [$request->anio_ini, $request->anio_fin])
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $activosPorPagina = array_chunk($activos, 9);

        $pdf = PDF::loadView('activo.reportes.rep18Pdf', [
            'activosPorPagina' => $activosPorPagina,
            'entidad' => $entidad,
            'unidad' => $unidad,
            'grupo' => $grupo,
            'responsable' => $responsable,
        ]);

        $this->configureSSLContext($pdf);

        $pdf->setPaper('A4', 'portrait');

        $fileName = "KARDEX_CORRELATIVO_" . date('Y-m-d') . ".pdf";

        return $pdf->stream($fileName);
    }


    // public function calcularSumatoria($activos, $campo)
    // {
    //     $sumas = array_column($activos, $campo);
    //     return array_sum($sumas);
    // }

    public function calcularSumatoria($activosPorPagina, $campo)
    {
        $sumatoria = array_map(function ($pagina) use ($campo) {
            return array_sum(array_column($pagina, $campo));
        }, $activosPorPagina);

        return $sumatoria;
    }

    public function configureSSLContext($pdf)
    {
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ])
        );
    }
}
