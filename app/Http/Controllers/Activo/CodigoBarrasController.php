<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\CodigobarraModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\DNS1D;

class CodigoBarrasController extends Controller
{
    public function index()
    {
        $codigosBarras = CodigobarraModel::all();

        return view('activo.codigos_barras.index', [
            'codigosBarras' => $codigosBarras
        ]);
    }
    // Lógica para mostrar la página de índice de códigos de barras

    public function store(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'activos_fijos_id' => 'required',
            'dea' => 'required',
            'codigobarra' => 'required',
        ]);

        // Crea una nueva instancia de Codigobarra
        $codigobarra = new CodigobarraModel();
        $codigobarra->activos_fijos_id = $request->input('activos_fijos_id');
        $codigobarra->dea = $request->input('dea');
        $codigobarra->codigobarra = $request->input('codigobarra');

        // Guarda el código de barras en la base de datos
        $codigobarra->save();

        return response()->json(['message' => 'Código de barras creado correctamente'], 201);
    }

    public function update(Request $request, $id)
    {
        // Valida los datos de entrada
        $request->validate([
            'activos_fijos_id' => 'required',
            'dea' => 'required',
            'codigobarra' => 'required',
        ]);

        // Busca el código de barras por su ID
        $codigobarra = CodigobarraModel::find($id);

        if (!$codigobarra) {
            return response()->json(['message' => 'Código de barras no encontrado'], 404);
        }

        // Actualiza los datos del código de barras
        $codigobarra->activos_fijos_id = $request->input('activos_fijos_id');
        $codigobarra->dea = $request->input('dea');
        $codigobarra->codigobarra = $request->input('codigobarra');

        // Guarda los cambios en la base de datos
        $codigobarra->save();

        return response()->json(['message' => 'Código de barras actualizado correctamente'], 200);
    }

    public function delete($id)
    {
        // Busca el código de barras por su ID
        $codigobarra = CodigobarraModel::find($id);

        if (!$codigobarra) {
            return response()->json(['message' => 'Código de barras no encontrado'], 404);
        }

        // Elimina el código de barras de la base de datos
        $codigobarra->delete();

        return response()->json(['message' => 'Código de barras eliminado correctamente'], 200);
    }

    public function show($id)
    {
        // Busca el código de barras por su ID
        $codigobarra = CodigobarraModel::find($id);

        if (!$codigobarra) {
            return response()->json(['message' => 'Código de barras no encontrado'], 404);
        }

        return response()->json($codigobarra, 200);
    }

    public function buscar($codigo)
    {
        $activo = ActualModel::where('codigo', $codigo)->first();

        if ($activo) {
            return response()->json([
                'codigo' => $activo->codigo,
                'descrip' => $activo->descrip,
            ]);
        } else {
            return response()->json(['message' => 'No se encontró ningún activo con ese código.'], 404);
        }
    }


    public function generar(Request $request)
    {
        // Lógica para generar códigos de barras
    }

    public function imprimirEtiquetas($codigo, $cantidad)
    {
        $activo = ActualModel::where('codigo', $codigo)->first();

        $pdf = Pdf::loadView('activo.pdfs.codigo_barras', [
            'activo' => $activo,
            'cantidad' => $cantidad,
        ]);
        $pdf->setPaper([0, 0, 150, 250], 'landscape');

        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $fecha = date('Y-m-d');
        return $pdf->stream("Reporte de codigo de barras -" . $fecha . "-activo-'. $activo->codigo .'.pdf");
    }

    public function guardarConfiguracion(Request $request)
    {
        // Lógica para guardar configuración
    }
}
