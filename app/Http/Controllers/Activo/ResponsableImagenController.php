<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveImagenActivoRequest;
use App\Models\Model_Activos\ActualModel;
use App\Models\EmpleadosModel;
use App\Models\Model_Activos\ImagenActivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;

class ResponsableImagenController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        $activo = ActualModel::find($id);
        return view('activo.responsableImagen.index', compact('activo', 'id'));
    }

    public function listado($id)
    {
        $data = DB::table('imagen_activos')
            ->join('users', 'imagen_activos.user_id', '=', 'users.id')
            ->select('imagen_activos.*', 'users.name as user_name')
            ->where('activo_id', $id);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.responsableImagen.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function store(SaveImagenActivoRequest $request)
    {
        $imagen = new ImagenActivo($request->validated());
        $imagen->user_id = auth()->id();
        $file = $request->file('ruta');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/imagenes'), $filename);
        $imagen->ruta = $filename;
        $imagen->save();

        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo adjunto guardado correctamente',
            'imagen' => $imagen,
        ]);
    }

    public function update(SaveImagenActivoRequest $request, $id)
    {
        $imagen = ImagenActivo::find($id);

        if (!$imagen) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Archivo adjunto no encontrado',
            ], 404);
        }
        $nombreArchivoAnterior = $imagen->ruta;
        if ($nombreArchivoAnterior) {
            $rutaArchivoAnterior = public_path('public/imagens/' . $nombreArchivoAnterior);
            if (File::exists($rutaArchivoAnterior)) {
                File::delete($rutaArchivoAnterior);
            }
        }
        if ($request->hasFile('ruta')) {
            $imagen->fill($request->validated());
            $file = $request->file('ruta');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/imagens'), $filename);
            $imagen->ruta = $filename;
            $imagen->save();
        } else {
            $imagen->update(array_filter($request->validated()));
        }
        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo adjunto guardado correctamente',
            'imagen' => $imagen,
        ]);
    }
}
