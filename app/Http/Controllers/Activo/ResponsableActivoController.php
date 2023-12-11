<?php

namespace App\Http\Controllers\Activo;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateActivoResponsableRequest;
use App\Models\ActualModel as ModelsActualModel;
use App\Models\Model_Activos\ActualModel;
use App\Models\AreasModel;
use App\Models\EmpleadosModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\Transferencia;
use Svg\Tag\Rect;

class ResponsableActivoController extends Controller
{
    public function index($id)
    {
        $this->listado($id);
        $areas = AreasModel::all();
        $empleado = EmpleadosModel::find($id);
        return view('activo.responsableActivo.index', compact('areas', 'id', 'empleado'));
    }


    public function listado($id)
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $data = ActualModel::query()
            ->with(['codconts', 'auxiliars', 'empleados.file', 'empleados', 'areas'])
            ->where('entidad', 4601)
            ->where('unidad', $unidad->unidad)
            ->where('codemp', $id)
            ->orderBy('id', 'desc');
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.gestionactivo.btn')
            ->addColumn('estado_texto', function (ActualModel $activo) {
                if ($activo->codestado == 1) {
                    return 'Bueno';
                } elseif ($activo->codestado == 2) {
                    return 'Regular';
                } elseif ($activo->codestado == 3) {
                    return 'Malo';
                } else {
                    return 'Desconocido';
                }
            })
            ->addColumn('codconts', function (ActualModel $activo) {
                return optional($activo->codconts)->nombre;
            })
            ->addColumn('auxiliars', function (ActualModel $activo) use ($unidad) {
                $auxiliar = DB::table('auxiliar')
                ->select('nomaux')
                ->where('codcont', $activo->codcont)
                ->where('codaux', $activo->codaux)
                ->where('unidad', $unidad->unidad)
                ->first();
                return optional($auxiliar)->nomaux;
            })
            ->addColumn('areas', function (ActualModel $activo) {
                return optional($activo->areas)->nombrearea;
            })
            ->addColumn('cargo', function (ActualModel $activo) {
                return optional($activo->empleados)->file ? $activo->empleados->file->nombrecargo : null;
            })
            ->addColumn('empleados', function (ActualModel $activo) {
                return optional($activo->empleados)->full_name;
            })
            ->rawColumns(['btn', 'auxiliars', 'empleados', 'cargo', 'codconts', 'areas'])
            ->make(true);
    }

    public function update(UpdateActivoResponsableRequest $request)
    {
        $empleado = $request->input('emp_id');
        $oficina = $request->input('oficina_id');
        try {
            DB::transaction(function () use ($request, $empleado, $oficina) {
                $activos = $request->input('activos');
                $empleadoOrigen = $request->input('empleadoOrigen');

                foreach ($activos as $activo) {
                    DB::table('actual')
                        ->where('id', $activo['id'])
                        ->update([
                            'codarea' => $oficina,
                            'codemp' => $empleado
                        ]);
                    Transferencia::create([
                        'activo_id' => $activo['id'],
                        'empleado_origen_id' => $empleadoOrigen,
                        'empleado_destino_id' => $empleado,
                    ]);
                }
            });

            return redirect()->route('activo.responsable.activo.index', ['id' => $empleado]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error en la transferencia: ' . $e->getMessage());
        }
    }
}
