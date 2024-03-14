<?php

namespace App\Http\Controllers\Transporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\EmpleadosModel;
use App\Models\AreasModel;
use App\Models\FileModel;

use App\Models\Almacen\LocalidadModel;

use App\Models\Transporte\SoluconsumoModel;

use App\Models\Compra\ProgramaCombModel;

use Carbon\Carbon;
use NumerosEnLetras;

use App\Models\TemporalModel;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Http\Requests;

use App\Models\Canasta\Dea;
class SoluconsumoController2 extends Controller
{
    public function index()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
     
        $soluconsumos = DB::table('soluconsumo as s')

            ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
            ->join('areas as a', 'a.idarea', '=', 's.idarea')

            // ->where('a.idarea', $personalArea->idarea)

            ->select(
                's.idsoluconsumo',
                's.estadosoluconsumo',
                's.fechasol',
                's.estado1',
                's.cominterna',
                's.referencia',

                'a.nombrearea',
                'lo.nombrelocalidad'
            )
            ->orderBy('s.idsoluconsumo', 'desc');
            $soluconsumos = $soluconsumos->get();
          


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;

        return view('transportes.pedidoparcial.index',
            ['soluconsumos' => $soluconsumos, 'idd' => $personalArea]
        );
    }

    public function index2()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $soluconsumos = DB::table('soluconsumo as s')

            ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
            ->join('areas as a', 'a.idarea', '=', 's.idarea')



            ->where('a.idarea', $personalArea->idarea)
            ->where('s.estado1', 2)
            ->select(
                's.idsoluconsumo',
                's.estado1',
                's.cominterna',
                's.referencia',

                'a.nombrearea',
                'lo.nombrelocalidad'
            )
            ->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;




        return view(
            'transportes.pedidoparcial.index2',
            ['soluconsumos' => $soluconsumos, 'idd' => $personalArea]
        );
    }

    public function index3()
    {

        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;


        $soluconsumos = DB::table('soluconsumo as s')

            ->join('localidad as lo', 'lo.idlocalidad', '=', 's.idlocalidad')
            ->join('areas as a', 'a.idarea', '=', 's.idarea')



            ->where('a.idarea', $personalArea->idarea)
            ->where('s.estado2', 2)
            ->select(
                's.idsoluconsumo',
                's.estado2',
                's.estado1',
                's.cominterna',
                's.referencia',

                'a.nombrearea',
                'lo.nombrelocalidad'
            )
            ->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;




        return view(
            'transportes.pedidoparcial.index3',
            ['soluconsumos' => $soluconsumos, 'idd' => $personalArea]
        );
    }


    public function create()
    {

        $personal = User::find(Auth::user()->id); // auth quien esta logeado,yo soy el id=16
        $IdProg = $personal->idprogramacomb;   //saca el programa del user garch
        $id = $personal->id; // guarda el id en id

        $userdate = User::find($id)->usuariosempleados;

        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;

        $areas = DB::table('areas')->where('estadoarea', 1)
            ->pluck('nombrearea', 'idarea');

        $localidades = DB::table('localidad')
            ->select(DB::raw("concat(' Codigo: ',idlocalidad,' //Nombre: ',nombrelocalidad,' //Distancia: ',distancialocalidad,' //Distrito: ',distrito)
   as localida"), 'idlocalidad')
            ->where('estadolocalidad', 1)
            ->orderBy('idlocalidad', 'asc')
            ->pluck('localida', 'idlocalidad');

        $empleados = DB::table('empleados')->where('estadoemp1', 1)
            ->select(DB::raw("concat(nombres ,' ', ap_pat,' ',ap_mat,' ',
                    ' // AREA. ',idarea   
                    ) as emplead"), 'idemp')
            ->pluck('emplead', 'idemp');

        $programas = ProgramaCombModel::find($IdProg);
        $date = Carbon::now();

        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', $id3)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev')
            ->first();

        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', 11)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev')
            ->first();

        $encargadotres = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', 19)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev')
            ->first();

        $Areanm = AreasModel::find($id3);
        $NmBr = $Areanm->nombrearea;
        $oFICI = "OFICINA DE";
        $NomFci = $oFICI . " " .  $NmBr;

        return view('transportes.pedidoparcial.create',
            compact('areas', 'localidades', 'empleados', 'personalArea', 'date', 'encargado', 'encargadodos', 'encargadotres', 'NomFci')
        );
    }

    public function store(Request $request)
    {


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $IdProg = $personal->dea_id;

        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;


        $productocinco = EmpleadosModel::find($userdate->idemp);
        $Nombreusuario = $productocinco->nombres;
        $Apellidopausuario = $productocinco->ap_pat;
        $Apellidomausuario = $productocinco->ap_mat;
        $Nombrecompusuario = $Nombreusuario . " " .  $Apellidopausuario . " " . $Apellidomausuario;

        $IdFiletres = $productocinco->idfile;
        $productoseis = FileModel::find($IdFiletres);
        $Nombreusuariocargo = $productoseis->nombrecargo;



        // encargado de unidad
        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', $id3)
            ->select('emp.nombres', 'e.idenc', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.cargo')
            ->first();
        $proddos = $encargado->idenc;
        $CarGoviatressta = $encargado->abrev;
        $Nombreviatressta = $encargado->nombres;
        $Apellidopaviatressta = $encargado->ap_pat;
        $Apellidomaviatressta = $encargado->ap_mat;
        $Nombrecompvia = $CarGoviatressta . " " .  $Nombreviatressta . " " .  $Apellidopaviatressta . " " . $Apellidomaviatressta;
        $Nombreviacargo = $encargado->cargo;

        // dirigido a: transporte
        $id4 = 19;
        $encargadotres = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', $id4)
            ->select('emp.nombres', 'e.idenc', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.cargo')
            ->first();

        $prod = $encargadotres->idenc;
        $CarGoviatresst = $encargadotres->abrev;
        $Nombreviatresst = $encargadotres->nombres;
        $Apellidopaviatresst = $encargadotres->ap_pat;
        $Apellidomaviatresst = $encargadotres->ap_mat;
        $Nombrecompdir = $CarGoviatresst . " " .  $Nombreviatresst . " " .  $Apellidopaviatresst . " " . $Apellidomaviatresst;
        $Nombredircargo = $encargadotres->cargo;

        $id5 = 11;
        // via dir admin:
        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', $id5)
            ->select('emp.nombres', 'e.idenc', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.cargo')
            ->first();
        $IdEmp = $encargadodos->idenc;
        $CarGoviatress = $encargadodos->abrev;
        $Nombreviatress = $encargadodos->nombres;
        $Apellidopaviatress = $encargadodos->ap_pat;
        $Apellidomaviatress = $encargadodos->ap_mat;
        $Nombrecompviatress = $CarGoviatress . " " .  $Nombreviatress . " " .  $Apellidopaviatress . " " . $Apellidomaviatress;

        $Nombreviacargotress = $encargadodos->cargo;

        // via uno
        $proddoss = $request->get('idlocalidad');
        $productoocho = LocalidadModel::find($proddoss);
        $Codlocalidad = $productoocho->codlocalidad;
        $Nombrelocalid = $productoocho->nombrelocalidad;
        $Distancialocalid = $productoocho->distancialocalidad;

        $Areanm = AreasModel::find($id3);
        $NmBr = $Areanm->nombrearea;
        $oFICI = "OFICINA DE";
        $NomFci = $oFICI . " " .  $NmBr;


        // $flechasol = substr($request->fechasol, 6, 4) . '-' . substr($request->fechasol, 3, 2) . '-' . substr($request->fechasol, 0, 2);

        $soluconsumos = new SoluconsumoModel();
        $soluconsumos->oficina = $NomFci;
        $soluconsumos->cominterna = $request->get('cominterna');

        $soluconsumos->dirigidoa = $prod;  //dirigido a responsable de transporte
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $proddos;  //via uno encargado de la unidad
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;

        $soluconsumos->viados = $IdEmp;  //via dos directora administrativab
        $soluconsumos->viadosnombre = $Nombrecompviatress;
        $soluconsumos->viadoscargo = $Nombreviacargotress;


        $soluconsumos->idlocalidad = $request->get('idlocalidad');
        $soluconsumos->codlocalidad = $Codlocalidad;
        $soluconsumos->nombrelocalidad = $Nombrelocalid;
        $soluconsumos->distancialocalidad = $Distancialocalid;


        $soluconsumos->idarea = $personalArea->idarea;  //de , nombre, cargo oficina


        $soluconsumos->idusuario = $id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;


        $soluconsumos->referencia = $request->input('referencia');

        $fechasolACT = Carbon::now();
        $gesti = $fechasolACT->year;
        $soluconsumos->fechasol = $fechasolACT;
        $hora = $fechasolACT->toTimeString();
        $soluconsumos->horasol = $hora;
        $soluconsumos->gestionsoluconsumo = $gesti;

        $soluconsumos->detallesouconsumo = $request->input('detallesouconsumo');
        $soluconsumos->fechasalida = $request->input('fechasalida');
        $soluconsumos->fecharetorno = $request->input('fecharetorno');
        $tsalidahora = $request->input('tsalidahr');
        $soluconsumos->tsalidahr = $tsalidahora;
        $tsalidahorad = Carbon::parse($tsalidahora);


        if ($tsalidahorad->lessThan(Carbon::parse('12:00:00'))) {
            $soluconsumos->tsalida = "1";
        } else {
            $soluconsumos->tsalida = "2";
        }
        $tllegadahora = $request->input('tllegadahr');
        $soluconsumos->tllegadahr = $tllegadahora;
        $tllegadahorad = Carbon::parse($tllegadahora);

        if ($tllegadahorad->lessThan(Carbon::parse('12:00:00'))) {
            // Es la mañana
            $soluconsumos->tllegada = "1";
        } else {
            // Es la tarde
            $soluconsumos->tllegada = "2";
        }
        $soluconsumos->tipo = "PRODUCTO";

        $soluconsumos->tiposoluconsumo = $request->input('tipo');
        $soluconsumos->estadosoluconsumo = 1;
        $soluconsumos->estado1 = 1;
        $soluconsumos->estado2 = 1;
        $soluconsumos->estado3 = 1;
        $soluconsumos->iddea = $IdProg;
        if ($soluconsumos->save()) {
            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('upedidoparcial.index');
    }

    public function show($id)
    {
    }

    public function editar($idsoluconsumo)
    {
        $soluconsumos = SoluconsumoModel::find($idsoluconsumo);
       $Fechaa = $soluconsumos->fechasol;

        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);

        $Horaa = $soluconsumos->horasol;
        $Fechayhora = $fechag . "-" .  $fecham . "-" .  $fechad . " " .  $Horaa;

        $areas = DB::table('areas')
        ->where('estadoarea',1)
        ->orderBy('idarea', 'asc')
        ->get();

        $localidades = DB::table('localidad')
        ->where('estadolocalidad',1)
        ->orderBy('idlocalidad', 'asc')
        ->get();

        $empleados = DB::table('empleados')->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;


        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('a.idarea', $id3)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->orderBy('e.idenc', 'asc')
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

        $encargadotres = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->orderBy('e.idenc', 'asc')
            // -> where('a.idarea',11)  el idarea 11 es unidad administrativa
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

        return view('transportes.pedidoparcial.editar',

            compact(
                'id',
                'soluconsumos',
                'areas',
                'empleados',
                'localidades',
                'personalArea',
                'encargado',
                'encargadodos',
                'encargadotres',
                'Fechayhora'
            )
        );
    }

    public function update(Request $request)
    {
        $personal = User::find(Auth::user()->id);
        $id = $personal->id;


        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;



        $productocinco = EmpleadosModel::find($userdate->idemp);
        $Nombreusuario = $productocinco->nombres;
        $Apellidopausuario = $productocinco->ap_pat;
        $Apellidomausuario = $productocinco->ap_mat;
        $Nombrecompusuario = $Nombreusuario . " " .  $Apellidopausuario . " " . $Apellidomausuario;

        $IdFiletres = $productocinco->idfile;
        $productoseis = FileModel::find($IdFiletres);
        $Nombreusuariocargo = $productoseis->nombrecargo;


        // via encargado de unidad
        $id6 = $request->get('viados');
        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $id6)
            ->select('emp.nombres', 'e.idenc', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.cargo')
            ->first();
        // dirigido a

        $id7 = $request->get('dirigidoa');
        $encargadotres = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $id7)
            ->select('emp.nombres', 'e.idenc', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.cargo')
            ->first();
        $CarGoviatresst = $encargadotres->abrev;
        $Nombreviatresst = $encargadotres->nombres;
        $Apellidopaviatresst = $encargadotres->ap_pat;
        $Apellidomaviatresst = $encargadotres->ap_mat;
        $Nombrecompdir = $CarGoviatresst . " " .  $Nombreviatresst . " " .  $Apellidopaviatresst . " " . $Apellidomaviatresst;

        $Nombredircargo = $encargadotres->cargo;

      
        $id5 = $request->get('viauno');
        //via uno
        $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $id5)
            ->select('emp.nombres', 'e.idenc', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.cargo')
            ->first();

        $CarGoviatressta = $encargadodos->abrev;
        $Nombreviatressta = $encargadodos->nombres;
        $Apellidopaviatressta = $encargadodos->ap_pat;
        $Apellidomaviatressta = $encargadodos->ap_mat;
        $Nombrecompvia = $CarGoviatressta . " " .  $Nombreviatressta . " " .  $Apellidopaviatressta . " " . $Apellidomaviatressta;
        $Nombreviacargo = $encargadodos->cargo;
        
        
        
        // via dos
     
        $CarGoviatress = $encargado->abrev;
        $Nombreviatress = $encargado->nombres;
        $Apellidopaviatress = $encargado->ap_pat;
        $Apellidomaviatress = $encargado->ap_mat;
        $Nombrecompviatress = $CarGoviatress . " " .  $Nombreviatress . " " .  $Apellidopaviatress . " " . $Apellidomaviatress;

        $Nombreviacargotress = $encargado->cargo;

        $proddoss = $request->get('idlocalidad');
        $productoocho = LocalidadModel::find($proddoss);
        $Codlocalidad = $productoocho->codlocalidad;
        $Nombrelocalid = $productoocho->nombrelocalidad;
        $Distancialocalid = $productoocho->distancialocalidad;

        $soluconsumos = SoluconsumoModel::find($request->idsoluconsumo);

        $soluconsumos->oficina = $request->input('oficina');
        $soluconsumos->cominterna = $request->get('cominterna');


        $soluconsumos->dirigidoa = $request->get('dirigidoa'); //dirigido a
        $soluconsumos->dirnombre = $Nombrecompdir;
        $soluconsumos->diracargo = $Nombredircargo;


        $soluconsumos->viauno = $request->get('viauno');  //via 
        $soluconsumos->viaunonombre = $Nombrecompvia;
        $soluconsumos->viaunocargo = $Nombreviacargo;

        $soluconsumos->viados = $request->get('viados');  //via 
        $soluconsumos->viadosnombre = $Nombrecompviatress;
        $soluconsumos->viadoscargo = $Nombreviacargotress;

        $soluconsumos->idarea =  $request->input('idarea'); //de , nombre, cargo oficina
        $soluconsumos->idusuario = $id;
        $soluconsumos->usuarionombre = $Nombrecompusuario;
        $soluconsumos->usuariocargo = $Nombreusuariocargo;
        $soluconsumos->referencia = $request->input('referencia');
        $soluconsumos->detallesouconsumo = $request->input('detallesouconsumo');

        $soluconsumos->fechasalida = $request->input('fechasalida');
        $soluconsumos->fecharetorno = $request->input('fecharetorno');

        $soluconsumos->idlocalidad = $request->get('idlocalidad');
        $soluconsumos->codlocalidad = $Codlocalidad;
        $soluconsumos->nombrelocalidad = $Nombrelocalid;
        $soluconsumos->distancialocalidad = $Distancialocalid;  //lugar

        $tsalidahora = $request->input('tsalidahr');
        $soluconsumos->tsalidahr = $tsalidahora;
        $tsalidahorad = Carbon::parse($tsalidahora);
        $soluconsumos->tiposoluconsumo = $request->input('tipo');
        // $tsalidahorad = $tsalidahora->toTimeString();
        if ($tsalidahorad->lessThan(Carbon::parse('12:00:00'))) {
            // Es la mañana
            $soluconsumos->tsalida = "1";
        } else {
            // Es la tarde
            $soluconsumos->tsalida = "2";
        }
        $tllegadahora = $request->input('tllegadahr');
        $soluconsumos->tllegadahr = $tllegadahora;
        $tllegadahorad = Carbon::parse($tllegadahora);
        // $tllegadahorad = $tllegadahora->toTimeString();
        if ($tllegadahorad->lessThan(Carbon::parse('12:00:00'))) {
            // Es la mañana
            $soluconsumos->tllegada = "1";
        } else {
            // Es la tarde
            $soluconsumos->tllegada = "2";
        }

        if ($soluconsumos->save()) {

            $request->session()->flash('message', 'Registro Procesado');
        } else {
            $request->session()->flash('message', 'Error al Procesar Registro');
        }
        return redirect()->route('upedidoparcial.index');
    }

    public function editrechazado($idsoluconsumo)
    {


        $soluconsumos = SoluconsumoModel::find($idsoluconsumo);
        $ida1 =$soluconsumos ->viauno;
        $ida2 =$soluconsumos ->viados;
        $ida3 =$soluconsumos ->dirigidoa;
        $ida4 =$soluconsumos ->idarea;
        $ida5 =$soluconsumos ->idlocalidad;


        $Fechaa = $soluconsumos->fechasol;

        $consumos = DB::table('soluconsumo as s')

        ->where('s.idsoluconsumo', $idsoluconsumo)
        ->select('s.idsoluconsumo', 's.estadosoluconsumo', 's.fechaprotrans', 's.horaprobtrans')
        ->first();

        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);

        $Horaa = $soluconsumos->horasol;
        $Fechayhora = $fechag . "-" .  $fecham . "-" .  $fechad . " " .  $Horaa;

        $Fechaare = $soluconsumos->fechaprob;
        $fechagr = substr($Fechaare, 8, 2);
        $fechamr = substr($Fechaare, 5, 2);
        $fechadr = substr($Fechaare, 0, 4);

        $Horaar = $soluconsumos->horaprob;
        $Fechayhorar = $fechagr . "-" .  $fechamr . "-" .  $fechadr . " " .  $Horaar;

 $Fechaaretr = $soluconsumos->fechaprotrans;
        $fechagrtr = substr($Fechaaretr, 8, 2);
        $fechamrtr = substr($Fechaaretr, 5, 2);
        $fechadrtr = substr($Fechaaretr, 0, 4);

        $Horaartr = $soluconsumos->horaprobtrans;
        $Fechayhorartr = $fechagrtr . "-" .  $fechamrtr . "-" .  $fechadrtr . " " .  $Horaartr;



        $areas = DB::table('areas')
        ->where('idarea', $ida4)
        ->get();

        $localidades = DB::table('localidad')
        ->where('idlocalidad', $ida5)
        ->get();

        $empleados = DB::table('empleados')->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;

        $date = Carbon::now();
        $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $ida1)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

            $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $ida2)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

            $encargadotres = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $ida3)
            // -> where('a.idarea',11)  el idarea 11 es unidad administrativa
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();


        $Areanm = AreasModel::find($id3);
        $NmBr = $Areanm->nombrearea;
        $oFICI = "OFICINA DE";
        $NomFci = $oFICI . " " .  $NmBr;

        return view('transportes.pedidoparcial.editrechazado',

            compact(
                'id',
                'soluconsumos',
                'areas',
                'empleados',
                'localidades',
                'personalArea',
                'date',
                'encargado',
                'encargadodos',
                'encargadotres',
                'NomFci',
                'Fechayhora',
                'Fechayhorar'
            )
        );
    }

    public function editaprobado($idsoluconsumo)
    {


        $soluconsumos = SoluconsumoModel::find($idsoluconsumo);
        $ida1 =$soluconsumos ->viauno;
        $ida2 =$soluconsumos ->viados;
        $ida3 =$soluconsumos ->dirigidoa;
        $ida4 =$soluconsumos ->idarea;
        $ida5 =$soluconsumos ->idlocalidad;

        $Fechaa = $soluconsumos->fechasol;

        $consumos = DB::table('soluconsumo as s')

            ->where('s.idsoluconsumo', $idsoluconsumo)
            ->select('s.idsoluconsumo', 's.estadosoluconsumo', 's.fechaprotrans', 's.horaprobtrans')
            ->first();

        $fechag = substr($Fechaa, 8, 2);
        $fecham = substr($Fechaa, 5, 2);
        $fechad = substr($Fechaa, 0, 4);

        $Horaa = $soluconsumos->horasol;
        $Fechayhora = $fechag . "-" .  $fecham . "-" .  $fechad . " " .  $Horaa;

        $Fechaare = $soluconsumos->fechaprob;
        $fechagr = substr($Fechaare, 8, 2);
        $fechamr = substr($Fechaare, 5, 2);
        $fechadr = substr($Fechaare, 0, 4);

        $Horaar = $soluconsumos->horaprob;
        $Fechayhorar = $fechagr . "-" .  $fechamr . "-" .  $fechadr . " " .  $Horaar;

        $Fechaaretr = $soluconsumos->fechaprotrans;
        $fechagrtr = substr($Fechaaretr, 8, 2);
        $fechamrtr = substr($Fechaaretr, 5, 2);
        $fechadrtr = substr($Fechaaretr, 0, 4);

        $Horaartr = $soluconsumos->horaprobtrans;
        $Fechayhorartr = $fechagrtr . "-" .  $fechamrtr . "-" .  $fechadrtr . " " .  $Horaartr;


        $areas = DB::table('areas')
        ->where('idarea', $ida4)
        ->get();

        $localidades = DB::table('localidad')
        ->where('idlocalidad', $ida5)
        ->get();
        
        $empleados = DB::table('empleados')->get();


        $personal = User::find(Auth::user()->id);
        $id = $personal->id;
        $userdate = User::find($id)->usuariosempleados;
        $personalArea = EmpleadosModel::find($userdate->idemp)->empleadosareas;
        $id3 = $personalArea->idarea;

        $date = Carbon::now();
         $encargado = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $ida1)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

            $encargadodos = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $ida2)
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();

            $encargadotres = DB::table('encargados as e')
            ->join('areas as a', 'a.idarea', '=', 'e.idarea')
            ->join('empleados as emp', 'e.idemp', '=', 'emp.idemp')
            ->where('e.idenc', $ida3)
            // -> where('a.idarea',11)  el idarea 11 es unidad administrativa
            ->select('emp.nombres', 'emp.ap_pat', 'emp.ap_mat', 'e.abrev', 'e.idenc', 'a.nombrearea', 'e.cargo')
            ->get();


        $Areanm = AreasModel::find($id3);
        $NmBr = $Areanm->nombrearea;
        $oFICI = "OFICINA DE";
        $NomFci = $oFICI . " " .  $NmBr;

        return view('transportes.pedidoparcial.editaprobado',

            compact(
                'id',
                'soluconsumos',
                'areas',
                'empleados',
                'localidades',
                'personalArea',
                'date',
                'encargado',
                'encargadodos',
                'encargadotres',
                'NomFci',
                'Fechayhora',
                'Fechayhorar',
                'Fechayhorartr',
                'consumos'
            )
        );
    }

    public function pdf()
    {
        $soluconsumos  = DB::table('soluconsumo')->get();
        $pdf = PDF::loadView('transportes.pedidoparcial.pdf', compact('soluconsumos'));
        return $pdf->stream();
    }

    public function solicitud($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
            $soluconsumos = SoluconsumoModel::find($id);
            $soluconsumos = DB::table('soluconsumo as s')
                ->select(


                    's.cominterna',
                    's.idarea', //de forma automatica del que tiene acceso
                    's.idusuario',  //de forma automatica del que tiene acceso
                    's.idlocalidad',  //el lugar de ida

                    //via
                    's.dirnombre',    //via
                    's.diracargo',    //via


                    //departe de 
                    's.viaunonombre', //departe de 
                    's.viaunocargo', //departe de 

                    's.viadosnombre', //departe de 
                    's.viadoscargo', //departe de 

                    's.usuarionombre',  //de forma automatica del que tiene acceso
                    's.usuariocargo',  //de forma automatica del que tiene acceso

                    's.oficina', //nombre de la oficina
                    's.referencia',
                    's.fechasol',
                    's.detallesouconsumo',
                    's.fechasalida',
                    's.fecharetorno',
                    's.tiposoluconsumo',
                    's.tsalida',
                    's.tllegada'
                )
                ->where('s.idsoluconsumo', $id)

                ->first();


            $fechaSol = $soluconsumos->fechasol;
            $fechaSol = Carbon::parse($fechaSol)->isoFormat('D \d\e MMMM \d\e\l Y');

            $fechaSalida = $soluconsumos->fechasalida;
            $fechaSalida = Carbon::parse($fechaSalida)->isoFormat('D \d\e MMMM \d\e\l Y');


            $diaSemana = $soluconsumos->fechasalida;
            $diaSemana = Carbon::parse($diaSemana);
            $diaSemana = $diaSemana->isoFormat('dddd');


            // $diaSemana = $soluconsumos->fechasalida;
            // $diaSemana = Carbon::parse($diaSemana);
            // $diaSemana = $diaSemana->format('l');


            $fechaRetorno = $soluconsumos->fecharetorno;
            $fechaRetorno = Carbon::parse($fechaRetorno)->isoFormat('D \d\e MMMM \d\e\l Y');

            $idlocalidade = $soluconsumos->idlocalidad;
            $localidades = DB::table('localidad')
            ->where('idlocalidad', $idlocalidade)
            ->first();



            $pdf = PDF::loadView(
                'transportes.pedidoparcial.pdf-solicitud',
                compact([
                    'soluconsumos', 'localidades',
                    'fechaSol', 'fechaRetorno',
                    'fechaSalida', 'diaSemana'
                ])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('upedidoparcial.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }
    public function solicituduno($id)
    {
        try {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
            $soluconsumos = SoluconsumoModel::find($id);
            $soluconsumos = DB::table('soluconsumo as s')
                ->select(


                    's.cominterna',
                    's.idarea', //de forma automatica del que tiene acceso
                    's.idusuario',  //de forma automatica del que tiene acceso
                    's.idlocalidad',  //el lugar de ida

                    //via
                    's.dirnombre',    //via
                    's.diracargo',    //via


                    //departe de 
                    's.viaunonombre', //departe de 
                    's.viaunocargo', //departe de 

                    's.viadosnombre', //departe de 
                    's.viadoscargo', //departe de 

                    's.usuarionombre',  //de forma automatica del que tiene acceso
                    's.usuariocargo',  //de forma automatica del que tiene acceso

                    's.oficina', //nombre de la oficina
                    's.referencia',
                    's.fechasol',
                    's.detallesouconsumo',
                    's.fechasalida',
                    's.fecharetorno',
                    's.tiposoluconsumo',
                    's.tsalida',
                    's.tllegada'
                )
                ->where('s.idsoluconsumo', $id)

                ->first();

            $prodserv = DB::table('detallesoluconsumo as d')

                ->join('unidadconsumo as uni', 'uni.idunidadconsumo', '=', 'd.idunidadconsumo')
                ->join('soluconsumo as sol', 'sol.idsoluconsumo', '=', 'd.idsoluconsumo')
                ->join('marcamovilidad as ma', 'ma.idmarcamovilidad', '=', 'uni.idmarcamovilidad')
                ->join('empleados as em', 'em.idemp', '=', 'd.idchofer')
                ->select(
                    'd.iddetallesoluconsumo',
                    'uni.nombreuconsumo',
                    'd.codigoconsumo',
                    'd.marcaconsumo',
                    'd.placaconsum',
                    'd.kilometrajeactual',
                    'd.chofernombre',
                    'uni.idunidadconsumo',
                    'uni.marcaconsumo',
                    'uni.placaconsumo',
                    'ma.nombremarca',
                    'uni.documento',
                    'em.telefono',
                    'uni.kilometrajefinalconsumo'
                )

                ->where('d.idsoluconsumo', $id)
                ->first();

            $rutaimagen = $prodserv->documento;



            $fechag = substr($rutaimagen, 19, 18);



            $rutaImagendos = public_path('/Imagenes/UNIDAD DE SISTEMAS/' . $fechag);

            $fechaSol = $soluconsumos->fechasol;
            $fechaSol = Carbon::parse($fechaSol)->isoFormat('D \d\e MMMM \d\e\l Y');

            $fechaSalida = $soluconsumos->fechasalida;
            $fechaSalida = Carbon::parse($fechaSalida)->isoFormat('D \d\e MMMM \d\e\l Y');


            $diaSemana = $soluconsumos->fechasalida;
            $diaSemana = Carbon::parse($diaSemana);
            $diaSemana = $diaSemana->isoFormat('dddd');


            // $diaSemana = $soluconsumos->fechasalida;
            // $diaSemana = Carbon::parse($diaSemana);
            // $diaSemana = $diaSemana->format('l');


            $fechaRetorno = $soluconsumos->fecharetorno;
            $fechaRetorno = Carbon::parse($fechaRetorno)->isoFormat('D \d\e MMMM \d\e\l Y');


            $localidades = DB::table('localidad')->first();



            $pdf = PDF::loadView(
                'transportes.pedidoparcial.pdf-solicituduno',
                compact([
                    'soluconsumos', 'localidades', 'prodserv', 'rutaImagendos',
                    'fechaSol', 'fechaRetorno',
                    'fechaSalida', 'diaSemana'
                ])
            );

            $pdf->setPaper('LETTER', 'portrait'); //landscape
            return $pdf->stream();
        } catch (Exception $ex) {
            \Log::error("Cotizacion Error: {$ex->getMessage()}");
            return redirect()->route('transportes.pedidoparcial.index')->with('message', $ex->getMessage());
        } finally {
            ini_restore('memory_limit');
            ini_restore('max_execution_time');
        }
    }

    public function respuesta7(Request $request)
    {
        $ot_antigua = $_POST['ot_antigua'];
        $data = "hola";
        $data2 = "holaSSSS";
        $validarci = DB::table('soluconsumo as s')
            ->select('s.cominterna')
            ->where('s.cominterna', $ot_antigua)
            ->get();
        if ($validarci->count() > 0) {
            return ['success' => true, 'data' => $data];
        } else  return ['success' => false, 'data' => $data2];
    }
}
