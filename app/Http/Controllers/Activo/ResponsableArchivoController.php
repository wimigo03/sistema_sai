<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArchivoAdjuntoRequest;
use App\Models\Model_Activos\ArchivoAdjunto;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class ResponsableArchivoController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        $empleado = Empleado::find($id);
        return view('activo.responsableArchivo.index', compact('empleado', 'id'));
    }

    public function listado($id)
    {
        $data = DB::table('archivo_adjuntos')
            ->where('empleado_id', $id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.responsableArchivo.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function store(SaveArchivoAdjuntoRequest $request)
    {
        $archivo = new ArchivoAdjunto($request->validated());
        $file = $request->file('ruta');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/archivos'), $filename);
        $archivo->ruta = $filename;
        $archivo->save();

        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo adjunto guardado correctamente',
            'archivo' => $archivo,
        ]);
    }

    public function update(SaveArchivoAdjuntoRequest $request, $id)
    {
        $archivo = ArchivoAdjunto::find($id);

        if (!$archivo) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Archivo adjunto no encontrado',
            ], 404);
        }
        $nombreArchivoAnterior = $archivo->ruta;
        if ($nombreArchivoAnterior) {
            $rutaArchivoAnterior = public_path('public/archivos/' . $nombreArchivoAnterior);
            if (File::exists($rutaArchivoAnterior)) {
                File::delete($rutaArchivoAnterior);
            }
        }
        if ($request->hasFile('ruta')) {
            $archivo->fill($request->validated());
            $file = $request->file('ruta');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/archivos'), $filename);
            $archivo->ruta = $filename;
            $archivo->save();
        } else {
            $archivo->update(array_filter($request->validated()));
        }
        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo adjunto guardado correctamente',
            'archivo' => $archivo,
        ]);
    }
}
