<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\Customer;
use App\Models\FileModel;
use App\Models\MovimientosPtModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use NumerosEnLetras;


class PlantaController extends Controller
{

    public function index()
    {
        return view('rechumanos.planta.index');
    }

    public function list()
    {
        $customers = AreasModel::select(['idarea', 'nombrearea', 'estadoarea', 'idnivel']);
        return Datatables::of($customers)
            ->addColumn('details_url', function ($customer) {
                return route('planta_detalle', $customer->idarea);
            })
            ->addColumn('btn2', function ($row) {
                $btn2 = '<a href="' . route('planta.lista', $row->idarea) . '" class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                            <i class="fa-solid fa-2xl fa-right-to-bracket"></i>
                                        </a>';
                return $btn2;
            })
            ->rawColumns(['btn2'])->make(true);
    }

    public function detalle($id)
    {
        $purchases = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', 'e.idarea')
            ->select('e.nombres', 'e.ap_pat', 'e.ap_mat', 'e.ci', 'e.fechingreso')
            ->where('e.tipo', 1)
            ->where('e.idarea', $id)
            ->get();

        return Datatables::of($purchases)->make(true);
    }

    public function detallePlanta(){
        $empleadoss = EmpleadosModel::where('tipo','1')->orderBy('fechingreso','desc')->paginate(10);
        
        $empleados = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('file as f', 'f.idfile', '=', 'e.idfile')
            ->select('a.nombrearea', 'f.numfile', 'e.idemp', 'e.nombres', 'e.ap_pat', 'e.ap_mat', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 
            'f.niveladm', 'f.clase', 'f.nivelsal', 'e.fechingreso', 'e.natalicio', 'e.edad', 'e.ci', 'e.poai', 'e.exppoai', 'e.decjurada', 'e.expdecjurada', 
            'e.sippase', 'e.expsippase', 'e.servmilitar', 'e.idioma', 'e.induccion', 'e.expinduccion', 'e.progvacacion', 'e.expprogvacacion', 'e.vacganadas', 
            'e.vacpendientes', 'e.vacusasdas', 'e.segsalud', 'e.inamovilidad', 'e.aservicios', 'e.cvitae', 'e.telefono', 'e.biometrico', 'e.gradacademico', 
            'e.rae', 'e.regprofesional', 'e.evdesempenio')
            ->where('e.tipo', '=', 1)
            ->orderBy('e.idemp','asc')
            ->get();

        return view('rechumanos.planta.lista2', compact('empleados','empleadoss'));
    }

    public function detallePlantaShow($id){
        $empleado = EmpleadosModel::where('idemp',$id)->first();
        return view('rechumanos.planta.lista2-show', compact('empleado'));
    }

    public function edit($id)
    {
        return view('rechumanos.planta.edit');
    }

    public function plantanuevo($id)
    {
        $area = AreasModel::where('estadoarea', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();
        $idarea = $id;
        $area_actual = AreasModel::find($id);
        $files = DB::table('areas as a')
            ->join('file as b', 'b.idarea', 'a.idarea')
            ->where('a.estadoarea', 1)
            ->where('b.estadofile', 1)
            ->where('b.tipofile', 1)
            ->select(DB::raw("concat(a.nombrearea,'_FILE ',b.numfile,'_',b.cargo,'_',b.nombrecargo,'_',b.habbasico,'_',b.categoria,'_',b.niveladm,'_',b.clase,'_',b.nivelsal) as file_completo"), 'b.idfile')
            ->pluck('file_completo', 'b.idfile');

        return view('rechumanos.planta.create', compact('niveles', 'area', 'idarea', 'area_actual', 'files'));
    }

    public function lista($idarea)
    {
        $empleados = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', 'e.idarea')
            ->join('file as f', 'f.idfile', 'e.idfile')
            ->select('a.nombrearea', 'f.numfile', 'e.idemp', 'e.nombres', 'e.ap_pat', 'e.ap_mat', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 'f.niveladm', 'f.clase', 'f.nivelsal', 'e.fechingreso', 'e.natalicio', 'e.edad', 'e.ci', 'e.poai', 'e.exppoai', 'e.decjurada', 'e.expdecjurada', 'e.sippase', 'e.expsippase', 'e.servmilitar', 'e.idioma', 'e.induccion', 'e.expinduccion', 'e.progvacacion', 'e.expprogvacacion', 'e.vacganadas', 'e.vacpendientes', 'e.vacusasdas', 'e.segsalud', 'e.inamovilidad', 'e.aservicios', 'e.cvitae', 'e.telefono', 'e.biometrico', 'e.gradacademico', 'e.rae', 'e.regprofesional', 'e.evdesempenio', 'e.rejap')
            ->where('e.tipo', 1)
            ->where('e.idarea', $idarea)->get();
        $areas = AreasModel::find($idarea);
        $nombrearea = $areas->nombrearea;

        return view('rechumanos.planta.lista', compact('empleados', 'idarea', 'nombrearea'));
    }


    public function guardarplanta(Request $request)
    {
        $empleados = new EmpleadosModel();
        $empleados->nombres = $request->input('nombres');
        $empleados->ap_pat = $request->input('ap_pat');
        $empleados->ap_mat = $request->input('ap_mat');
        $empleados->fechingreso = $request->input('fechingreso');
        $empleados->natalicio = $request->input('natalicio');
        $edad = Carbon::parse($request->input('natalicio'))->age;
        $empleados->edad = $edad;
        $empleados->ci = $request->input('ci');
        $empleados->poai = $request->input('poai');
        $empleados->exppoai = $request->input('exppoai');
        $empleados->decjurada = $request->input('decjurada');
        $empleados->expdecjurada = $request->input('expdecjurada');
        $empleados->sippase = $request->input('sippase');
        $empleados->expsippase = $request->input('expsippase');
        $empleados->servmilitar = $request->input('servmilitar');
        $empleados->idioma = $request->input('idioma');
        $empleados->induccion = $request->input('induccion');
        $empleados->expinduccion = $request->input('expinduccion');
        $empleados->progvacacion = $request->input('progvacacion');
        $empleados->expprogvacacion = $request->input('expprogvacacion');
        $empleados->vacganadas = $request->input('vacganadas');
        $empleados->vacpendientes = $request->input('vacpendientes');
        $empleados->vacusasdas = $request->input('vacusasdas');
        $empleados->segsalud = $request->input('segsalud');
        $empleados->inamovilidad = $request->input('inamovilidad');
        $empleados->aservicios = $request->input('aservicios');
        $empleados->cvitae = $request->input('cvitae');
        $empleados->telefono = $request->input('telefono');
        $empleados->biometrico = $request->input('biometrico');
        $empleados->gradacademico = $request->input('gradacademico');
        $empleados->rae = $request->input('rae');
        $empleados->regprofesional = $request->input('regprofesional');
        $empleados->evdesempenio = $request->input('evdesempenio');
        $empleados->idfile = $request->input('idfile');
        $empleados->idarea = $request->input('idarea');
        $empleados->rejap = $request->input('rejap');
        $empleados->estadoemp1 = 1;
        $empleados->estadoemp2 = 1;
        $empleados->tipo = 1;
        $empleados->save();

        $file = FileModel::find($request->input('idfile'));
        $file->estadofile = 2;
        $file->save();

        return redirect()->action('App\Http\Controllers\PlantaController@lista', [$request->input('idarea')]);
    }


    public function editarplanta($idempledoPlanta)
    {

        $area = AreasModel::where('estadoarea', '=', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();
        $empleados = EmpleadosModel::find($idempledoPlanta);
        $areaactual = DB::table('areas as a')
            ->join('empleados as e', 'e.idarea', '=', 'a.idarea')
            ->select('a.nombrearea')
            ->where('e.idemp', '=', $idempledoPlanta)->first();
        //dd($niveles);
        //return view('rechumanos.planta.edit')->with('empleados', $empleados,"niveles",$niveles,"area", $area);

        return view('rechumanos.planta.edit', ["areaactual" => $areaactual, "niveles" => $niveles, "area" => $area, "empleados" => $empleados]);
    }

    public function actualizarPlanta(Request $request)
    {
        $empleados = EmpleadosModel::find($request->input('idemp'));
        $empleados->nombres = $request->input('nombres');
        $empleados->ap_pat = $request->input('ap_pat');
        $empleados->ap_mat = $request->input('ap_mat');
        $empleados->fechingreso = $request->input('fechingreso');
        $empleados->natalicio = $request->input('natalicio');


        $edad = Carbon::parse($request->input('natalicio'))->age;

        $empleados->edad = $edad;


        // $empleados -> edad = $request->input('edad');
        $empleados->ci = $request->input('ci');
        $empleados->poai = $request->input('poai');
        $empleados->exppoai = $request->input('exppoai');
        $empleados->decjurada = $request->input('decjurada');
        $empleados->expdecjurada = $request->input('expdecjurada');
        $empleados->sippase = $request->input('sippase');
        $empleados->expsippase = $request->input('expsippase');
        $empleados->servmilitar = $request->input('servmilitar');
        $empleados->idioma = $request->input('idioma');
        $empleados->induccion = $request->input('induccion');
        $empleados->expinduccion = $request->input('expinduccion');
        $empleados->progvacacion = $request->input('progvacacion');
        $empleados->expprogvacacion = $request->input('expprogvacacion');
        $empleados->vacganadas = $request->input('vacganadas');
        $empleados->vacpendientes = $request->input('vacpendientes');
        $empleados->vacusasdas = $request->input('vacusasdas');
        $empleados->segsalud = $request->input('segsalud');
        $empleados->inamovilidad = $request->input('inamovilidad');
        $empleados->aservicios = $request->input('aservicios');
        $empleados->cvitae = $request->input('cvitae');
        $empleados->telefono = $request->input('telefono');
        $empleados->biometrico = $request->input('biometrico');
        $empleados->gradacademico = $request->input('gradacademico');
        $empleados->rae = $request->input('rae');
        $empleados->regprofesional = $request->input('regprofesional');
        $empleados->evdesempenio = $request->input('evdesempenio');
        $empleados->idfile = $request->input('idfile');
        $empleados->idarea = $request->input('idarea');
        $empleados->rejap = $request->input('rejap');

        $empleados->estadoemp1 = 1;
        $empleados->estadoemp2 = 1;
        $empleados->tipo = 1;

        $empleados->save();

        if ($request->input('idfile') != $request->input('idfileoriginal')) {
            $file = FileModel::find($request->input('idfile'));
            $file->estadofile = 2;
            $file2 = FileModel::find($request->input('idfileoriginal'));
            $file2->estadofile = 1;
            $file->save();
            $file2->save();
        } else {
        }

        return redirect()->action('App\Http\Controllers\PlantaController@lista', [$request->input('idareaoriginal')]);
    }



    public function editarplanta2($idempledoPlanta)
    {

        $area = AreasModel::where('estadoarea', '=', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();
        $empleados = EmpleadosModel::find($idempledoPlanta);

        $areaactual = DB::table('areas as a')
            ->join('empleados as e', 'e.idarea', '=', 'a.idarea')
            ->select('a.nombrearea')
            ->where('e.idemp', '=', $idempledoPlanta)->first();

        //dd($niveles);
        //return view('rechumanos.planta.edit')->with('empleados', $empleados,"niveles",$niveles,"area", $area);

        return view('rechumanos.planta.delete', ["areaactual" => $areaactual, "niveles" => $niveles, "area" => $area, "empleados" => $empleados]);
    }


    public function deletePlanta(Request $request)
    {
        $empleados = EmpleadosModel::find($request->input('idemp'));
        $empleados->nombres = $request->input('nombres');
        $empleados->ap_pat = $request->input('ap_pat');
        $empleados->ap_mat = $request->input('ap_mat');
        $empleados->fechingreso = $request->input('fechingreso');
        $empleados->natalicio = $request->input('natalicio');


        $edad = Carbon::parse($request->input('natalicio'))->age;

        $empleados->edad = $edad;


        // $empleados -> edad = $request->input('edad');
        $empleados->ci = $request->input('ci');
        $empleados->poai = $request->input('poai');
        $empleados->exppoai = $request->input('exppoai');
        $empleados->decjurada = $request->input('decjurada');
        $empleados->expdecjurada = $request->input('expdecjurada');
        $empleados->sippase = $request->input('sippase');
        $empleados->expsippase = $request->input('expsippase');
        $empleados->servmilitar = $request->input('servmilitar');
        $empleados->idioma = $request->input('idioma');
        $empleados->induccion = $request->input('induccion');
        $empleados->expinduccion = $request->input('expinduccion');
        $empleados->progvacacion = $request->input('progvacacion');
        $empleados->expprogvacacion = $request->input('expprogvacacion');
        $empleados->vacganadas = $request->input('vacganadas');
        $empleados->vacpendientes = $request->input('vacpendientes');
        $empleados->vacusasdas = $request->input('vacusasdas');
        $empleados->segsalud = $request->input('segsalud');
        $empleados->inamovilidad = $request->input('inamovilidad');
        $empleados->aservicios = $request->input('aservicios');
        $empleados->cvitae = $request->input('cvitae');
        $empleados->telefono = $request->input('telefono');
        $empleados->biometrico = $request->input('biometrico');
        $empleados->gradacademico = $request->input('gradacademico');
        $empleados->rae = $request->input('rae');
        $empleados->regprofesional = $request->input('regprofesional');
        $empleados->evdesempenio = $request->input('evdesempenio');
        $empleados->idfile = $request->input('idfile');
        $empleados->idarea = $request->input('idarea');
        $empleados->rejap = $request->input('rejap');

        $empleados->estadoemp1 = 1;
        $empleados->estadoemp2 = 1;
        $empleados->tipo = 1;

        $empleados->save();

        if ($request->input('idfile') != $request->input('idfileoriginal')) {
            $file = FileModel::find($request->input('idfile'));
            $file->estadofile = 2;
            $file2 = FileModel::find($request->input('idfileoriginal'));
            $file2->estadofile = 1;
            $file->save();
            $file2->save();


            $fileactual = DB::table('file as f')
                ->select('f.numfile', 'f.cargo', 'f.habbasico', 'f.nombrecargo')
                ->where('f.idfile', '=', $request->input('idfileoriginal'))->first();

            // $fileactual = FileModel::find($request->input('idfile'))->first();
            $filenuevo = DB::table('file as f')
                ->select('f.numfile', 'f.cargo', 'f.habbasico', 'f.nombrecargo')
                ->where('f.idfile', '=', $request->input('idfile'))->first();

            //$areaactual = AreasModel::find($request->input('idarea'))->first();
            $areaactual = DB::table('areas as a')
                ->select('a.nombrearea')
                ->where('a.idarea', '=', $request->input('idarea'))->first();



            $movimientosplanta = new MovimientosPtModel();
            $movimientosplanta->idemp = $request->input('idemp');
            $movimientosplanta->fechamovpt = $request->input('fechainactivo');
            $movimientosplanta->motivopt = $request->input('motivo');

            $movimientosplanta->fileactualpt = $fileactual->numfile;
            $movimientosplanta->cargoactualpt = $fileactual->cargo;
            $movimientosplanta->nombrecargoactualpt = $fileactual->nombrecargo;
            $movimientosplanta->haberbasicoactualpt = $fileactual->habbasico;
            $movimientosplanta->nombreareaactualpt = $request->input('nombreareaactual');

            $movimientosplanta->filenuevopt = $filenuevo->numfile;
            $movimientosplanta->cargonuevopt = $filenuevo->cargo;
            $movimientosplanta->nombrecargonuevopt = $filenuevo->nombrecargo;
            $movimientosplanta->haberbasiconuevopt = $filenuevo->habbasico;
            $movimientosplanta->nombreareanuevopt = $areaactual->nombrearea;
            $movimientosplanta->save();
        } else {
        }

        return redirect()->action('App\Http\Controllers\PlantaController@lista', [$request->input('idareaoriginal')]);
    }
}
