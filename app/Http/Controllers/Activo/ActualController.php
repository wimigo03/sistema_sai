<?php

namespace App\Http\Controllers\Activo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualStoreRequest;
use App\Http\Requests\ActualUpdateRequest;
use App\Models\Ambiente;
use App\Models\AreasModel;
use App\Models\Model_Activos\UnidadadminModel;
use App\Models\Model_Activos\CodcontModel;
use App\Models\EmpleadosModel;
use App\Models\Model_Activos\ActualModel;
use App\Models\Model_Activos\AuxiliarModel;
use App\Models\Model_Activos\EntidadesModel;
use App\Models\Model_Activos\ImagenActivo;
use App\Models\Model_Activos\OrganismofinModel;
use App\Models\Model_Activos\UbicacionactivoModel;
use App\Models\Model_Activos\Ufv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ActualController extends Controller
{
    public function index()
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $activos = ActualModel::orderBy('id', 'desc')
            ->with([
                'codconts',
                'areas',
                'empleados',
                'empleados.file'
            ])
            ->where('unidad', $unidad->unidad)
            ->paginate(10);
            foreach ($activos as $activo) {
                $activo->load(['auxiliars' => function ($query) use ($activo) {
                    $query->where('codcont', $activo->codcont)
                          ->where('codaux', $activo->codaux);
                }]);
            }
        return view('activo.gestionactivo.index', compact('unidad', 'activos'));
    }

    public function search(Request $request)
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
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
            'areas',
            'empleados',
            'ambiente'
        ])
        ->byCodigo($request->codigo)
        ->byCi($request->ci)
        ->byIdBien($request->id_bien)
        ->byEstado($request->estado)
        ->byAmbiente($request->ambiente)
        ->byNombre(strtoupper($request->nombre))
        ->byApPaterno(strtoupper($request->ap_pat))
        ->byApMaterno(strtoupper($request->ap_mat))
        ->byGrupo(strtoupper($request->grupo))
        ->byAuxiliar($auxiliar)
        ->byOficina(strtoupper($request->oficina))
        ->byPreventivo($request->cod_rube)
        ->where('unidad', $unidad->unidad)
        ->orderBy('id', 'desc')
        ->paginate(10);

        foreach ($activos as $activo) {
            $activo->load(['auxiliar' => function ($query) use ($activo, $unidad) {
                $query->where('codcont', $activo->codcont)
                        ->where('codaux', $activo->codaux)
                      ->where('unidad', $unidad->unidad);
            }]);
        }

        $activos->appends($request->except('page'));
        return view('activo.gestionactivo.index', compact('activos', 'unidad'));
    }

    public function listado()
    {
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $data = ActualModel::query()
            ->with(['codconts', 'auxiliars', 'empleados.file', 'empleados', 'areas'])
            ->where('entidad', 4601)
            ->where('unidad', $unidad->unidad)
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

    public function create()
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $organismofins = OrganismofinModel::all();
        $codcont = CodcontModel::all();
        $auxiliars  = [];
        $areas = AreasModel::all();
        $ambientes = Ambiente::where('unidad', $unidad->unidad)->get();
        $empleados  = [];
        // $organismofins = OrganismofinModel::all();

        return view('activo.gestionactivo.create', compact('organismofins', 'ambientes', 'auxiliars', 'entidad', 'unidad', 'codcont', 'empleados', 'areas'));
    }

    public function getAuxiliar(Request $request)
    {
        $codigo = $request->input('codigo');
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $auxiliars = DB::table('auxiliar')
            ->where('entidad', 4601)
            ->where('unidad', $unidad->unidad)
            ->where('codcont', $codigo)
            ->get();
        $grupo = CodcontModel::where('codcont', $codigo)->first();
        return response()->json([
            'auxiliars' => $auxiliars,
            'vidaUtil' => $grupo ? $grupo->vidautil : '',
        ]);
    }

    public function getLastAuxiliar(Request $request)
    {
        $codigoGrupo = $request->input('codigoGrupo');
        $codigoAux = $request->input('codigoAux');
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $lastActual = DB::table('actual')
            ->where('entidad', '=', 4601)
            ->where('unidad', $unidad->unidad)
            ->where('codcont', $codigoGrupo)
            ->where('codaux', $codigoAux)
            ->orderBy('id', 'desc')
            ->first();
        $cantidad_auxiliar = DB::table('actual')
            ->where('entidad', '=', 4601)
            ->where('unidad', $unidad->unidad)
            ->where('codcont', $codigoGrupo)
            ->where('idaux', $codigoAux)
            ->count();
        return response()->json([
            'lastActual' => $lastActual,
            'cantidad_auxiliar' => $cantidad_auxiliar
        ]);
    }

    public function getResponsables(Request $request)
    {
        $area = $request->input('area_id');
        $emp = $request->input('emp_id');
        $query = EmpleadosModel::where('idarea', $area);
        if ($emp !== null) {
            $query->where('idemp', '!=', $emp);
        }
        $empleados = $query->get();


        return response()->json([
            'empleados' => $empleados,
        ]);
    }

    public function getCargo(Request $request)
    {
        $id = $request->input('emp_id');
        $empleado = EmpleadosModel::find($id);
        $file = DB::table('empleados')->where('idemp', $id)->select('idfile')->first();

        $files = DB::table('file')->where('idfile', $file->idfile)->get();
        $activos = ActualModel::where([
            ['idemp', '=', $id]
        ])->get();
        return response()->json([
            'empleado' => $empleado,
            'files' => $files,
            'activos' => $activos
        ]);
    }

    public function store(ActualStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $actual = new ActualModel();
            $fechaActual = now();

            $actual->dia = $fechaActual->format('d');
            $actual->mes = $fechaActual->format('m');
            $actual->ano = $fechaActual->format('Y');
            $actual->estadoactual = 1;
            $actual->idunidadadmin = $request->input('idunidadadmin');
            $actual->unidad = $request->input('unidad');

            $actual->identidades = $request->input('identidades');
            $actual->entidad = $request->input('entidad');

            $actual->codcont = $request->input('codcont');

            $actual->codaux = $request->input('codaux');


            $actual->codarea = $request->input('codarea');
            $actual->codemp = $request->input('codemp');
            $actual->org_fin = $request->input('org_fin');
            $actual->codigo = $request->input('codigo');
            $actual->ambiente_id = $request->input('ambiente_id');
            $actual->vidautil = $request->input('vidautil');
            $actual->descrip = $request->input('descrip');
            $actual->costo = $request->input('costo');
            $actual->depacu = $request->input('depacu');
            $actual->mes = $request->input('mes');
            $actual->observaciones = $request->input('observaciones');
            // $actual->ano = $request->input('ano');
            // $actual->b_rev = $request->input('b_rev');
            $actual->dia = $request->input('dia');





            // $actual->dia_ant = $request->input('dia_ant');
            // $actual->mes_ant = $request->input('mes_ant');
            // $actual->ano_ant = $request->input('ano_ant');
            // $actual->vut_ant = $request->input('vul_ant');
            // $actual->costo_ant = $request->input('costo_ant');
            // $actual->band_ufv = $request->input('band_ufv');
            // $actual->codestado = $request->input('codestado');
            $actual->cod_rube = $request->input('cod_rube');
            // $actual->nro_conv = $request->input('nro_conv');
            //  $actual->org_fin = $request->input('org_fin');
            $actual->feul = $request->input('feul');
            $actual->usuar = auth()->user()->name;
            // $actual->codigosec = $request->input('codigosec');
            //  $actual->banderas = $request->input('banderas');
            $actual->depacu = 0;
            $actual->b_rev = 0;
            $actual->dia_ant = 0;
            $actual->mes_ant = 0;
            $actual->ano_ant = 0;
            $actual->vut_ant = 0;
            $actual->costo_ant = 0;
            $actual->band_ufv = 0;
            $actual->codestado = $request->input('codestado');
            $actual->codigosec = 0;
            $actual->banderas = 0;
            if (!is_numeric($actual->ambiente_id)) {
                $ambiente = Ambiente::create([
                    'unidad' => $actual->unidad,
                    'nombre' => $actual->ambiente_id
                ]);
                $actual->ambiente_id = $ambiente->id;
            }

            $actual->save();
            if ($request->file('fotografia')) {
                $file = $request->file('fotografia');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('public/images'), $filename);

                ImagenActivo::create([
                    'activo_id' => $actual->id,
                    'user_id' => auth()->id(),
                    'descripcion' > 'imagen-fotograf=ia',
                    'ruta' => $filename
                ]);
            }

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $index => $file) {
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('public/images'), $filename);
                    ImagenActivo::create([
                        'activo_id' => $actual->id,
                        'user_id' => auth()->id(),
                        'descripcion' => 'imagen-' . $index,
                        'ruta' => $filename
                    ]);
                }
            }

            UbicacionactivoModel::create([
                'activo_id' => $actual->id,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'user_id' => auth()->id(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar los datos.');
        }
        return redirect()->route('activo.gestionactivo.index');
    }

    public function show($id)
    {
        $actual = ActualModel::with(['codconts', 'auxiliars', 'unidadadmin', 'entidades', 'empleados.file', 'organismofins', 'ubicaciones'])->find($id);
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $auxiliar = AuxiliarModel::where('codcont', $actual->codcont)
            ->where('codaux', $actual->codaux)
            ->where('unidad', $unidad->unidad)
            ->first();
            if($actual->ano > 2022){
                $ufInicial =  Ufv::query()
                ->orderBy('id', 'DESC')
                ->first();
            }else{
                $ufInicial = Ufv::query()
                    ->where('dia', $actual->dia)
                    ->where('mes', $actual->mes)
                    ->where('ano', $actual->ano)
                    ->first();
            }
            $ufActual = Ufv::query()
            ->orderBy('id', 'DESC')
            ->first();

        $empleado = EmpleadosModel::where('idemp', $actual->codemp)->first();
        return view('activo.gestionactivo.show', [
            'actual' => $actual,
            'auxiliar' => $auxiliar,
            'entidad' => $entidad,
            'ufInicial' => $ufInicial->indice_ufv,
            'ufActual' => $ufActual->indice_ufv,
        ]);
    }

    public function editar($id)
    {
        $entidad = EntidadesModel::where('entidad', 4601)->first();
        $unidad = UnidadadminModel::where('estadouni', 1)->first();
        $ambientes = Ambiente::where('unidad', $unidad->unidad)->get();
        $actual = ActualModel::with('ultimaImagen', 'empleados', 'areas', 'unidadadmin', 'auxiliars', 'codconts', 'entidades', 'organismofins')->find($id);
        $organismofins = OrganismofinModel::all();
        $codcont = CodcontModel::all();
        $auxiliars  = AuxiliarModel::query()
            ->where('unidad', $unidad->unidad)
            ->where('codcont', $actual->codcont)
            ->get();
            if($actual->ano > 2022){
                $ufInicial =  Ufv::query()
                ->orderBy('id', 'DESC')
                ->first()->indice_ufv;
            }else{
                $ufInicial = Ufv::query()
                    ->where('dia', $actual->dia)
                    ->where('mes', $actual->mes)
                    ->where('ano', $actual->ano)
                    ->first()->indice_ufv;
            }
        $ufActual = Ufv::query()
            ->orderBy('id', 'DESC')
            ->first()->indice_ufv;
        $areas = AreasModel::all();
        // $organismofins = OrganismofinModel::all();
        return view('activo.gestionactivo.edit',  compact('actual', 'ufInicial', 'ufActual', 'ambientes', 'organismofins', 'auxiliars', 'entidad', 'unidad', 'codcont', 'areas'));
    }

    public function update(ActualUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $actual = ActualModel::find($id);

            $actual->codigo = $request->input('codigo');
            $actual->ambiente_id = $request->input('ambiente_id');
            $actual->vidautil = $request->input('vidautil');
            $actual->descrip = $request->input('descrip');
            $actual->costo = $request->input('costo');
            $actual->depacu = $request->input('depacu');
            $actual->observaciones = $request->input('observaciones');
            // $actual->ano = $request->input('ano');
            // $actual->b_rev = $request->input('b_rev');

            // $actual->dia_ant = $request->input('dia_ant');
            // $actual->mes_ant = $request->input('mes_ant');
            // $actual->ano_ant = $request->input('ano_ant');
            // $actual->vut_ant = $request->input('vul_ant');
            // $actual->costo_ant = $request->input('costo_ant');
            // $actual->band_ufv = $request->input('band_ufv');
            // $actual->codestado = $request->input('codestado');
            $actual->cod_rube = $request->input('cod_rube');
            // $actual->nro_conv = $request->input('nro_conv');
            //  $actual->org_fin = $request->input('org_fin');
            $actual->feul = $request->input('feul');
            $actual->usuar = auth()->user()->name;
            // $actual->codigosec = $request->input('codigosec');
            //  $actual->banderas = $request->input('banderas');
            $actual->estadoactual = 1;
            $actual->identidades = $request->input('identidades');

            $actual->codestado = $request->input('codestado');
            if (!is_numeric($actual->ambiente_id)) {
                $ambiente = Ambiente::create([
                    'unidad' => $actual->unidad,
                    'nombre' => $actual->ambiente_id
                ]);
                $actual->ambiente_id = $ambiente->id;
            }
            $actual->save();

            if ($request->file('fotografia')) {
                $file = $request->file('fotografia');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('public/images'), $filename);

                ImagenActivo::create([
                    'activo_id' => $actual->id,
                    'user_id' => auth()->id(),
                    'descripcion' > 'imagen-fotograf=ia',
                    'ruta' => $filename
                ]);
            }

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $index => $file) {
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('public/images'), $filename);
                    ImagenActivo::create([
                        'activo_id' => $actual->id,
                        'user_id' => auth()->id(),
                        'descripcion' => 'imagen-' . $index,
                        'ruta' => $filename
                    ]);
                }
            }

            UbicacionactivoModel::create([
                'activo_id' => $actual->id,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'user_id' => auth()->id(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar los datos.');
        }

        return redirect()->route('activo.gestionactivo.index');
    }

    private function fillActualModel(ActualModel $actual, Request $request)
    {
        // Asignar los valores del formulario a las propiedades del modelo
        $actual->codigo = $request->input('codigo');
        $actual->ambiente_id = $request->input('ambiente_id');
        $actual->vidautil = $request->input('vidautil');
        $actual->descrip = $request->input('descrip');
        $actual->costo = $request->input('costo');
        $actual->depacu = $request->input('depacu');
        $actual->mes = $request->input('mes');
        $actual->observaciones = $request->input('observaciones');
        // $actual->ano = $request->input('ano');
        // $actual->b_rev = $request->input('b_rev');
        $actual->dia = $request->input('dia');





        // $actual->dia_ant = $request->input('dia_ant');
        // $actual->mes_ant = $request->input('mes_ant');
        // $actual->ano_ant = $request->input('ano_ant');
        // $actual->vut_ant = $request->input('vul_ant');
        // $actual->costo_ant = $request->input('costo_ant');
        // $actual->band_ufv = $request->input('band_ufv');
        // $actual->codestado = $request->input('codestado');
        $actual->cod_rube = $request->input('cod_rube');
        // $actual->nro_conv = $request->input('nro_conv');
        //  $actual->org_fin = $request->input('org_fin');
        $actual->feul = $request->input('feul');
        $actual->usuar = auth()->user()->name;
        // $actual->codigosec = $request->input('codigosec');
        //  $actual->banderas = $request->input('banderas');
    }
}
