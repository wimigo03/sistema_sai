<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\EmpleadosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\CodcontModel;
use Illuminate\Support\Facades\Auth;

class ResponsableController extends Controller
{

    public function index($id)
    {
        $this->listado($id);
        return view('activo.responsable.index', compact('id'));
    }


    public function listado($id)
    {
        $data =  EmpleadosModel::query()
            ->join('areas as a', 'a.idarea', '=', 'empleados.idarea')
            ->join('file as f', 'f.idfile', '=', 'empleados.idfile')
            ->select('a.nombrearea', 'f.numfile', 'empleados.idemp', 'empleados.nombres', 'empleados.ap_pat', 'empleados.ap_mat', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 'f.niveladm', 'f.clase', 'f.nivelsal', 'empleados.fechingreso', 'empleados.natalicio', 'empleados.edad', 'empleados.ci', 'empleados.poai', 'empleados.exppoai', 'empleados.decjurada', 'empleados.expdecjurada', 'empleados.sippase', 'empleados.expsippase', 'empleados.servmilitar', 'empleados.idioma', 'empleados.induccion', 'empleados.expinduccion', 'empleados.progvacacion', 'empleados.expprogvacacion', 'empleados.vacganadas', 'empleados.vacpendientes', 'empleados.vacusasdas', 'empleados.segsalud', 'empleados.inamovilidad', 'empleados.aservicios', 'empleados.cvitae', 'empleados.telefono', 'empleados.biometrico', 'empleados.gradacademico', 'empleados.rae', 'empleados.regprofesional', 'empleados.evdesempenio', 'empleados.rejap','empleados.estadoemp1')
            ->where('empleados.tipo', 1)
            ->where('empleados.idarea', $id)
            ->get();
           
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btns', function ($data) {
                $btns ='<a href="' . route('activo.responsable.activo.index', $data->idemp) . '" class="tts:left tts-slideIn tts-custom" aria-label="Ver activos">
                            <i class="fa-solid fa-2xl fa-right-to-bracket"></i>
                        </a><a href="' . route('activo.responsable.archivos.index', $data->idemp) . '" class="tts:left tts-slideIn tts-custom ml-3" aria-label="Ver archivos">
                        <i class="fa-solid fa-2xl fa-file-pdf"></i>
                    </a>';
                return $btns;
            })
            ->rawColumns(['btns'])
            ->make(true);
    }

    public function create($id)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('unidad', 'A')->first();
        $codconts = CodcontModel::where('codcont', $id)->first();

        $auxiliar = AuxiliarModel::where('entidad', 4601)
            ->where('unidad', 'A')
            ->where('codcont', $id)
            ->first();
        if ($auxiliar) {
            $codaux = $auxiliar->codaux;
            $newauxiliar = $codaux + 1;
        } else {
            $newauxiliar =  1;
        }
        $usuar = Auth::user()->name;


        return view('activo.auxiliar.create', compact('usuar', 'newauxiliar', 'codconts', 'unidad', 'entidad'));
    }
}
