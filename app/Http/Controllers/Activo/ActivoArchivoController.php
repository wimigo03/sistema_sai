<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArchivoActivoRequest;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\ArchivoActivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class ActivoArchivoController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        $activo = ActualModel::find($id);
        return view('activo.activoArchivo.index', compact('activo', 'id'));
    }

    public function listado($id)
    {
        $data = DB::table('archivo_activos')
            ->join('users', 'archivo_activos.user_id', '=', 'users.id')
            ->select('archivo_activos.*', 'users.name as user_name')
            ->where('activo_id', $id);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.activoArchivo.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function store(SaveArchivoActivoRequest $request)
    {
        $archivo = new ArchivoActivo($request->validated());
        $archivo->user_id = auth()->id();
        $file = $request->file('ruta');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/archivos'), $filename);
        $archivo->ruta = $filename;
        $archivo->save();

        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo del activo fue guardado correctamente',
            'archivo' => $archivo,
        ]);
    }

    public function update(SaveArchivoActivoRequest $request, $id)
    {
        $archivo = ArchivoActivo::find($id);
        if (!$archivo) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Archivo adjunto no encontrado',
            ], 404);
        }
        $archivo->user_id = auth()->id();
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
