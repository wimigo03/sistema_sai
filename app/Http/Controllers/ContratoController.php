<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\Customer;
use App\Models\FileModel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use NumerosEnLetras;


class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //index
    public function index()
    {

        return view('rechumanos.contrato.index');
    }


    /////////////////////////////////////////////

    public function list()

    {
        $customers = Area::select(['idarea', 'nombrearea', 'estadoarea', 'idnivel']);

        return Datatables::of($customers)
            ->addColumn('details_url', function ($customer) {
                return route('contrato_detalle', $customer->idarea);
            })
            ->addColumn('btn2', function ($row) {

                $btn2 = '<a href="' . route('contrato.lista', $row->idarea) . '" class="btn btn-outline-info btn-sm"  title="Editar">Acceder</a>';

                return $btn2;
            })
            ->rawColumns(['btn2'])->make(true);
    }

    ///////////////////////////////////////////////////////

    public function detalle($id)
    {


        $purchases = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            //->join('file as f', 'f.idfile', '=', 'e.idfile')
            //->select('a.nombrearea','f.numfile','e.idemp','e.nombres','e.ap_pat','e.ap_mat','f.cargo','f.nombrecargo','f.habbasico','f.categoria','f.niveladm','f.clase','f.nivelsal','e.fechingreso','e.natalicio','e.edad','e.ci','e.poai','e.exppoai','e.decjurada','e.expdecjurada','e.sippase','e.expsippase','e.servmilitar','e.idioma','e.induccion','e.expinduccion','e.progvacacion','e.expprogvacacion','e.vacganadas','e.vacpendientes','e.vacusasdas','e.segsalud','e.inamovilidad','e.aservicios','e.cvitae','e.telefono','e.biometrico','e.gradacademico','e.rae','e.regprofesional','e.evdesempenio','e.totalpresupuesto','e.fechafinal','e.ncontrato','e.npreventivo','e.progproy','e.rejap','e.aportesafp','e.cuentabanco','e.filecontrato','e.nit','e.sigep')
            ->where('e.tipo', '=', 2)
            ->where('e.idarea', '=', $id)
            ->get();

        return Datatables::of($purchases)->make(true);
    }

    ///////////////////////////////////////////////////////




    public function detalleContrato()
    {

        $empleados = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('file as f', 'f.idfile', '=', 'e.idfile')
            ->select('a.nombrearea', 'f.numfile', 'e.idemp', 'e.nombres', 'e.ap_pat', 'e.ap_mat', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 'f.niveladm', 'f.clase', 'f.nivelsal', 'e.fechingreso', 'e.natalicio', 'e.edad', 'e.ci', 'e.poai', 'e.exppoai', 'e.decjurada', 'e.expdecjurada', 'e.sippase', 'e.expsippase', 'e.servmilitar', 'e.idioma', 'e.induccion', 'e.expinduccion', 'e.progvacacion', 'e.expprogvacacion', 'e.vacganadas', 'e.vacpendientes', 'e.vacusasdas', 'e.segsalud', 'e.inamovilidad', 'e.aservicios', 'e.cvitae', 'e.telefono', 'e.biometrico', 'e.gradacademico', 'e.rae', 'e.regprofesional', 'e.evdesempenio', 'e.totalpresupuesto', 'e.fechafinal', 'e.ncontrato', 'e.npreventivo', 'e.progproy', 'e.rejap', 'e.aportesafp', 'e.cuentabanco', 'e.filecontrato', 'e.nit', 'e.sigep')

            ->where('e.tipo', '=', 2)
            ->get();
        //$areas = Area::find($idarea);
        //$nombrearea=$areas->nombrearea;

        return view('rechumanos.contrato.lista2', ["empleados" => $empleados]);
    }


    /////////////////////////////////////////////////////

    public function edit($id)
    {

        return view('rechumanos.contrato.edit');
    }


    /////////////////////////////////////////////////

    public function contratonuevo($id)
    {

        $area = Area::where('estadoarea', '=', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();

        return view('rechumanos.contrato.create', ["niveles" => $niveles, "area" => $area, "idarea" => $id]);
    }

    ////////////////////////////////////////////////

    public function lista($idarea)
    {

        $empleados = DB::table('empleados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('file as f', 'f.idfile', '=', 'e.idfile')
            ->select('a.nombrearea', 'f.numfile', 'e.idemp', 'e.nombres', 'e.ap_pat', 'e.ap_mat', 'f.cargo', 'f.nombrecargo', 'f.habbasico', 'f.categoria', 'f.niveladm', 'f.clase', 'f.nivelsal', 'e.fechingreso', 'e.natalicio', 'e.edad', 'e.ci', 'e.poai', 'e.exppoai', 'e.decjurada', 'e.expdecjurada', 'e.sippase', 'e.expsippase', 'e.servmilitar', 'e.idioma', 'e.induccion', 'e.expinduccion', 'e.progvacacion', 'e.expprogvacacion', 'e.vacganadas', 'e.vacpendientes', 'e.vacusasdas', 'e.segsalud', 'e.inamovilidad', 'e.aservicios', 'e.cvitae', 'e.telefono', 'e.biometrico', 'e.gradacademico', 'e.rae', 'e.regprofesional', 'e.evdesempenio', 'e.totalpresupuesto', 'e.fechafinal', 'e.ncontrato', 'e.npreventivo', 'e.progproy', 'e.rejap', 'e.aportesafp', 'e.cuentabanco', 'e.filecontrato', 'e.nit', 'e.sigep')
            ->where('e.tipo', '=', 2)
            ->where('e.idarea', '=', $idarea)->get();
        $areas = Area::find($idarea);
        $nombrearea = $areas->nombrearea;

        return view('rechumanos.contrato.lista', ["empleados" => $empleados, "idarea" => $idarea, "nombrearea" => $nombrearea]);
    }


    public function guardarcontrato(Request $request)
    {

        $empleados = new Empleado();
        $empleados->nombres = $request->input('nombres');
        $empleados->ap_pat = $request->input('ap_pat');
        $empleados->ap_mat = $request->input('ap_mat');
        $empleados->fechingreso = $request->input('fechingreso');
        $empleados->natalicio = $request->input('natalicio');
        $edad = Carbon::parse($request->input('natalicio'))->age;

        $empleados->edad = $edad;

        //$empleados -> edad = $request->input('edad');
        $empleados->ci = $request->input('ci');
        // $empleados -> poai = $request->input('poai');
        //$empleados -> exppoai = $request->input('exppoai');
        // $empleados -> decjurada = $request->input('decjurada');
        //$empleados -> expdecjurada = $request->input('expdecjurada');
        $empleados->sippase = $request->input('sippase');
        $empleados->expsippase = $request->input('expsippase');
        $empleados->servmilitar = $request->input('servmilitar');
        $empleados->idioma = $request->input('idioma');
        // $empleados -> induccion = $request->input('induccion');
        // $empleados -> expinduccion = $request->input('expinduccion');
        //$empleados -> progvacacion = $request->input('progvacacion');
        //$empleados -> expprogvacacion = $request->input('expprogvacacion');
        // $empleados -> vacganadas = $request->input('vacganadas');
        //$empleados -> vacpendientes = $request->input('vacpendientes');
        //$empleados -> vacusasdas = $request->input('vacusasdas');
        //$empleados -> segsalud = $request->input('segsalud');
        //$empleados -> inamovilidad = $request->input('inamovilidad');
        //$empleados -> aservicios = $request->input('aservicios');
        $empleados->cvitae = $request->input('cvitae');
        $empleados->telefono = $request->input('telefono');
        $empleados->biometrico = $request->input('biometrico');
        $empleados->gradacademico = $request->input('gradacademico');
        //$empleados -> rae = $request->input('rae');
        // $empleados -> regprofesional = $request->input('regprofesional');
        //$empleados -> evdesempenio = $request->input('evdesempenio');
        $empleados->idfile = $request->input('idfile');
        $empleados->idarea = $request->input('idarea');

        $empleados->totalpresupuesto = $request->input('totalpresupuesto');
        $empleados->fechafinal = $request->input('fechafinal');
        $empleados->ncontrato = $request->input('ncontrato');
        $empleados->npreventivo = $request->input('npreventivo');
        $empleados->progproy = $request->input('progproy');
        $empleados->rejap = $request->input('rejap');
        $empleados->aportesafp = $request->input('aportesafp');
        $empleados->cuentabanco = $request->input('cuentabanco');
        //$empleados -> filecontrato = $request->input('filecontrato');
        $empleados->nit = $request->input('nit');
        $empleados->sigep = $request->input('sigep');


        $nombfile = DB::table('file as f')
            ->select('f.numfile')
            ->where('f.idfile', '=', $request->input('idfile'))->first();

        $empleados->filecontrato = $nombfile->numfile;

        $empleados->estadoemp1 = 1;
        $empleados->estadoemp2 = 1;
        $empleados->tipo = 2;

        $empleados->save();
        $file = FileModel::find($request->input('idfile'));
        $file->estadofile = 2;
        $file->save();
        return redirect()->action('App\Http\Controllers\ContratoController@lista', [$request->input('idarea')]);
    }


    public function editarcontrato($idempledoPlanta)
    {

        $area = Area::where('estadoarea', '=', 1)->with('iPais_all')->get();
        $niveles = DB::table('niveles')->get();
        $empleados = Empleado::find($idempledoPlanta);
        //dd($niveles);
        //return view('rechumanos.planta.edit')->with('empleados', $empleados,"niveles",$niveles,"area", $area);

        return view('rechumanos.contrato.edit', ["niveles" => $niveles, "area" => $area, "empleados" => $empleados]);
    }

    public function actualizarcontrato(Request $request)
    {
        $empleados = Empleado::find($request->input('idemp'));
        $empleados->nombres = $request->input('nombres');
        $empleados->ap_pat = $request->input('ap_pat');
        $empleados->ap_mat = $request->input('ap_mat');
        $empleados->fechingreso = $request->input('fechingreso');
        $empleados->natalicio = $request->input('natalicio');

        $edad = Carbon::parse($request->input('natalicio'))->age;

        $empleados->edad = $edad;


        $empleados->ci = $request->input('ci');
        // $empleados -> poai = $request->input('poai');
        //$empleados -> exppoai = $request->input('exppoai');
        // $empleados -> decjurada = $request->input('decjurada');
        //$empleados -> expdecjurada = $request->input('expdecjurada');
        $empleados->sippase = $request->input('sippase');
        $empleados->expsippase = $request->input('expsippase');
        $empleados->servmilitar = $request->input('servmilitar');
        $empleados->idioma = $request->input('idioma');
        // $empleados -> induccion = $request->input('induccion');
        // $empleados -> expinduccion = $request->input('expinduccion');
        //$empleados -> progvacacion = $request->input('progvacacion');
        //$empleados -> expprogvacacion = $request->input('expprogvacacion');
        // $empleados -> vacganadas = $request->input('vacganadas');
        //$empleados -> vacpendientes = $request->input('vacpendientes');
        //$empleados -> vacusasdas = $request->input('vacusasdas');
        //$empleados -> segsalud = $request->input('segsalud');
        //$empleados -> inamovilidad = $request->input('inamovilidad');
        //$empleados -> aservicios = $request->input('aservicios');
        $empleados->cvitae = $request->input('cvitae');
        $empleados->telefono = $request->input('telefono');
        $empleados->biometrico = $request->input('biometrico');
        $empleados->gradacademico = $request->input('gradacademico');
        //$empleados -> rae = $request->input('rae');
        // $empleados -> regprofesional = $request->input('regprofesional');
        //$empleados -> evdesempenio = $request->input('evdesempenio');
        $empleados->idfile = $request->input('idfile');
        $empleados->idarea = $request->input('idarea');

        $empleados->totalpresupuesto = $request->input('totalpresupuesto');
        $empleados->fechafinal = $request->input('fechafinal');
        $empleados->ncontrato = $request->input('ncontrato');
        $empleados->npreventivo = $request->input('npreventivo');
        $empleados->progproy = $request->input('progproy');
        $empleados->rejap = $request->input('rejap');
        $empleados->aportesafp = $request->input('aportesafp');
        $empleados->cuentabanco = $request->input('cuentabanco');
        // $empleados -> filecontrato = $request->input('filecontrato');
        $empleados->nit = $request->input('nit');
        $empleados->sigep = $request->input('sigep');


        $nombfile = DB::table('file as f')
            ->select('f.numfile')
            ->where('f.idfile', '=', $request->input('idfile'))->first();

        $empleados->filecontrato = $nombfile->numfile;


        $empleados->estadoemp1 = 1;
        $empleados->estadoemp2 = 1;
        $empleados->tipo = 2;

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

        return redirect()->action('App\Http\Controllers\ContratoController@lista', [$request->input('idareaoriginal')]);
    }
}
