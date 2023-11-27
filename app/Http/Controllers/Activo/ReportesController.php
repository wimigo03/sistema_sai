<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\ActualModel;
use App\Models\AreasModel;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\EmpleadosModel;
use App\Models\Model_Activos\CodcontModel;
use App\Models\Model_Activos\EntidadesModel;
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
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 200);

        $zipFileName = "INVENTARIO_ORDENADO_POR_CODIGO_DE_ACTIVO_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $dia = $activo["dia"];
                $mes = $activo["mes"];
                $ano = $activo["ano"];
                $fechaInicial = "$ano-$mes-$dia";

                $activo["depreciacion_gestion"] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo["depreciacion"] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo["valor_neto"] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }
            $activosPorPagina = array_chunk($activosLote, 5);

            $totalCostos = $this->calcularSumatoria($activosPorPagina, 'costo');
            $totalDepreciacion = $this->calcularSumatoria($activosPorPagina, 'depreciacion');
            $totalValorNeto = $this->calcularSumatoria($activosPorPagina, 'valor_neto');
            $totalDepreciacionAnual = $this->calcularSumatoria($activosPorPagina, 'depreciacion_gestion');
            $pdf = PDF::loadView('activo.reportes.rep1Pdf', [
                'activosPorPagina' => $activosPorPagina,
                'totalCostos' => $totalCostos,
                'totalDepreciacion' => $totalDepreciacion,
                'totalValorNeto' => $totalValorNeto,
                'totalDepreciacionAnual' => $totalDepreciacionAnual,
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

            $pdfFileName = "INVENTARIO_ORDENADO_POR_CODIGO_DE_ACTIVO_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }
        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 200);

        $zipFileName = "INVENTARIO_ORDENADO_POR_GRUPO_CONTABLE_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {
            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }
            $activosPorPagina = array_chunk($activosLote, 5);

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
            $pdfFileName = "INVENTARIO_ORDENADO_POR_GRUPO_CONTABLE_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }
        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();
        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 200);

        $zipFileName = "INVENTARIO_ORDENADO_POR_GRUPO_Y_AUXILIAR_CONTABLE" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }

            $activosPorPagina = array_chunk($activosLote, 5);

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

            $pdfFileName = "INVENTARIO_ORDENADO_POR_GRUPO_Y_AUXILIAR_CONTABLE -" . date('Y-m-d') . ".pdf";

            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }
        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();
        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 200);
        $zipFileName = "INVENTARIO_ORDENADO_POR_OFICINA_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }

            $activosPorPagina = array_chunk($activosLote, 5);

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

            $fileName = "INVENTARIO ORDENADO POR OFICINA -" . date('Y-m-d') . ".pdf";
            $pdfFileName = "INVENTARIO_ORDENADO_POR_OFICINA_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }
        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->orderBy('codigo')
            ->get()
            ->toArray();
        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 200);

        $zipFileName = "INVENTARIO_ORDENADO_POR_OFICINA_Y_RESPONSABLE_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }

            $activosPorPagina = array_chunk($activosLote, 5);

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

            $pdfFileName = "INVENTARIO_ORDENADO_POR_OFICINA_Y_RESPONSABLE_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }
        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function reporte6Pdf(Request $request)
    {
        $grupos = CodcontModel::query()
            ->with(['actuals' => function ($query) {
                $query->where('entidad', 4601)
                    ->where('unidad', 'A');
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
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');

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

        return $pdf->download($fileName);
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

        $fileName = "DETALLE DE RESPONSABLES POR OFICINA -" . date('Y-m-d') . ".pdf";

        return $pdf->download($fileName);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 3);

        $zipFileName = "REPORTE_TRANSFERENCIA_ACTIVOS_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            $activosPorPagina = array_chunk($activosLote, 3);
            $pdf = PDF::loadView('activo.reportes.rep8Pdf', [
                'activosPorPagina' => $activosPorPagina,
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

            $pdfFileName = "REPORTE_TRANSFERENCIA_ACTIVOS_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function reporte10Pdf(Request $request)
    {
        $unidadSeleccionado = $request->input('unidad');
        $unidad = UnidadadminModel::where('unidad', $unidadSeleccionado)->first();
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $grupo = CodcontModel::where('codcont', $request->input('grupo_id'))->first();
        $activosSeleccionados = json_decode($request->input('activos'), true);
        $idsActivosSeleccionados = [];
        foreach ($activosSeleccionados as $activo) {
            $idsActivosSeleccionados[] = $activo['id'];
        }
        $activos = ActualModel::with(['codconts', 'auxiliars', 'empleados', 'areas'])
            ->where('entidad', 4601)
            ->where('unidad', $unidadSeleccionado)
            ->whereIn('id', $idsActivosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 5);

        $zipFileName = "INVENTARIO_ORDENADO_POR_CODIGO_DE_ACTIVO_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }

            $activosPorPagina = array_chunk($activosLote, 5);

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

            $pdfFileName = "INVENTARIO_ORDENADO_POR_CODIGO_DE_ACTIVO_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        foreach ($activos as &$activo) {
            $vidaUtil = $activo["vidautil"];
            $costoInicial = $activo["costo"];
            $fechaInicial = $activo["feul"];
            $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
            $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
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

        $fileName = "ASIGNACION INDIVIDUAL DE BIENES -" . date('Y-m-d') . ".pdf";

        return $pdf->download($fileName);
    }

    public function reporte15Pdf(Request $request)
    {
        $grupos = CodcontModel::query()
            ->with(['actuals' => function ($query) use ($request) {
                $query->where('entidad', 4601)
                    ->where('unidad', $request->input('unidad'));
            }])
            ->get()
            ->toArray();

        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', $request->input('unidad'))->first();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $gruposPorLote = array_chunk($grupos, 10);

        $zipFileName = "RESUMEN_ACTIVOS_ORDENADO_POR_GRUPO_CONTABLE_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($gruposPorLote as $indice => $gruposLote) {

            foreach ($gruposLote as &$grupo) {
                $grupo['cantidad'] = 0;
                $grupo['costo'] = 0;
                $grupo['depreciacion'] = 0;
                $grupo['valor_neto'] = 0;
                $grupo['depreciacion_gestion'] = 0;

                foreach ($grupo['actuals'] as &$activo) {
                    $vidaUtil = $activo["vidautil"];
                    $costoInicial = $activo["costo"];
                    $fechaInicial = $activo["feul"];
                    $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                    $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                    $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');

                    $grupo['costo'] += $activo['costo'];
                    $grupo['depreciacion'] += $activo['depreciacion'];
                    $grupo['valor_neto'] += $activo['valor_neto'];
                    $grupo['depreciacion_gestion'] += $activo['depreciacion_gestion'];
                    $grupo['cantidad'] += 1;
                }
            }

            $gruposPorPagina = array_chunk($gruposLote, 10);
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

            $pdfFileName = "RESUMEN_ACTIVOS_ORDENADO_POR_GRUPO_CONTABLE_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 9);

        $zipFileName = "ASIGNACION_INDIVIDUAL_DE_BIENES_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }

            $pdf = PDF::loadView('activo.reportes.rep16Pdf', [
                'activosPorPagina' => $activosLote,
                'entidad' => $entidad,
                'unidad' => $unidad,
                'responsable' => $responsable,
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

            $pdfFileName = "ASIGNACION_INDIVIDUAL_DE_BIENES_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 9);

        $zipFileName = "ASIGNACION_INDIVIDUAL_DE_BIENES_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            foreach ($activosLote as &$activo) {
                $vidaUtil = $activo["vidautil"];
                $costoInicial = $activo["costo"];
                $fechaInicial = $activo["feul"];
                $activo['depreciacion_gestion'] = number_format($this->depreciacionAcumuladaGestion($costoInicial, $vidaUtil), 2, '.', '');
                $activo['depreciacion'] = number_format($this->depreciacionAcumulada($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
                $activo['valor_neto'] = number_format($this->valorActual($costoInicial, $vidaUtil, $fechaInicial), 2, '.', '');
            }

            $pdf = PDF::loadView('activo.reportes.rep17Pdf', [
                'activosPorPagina' => $activosLote,
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

            $pdfFileName = "ASIGNACION_INDIVIDUAL_DE_BIENES_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
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
            ->whereIn('id', $activosSeleccionados)
            ->orderBy('codigo')
            ->get()
            ->toArray();

        $tempDir = storage_path('temp_pdfs');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $activosPorLote = array_chunk($activos, 1);

        $zipFileName = "KARDEX_CORRELATIVO_" . date('Y-m-d') . ".zip";
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($activosPorLote as $indice => $activosLote) {

            $pdf = PDF::loadView('activo.reportes.rep18Pdf', [
                'activosPorPagina' => $activosLote,
                'entidad' => $entidad,
                'unidad' => $unidad,
                'grupo' => $grupo,
                'responsable' => $responsable,
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
            $pdf->setPaper('A4', 'portrait');

            $pdfFileName = "KARDEX_CORRELATIVO_Lote_" . ($indice + 1) . ".pdf";
            $pdfFilePath = $tempDir . '/' . $pdfFileName;

            $pdf->save($pdfFilePath);
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    public function calcularSumatoria($activosPorPagina, $campo)
    {
        $sumatoria = array_map(function ($pagina) use ($campo) {
            return array_sum(array_column($pagina, $campo));
        }, $activosPorPagina);

        return $sumatoria;
    }
}
