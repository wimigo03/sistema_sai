<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListRequest;
use App\Http\Requests\UpdateCheckListRequest;
use App\Models\Model_Activos\ArchivoVehiculo;
use App\Models\Model_Activos\CheckList;
use App\Models\Model_Activos\Vehiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CheckListController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        $activo = Vehiculo::find($id);
        return view('activo.checklist.index', compact('activo', 'id'));
    }

    public function listado($id)
    {
        $data = DB::table('check_lists')
            ->join('users', 'check_lists.user_id', '=', 'users.id')
            ->select('check_lists.*', 'users.name as user_name')
            ->where('vehiculo_id', $id);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.checklist.btn')
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function store(StoreCheckListRequest $request)
    {
        $archivo = new CheckList($request->validated());
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

    public function update(StoreCheckListRequest $request, $id)
    {
        $archivo = CheckList::find($id);
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
