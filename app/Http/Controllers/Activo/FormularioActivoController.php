<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_Activos\FormularioActivo;
use Yajra\DataTables\DataTables;
use App\Http\Requests\SaveFormularioActivoRequest;
use Illuminate\Http\JsonResponse;

class FormularioActivoController extends Controller
{
    public function listado($id)
    {
        $data = FormularioActivo::with(['activo'])
        ->where('formulario_id', $id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('codigo', function (FormularioActivo $formularioActivo) {
                return optional($formularioActivo->activo)->codigo;
            })
            ->addColumn('descrip', function (FormularioActivo $formularioActivo) {
                return optional($formularioActivo->activo)->descrip;
            })
            ->addColumn('estado', function (FormularioActivo $formularioActivo) {
                if ($formularioActivo->activo->codestado == 1) {
                    return 'Bueno';
                } elseif ($formularioActivo->activo->codestado == 2) {
                    return 'Regular';
                } elseif ($formularioActivo->activo->codestado == 3) {
                    return 'Malo';
                } else {
                    return '';
                }
            })
            ->addColumn('btn_activos', 'activo.formulario.btn_activos')
            ->rawColumns(['btn_activos','codigo','descrip','estado'])
            ->make(true);
    }

    public function store(SaveFormularioActivoRequest $request)
    {
        $activo = FormularioActivo::create($request->validated());
        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo del activo fue guardado correctamente',
            'activo' => $activo,
        ]);
    }

    public function update(SaveFormularioActivoRequest $request, $id)
    {
        $formularioActivo = FormularioActivo::find($id);
        $formularioActivo->update($request->validated());

        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo del activo fue actualizado correctamente',
            'formularioActivo' => $formularioActivo,
        ]);
    }

    public function destroy($id)
    {

        $formularioActivo = FormularioActivo::find($id);
        $formularioActivo->delete();
        return new JsonResponse([
            'success' => true,
            'message' => 'Archivo del activo fue eliminado correctamente',
        ]);
    }
}
