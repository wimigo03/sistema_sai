<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\ActualModel;
use App\Models\Area;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\Empleado;
use App\Models\Model_Activos\CodcontModel;
use Illuminate\Http\Request;

class FiltrosController extends Controller
{
    protected $unidad;

    protected $grupo_id;
    protected $auxiliar_id;
    protected $oficina_id;
    protected $empleado_id;

    protected $grupos;
    protected $auxiliares;
    protected $oficinas;
    protected $empleados;
    protected $activos;

    public function __construct(Request $request)
    {
        $this->unidad = $request->input('unidad');
        $this->grupo_id = $request->input('grupo_id');
        $this->auxiliar_id = $request->input('auxiliar_id');
        $this->oficina_id = $request->input('oficina_id');
        $this->empleado_id = $request->input('empleado_id');

        $this->grupos = CodcontModel::query();
        $this->auxiliares = AuxiliarModel::query()
            ->where('entidad', 4601)
            ->where('unidad', $this->unidad);
        $this->oficinas = Area::query();
        $this->empleados = Empleado::query();
        $this->activos = ActualModel::query()
            ->where('unidad', $this->unidad)
            ->where('entidad', 4601);
    }
    public function filtroUnidad()
    {
        return response()->json([
            'activos' => $this->activos->get(),
            'grupos' => $this->grupos->get(),
            'oficinas' => $this->oficinas->get(),
        ]);
    }
    public function filtroTodos()
    {
        // Filtrar activos por grupo, auxiliar, oficina y empleado seleccionados
        $this->activos->where(function ($query) {
            if (isset($this->grupo_id)) {
                $query->where('codcont', $this->grupo_id);
            }
            if (isset($this->auxiliar_id)) {
                $query->where('codaux', $this->auxiliar_id);
            }
            if (isset($this->oficina_id)) {
                $query->where('codarea', $this->oficina_id);
            }
            if (isset($this->empleado_id)) {
                $query->where('codemp', $this->empleado_id);
            }
        });
        $this->grupos->where(function ($query) {
            if (isset($this->oficina_id)) {
                $query->whereIn('codcont', function ($q) {
                    $q->select('codcont')
                        ->from('actual')
                        ->where('codarea', $this->oficina_id);
                });
            }
            if (isset($this->auxiliar_id)) {
                $query->whereIn('codcont', function ($q) {
                    $q->select('codcont')
                        ->from('actual')
                        ->where('codaux', $this->auxiliar_id);
                });
            }
            if (isset($this->empleado_id)) {
                $query->whereIn('codcont', function ($q) {
                    $q->select('codcont')
                        ->from('actual')
                        ->where('codemp', $this->empleado_id);
                });
            }
        });
        // Filtrar auxiliares por grupo, oficina y empleado seleccionados
        $this->auxiliares->where(function ($query) {
            if (isset($this->grupo_id)) {
                $query->where('codcont', $this->grupo_id);
                $query->whereIn('codaux', function ($q) {
                    $q->select('codaux')
                        ->from('actual')
                        ->where('codcont', $this->grupo_id)
                        ->where('codcont', $this->grupo_id);
                });
            }
            if (isset($this->oficina_id)) {
                $query->whereIn('codaux', function ($q) {
                    $q->select('codaux')
                        ->from('actual')
                        ->where('codarea', $this->oficina_id);
                });
            }
            if (isset($this->empleado_id)) {
                $query->whereIn('codaux', function ($q) {
                    $q->select('codaux')
                        ->from('actual')
                        ->where('codemp', $this->empleado_id);
                });
            }
        });


        // Filtrar oficinas por grupo seleccionado
        $this->oficinas->where(function ($query) {
            if (isset($this->grupo_id)) {
                $query->whereIn('idarea', function ($q) {
                    $q->select('codarea')
                        ->from('actual')
                        ->where('codcont', $this->grupo_id);
                });
            }
            if (isset($this->auxiliar_id)) {
                $query->whereIn('idarea', function ($q) {
                    $q->select('codarea')
                        ->from('actual')
                        ->where('codaux', $this->auxiliar_id);
                });
            }
            if (isset($this->empleado_id)) {
                $query->whereIn('idarea', function ($q) {
                    $q->select('codarea')
                        ->from('actual')
                        ->where('codemp', $this->empleado_id);
                });
            }
        });

        // Filtrar empleados por oficina seleccionada
        $this->empleados->where(function ($query) {
            if (isset($this->grupo_id)) {
                $query->whereIn('idemp', function ($q) {
                    $q->select('codemp')
                        ->from('actual')
                        ->where('codcont', $this->grupo_id);
                });
            }
            if (isset($this->auxiliar_id)) {
                $query->whereIn('idemp', function ($q) {
                    $q->select('codemp')
                        ->from('actual')
                        ->where('codaux', $this->auxiliar_id);
                });
            }
            if (isset($this->oficina_id)) {
                $query->where('idarea', $this->oficina_id)
                    ->whereIn('idemp', function ($q) {
                        $q->select('codemp')
                            ->from('actual')
                            ->where('codarea', $this->oficina_id);
                    });
            }
        });
        // Obtener los resultados
        $result = [
            'activos' => $this->activos->get(),
            'auxiliares' => $this->auxiliares->get(),
            'oficinas' => $this->oficinas->get(),
            'empleados' => $this->empleados->get(),
            'grupos' => $this->grupos->get(),
        ];
        return response()->json($result);
    }
}
