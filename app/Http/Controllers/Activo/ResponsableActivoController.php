<?php

namespace App\Http\Controllers\Activo;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateActivoResponsableRequest;
use App\Models\ActualModel as ModelsActualModel;
use App\Models\Model_Activos\ActualModel;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\Transferencia;
use Svg\Tag\Rect;

class ResponsableActivoController extends Controller
{
    public function index($id)
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $empleado = Empleado::find($id);
        $areas = Area::all();
        $activos = ActualModel::orderBy('id', 'desc')
        ->with([
            'codconts',
            'ambiente'
        ])
        ->where('unidad', $unidad->unidad)
        ->where('codemp', $id)
        ->get();

        foreach ($activos as $activo) {
            $activo->load(['auxiliar' => function ($query) use ($activo) {
                $query->where('codcont', $activo->codcont)
                      ->where('codaux', $activo->codaux);
            }]);
        }

        return view('activo.responsableActivo.index', compact('unidad', 'activos','empleado','areas'));
    }

    public function search(Request $request, $id)
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $empleado = Empleado::find($id);
        $areas = Area::all();
        $auxiliar = null;
       if ($request->has('auxiliar') && !empty($request->auxiliar)) {
           $auxiliar = AuxiliarModel::query()
               ->where('unidad', $unidad->unidad)
               ->where('nomaux', 'like', strtoupper($request->auxiliar) . '%')
               ->first();
       }
        $activos = ActualModel::query()
        ->with([
            'codconts',
            'ambiente'
        ])
        ->byCodigo($request->codigo)
        ->byCi($request->ci)
        ->byIdBien($request->id_bien)
        ->byEstado($request->estado)
        ->byAmbiente($request->ambiente)
        ->byGrupo(strtoupper($request->grupo))
        ->byAuxiliar($auxiliar)
        ->byKardex($request->kardex)
        ->byPreventivo($request->cod_rube)
        ->where('unidad', $unidad->unidad)
        ->where('codemp', $id)
        ->orderBy('id', 'desc')
        ->get();

        foreach ($activos as $activo) {
            $activo->load(['auxiliar' => function ($query) use ($activo, $unidad) {
                $query->where('codcont', $activo->codcont)
                        ->where('codaux', $activo->codaux)
                      ->where('unidad', $unidad->unidad);
            }]);
        }

        return view('activo.responsableActivo.index', compact('activos', 'unidad','empleado','areas'));
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
            ->addColumn('btn', 'activo.responsableActivo.btn')
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
