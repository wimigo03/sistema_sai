<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\EmpleadoContrato;
use App\Models\Area;
use App\Models\File;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exportar\EmpleadosExcel;
use App\Models\User;
use App\Models\FacebookDetalle;
use DB;
use PDF;

class EmpleadoController extends Controller
{
    private function completar_contratos()
    {
        $empleados = Empleado::get();
        foreach($empleados as $empleado){
            $contrato = EmpleadoContrato::create([
                'idfile' => '32',
                'dea_id' => '1',
                'idarea' => $empleado->idarea,
                'idemp' => $empleado->idemp,
                'fecha_ingreso' => date('Y-m-d'),
                'poai' => '1',
                'decjurada' => '1',
                'sippase' => '1',
                'induccion' => '1',
                'tipo' => '1',
                'estado' => '1'
            ]);
        }

        dd("completar_contratos finalizado...");
    }

    public function index()
    {
        //$this->completar_contratos();
        $dea_id = Auth::user()->dea->id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::where('dea_id',$dea_id)->pluck('nombrecargo','idfile');
        $estados = Empleado::ESTADOS;
        $tipos = EmpleadoContrato::TIPOS;
        $empleados = Empleado::query()
                                ->ByDea($dea_id)
                                ->orderBy('idemp','desc')
                                ->paginate(10);
        return view('empleados.index', compact('dea_id','areas','cargos','estados','tipos','empleados'));
    }

    public function search(Request $request)
    {
        $dea_id = $request->dea_id;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::where('dea_id',$dea_id)->pluck('nombrecargo','idfile');
        $estados = Empleado::ESTADOS;
        $tipos = EmpleadoContrato::TIPOS;
        $empleados = Empleado::query()
                                ->ByDea($dea_id)
                                ->ByArea($request->area_id)
                                ->ByCargo($request->file_id)
                                ->ByApellidoPaterno($request->ap_paterno)
                                ->ByApellidoMaterno($request->ap_materno)
                                ->ByNombre($request->nombre)
                                ->ByNroCarnet($request->nro_carnet)
                                ->ByTipo($request->tipo)
                                ->ByFechaIngreso($request->fecha_ingreso)
                                ->ByFechaRetiro($request->fecha_retiro)
                                ->ByEstado($request->estado)
                                ->orderBy('idemp','desc')
                                ->paginate(10);
        return view('empleados.index', compact('dea_id','areas','cargos','estados','tipos','empleados'));
    }

    public function create($dea_id)
    {
        $extensiones = Empleado::EXTENSIONES;
        $grados_academicos = Empleado::GRADOS_ACADEMICOS;
        //$areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        //$cargos = File::where('dea_id',$dea_id)->pluck('nombrecargo','idfile');
        $tipos = EmpleadoContrato::TIPOS;
        return view('empleados.create', compact('dea_id','extensiones','grados_academicos','tipos'));
    }

    public function getAreas(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $dea_id = Auth::user()->dea->id;
            $areas = DB::table('areas')
                            ->where('dea_id',$dea_id)
                            //->where('tipo', $id)
                            ->where('estadoarea','1')
                            ->select('nombrearea','idarea')
                            ->get()
                            ->toJson();
            if($areas){
                return response()->json([
                    'areas' => $areas
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCargos(Request $request){
        try{
            $input = $request->all();
            $id = $input['id'];
            $tipo = $input['tipo'];
            $dea_id = Auth::user()->dea->id;
            $cargos = DB::table('file')
                            ->where('dea_id',$dea_id)
                            ->where('idarea', $id)
                            ->where('tipofile', $tipo)
                            ->where('estadofile','2')
                            ->select(DB::raw("concat(numfile,' - ',nombrecargo,' - ',cargo) as full_cargo"),'idfile')
                            ->get()
                            ->toJson();
            if($cargos){
                return response()->json([
                    'cargos' => $cargos
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nro_carnet' => 'required|numeric|integer|unique:empleados,ci,null,idemp,dea_id,'. $request->dea_id,
            'foto' => 'nullable|file|mimes:jpg,jpeg|max:2048'
        ]);

        try{
            $empleado_contrato = DB::transaction(function () use ($request) {
                $empleado = Empleado::create([
                    'dea_id' => $request->dea_id,
                    'idarea' => $request->area_id,
                    'nombres' => $request->nombre,
                    'ap_pat' => $request->apellido_paterno,
                    'ap_mat' => $request->apellido_materno,
                    'natalicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->natalicio))),
                    'ci' => $request->nro_carnet,
                    'extension' => $request->extension,
                    'servmilitar' => $request->libreta_militar,
                    'idioma' => $request->idioma,
                    'inamovilidad' => isset($request->inamovilidad) ? '1' : '2',
                    'aservicios' => $request->anhos_servicio,
                    'cvitae' => isset($request->cvitae) ? '1' : '2',
                    'telefono' => $request->telefono,
                    'gradacademico' => $request->grado_academico,
                    'rae' => $request->rae,
                    'regprofesional' => $request->registro_profesional,
                    'estado' => '1',
                    'cuentabanco' => $request->cuenta_banco,
                    'filecontrato' => $request->file_contrato,
                    'nit' => $request->nit,
                    'sigep' => isset($request->sigep) ? '1' : '2',
                    'kua' => $request->kua
                ]);

                $empleado_contrato = EmpleadoContrato::create([
                    'idfile' => $request->cargo_id,
                    'dea_id' => $request->dea_id,
                    'idarea' => $request->area_id,
                    'idemp' => $empleado->idemp,
                    'user_id' => Auth::user()->id,
                    'fecha_ingreso' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_ingreso))),
                    'poai' => isset($request->poai) ? '1' : '2',
                    'exppoai' => isset($request->exp_poai) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_poai))) : null,
                    'decjurada' => isset($request->declaracion_jurada) ? '1' : '2',
                    'expdecjurada' => isset($request->exp_declaracion_jurada) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_declaracion_jurada))) : null,
                    'sippase' => isset($request->sippase) ? '1' : '2',
                    'expsippase' => isset($request->exp_sippase) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_sippase))) : null,
                    'induccion' => isset($request->induccion) ? '1' : '2',
                    'expinduccion' => isset($request->exp_induccion) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_induccion))) : null,
                    'progvacacion' => isset($request->progvacacion) ? '1' : '2',
                    'expprogvacacion' => isset($request->exp_progvacacion) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_progvacacion))) : null,
                    'segsalud' => $request->seguro_salud,
                    'biometrico' => $request->biometrico,
                    'tipo' => $request->tipo,
                    'fecha_conclusion_contrato' => isset($request->fecha_conclusion_contrato) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_conclusion_contrato))) : null,
                    'ncontrato' => $request->n_contrato,
                    'npreventivo' => $request->n_preventivo,
                    'rejap' => isset($request->rejap) ? '1' : '2',
                    'estado' => '1'
                ]);

                $foto = isset($request->foto) ? date('Ymdhis') . '_' . $empleado->idemp . '.'.pathinfo($request->foto->getClientOriginalName(), PATHINFO_EXTENSION) : null;
                $photo = isset($request->foto) ? 'personal_fotos/' . $foto : null;
                $cargar_photo = isset($request->foto) ? $request->foto->move(public_path('personal_fotos/'), $foto) : null;
                $empleado->update([
                    'url_foto' => $photo
                ]);

                $file = File::find($request->cargo_id);
                $file->update([
                    'estadofile' => '1'
                ]);

                return $empleado_contrato;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Empleado: " . $empleado_contrato->idemp . " registrado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('empleado.index')->with('success_message', 'Personal registrado correctamente...');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al registrar personal: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al crear el registro]')->withInput();
        }
    }

    public function editar($empleado_id)
    {
        $empleado = Empleado::find($empleado_id);
        $dea_id = $empleado->dea_id;
        $empleado_contrato = EmpleadoContrato::where('idemp',$empleado_id)->orderBy('id','desc')->take(1)->first();
        if($empleado_contrato == null){
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el registro, por favor comunicarse con el area de sistemas.]')->withInput();
        }
        $extensiones = Empleado::EXTENSIONES;
        $grados_academicos = Empleado::GRADOS_ACADEMICOS;
        $areas = Area::where('dea_id',$dea_id)->where('estadoarea','1')->get();
        $cargos = File::where('dea_id',$dea_id)
                            ->where('idarea',$empleado->idarea)
                            ->where('estadofile','2')
                            ->orWhere('idfile',$empleado_contrato->idfile)->get();
        $tipos = EmpleadoContrato::TIPOS;
        return view('empleados.editar', compact('empleado','dea_id','empleado_contrato','extensiones','grados_academicos','areas','cargos','tipos'));
    }

    public function update(Request $request)
    {//dd($request->all());
        $request->validate([
            'nro_carnet' => 'required|numeric|integer|unique:empleados,ci,' . $request->empleado_id . ',idemp,dea_id,'. $request->dea_id,
            'foto' => 'nullable|file|mimes:jpg,jpeg|max:2048'
        ]);

        try{
            $empleado_contrato = DB::transaction(function () use ($request) {
                $empleado = Empleado::find($request->empleado_id);
                $empleado->update([
                    'dea_id' => $request->dea_id,
                    'idarea' => $request->area_id,
                    'nombres' => $request->nombre,
                    'ap_pat' => $request->apellido_paterno,
                    'ap_mat' => $request->apellido_materno,
                    'natalicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->natalicio))),
                    'ci' => $request->nro_carnet,
                    'extension' => $request->extension,
                    'servmilitar' => $request->libreta_militar,
                    'idioma' => $request->idioma,
                    'inamovilidad' => isset($request->inamovilidad) ? '1' : '2',
                    'aservicios' => $request->anhos_servicio,
                    'cvitae' => isset($request->cvitae) ? '1' : '2',
                    'telefono' => $request->telefono,
                    'gradacademico' => $request->grado_academico,
                    'rae' => $request->rae,
                    'regprofesional' => $request->registro_profesional,
                    'estado' => '1',
                    'cuentabanco' => $request->cuenta_banco,
                    'filecontrato' => $request->file_contrato,
                    'nit' => $request->nit,
                    'sigep' => isset($request->sigep) ? '1' : '2',
                    'kua' => $request->kua
                ]);
                $empleado_contrato = EmpleadoContrato::find($request->empleado_contrato_id);

                $file_anterior = File::find($empleado_contrato->idfile);
                if($file_anterior != null){
                    $file_anterior->update([
                        'estadofile' => '2'
                    ]);
                }

                $empleado_contrato->update([
                    'idfile' => $request->cargo_id,
                    'dea_id' => $request->dea_id,
                    'idarea' => $request->area_id,
                    'user_id' => Auth::user()->id,
                    'fecha_ingreso' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_ingreso))),
                    'poai' => isset($request->poai) ? '1' : '2',
                    'exppoai' => isset($request->exp_poai) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_poai))) : null,
                    'decjurada' => isset($request->declaracion_jurada) ? '1' : '2',
                    'expdecjurada' => isset($request->exp_declaracion_jurada) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_declaracion_jurada))) : null,
                    'sippase' => isset($request->sippase) ? '1' : '2',
                    'expsippase' => isset($request->exp_sippase) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_sippase))) : null,
                    'induccion' => isset($request->induccion) ? '1' : '2',
                    'expinduccion' => isset($request->exp_induccion) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_induccion))) : null,
                    'progvacacion' => isset($request->progvacacion) ? '1' : '2',
                    'expprogvacacion' => isset($request->exp_progvacacion) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_progvacacion))) : null,
                    'segsalud' => $request->seguro_salud,
                    'biometrico' => $request->biometrico,
                    'tipo' => $request->tipo,
                    'fecha_conclusion_contrato' => isset($request->fecha_conclusion_contrato) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_conclusion_contrato))) : null,
                    'ncontrato' => $request->n_contrato,
                    'npreventivo' => $request->n_preventivo,
                    'rejap' => isset($request->rejap) ? '1' : '2'
                ]);

                if(isset($request->foto)){
                    $foto = isset($request->foto) ? date('Ymdhis') . '_' . $empleado->idemp . '.'.pathinfo($request->foto->getClientOriginalName(), PATHINFO_EXTENSION) : null;
                    $photo = isset($request->foto) ? 'personal_fotos/' . $foto : null;
                    $cargar_photo = isset($request->foto) ? $request->foto->move(public_path('personal_fotos/'), $foto) : null;
                    $empleado->update([
                        'url_foto' => $photo
                    ]);
                }

                $file = File::find($request->cargo_id);
                $file->update([
                    'estadofile' => '1'
                ]);

                return $empleado_contrato;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Empleado: " . $empleado_contrato->idemp . " actualizado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('empleado.index')->with('info_message', 'Personal actualizado correctamente...');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al actualizar personal: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al actualizar el registro]')->withInput();
        }
    }

    public function retirar($empleado_id)
    {
        $empleado = Empleado::find($empleado_id);
        return view('empleados.retirar', compact('empleado'));
    }

    public function procesar_retiro(Request $request)
    {
        $fecha_retiro = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_retiro)));
        $empleado = Empleado::find($request->empleado_id);
        if($fecha_retiro < $empleado->ultimo_contrato_ingreso){
            return redirect()->back()->with('error_message','[La fecha de retiro no puede ser menor a la fecha de ingreso]')->withInput();
        }

        $contrato = EmpleadoContrato::where('idemp',$request->empleado_id)->orderBy('id','desc')->take(1)->first();
        if($contrato == null){
            return redirect()->back()->with('error_message','[Ocurrio un Error al modificar el registro, por favor comunicarse con el area de sistemas.]')->withInput();
        }

        $empleado->update([
            'estado' => '2'
        ]);

        $empleado_contrato = EmpleadoContrato::find($contrato->id);
        $empleado_contrato->update([
            'fecha_retiro' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_retiro))),
            'estado' => '2',
            'user_id' => Auth::user()->id,
            'obs_retiro' => $request->obs_retiro
        ]);

        $file = File::find($empleado_contrato->idfile);
        $file->update([
            'estadofile' => '2'
        ]);

        $euser = User::select('id')->where('idemp',$request->empleado_id)->first();
        if($euser != null){
            $user = User::find($euser->id);
            $user->update([
                'estadouser' => '0'
            ]);
        }

        Log::channel('recursos_humanos')->info(
            "\n" .
            "Empleado: " . $empleado_contrato->idemp . " retirado con éxito" . "\n" .
            "Usuario: " . Auth::user()->id . "\n"
        );

        return redirect()->route('empleado.index')->with('success_message', 'Personal retirado correctamente...');
    }

    public function recontratar($empleado_id)
    {
        $empleado = Empleado::find($empleado_id);
        $dea_id = $empleado->dea_id;
        $extensiones = Empleado::EXTENSIONES;
        $grados_academicos = Empleado::GRADOS_ACADEMICOS;
        $areas = Area::where('dea_id',$dea_id)->pluck('nombrearea','idarea');
        $cargos = File::where('dea_id',$dea_id)->pluck('nombrecargo','idfile');
        $tipos = EmpleadoContrato::TIPOS;
        return view('empleados.recontratar', compact('empleado','dea_id','extensiones','grados_academicos','areas','cargos','tipos'));
    }

    public function procesar_recontrato(Request $request)
    {
        $request->validate([
            'nro_carnet' => 'required|numeric|integer|unique:empleados,ci,' . $request->empleado_id . ',idemp,dea_id,'. $request->dea_id,
            'foto' => 'nullable|file|mimes:jpg,jpeg|max:2048'
        ]);

        try{
            $empleado_contrato = DB::transaction(function () use ($request) {
                $empleado = Empleado::find($request->empleado_id);
                $empleado->update([
                    'dea_id' => $request->dea_id,
                    'idarea' => $request->area_id,
                    'nombres' => $request->nombre,
                    'ap_pat' => $request->apellido_paterno,
                    'ap_mat' => $request->apellido_materno,
                    'natalicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->natalicio))),
                    'ci' => $request->nro_carnet,
                    'extension' => $request->extension,
                    'servmilitar' => $request->libreta_militar,
                    'idioma' => $request->idioma,
                    'inamovilidad' => isset($request->inamovilidad) ? '1' : '2',
                    'aservicios' => $request->anhos_servicio,
                    'cvitae' => isset($request->cvitae) ? '1' : '2',
                    'telefono' => $request->telefono,
                    'gradacademico' => $request->grado_academico,
                    'rae' => $request->rae,
                    'regprofesional' => $request->registro_profesional,
                    'estado' => '1',
                    'cuentabanco' => $request->cuenta_banco,
                    'filecontrato' => $request->file_contrato,
                    'nit' => $request->nit,
                    'sigep' => isset($request->sigep) ? '1' : '2',
                    'kua' => $request->kua
                ]);

                $empleado_contrato = EmpleadoContrato::create([
                    'idfile' => $request->cargo_id,
                    'dea_id' => $request->dea_id,
                    'idarea' => $request->area_id,
                    'idemp' => $empleado->idemp,
                    'user_id' => Auth::user()->id,
                    'fecha_ingreso' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha_ingreso))),
                    'poai' => isset($request->poai) ? '1' : '2',
                    'exppoai' => isset($request->exp_poai) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_poai))) : null,
                    'decjurada' => isset($request->declaracion_jurada) ? '1' : '2',
                    'expdecjurada' => isset($request->exp_declaracion_jurada) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_declaracion_jurada))) : null,
                    'sippase' => isset($request->sippase) ? '1' : '2',
                    'expsippase' => isset($request->exp_sippase) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_sippase))) : null,
                    'induccion' => isset($request->induccion) ? '1' : '2',
                    'expinduccion' => isset($request->exp_induccion) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_induccion))) : null,
                    'progvacacion' => isset($request->progvacacion) ? '1' : '2',
                    'expprogvacacion' => isset($request->exp_progvacacion) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->exp_progvacacion))) : null,
                    'segsalud' => $request->seguro_salud,
                    'biometrico' => $request->biometrico,
                    'tipo' => $request->tipo,
                    'ncontrato' => $request->n_contrato,
                    'npreventivo' => $request->n_preventivo,
                    'rejap' => isset($request->rejap) ? '1' : '2',
                    'estado' => '1'
                ]);

                if(isset($request->foto)){
                    $foto = isset($request->foto) ? date('Ymdhis') . '_' . $empleado->idemp . '.'.pathinfo($request->foto->getClientOriginalName(), PATHINFO_EXTENSION) : null;
                    $photo = isset($request->foto) ? 'personal_fotos/' . $foto : null;
                    $cargar_photo = isset($request->foto) ? $request->foto->move(public_path('personal_fotos/'), $foto) : null;
                    $empleado->update([
                        'url_foto' => $photo
                    ]);
                }

                return $empleado_contrato;
            });

            Log::channel('recursos_humanos')->info(
                "\n" .
                "Empleado: " . $empleado_contrato->idemp . " recontratado con éxito" . "\n" .
                "Usuario: " . Auth::user()->id . "\n"
            );

            return redirect()->route('empleado.index')->with('info_message', 'Personal recontratado correctamente...');
        } catch (\Exception $e) {
            Log::channel('recursos_humanos')->info(
                "\n" .
                "Error al recontratar personal: " . "\n" .
                "Usuario: " . Auth::user()->id . "\n" .
                "Error: " . $e->getMessage() . "\n"
            );
            return redirect()->back()->with('error_message','[Ocurrio un Error al recontratar el registro]')->withInput();
        }
    }

    public function show($empleado_id)
    {
        $empleado = Empleado::find($empleado_id);
        $dea_id = $empleado->dea_id;
        $empleados_contratos = EmpleadoContrato::where('idemp',$empleado_id)->orderBy('id','desc')->get();
        return view('empleados.show', compact('empleado','dea_id','empleados_contratos'));
    }

    public function pdf_show($empleado_id)
    {
        $empleado = Empleado::find($empleado_id);
        $dea_id = $empleado->dea_id;
        $empleados_contratos = EmpleadoContrato::where('idemp',$empleado_id)->orderBy('id','desc')->get();
        $pdf = PDF::loadView('empleados.pdf-show', compact(['empleado','dea_id','empleados_contratos']));
        $pdf->setPaper('LETTER', 'portrait');
        return $pdf->stream('informacion_personal.pdf');
    }

    public function imprimir_credenciales($dea_id)
    {
        $empleados = Empleado::query()
                                ->ByDea($dea_id)
                                ->ByEstado('1')
                                ->orderBy('idemp','desc')
                                ->get();
        return view('empleados.imprimir-credenciales', compact('dea_id','empleados'));
    }

    public function procesar_credenciales(Request $request)
    {
        try{
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
            $empleados = Empleado::whereIn('idemp',$request->print)->get();
            $pdf = PDF::loadView('empleados.pdf-credenciales', compact(['empleados']));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('credenciales.pdf');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function excel(Request $request)
    {
        try {
            ini_set('memory_limit','-1');
            ini_set('max_execution_time','-1');
                $dea_id = $request->dea_id;
                $empleados = Empleado::query()
                                        ->ByDea($dea_id)
                                        ->ByArea($request->area_id)
                                        ->ByCargo($request->file_id)
                                        ->ByApellidoPaterno($request->ap_paterno)
                                        ->ByApellidoMaterno($request->ap_materno)
                                        ->ByNombre($request->nombre)
                                        ->ByNroCarnet($request->nro_carnet)
                                        ->ByTipo($request->tipo)
                                        ->ByFechaIngreso($request->fecha_ingreso)
                                        ->ByFechaRetiro($request->fecha_retiro)
                                        ->ByEstado($request->estado)
                                        ->orderBy('idemp','desc')
                                        ->get();
                return Excel::download(new EmpleadosExcel($empleados),'personal.xlsx');
        } catch (\Throwable $th) {
            return view('errors.500');
        }finally{
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
}
