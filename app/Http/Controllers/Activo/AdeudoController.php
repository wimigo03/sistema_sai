<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAdeudoRequest;
use App\Models\ActualModel;
use App\Models\EmpleadosModel;
use App\Models\Model_Activos\Adeudo;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Model_Activos\UnidadadminModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AdeudoController extends Controller
{
  public function index()
  {
      $unidad = UnidadadminModel::where('estadouni', 1)->first();
      $adeudos = Adeudo::orderBy('id', 'desc')
          ->with('empleado','empleado.file','empleado.empleadosareas')
          ->paginate(10);

      return view('activo.adeudo.index', compact('unidad', 'adeudos'));
  }


    public function search(Request $request)
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $adeudos = Adeudo::query()
            ->with('empleado','empleado.file','empleado.empleadosareas')
            ->byCi($request->ci)
            ->byNombre(strtoupper($request->nombre))
            ->byApPaterno(strtoupper($request->ap_pat))
            ->byApMaterno(strtoupper($request->ap_mat))
            ->byOficina(strtoupper($request->oficina))
            ->byCargo(strtoupper($request->cargo))
            ->orderBy('id', 'desc')
            ->paginate(10);

            $adeudos->appends($request->except('page'));
        return view('activo.adeudo.index', compact('adeudos', 'unidad'));
    }

    public function listado()
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $data = Adeudo::query()
            ->with('empleado','empleado.file')
            ->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('btn', 'activo.adeudo.btn')
            ->addColumn('nombre_empleado', function (Adeudo $adeudo) {
                return optional($adeudo->empleado)->full_name;
            })
            ->addColumn('cargo', function (Adeudo $adeudo) {
                return optional($adeudo->empleado)->file->nombrecargo;
            })
            ->rawColumns(['btn','nombre_empleado','cargo'])
            ->make(true);
    }

    public function getCi(Request $request)
    {
        $empleado = EmpleadosModel::with(['file'])
            ->withCount('actuals')
            ->where('ci', $request->input('ci'))
            ->first();
        return response()->json([
            'response' => $empleado,
            'count_actuals' => $empleado->actuals_count
        ]);
    }


    public function create()
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        return view('activo.adeudo.create', compact('entidad', 'unidad'));
    }

    public function store(SaveAdeudoRequest $request)
    {
        $adeudo = (new Adeudo)->fill($request->all());
        if($request->hasFile('respaldo'))
        {
          $adeudo->respaldo = $this->guardarDocumento($request, 'respaldo', 'public/respaldos');
        }
        $adeudo->save();
        return redirect()->route('activo.adeudo.index');
    }

    public function editar($id)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $adeudo = Adeudo::find($id);
        return view('activo.adeudo.edit', compact('entidad', 'unidad','adeudo'));
    }

    public function update($id, SaveAdeudoRequest $request)
    {
      $adeudo = (new Adeudo)->fill($request->all());
      if($request->hasFile('respaldo'))
      {
        $adeudo->respaldo = $this->guardarDocumento($request, 'respaldo', 'public/respaldos');
      }
      $adeudo->save();
      return redirect()->route('activo.adeudo.index');
    }

    public function show($id)
    {
        $adeudo = Adeudo::with('empleado')->find($id);
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();

        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $dias = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
        $fecha = Carbon::parse($adeudo->created_at);
        $dia_semana = $dias[$fecha->dayOfWeek];
        $mes = $meses[($fecha->format('n')) - 1];
        $fecha_creacion = ucfirst($dia_semana) . ' ' . $fecha->format('d') . ' de ' . $mes . ' del ' . $fecha->format('Y') . ' Hora: ' . $fecha->format('H:i:s');

        return view('activo.adeudo.show', compact('entidad', 'unidad', 'adeudo', 'fecha_creacion'));
    }

    public function guardarDocumento($request, $nombreCampo, $ruta)
    {
        $file = $request->file($nombreCampo);
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path($ruta), $filename);
        return $filename;
    }
}
